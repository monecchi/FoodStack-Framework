<?php

// Set-up Action and Filter Hooks
register_uninstall_hook(__FILE__, 'ebor_framework_cpt_delete_plugin_options');
add_action('admin_init', 'ebor_framework_cpt_init' );
add_action('admin_menu', 'ebor_framework_cpt_add_options_page');
//RUN ON THEME ACTIVATION
register_activation_hook( __FILE__, 'ebor_framework_cpt_activation' );

// Delete options table entries ONLY when plugin deactivated AND deleted
function ebor_framework_cpt_delete_plugin_options() {
	delete_option('ebor_framework_cpt_display_options');
}

// Flush rewrite rules on activation
function ebor_framework_cpt_activation() {
	flush_rewrite_rules(true);
}

// Init plugin options to white list our options
function ebor_framework_cpt_init(){
	register_setting( 'ebor_framework_cpt_plugin_display_options', 'ebor_framework_cpt_display_options', 'ebor_framework_cpt_validate_display_options' );
}

// Add menu page
if(!( function_exists('ebor_framework_cpt_add_options_page') )){
	function ebor_framework_cpt_add_options_page(){
		$theme = wp_get_theme();
		add_options_page( $theme->get( 'Name' ) . ' Post Type Options', $theme->get( 'Name' ) . ' Post Type Options', 'manage_options', __FILE__, 'ebor_framework_cpt_render_form');
	}
}

// Render the Plugin options form
function ebor_framework_cpt_render_form() { 
	$theme = wp_get_theme();
?>

<div class="wrap">
    <!-- Display Plugin Icon, Header, and Description -->
    <div class="title_line" style="margin-bottom:10px">
        <h2><span class="dashicons dashicons-align-left" style="width:35px; height:35px; vertical-align:middle; font-size:35px;"></span> <?php echo $theme->get( 'Name' ) . __(' Custom Post Type Settings','ebor'); ?></h2>
    </div>
    <div class="section panel" style="padding: 20px;">
        <div class="wrap">
            <!-- Beginning of the Plugin Options Form -->
            <form method="post" action="options.php">
                <?php settings_fields('ebor_framework_cpt_plugin_display_options'); ?>
                <?php $displays = get_option('ebor_framework_cpt_display_options'); ?>
                <table class="form-table">
                    <h1>Instructions:</h1>
                    <div class="notifier" style="width:100%; border: 1px solid #f7f7f7; margin-top: 10px; padding: 10px; color: #343A3C; background: #fafafa;">
                    <h3>Enter the URL slug you want to use for the registered post types bellow. <strong>DO-NOT: use numbers, spaces, capital letters or special characters.</strong></h3>
                        <h4>When you make any changes in this plugin, be sure to visit <a href="options-permalink.php">Your Permalink Settings</a> & click the <code>'Save Changes'</code> button to refresh & re-write your permalinks, otherwise your changes will not take effect properly.</h4>
                    </div>
                    <!-- Checkbox Buttons -->
                    <hr />
                    <h1>Registered Post Types:</h1>
                    <tr valign="top">
                        <th><label for="portfolio"><?php _e( 'Post Type: Portfolio', 'pivot' ); ?></label></th>
                        <td>
                            <label for="portfolio">Portfolio slug: <input id="portfolio" type="text" size="30" name="ebor_framework_cpt_display_options[portfolio_slug]" value="<?php echo $displays['portfolio_slug']; ?>" placeholder="portfolio" /> <small>E.g. <code>works</code> or <code>projects</code> could be used as the url slug for the 'portfolio' post type.<small></label>
<br />
                            <br /><p>If you leave the field blank, <code>portfolio</code> is set as the default url slug.<br /> You can use any words as long as you follow the url slug pattern mentioned in the above instructions. E.g. entering <code>works</code> would result in <b>www.website.com/works</b> becoming the URL to your portfolio.</p>
                            <hr />
                        </td>
                    </tr>
                    <tr>
                        <th><label for="team"><?php _e( 'Post Type: Team', 'pivot' ); ?></label></th>
                        <td>
                            <label for="team">Team slug: <input id="team" type="text" size="30" name="ebor_framework_cpt_display_options[team_slug]" value="<?php echo $displays['team_slug']; ?>" placeholder="team" /> <small>E.g. <code>staff</code> or <code>founders</code> could be used as the url slug for the 'team' post type.<small></label>
<br />
                            <br /><p>If you leave the field blank, <code>team</code> is set as the default url slug. <br /> You can use any word as long as you follow the url slug pattern mentioned above. E.g. entering <code>staff</code> would result in <b>www.website.com/staff</b> becoming the URL to your team post type.</p>
                            <hr />
                        </td>
                    </tr>
                    <br />
                    <br />
                    <tr>
                        <th><label for="food-menu"><span class="dashicons dashicons-carrot" style="width:25px; height:25px; vertical-align:middle; font-size:25px;"></span> <?php _e( 'Food Menu', 'pivot' ); ?> <small><?php _e( 'Post Type', 'pivot' ); ?></small> </label></th>
                        <td>
                            <label for="food-menu">Food Menu slug: <input id="food-menu" type="text" size="30" name="ebor_framework_cpt_display_options[food_menu_slug]" value="<?php echo $displays['food_menu_slug']; ?>" placeholder="food_menu" /> <small> If you leave the field blank, <code>food_menu</code> is set as the default url slug.</small></label>
<br />
                           <br /><p>The words <code>snacks</code> or <code>burguers</code> could be used as the url slug for the <strong>food_menu</strong> post type. You can use any word as long as you follow the url slug pattern mentioned in the above instructions. <br /> E.g. entering <code>cardapio</code> would result in <b>www.website.com/cardapio</b> becoming the URL to your team post type.</p>
                            <hr />
                            <p><b>Food Menu Post Type Extra Customization Options.</b><br /> Use the settings bellow to change the url slug for both <strong>Food Menu Categories & Food Tags</strong>.</p>
                            <br />
                            <label for="food-menu-cat">Food Menu Categories: <input id="food-menu-cat" type="text" size="30" name="ebor_framework_cpt_display_options[food_cat_slug]" value="<?php echo $displays['food_cat_slug']; ?>" placeholder="food_menu_categories" /></label>
<hr />
                            <p><b>Hack Tip:</b> Setting the same slug for the <code>food_menu</code> post type and for the <code>food_menu_categories</code> taxonomy will force wordpress to redirect to <code>cardapio/food-menu-category-slug</code>, this hack helps you to set up pages with the same slugs as the categories so you can filter your posts within those pages, so instead of displaying the taxonomy-term.php template you'll be displaying a custom page that will end up with the same slug as the custom taxonomy categories.</p>
                            <br />

                            <label for="food-menu-tag">Food Menu Tags: <input id="food-menu-tag" type="text" size="30" name="ebor_framework_cpt_display_options[food_tag_slug]" value="<?php echo $displays['food_tag_slug']; ?>" placeholder="food_tag" /></label>
<br />
                            <br /><p>If you leave the field blank, <code>food_menu_categories</code> is set as the default url slug. You can use any word as long as you follow the url slug pattern mentioned in the above instructions.<br /> E.g. entering <code>especialidades</code> would result in <b>www.website.com/especialidades/pizzas-tradicionais</b> becoming the URL to your Food Menu Categories taxonomy.</p>
                            <hr />
                        </td>
                    </tr>

                </table>
                <?php submit_button('Save Options'); ?>
            </form>
        </div>
    </div>
</div>

<?php 
}

/**
 * Validate inputs for post type options form
 */
function ebor_framework_cpt_validate_display_options($input) {
	
	if( get_option('ebor_framework_cpt_display_options') ){
		
		$displays = get_option('ebor_framework_cpt_display_options');
		
		foreach ($displays as $key => $value) {
			if(isset($input[$key])){
				$input[$key] = wp_filter_nohtml_kses($input[$key]);
			}
		}
	
	}
	return $input;
	
}

function ebor_framework_register_mega_menu() {

    $labels = array( 
        'name' => __( 'Ebor Mega Menu', 'ebor' ),
        'singular_name' => __( 'Ebor Mega Menu Item', 'ebor' ),
        'add_new' => __( 'Add New', 'ebor' ),
        'add_new_item' => __( 'Add New Ebor Mega Menu Item', 'ebor' ),
        'edit_item' => __( 'Edit Ebor Mega Menu Item', 'ebor' ),
        'new_item' => __( 'New Ebor Mega Menu Item', 'ebor' ),
        'view_item' => __( 'View Ebor Mega Menu Item', 'ebor' ),
        'search_items' => __( 'Search Ebor Mega Menu Items', 'ebor' ),
        'not_found' => __( 'No Ebor Mega Menu Items found', 'ebor' ),
        'not_found_in_trash' => __( 'No Ebor Mega Menu Items found in Trash', 'ebor' ),
        'parent_item_colon' => __( 'Parent Ebor Mega Menu Item:', 'ebor' ),
        'menu_name' => __( 'Ebor Mega Menu', 'ebor' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'menu_icon' => 'dashicons-menu',
        'description' => __('Mega Menus entries for the theme.', 'ebor'),
        'supports' => array( 'title', 'editor' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 40,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post'
    );

    register_post_type( 'mega_menu', $args );
}

function ebor_framework_register_portfolio() {

$displays = get_option('ebor_framework_cpt_display_options');
if( $displays['portfolio_slug'] ){ $slug = $displays['portfolio_slug']; } else { $slug = 'portfolio'; }

    $labels = array( 
        'name' => __( 'Portfolio', 'ebor' ),
        'singular_name' => __( 'Portfolio', 'ebor' ),
        'add_new' => __( 'Add New', 'ebor' ),
        'add_new_item' => __( 'Add New Portfolio', 'ebor' ),
        'edit_item' => __( 'Edit Portfolio', 'ebor' ),
        'new_item' => __( 'New Portfolio', 'ebor' ),
        'view_item' => __( 'View Portfolio', 'ebor' ),
        'search_items' => __( 'Search Portfolios', 'ebor' ),
        'not_found' => __( 'No portfolios found', 'ebor' ),
        'not_found_in_trash' => __( 'No portfolios found in Trash', 'ebor' ),
        'parent_item_colon' => __( 'Parent Portfolio:', 'ebor' ),
        'menu_name' => __( 'Portfolio', 'ebor' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Portfolio entries for the ebor Theme.', 'ebor'),
        'supports' => array( 'title', 'editor', 'thumbnail', 'post-formats', 'comments' ),
        'taxonomies' => array( 'portfolio-category' ),
        'public' => true,
        'show_in_rest' => true, // wheather or not to make the new custom post_type avaialble on WP REST API
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-portfolio',
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => $slug ),
        'capability_type' => 'post'
    );

    register_post_type( 'portfolio', $args );
}

function ebor_framework_create_portfolio_taxonomies(){
	$labels = array(
	    'name' => _x( 'Portfolio Categories','ebor' ),
	    'singular_name' => _x( 'Portfolio Category','ebor' ),
	    'search_items' =>  __( 'Search Portfolio Categories','ebor' ),
	    'all_items' => __( 'All Portfolio Categories','ebor' ),
	    'parent_item' => __( 'Parent Portfolio Category','ebor' ),
	    'parent_item_colon' => __( 'Parent Portfolio Category:','ebor' ),
	    'edit_item' => __( 'Edit Portfolio Category','ebor' ), 
	    'update_item' => __( 'Update Portfolio Category','ebor' ),
	    'add_new_item' => __( 'Add New Portfolio Category','ebor' ),
	    'new_item_name' => __( 'New Portfolio Category Name','ebor' ),
	    'menu_name' => __( 'Portfolio Categories','ebor' ),
	  ); 	
  register_taxonomy('portfolio_category', array('portfolio'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_in_rest' => true, // wheather or not to make the new custom post_type avaialble on WP REST API
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => true,
  ));
}

// Food Menu Categories

function ebor_framework_create_food_menu_taxonomies(){

$displays = get_option('ebor_framework_cpt_display_options');
 if( $displays['food_cat_slug'] ){ $slug = $displays['food_cat_slug']; } else { $slug = 'food_menu_categories'; }

	$labels = array(
	    'name' => _x( 'Cardapio Types','ebor' ),
	    'singular_name' => _x( 'Cardapio Category','ebor' ),
	    'search_items' =>  __( 'Search Cardapio Categories','ebor' ),
	    'all_items' => __( 'All Cardapio Categories','ebor' ),
	    'parent_item' => __( 'Parent Cardapio Category','ebor' ),
	    'parent_item_colon' => __( 'Parent Cardapio Category:','ebor' ),
	    'edit_item' => __( 'Edit Cardapio Category','ebor' ), 
	    'update_item' => __( 'Update Cardapio Category','ebor' ),
	    'add_new_item' => __( 'Add New Cardapio Category','ebor' ),
	    'new_item_name' => __( 'New Cardapio Category Name','ebor' ),
	    'menu_name' => __( 'Cardapio Categories','ebor' ),
	  ); 	
  // register_taxonomy('food_menu_categories', array('food_menu'), array(
  //   'hierarchical' => true,
  //   'labels' => $labels,
  //   'show_ui' => true,
  //   'show_in_rest' => true, // wheather or not to make the new custom taxonomy avaialble on WP REST API
  //   'show_admin_column' => true,
  //   'query_var' => true,
  //   'rewrite' => true, 'rewrite' => array( 'slug' => $slug ), 
  // ));

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => true, 'rewrite' => array( 'slug' => $slug ), 
        'show_in_rest'      => true,
        'rest_base'         => 'especialidade',
        'rest_controller_class' => 'WP_REST_Terms_Controller',
    );
  
    register_taxonomy( 'food_menu_categories', array( 'food_menu' ), $args );
}

// Food Menu Tags

function ebor_framework_create_food_menu_tags() {

$displays = get_option('ebor_framework_cpt_display_options');
if( $displays['food_tag_slug'] ){ $slug = $displays['food_tag_slug']; } else { $slug = 'food_tag'; }

  // Custom Meu Rancho Tags for the food_menu post type
   register_taxonomy('food_tag', array('food_menu'), array(
    'hierarchical' => false,
    'sort' => true, 'args' => array('orderby' => 'term_order'), // if is a non hierarchical taxonomy such as post_tag, then sorts the taxonomy terms by entry order.
    'label' => __( 'Food Tags', 'ebor' ), 
    'singular_name' => __( 'Food Tag', 'ebor' ),
    'show_in_rest'      => true,  // wheather or not to make the new custom taxonomy avaialble on WP REST API
    'rest_base'         => 'ingrediente',
    'rest_controller_class' => 'WP_REST_Terms_Controller',
    'show_admin_column' => true,
    'query_var' => true,
    '_builtin' => false,
    'rewrite' => true, 'rewrite' => array( 'slug' => $slug, 'with_front'=>'false' ), 
   ));
}


// Food Menu

function ebor_framework_register_food_menu() {

$displays = get_option('ebor_cpt_display_options');

if( $displays['food_menu_slug'] ){ $slug = $displays['food_menu_slug']; } else { $slug = 'food_menu'; }

    $labels = array( 
        'name' => __( 'Cardapio', 'ebor' ),
        'singular_name' => __( 'Cardapio', 'ebor' ),
        'add_new' => __( 'Add New Cardapio', 'ebor' ),
        'add_new_item' => __( 'Add New Cardapio Iten', 'ebor' ),
        'edit_item' => __( 'Edit Cardapio Iten', 'ebor' ),
        'new_item' => __( 'New Cardapio Item', 'ebor' ),
        'view_item' => __( 'View Cardapio Item', 'ebor' ),
        'search_items' => __( 'Search Cardapios', 'ebor' ),
        'not_found' => __( 'No cardapios found', 'ebor' ),
        'not_found_in_trash' => __( 'No cardapios found in Trash', 'ebor' ),
        'parent_item_colon' => __( 'Parent Cardapio:', 'ebor' ),
        'menu_name' => __( 'Cardapio', 'ebor' ),
    );

    // $args = array( 
    //     'labels' => $labels,
    //     'hierarchical' => false,
    //     'description' => __('Cardapio entries for the Meu Rancho Site.', 'ebor'),
    //     'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'post-formats', 'tags' ),
    //     'taxonomies' => array( 'food_menu_categories', 'food_tag' ),
    //     'public' => true,
    //     'show_in_rest' => true, // wheather or not to make the new custom post_type avaialble on WP REST API
    //     'show_ui' => true,
    //     'show_in_menu' => true,
    //     'menu_position' => 5,
    //     'menu_icon' => 'dashicons-images-alt2',
    //  // 'menu_icon' => 'get_template_directory_uri() . "images/custom-posttype-icon.png"' (Use an image located in the current theme - optional)
     
    //     'show_in_nav_menus' => true,
    //     'publicly_queryable' => true,
    //     'exclude_from_search' => false,
    //     'has_archive' => true,
    //     'query_var' => true,
    //     'can_export' => true,
    //     'rewrite' => array( 'slug' => $slug ),
    //     'capability_type' => 'post'
    // );

    // register_post_type( 'food_menu', $args );

    $args = array(
        'labels'             => $labels,
        'description' => __('Cardapio entries for the Meu Rancho Site.', 'ebor'),
        'public'             => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'can_export'         => true,
        'rewrite'            => array( 'slug' => $slug ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'taxonomies' => array( 'food_menu_categories', 'food_tag' ),
        'menu_position'      => 5, //null,
        'menu_icon' => 'dashicons-images-alt2',
        'show_in_rest'       => true,
        'rest_base'          => 'cardapio-api',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'post-formats', 'tags', 'excerpt', 'comments' )
    );
  
    register_post_type( 'food_menu', $args );

}


function ebor_framework_register_team() {

$displays = get_option('ebor_framework_cpt_display_options');

if( $displays['team_slug'] ){ $slug = $displays['team_slug']; } else { $slug = 'team'; }

    $labels = array( 
        'name' => __( 'Team Members', 'ebor' ),
        'singular_name' => __( 'Team Member', 'ebor' ),
        'add_new' => __( 'Add New', 'ebor' ),
        'add_new_item' => __( 'Add New Team Member', 'ebor' ),
        'edit_item' => __( 'Edit Team Member', 'ebor' ),
        'new_item' => __( 'New Team Member', 'ebor' ),
        'view_item' => __( 'View Team Member', 'ebor' ),
        'search_items' => __( 'Search Team Members', 'ebor' ),
        'not_found' => __( 'No Team Members found', 'ebor' ),
        'not_found_in_trash' => __( 'No Team Members found in Trash', 'ebor' ),
        'parent_item_colon' => __( 'Parent Team Member:', 'ebor' ),
        'menu_name' => __( 'Team Members', 'ebor' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Team Member entries for the ebor Theme.', 'ebor'),
        'supports' => array( 'title', 'thumbnail', 'editor' ),
        'public' => true,
        'show_in_rest' => true, // wheather or not to make the new custom post_type avaialble on WP REST API
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-groups',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => $slug ),
        'capability_type' => 'post'
    );

    register_post_type( 'team', $args );
}

function ebor_framework_create_team_taxonomies(){
	
	$labels = array(
		'name' => _x( 'Team Categories','ebor' ),
		'singular_name' => _x( 'Team Category','ebor' ),
		'search_items' =>  __( 'Search Team Categories','ebor' ),
		'all_items' => __( 'All Team Categories','ebor' ),
		'parent_item' => __( 'Parent Team Category','ebor' ),
		'parent_item_colon' => __( 'Parent Team Category:','ebor' ),
		'edit_item' => __( 'Edit Team Category','ebor' ), 
		'update_item' => __( 'Update Team Category','ebor' ),
		'add_new_item' => __( 'Add New Team Category','ebor' ),
		'new_item_name' => __( 'New Team Category Name','ebor' ),
		'menu_name' => __( 'Team Categories','ebor' ),
	); 
		
	register_taxonomy('team_category', array('team'), array(
		'hierarchical' => true,
		'labels' => $labels,
        'show_in_rest' => true, // wheather or not to make the new custom taxonomy avaialble on WP REST API
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => true,
	));
  
}

function ebor_framework_register_client() {

    $labels = array( 
        'name' => __( 'Clients', 'ebor' ),
        'singular_name' => __( 'Client', 'ebor' ),
        'add_new' => __( 'Add New', 'ebor' ),
        'add_new_item' => __( 'Add New Client', 'ebor' ),
        'edit_item' => __( 'Edit Client', 'ebor' ),
        'new_item' => __( 'New Client', 'ebor' ),
        'view_item' => __( 'View Client', 'ebor' ),
        'search_items' => __( 'Search Clients', 'ebor' ),
        'not_found' => __( 'No Clients found', 'ebor' ),
        'not_found_in_trash' => __( 'No Clients found in Trash', 'ebor' ),
        'parent_item_colon' => __( 'Parent Client:', 'ebor' ),
        'menu_name' => __( 'Clients', 'ebor' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Client entries.', 'ebor'),
        'supports' => array( 'title', 'thumbnail' ),
        'public' => false,
        'show_in_rest' => true, // wheather or not to make the new custom post_type avaialble on WP REST API
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-businessman',
        'show_in_nav_menus' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => false,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'client', $args );
}

function ebor_framework_create_client_taxonomies(){
	
	$labels = array(
		'name' => _x( 'Client Categories','ebor' ),
		'singular_name' => _x( 'Client Category','ebor' ),
		'search_items' =>  __( 'Search Client Categories','ebor' ),
		'all_items' => __( 'All Client Categories','ebor' ),
		'parent_item' => __( 'Parent Client Category','ebor' ),
		'parent_item_colon' => __( 'Parent Client Category:','ebor' ),
		'edit_item' => __( 'Edit Client Category','ebor' ), 
		'update_item' => __( 'Update Client Category','ebor' ),
		'add_new_item' => __( 'Add New Client Category','ebor' ),
		'new_item_name' => __( 'New Client Category Name','ebor' ),
		'menu_name' => __( 'Client Categories','ebor' ),
	); 
		
	register_taxonomy('client_category', array('client'), array(
		'hierarchical' => true,
		'labels' => $labels,
        'show_in_rest' => true, // wheather or not to make the new custom taxonomy avaialble on WP REST API
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => true,
	));
  
}

function ebor_framework_register_testimonial() {

    $labels = array( 
        'name' => __( 'Testimonials', 'ebor' ),
        'singular_name' => __( 'Testimonial', 'ebor' ),
        'add_new' => __( 'Add New', 'ebor' ),
        'add_new_item' => __( 'Add New Testimonial', 'ebor' ),
        'edit_item' => __( 'Edit Testimonial', 'ebor' ),
        'new_item' => __( 'New Testimonial', 'ebor' ),
        'view_item' => __( 'View Testimonial', 'ebor' ),
        'search_items' => __( 'Search Testimonials', 'ebor' ),
        'not_found' => __( 'No Testimonials found', 'ebor' ),
        'not_found_in_trash' => __( 'No Testimonials found in Trash', 'ebor' ),
        'parent_item_colon' => __( 'Parent Testimonial:', 'ebor' ),
        'menu_name' => __( 'Testimonials', 'ebor' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Testimonial entries.', 'ebor'),
        'supports' => array( 'title', 'editor' ),
        'public' => false,
        'show_in_rest' => true, // wheather or not to make the new custom post_type avaialble on WP REST API
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-editor-quote',
        'show_in_nav_menus' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => false,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'testimonial', $args );
}

function ebor_framework_create_testimonial_taxonomies(){
	
	$labels = array(
		'name' => _x( 'Testimonial Categories','ebor' ),
		'singular_name' => _x( 'Testimonial Category','ebor' ),
		'search_items' =>  __( 'Search Testimonial Categories','ebor' ),
		'all_items' => __( 'All Testimonial Categories','ebor' ),
		'parent_item' => __( 'Parent Testimonial Category','ebor' ),
		'parent_item_colon' => __( 'Parent Testimonial Category:','ebor' ),
		'edit_item' => __( 'Edit Testimonial Category','ebor' ), 
		'update_item' => __( 'Update Testimonial Category','ebor' ),
		'add_new_item' => __( 'Add New Testimonial Category','ebor' ),
		'new_item_name' => __( 'New Testimonial Category Name','ebor' ),
		'menu_name' => __( 'Testimonial Categories','ebor' ),
	); 
		
	register_taxonomy('testimonial_category', array('testimonial'), array(
		'hierarchical' => true,
		'labels' => $labels,
        'show_in_rest' => true, // wheather or not to make the new custom taxonomy avaialble on WP REST API
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => true,
	));
  
}

function ebor_framework_create_faq_taxonomies(){
    
    $labels = array(
        'name' => _x( 'FAQ Categories','ebor' ),
        'singular_name' => _x( 'FAQ Category','ebor' ),
        'search_items' =>  __( 'Search FAQ Categories','ebor' ),
        'all_items' => __( 'All FAQ Categories','ebor' ),
        'parent_item' => __( 'Parent FAQ Category','ebor' ),
        'parent_item_colon' => __( 'Parent FAQ Category:','ebor' ),
        'edit_item' => __( 'Edit FAQ Category','ebor' ), 
        'update_item' => __( 'Update FAQ Category','ebor' ),
        'add_new_item' => __( 'Add New FAQ Category','ebor' ),
        'new_item_name' => __( 'New FAQ Category Name','ebor' ),
        'menu_name' => __( 'FAQ Categories','ebor' ),
    ); 
        
    register_taxonomy('faq_category', array('faq'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_in_rest' => true, // wheather or not to make the new custom taxonomy avaialble on WP REST API
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => true,
    ));
  
}

function ebor_framework_register_faq() {

    $labels = array( 
        'name' => __( 'FAQs', 'ebor' ),
        'singular_name' => __( 'FAQ', 'ebor' ),
        'add_new' => __( 'Add New', 'ebor' ),
        'add_new_item' => __( 'Add New FAQ', 'ebor' ),
        'edit_item' => __( 'Edit FAQ', 'ebor' ),
        'new_item' => __( 'New FAQ', 'ebor' ),
        'view_item' => __( 'View FAQ', 'ebor' ),
        'search_items' => __( 'Search FAQs', 'ebor' ),
        'not_found' => __( 'No faqs found', 'ebor' ),
        'not_found_in_trash' => __( 'No FAQs found in Trash', 'ebor' ),
        'parent_item_colon' => __( 'Parent FAQ:', 'ebor' ),
        'menu_name' => __( 'FAQs', 'ebor' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('FAQ Entries.', 'ebor'),
        'supports' => array( 'title', 'editor' ),
        'public' => true,
        'show_in_rest' => true, // wheather or not to make the new custom post_type avaialble on WP REST API
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'faq', $args );
}