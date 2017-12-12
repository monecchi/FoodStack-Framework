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
        <h2><span class="dashicons dashicons-align-left" style="width:35px; height:35px; vertical-align:middle; font-size:35px;"></span> <?php echo $theme->get( 'Name' ) . __(' Custom Post Type Settings','ebor-framework'); ?></h2>
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
        'name' => __( 'Ebor Mega Menu', 'ebor-framework' ),
        'singular_name' => __( 'Ebor Mega Menu Item', 'ebor-framework' ),
        'add_new' => __( 'Add New', 'ebor-framework' ),
        'add_new_item' => __( 'Add New Ebor Mega Menu Item', 'ebor-framework' ),
        'edit_item' => __( 'Edit Ebor Mega Menu Item', 'ebor-framework' ),
        'new_item' => __( 'New Ebor Mega Menu Item', 'ebor-framework' ),
        'view_item' => __( 'View Ebor Mega Menu Item', 'ebor-framework' ),
        'search_items' => __( 'Search Ebor Mega Menu Items', 'ebor-framework' ),
        'not_found' => __( 'No Ebor Mega Menu Items found', 'ebor-framework' ),
        'not_found_in_trash' => __( 'No Ebor Mega Menu Items found in Trash', 'ebor-framework' ),
        'parent_item_colon' => __( 'Parent Ebor Mega Menu Item:', 'ebor-framework' ),
        'menu_name' => __( 'Ebor Mega Menu', 'ebor-framework' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'menu_icon' => 'dashicons-menu',
        'description' => __('Mega Menus entries for the theme.', 'ebor-framework'),
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
        'name' => __( 'Portfolio', 'ebor-framework' ),
        'singular_name' => __( 'Portfolio', 'ebor-framework' ),
        'add_new' => __( 'Add New', 'ebor-framework' ),
        'add_new_item' => __( 'Add New Portfolio', 'ebor-framework' ),
        'edit_item' => __( 'Edit Portfolio', 'ebor-framework' ),
        'new_item' => __( 'New Portfolio', 'ebor-framework' ),
        'view_item' => __( 'View Portfolio', 'ebor-framework' ),
        'search_items' => __( 'Search Portfolios', 'ebor-framework' ),
        'not_found' => __( 'No portfolios found', 'ebor-framework' ),
        'not_found_in_trash' => __( 'No portfolios found in Trash', 'ebor-framework' ),
        'parent_item_colon' => __( 'Parent Portfolio:', 'ebor-framework' ),
        'menu_name' => __( 'Portfolio', 'ebor-framework' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Portfolio entries for the ebor Theme.', 'ebor-framework'),
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
	    'name' => __( 'Portfolio Categories','ebor-framework' ),
	    'singular_name' => __( 'Portfolio Category','ebor-framework' ),
	    'search_items' =>  __( 'Search Portfolio Categories','ebor-framework' ),
	    'all_items' => __( 'All Portfolio Categories','ebor-framework' ),
	    'parent_item' => __( 'Parent Portfolio Category','ebor-framework' ),
	    'parent_item_colon' => __( 'Parent Portfolio Category:','ebor-framework' ),
	    'edit_item' => __( 'Edit Portfolio Category','ebor-framework' ), 
	    'update_item' => __( 'Update Portfolio Category','ebor-framework' ),
	    'add_new_item' => __( 'Add New Portfolio Category','ebor-framework' ),
	    'new_item_name' => __( 'New Portfolio Category Name','ebor-framework' ),
	    'menu_name' => __( 'Portfolio Categories','ebor-framework' ),
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

/**
 * Food Menu Categories - Register custom taxonomy 
 * @see https://codex.wordpress.org/Function_Reference/register_taxonomy [Wordpress Codex]
 */

function ebor_framework_create_food_menu_taxonomies(){

$displays = get_option('ebor_framework_cpt_display_options');
 if( $displays['food_cat_slug'] ){ $slug = $displays['food_cat_slug']; } else { $slug = 'food_menu_categories'; }

	$labels = array(
	    'name' => __( 'Food Menu Types','ebor-framework' ),
	    'singular_name' => __( 'Food Menu Category','ebor-framework' ),
	    'search_items' =>  __( 'Search Food Menu Categories','ebor-framework' ),
	    'all_items' => __( 'All Food Menu Categories','ebor-framework' ),
	    'parent_item' => __( 'Parent Food Menu Category','ebor-framework' ),
	    'parent_item_colon' => __( 'Parent Food Menu Category:','ebor-framework' ),
	    'edit_item' => __( 'Edit Food Menu Category','ebor-framework' ), 
	    'update_item' => __( 'Update Food Menu Category','ebor-framework' ),
	    'add_new_item' => __( 'Add New Food Menu Category','ebor-framework' ),
	    'new_item_name' => __( 'New Food Menu Category Name','ebor-framework' ),
	    'menu_name' => __( 'Food Menu Categories','ebor-framework' ),
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
        'description' => __('Manages all the Food Menu Categories', 'ebor-framework'),
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

// Food Menu Tags - Add new taxonomy food_tags, NOT hierarchical tags (like post_tags)

function ebor_framework_create_food_menu_tags() {

$displays = get_option('ebor_framework_cpt_display_options');
if( $displays['food_tag_slug'] ){ $slug = $displays['food_tag_slug']; } else { $slug = 'food_tag'; }

    $labels = array(
        'name'                       => _x( 'Ingredients', 'taxonomy food_tags general name', 'ebor-framework' ),
        'singular_name'              => _x( 'Ingredient', 'taxonomy food_tags singular name', 'ebor-framework' ),
        'search_items'               => __( 'Search Ingredients', 'ebor-framework' ),
        'popular_items'              => __( 'Popular Ingredients', 'ebor-framework' ),
        'all_items'                  => __( 'All Ingredients', 'ebor-framework' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Edit Ingredient', 'ebor-framework' ),
        'update_item'                => __( 'Update Ingredient', 'ebor-framework' ),
        'add_new_item'               => __( 'Add New Ingredient', 'ebor-framework' ),
        'new_item_name'              => __( 'New Ingredient Name', 'ebor-framework' ),
        'separate_items_with_commas' => __( 'Separate ingredients with commas', 'ebor-framework' ),
        'add_or_remove_items'        => __( 'Add or remove Ingredients', 'ebor-framework' ),
        'choose_from_most_used'      => __( 'Choose from the most used Ingredients', 'ebor-framework' ),
        'not_found'                  => __( 'No Ingredient found.', 'ebor-framework' ),
        'menu_name'                  => __( 'Ingredients', 'ebor-framework' ),
    );

  // Custom Meu Rancho Tags for the food_menu post type
  //  array( 'sort' => true, 'args' => array( 'orderby' => 'term_order' ) ) );
   register_taxonomy('food_tag', array('food_menu'), array(
    'description' => __('Acting like post tags, it manages all the food menu ingredients.', 'ebor-framework'),
    'hierarchical' => false, // NOT hierarchical tags (like post_tags)
    'sort' => true, 'args' => array('orderby' => 'term_order'), // if is a non hierarchical taxonomy such as post_tag, then sorts the taxonomy terms by entry order.
    'labels' => $labels,
    'show_ui'           => true,
    'show_in_rest'      => true,  // wheather or not to make the new custom taxonomy avaialble on WP REST API
    'rest_base'         => 'ingrediente',
    'rest_controller_class' => 'WP_REST_Terms_Controller',
    'show_admin_column' => true,
    //'update_count_callback' => '_update_post_term_count',
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
        'name' => __( 'Food Menus', 'ebor-framework' ),
        'singular_name' => _x( 'Food Menu', 'Sidebar Nav Menu - All Food Menu Items', 'ebor-framework' ),
        'add_new' => _x( 'Add New Food Menu', 'Sidebar Nav Menu', 'ebor-framework' ), 
        'add_new_item' => _x( 'Add New Food Menu', 'Add New Item Page Title', 'ebor-framework' ),  
        'edit_item' => _x( 'Edit Food Menu Item', 'Edit Item Page Title', 'ebor-framework' ),
        'new_item' => _x( 'New Food Menu Item', 'Action Button - Add New Item', 'ebor-framework' ), 
        'view_item' => __( 'View Food Menu Item', 'ebor-framework' ),
        'search_items' => __( 'Search Food Menu Items', 'ebor-framework' ),
        'not_found' => __( 'No Food Menu found', 'ebor-framework' ),
        'not_found_in_trash' => __( 'No Food Menu found in Trash', 'ebor-framework' ),
        'parent_item_colon' => __( 'Parent Food Menu:', 'ebor-framework' ),
        'menu_name' => __( 'Food Menu', 'ebor-framework' ),
    );

    // $args = array( 
    //     'labels' => $labels,
    //     'hierarchical' => false,
    //     'description' => __('Food Menu entries.', 'ebor-framework'),
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
        'description' => __('Food Menu entries.', 'ebor-framework'),
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
        'rest_base'          => 'cardapios',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'tags', 'excerpt' ) // array( 'title', 'editor', 'author', 'thumbnail', 'post-formats', 'tags', 'excerpt', 'comments' )
    );
  
    register_post_type( 'food_menu', $args );

}


function ebor_framework_register_team() {

$displays = get_option('ebor_framework_cpt_display_options');

if( $displays['team_slug'] ){ $slug = $displays['team_slug']; } else { $slug = 'team'; }

    $labels = array( 
        'name' => __( 'Team Members', 'ebor-framework' ),
        'singular_name' => __( 'Team Member', 'ebor-framework' ),
        'add_new' => __( 'Add New Team Member', 'ebor-framework' ),
        'add_new_item' => __( 'Add New Team Member', 'ebor-framework' ),
        'edit_item' => __( 'Edit Team Member', 'ebor-framework' ),
        'new_item' => __( 'New Team Member', 'ebor-framework' ),
        'view_item' => __( 'View Team Member', 'ebor-framework' ),
        'search_items' => __( 'Search Team Members', 'ebor-framework' ),
        'not_found' => __( 'No Team Members found', 'ebor-framework' ),
        'not_found_in_trash' => __( 'No Team Members found in Trash', 'ebor-framework' ),
        'parent_item_colon' => __( 'Parent Team Member:', 'ebor-framework' ),
        'menu_name' => __( 'Team Members', 'ebor-framework' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Team Member entries for the ebor Theme.', 'ebor-framework'),
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
		'name' => __( 'Team Categories','ebor-framework' ),
		'singular_name' => __( 'Team Category','ebor-framework' ),
		'search_items' =>  __( 'Search Team Categories','ebor-framework' ),
		'all_items' => __( 'All Team Categories','ebor-framework' ),
		'parent_item' => __( 'Parent Team Category','ebor-framework' ),
		'parent_item_colon' => __( 'Parent Team Category:','ebor-framework' ),
		'edit_item' => __( 'Edit Team Category','ebor-framework' ), 
		'update_item' => __( 'Update Team Category','ebor-framework' ),
		'add_new_item' => __( 'Add New Team Category','ebor-framework' ),
		'new_item_name' => __( 'New Team Category Name','ebor-framework' ),
		'menu_name' => __( 'Team Categories','ebor-framework' ),
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
        'name' => __( 'Clients', 'ebor-framework' ),
        'singular_name' => __( 'Client', 'ebor-framework' ),
        'add_new' => __( 'Add New Client', 'ebor-framework' ),
        'add_new_item' => __( 'Add New Client', 'ebor-framework' ),
        'edit_item' => __( 'Edit Client', 'ebor-framework' ),
        'new_item' => __( 'New Client', 'ebor-framework' ),
        'view_item' => __( 'View Client', 'ebor-framework' ),
        'search_items' => __( 'Search Clients', 'ebor-framework' ),
        'not_found' => __( 'No Clients found', 'ebor-framework' ),
        'not_found_in_trash' => __( 'No Clients found in Trash', 'ebor-framework' ),
        'parent_item_colon' => __( 'Parent Client:', 'ebor-framework' ),
        'menu_name' => __( 'Clients', 'ebor-framework' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Client entries.', 'ebor-framework'),
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
		'name' => __( 'Client Categories','ebor-framework' ),
		'singular_name' => __( 'Client Category','ebor-framework' ),
		'search_items' =>  __( 'Search Client Categories','ebor-framework' ),
		'all_items' => __( 'All Client Categories','ebor-framework' ),
		'parent_item' => __( 'Parent Client Category','ebor-framework' ),
		'parent_item_colon' => __( 'Parent Client Category:','ebor-framework' ),
		'edit_item' => __( 'Edit Client Category','ebor-framework' ), 
		'update_item' => __( 'Update Client Category','ebor-framework' ),
		'add_new_item' => __( 'Add New Client Category','ebor-framework' ),
		'new_item_name' => __( 'New Client Category Name','ebor-framework' ),
		'menu_name' => __( 'Client Categories','ebor-framework' ),
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
        'name' => __( 'Testimonials', 'ebor-framework' ),
        'singular_name' => __( 'Testimonial', 'ebor-framework' ),
        'add_new' => __( 'Add New', 'ebor-framework' ),
        'add_new_item' => __( 'Add New Testimonial', 'ebor-framework' ),
        'edit_item' => __( 'Edit Testimonial', 'ebor-framework' ),
        'new_item' => __( 'New Testimonial', 'ebor-framework' ),
        'view_item' => __( 'View Testimonial', 'ebor-framework' ),
        'search_items' => __( 'Search Testimonials', 'ebor-framework' ),
        'not_found' => __( 'No Testimonials found', 'ebor-framework' ),
        'not_found_in_trash' => __( 'No Testimonials found in Trash', 'ebor-framework' ),
        'parent_item_colon' => __( 'Parent Testimonial:', 'ebor-framework' ),
        'menu_name' => __( 'Testimonials', 'ebor-framework' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Testimonial entries.', 'ebor-framework'),
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
		'name' => __( 'Testimonial Categories','ebor-framework' ),
		'singular_name' => __( 'Testimonial Category','ebor-framework' ),
		'search_items' =>  __( 'Search Testimonial Categories','ebor-framework' ),
		'all_items' => __( 'All Testimonial Categories','ebor-framework' ),
		'parent_item' => __( 'Parent Testimonial Category','ebor-framework' ),
		'parent_item_colon' => __( 'Parent Testimonial Category:','ebor-framework' ),
		'edit_item' => __( 'Edit Testimonial Category','ebor-framework' ), 
		'update_item' => __( 'Update Testimonial Category','ebor-framework' ),
		'add_new_item' => __( 'Add New Testimonial Category','ebor-framework' ),
		'new_item_name' => __( 'New Testimonial Category Name','ebor-framework' ),
		'menu_name' => __( 'Testimonial Categories','ebor-framework' ),
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
        'name' => __( 'FAQ Categories','ebor-framework' ),
        'singular_name' => __( 'FAQ Category','ebor-framework' ),
        'search_items' =>  __( 'Search FAQ Categories','ebor-framework' ),
        'all_items' => __( 'All FAQ Categories','ebor-framework' ),
        'parent_item' => __( 'Parent FAQ Category','ebor-framework' ),
        'parent_item_colon' => __( 'Parent FAQ Category:','ebor-framework' ),
        'edit_item' => __( 'Edit FAQ Category','ebor-framework' ), 
        'update_item' => __( 'Update FAQ Category','ebor-framework' ),
        'add_new_item' => __( 'Add New FAQ Category','ebor-framework' ),
        'new_item_name' => __( 'New FAQ Category Name','ebor-framework' ),
        'menu_name' => __( 'FAQ Categories','ebor-framework' ),
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
        'name' => __( 'FAQs', 'ebor-framework' ),
        'singular_name' => __( 'FAQ', 'ebor-framework' ),
        'add_new' => __( 'Add New', 'ebor-framework' ),
        'add_new_item' => __( 'Add New FAQ', 'ebor-framework' ),
        'edit_item' => __( 'Edit FAQ', 'ebor-framework' ),
        'new_item' => __( 'New FAQ', 'ebor-framework' ),
        'view_item' => __( 'View FAQ', 'ebor-framework' ),
        'search_items' => __( 'Search FAQs', 'ebor-framework' ),
        'not_found' => __( 'No faqs found', 'ebor-framework' ),
        'not_found_in_trash' => __( 'No FAQs found in Trash', 'ebor-framework' ),
        'parent_item_colon' => __( 'Parent FAQ:', 'ebor-framework' ),
        'menu_name' => __( 'FAQs', 'ebor-framework' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('FAQ Entries.', 'ebor-framework'),
        'supports' => array( 'title', 'editor', 'thumbnail', ),
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

function ebor_framework_register_class() {

    $labels = array( 
        'name' => __( 'Classes', 'ebor-framework' ),
        'singular_name' => __( 'Class', 'ebor-framework' ),
        'add_new' => __( 'Add New', 'ebor-framework' ),
        'add_new_item' => __( 'Add New Class', 'ebor-framework' ),
        'edit_item' => __( 'Edit Class', 'ebor-framework' ),
        'new_item' => __( 'New Class', 'ebor-framework' ),
        'view_item' => __( 'View Class', 'ebor-framework' ),
        'search_items' => __( 'Search Classes', 'ebor-framework' ),
        'not_found' => __( 'No Classes found', 'ebor-framework' ),
        'not_found_in_trash' => __( 'No Classes found in Trash', 'ebor-framework' ),
        'parent_item_colon' => __( 'Parent Classes:', 'ebor-framework' ),
        'menu_name' => __( 'Classes', 'ebor-framework' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Class Entries.', 'ebor-framework'),
        'supports' => array( 'title', 'editor', 'thumbnail', 'author' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => 'classes' ),
        'capability_type' => 'post'
    );

    register_post_type( 'class', $args );
}

function ebor_framework_create_class_taxonomies(){
    
    $labels = array(
        'name' => __( 'Class Categories','ebor-framework' ),
        'singular_name' => __( 'Class Category','ebor-framework' ),
        'search_items' =>  __( 'Search Class Categories','ebor-framework' ),
        'all_items' => __( 'All Class Categories','ebor-framework' ),
        'parent_item' => __( 'Parent Class Category','ebor-framework' ),
        'parent_item_colon' => __( 'Parent Class Category:','ebor-framework' ),
        'edit_item' => __( 'Edit Class Category','ebor-framework' ), 
        'update_item' => __( 'Update Class Category','ebor-framework' ),
        'add_new_item' => __( 'Add New Class Category','ebor-framework' ),
        'new_item_name' => __( 'New Class Category Name','ebor-framework' ),
        'menu_name' => __( 'Class Categories','ebor-framework' ),
    ); 
        
    register_taxonomy('class_category', array('class'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => false,
        'rewrite' => false,
    ));
  
}

function ebor_framework_register_service() {

    $labels = array( 
        'name' => __( 'Services', 'ebor-framework' ),
        'singular_name' => __( 'Service', 'ebor-framework' ),
        'add_new' => __( 'Add New', 'ebor-framework' ),
        'add_new_item' => __( 'Add New Service', 'ebor-framework' ),
        'edit_item' => __( 'Edit Service', 'ebor-framework' ),
        'new_item' => __( 'New Service', 'ebor-framework' ),
        'view_item' => __( 'View Service', 'ebor-framework' ),
        'search_items' => __( 'Search Services', 'ebor-framework' ),
        'not_found' => __( 'No Services found', 'ebor-framework' ),
        'not_found_in_trash' => __( 'No Services found in Trash', 'ebor-framework' ),
        'parent_item_colon' => __( 'Parent Service:', 'ebor-framework' ),
        'menu_name' => __( 'Services', 'ebor-framework' ),
    );
     
     $args = array( 
         'labels' => $labels,
         'hierarchical' => false,
         'description' => __('Service entries.', 'ebor-framework'),
         'supports' => array( 'title', 'thumbnail', 'editor', 'excerpt', 'author' ),
         'taxonomies' => array( 'service_category' ),
         'public' => true,
         'show_ui' => true,
         'show_in_menu' => true,
         'menu_position' => 5,
         'menu_icon' => 'dashicons-shield-alt',
         
         'show_in_nav_menus' => true,
         'publicly_queryable' => true,
         'exclude_from_search' => false,
         'has_archive' => true,
         'query_var' => true,
         'can_export' => true,
         'rewrite' => array( 'slug' => 'services' ),
         'capability_type' => 'post'
     );

    register_post_type( 'service', $args );
}

function ebor_framework_create_service_taxonomies(){
    
    $labels = array(
        'name' => __( 'Service Categories','ebor-framework' ),
        'singular_name' => __( 'Service Category','ebor-framework' ),
        'search_items' =>  __( 'Search Service Categories','ebor-framework' ),
        'all_items' => __( 'All Service Categories','ebor-framework' ),
        'parent_item' => __( 'Parent Service Category','ebor-framework' ),
        'parent_item_colon' => __( 'Parent Service Category:','ebor-framework' ),
        'edit_item' => __( 'Edit Service Category','ebor-framework' ), 
        'update_item' => __( 'Update Service Category','ebor-framework' ),
        'add_new_item' => __( 'Add New Service Category','ebor-framework' ),
        'new_item_name' => __( 'New Service Category Name','ebor-framework' ),
        'menu_name' => __( 'Service Categories','ebor-framework' ),
    ); 
        
    register_taxonomy('service_category', array('service'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => true,
    ));
  
}

function ebor_framework_register_case_study() {

$displays = get_option('ebor_framework_cpt_display_options');

if( $displays['case_studies_slug'] ){ $slug = $displays['case_studies_slug']; } else { $slug = 'case-studies'; }

    $labels = array( 
        'name' => __( 'Case Studies', 'ebor-framework' ),
        'singular_name' => __( 'Case Study', 'ebor-framework' ),
        'add_new' => __( 'Add New', 'ebor-framework' ),
        'add_new_item' => __( 'Add New Case Study', 'ebor-framework' ),
        'edit_item' => __( 'Edit Case Study', 'ebor-framework' ),
        'new_item' => __( 'New Case Study', 'ebor-framework' ),
        'view_item' => __( 'View Case Study', 'ebor-framework' ),
        'search_items' => __( 'Search Case Studies', 'ebor-framework' ),
        'not_found' => __( 'No Case Studies found', 'ebor-framework' ),
        'not_found_in_trash' => __( 'No Case Studies found in Trash', 'ebor-framework' ),
        'parent_item_colon' => __( 'Parent Case Study:', 'ebor-framework' ),
        'menu_name' => __( 'Case Studies', 'ebor-framework' ),
    );
     
     $args = array( 
         'labels' => $labels,
         'hierarchical' => false,
         'description' => __('Case Study entries.', 'ebor-framework'),
         'supports' => array( 'title', 'thumbnail', 'editor', 'excerpt', 'author' ),
         'taxonomies' => array( 'case_study_category' ),
         'public' => true,
         'show_ui' => true,
         'show_in_menu' => true,
         'menu_position' => 5,
         'menu_icon' => 'dashicons-chart-area',
         
         'show_in_nav_menus' => true,
         'publicly_queryable' => true,
         'exclude_from_search' => false,
         'has_archive' => true,
         'query_var' => true,
         'can_export' => true,
         'rewrite' => array( 'slug' => $slug ),
         'capability_type' => 'post'
     );

    register_post_type( 'case_study', $args );
}

function ebor_framework_create_case_study_taxonomies(){
    
    $labels = array(
        'name' => __( 'Case Study Categories','ebor-framework' ),
        'singular_name' => __( 'Case Study Category','ebor-framework' ),
        'search_items' =>  __( 'Search Case Study Categories','ebor-framework' ),
        'all_items' => __( 'All Case Study Categories','ebor-framework' ),
        'parent_item' => __( 'Parent Case Study Category','ebor-framework' ),
        'parent_item_colon' => __( 'Parent Case Study Category:','ebor-framework' ),
        'edit_item' => __( 'Edit Case Study Category','ebor-framework' ), 
        'update_item' => __( 'Update Case Study Category','ebor-framework' ),
        'add_new_item' => __( 'Add New Case Study Category','ebor-framework' ),
        'new_item_name' => __( 'New Case Study Category Name','ebor-framework' ),
        'menu_name' => __( 'Case Study Categories','ebor-framework' ),
    ); 
        
    register_taxonomy('case_study_category', array('case_study'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => true,
    ));
  
}