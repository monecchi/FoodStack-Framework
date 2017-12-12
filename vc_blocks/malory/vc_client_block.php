<?php 

/**
 * The Shortcode
 */
function ebor_client_shortcode( $atts ) {
	extract( 
		shortcode_atts( 
			array(
				'pppage' => '8',
				'filter' => 'all'
			), $atts 
		) 
	);
	
	/**
	 * Setup post query
	 */
	$query_args = array(
		'post_type' => 'client',
		'posts_per_page' => $pppage
	);
	
	if (!( $filter == 'all' )) {
		if( function_exists( 'icl_object_id' ) ){
			$filter = (int)icl_object_id( $filter, 'client_category', true);
		}
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'client_category',
				'field' => 'id',
				'terms' => $filter
			)
		);
	}
	
	global $wp_query, $post;
	$old_post = $post;
	$wp_query = new WP_Query( $query_args );
	
	ob_start();
	
	get_template_part('loop/loop-client', 'carousel');
	
	$output = ob_get_contents();
	ob_end_clean();

	wp_reset_postdata();
	$post = $old_post;
	
	return $output;
}
add_shortcode( 'malory_client', 'ebor_client_shortcode' );

/**
 * The VC Functions
 */
function ebor_client_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'malory-vc-block',
			"name" => esc_html__("Client Feeds", 'malory'),
			"base" => "malory_client",
			"category" => esc_html__('malory WP Theme', 'malory'),
			'description' => 'Show client posts with layout options.',
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Show How Many Posts?", 'malory'),
					"param_name" => "pppage",
					"value" => '8'
				)
			)
		) 
	);
}
add_action( 'vc_before_init', 'ebor_client_shortcode_vc');