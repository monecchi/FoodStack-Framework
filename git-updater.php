<?php
/**
 * How To Deploy WordPress Plugins With GitHub Using Transients
 * @see https://www.smashingmagazine.com/2015/08/deploy-wordpress-plugins-with-github-using-transients/#writing-the-code-for-our-filters
 */

class Github_Updater {

	private $file;

	private $plugin;

	private $basename;

	private $active;

	private $username;

	private $repository;

	private $authorize_token;

	private $github_response;

	private $readme_response;


	public function __construct( $file ) {

		$this->file = $file;

		add_action( 'admin_init', array( $this, 'set_plugin_properties' ) );

		return $this;
	}

	public function set_plugin_properties() {
		$this->plugin	= get_plugin_data( $this->file );
		$this->basename = plugin_basename( $this->file );
		$this->active	= is_plugin_active( $this->basename );
	}

	public function set_username( $username ) {
		$this->username = $username;
	}

	public function set_repository( $repository ) {
		$this->repository = $repository;
	}

	public function authorize( $token ) {
		$this->authorize_token = $token;
	}

    /**
     * Github API - Get Latest release
     * @see https://developer.github.com/v3/repos/releases/
    */
	private function get_repository_info() {
	    if ( is_null( $this->github_response ) ) { // Do we have a response?

	    	$options = array('timeout' => 10);

	        $request_uri = sprintf( 'https://api.github.com/repos/%s/%s/releases', $this->username, $this->repository ); // Build URI

	        if( $this->authorize_token ) { // Is there an access token?
	            $request_uri = add_query_arg( 'access_token', $this->authorize_token, $request_uri ); // Append it
	        }

	        $response = json_decode( wp_remote_retrieve_body( wp_remote_get( $request_uri, $options ) ), true ); // Get JSON and parse it

	        if( is_array( $response ) ) { // If it is an array
	            $response = current( $response ); // Get the first item
	        }

	        if( $this->authorize_token ) { // Is there an access token?
	            $response['zipball_url'] = add_query_arg( 'access_token', $this->authorize_token, $response['zipball_url'] ); // Update our zip url with token
	        }

	        $this->github_response = $response; // Set it to our property
	    }
	}

	public function readme_changelog() {

		if ( is_null( $this->readme_response ) ) {

			 $request_readme = sprintf( 'https://api.github.com/repos/%s/%s/readme', $this->username, $this->repository ); // Build URI

			 $response_readme = json_decode( wp_remote_retrieve_body( wp_remote_get( $request_readme ) ), true ); // Get JSON and parse it

			//$readme_request = wp_remote_get( sprintf( 'https://raw.githubusercontent.com/repos/%s/%s/master/README.md', $this->username, $this->repository ) );
			//$readme_raw = wp_remote_retrieve_body( $readme_request );

			$this->readme_response = $response_readme;

		}

		
	}

	public function initialize() {
		//add_filter( 'admin_init', array( $this, 'readme_changelog' ) );
		add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'modify_transient' ), 10, 1 );
		add_filter( 'plugins_api', array( $this, 'plugin_popup' ), 10, 3);
		add_filter( 'upgrader_post_install', array( $this, 'after_install' ), 10, 3 );
	}

	public function modify_transient( $transient ) {

		if( property_exists( $transient, 'checked' ) ) { // Check if transient has a checked property

			if( $checked = $transient->checked ) { // Did Wordpress check for updates?

				$this->get_repository_info(); // Get the repo info

				$out_of_date = version_compare( $this->github_response['tag_name'], $checked[ $this->basename ], 'gt' ); // Check if we're out of date

				if( $out_of_date ) {

					$new_files = $this->github_response['zipball_url']; // Get the ZIP

					$slug = current( explode('/', $this->basename ) ); // Create valid slug

					// Setup plugin icons
					$plugin['icons'] = array();

					$icons = array(
						'svg' => plugins_url( 'assets/icon.svg', __FILE__ ),
						'1x'  => plugins_url( 'assets/icon-128x128.png', __FILE__ ),
						'2x'  => plugins_url( 'assets/icon-256x256.png', __FILE__ )
					);

					// Setup our plugin info
					$plugin = array(
						'url' => $this->plugin["PluginURI"],
						'slug' => $slug,
      				    'icons' => $icons,
						'package' => $new_files,
						'new_version' => $this->github_response['tag_name']
					);

					$transient->response[$this->basename] = (object) $plugin; // Return it in response
				}
			}
		}

		return $transient; // Return filtered transient
	}


	public function plugin_popup( $result, $action, $args ) {

		if( ! empty( $args->slug ) ) { // If there is a slug
			
			if( $args->slug == current( explode( '/' , $this->basename ) ) ) { // And it's our slug

				$this->get_repository_info(); // Get our repo info

				// Set it to an array
				$plugin = array(
					'name'				=> $this->plugin["Name"],
					'slug'				=> $this->basename,
					'requires'			=> '4.5.2',
					'tested'			=> '4.9.6',
					'rating'			=> '95.5',
					'ratings' => array(
                  					5 => 1800,
                  					4 => 200 
      				),
					'num_ratings'		=> '2000',
					'downloaded'		=> '14249',
					'added'				=> $this->github_response['created_at'], //'2017-12-17',
					'version'			=> $this->github_response['tag_name'],
					'author'			=> $this->plugin['AuthorName'],
					'author_profile'	=> $this->plugin['AuthorURI'],
					'last_updated'		=> $this->github_response['published_at'],
					'homepage'			=> $this->plugin['PluginURI'],
					'short_description' => $this->plugin['Description'],
					'sections'			=> array(
						'description'	=> $this->plugin['Description'],
						'updates'		=> class_exists( 'Parsedown' ) ? Parsedown::instance()->parse( $this->github_response['body'] ) : $this->github_response['body'],
						'changelog'		=> class_exists( 'Parsedown' ) ? Parsedown::instance()->parse( base64_decode($this->readme_response['content']) ) : $this->github_response['body'],
					),
					'banners'			=> array(
                  		'low'			=> plugins_url( 'assets/banner-772x250.png', __FILE__ ),
                  		'high'			=> plugins_url( 'assets/banner-1544x500.png', __FILE__ )
      				),
					'compatibility' => array(
						'4.9.1' => array(
							'1.3.9' => array(
								'0' => 100,
								'1' => 1,
								'2' => 1
							),
						),
					),
      				'contributors' => array(
                  		'designroom' => 'https://profiles.wordpress.org/designroom',
      				),
					'download_link'		=> $this->github_response['zipball_url']
				);

				return (object) $plugin; // Return the data
			}

		}
		return $result; // Otherwise return default
	}

	public function after_install( $response, $hook_extra, $result ) {
		global $wp_filesystem; // Get global FS object

		$install_directory = plugin_dir_path( $this->file ); // Our plugin directory
		$wp_filesystem->move( $result['destination'], $install_directory ); // Move files to the plugin dir
		$result['destination'] = $install_directory; // Set the destination for the rest of the stack

		if ( $this->active ) { // If it was active
			activate_plugin( $this->basename ); // Reactivate
		}

		return $result;
	}
}
