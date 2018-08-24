<?php 

/**
 * The Shortcode
 */
function ebor_services_image_block_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'layout' => 'standard',
				'link'   => '',
				'image'  => '',
				'title'  => '',
				'mask'   => 'no-mask',
				'custom_css_class' => ''
			), $atts 
		) 
	);
	
	$link   = vc_build_link( $link );
	$before = ( isset( $link['url'] ) && $link['url'] !== '' ) ? '<a href="'. esc_url( $link['url'] ) .'">' : '';
	$after  = ( is_array( $link ) ) ? '</a>' : '';
		
	if( 'standard' == $layout ){
	
		$output = '
			<figure class="wpb_content_element overlay-info '. $mask .' '. esc_attr( $custom_css_class ).'">
				
				'. $before .'
					'. wp_get_attachment_image( $image, 'large' ) .'
				'. $after.'
				
				<figcaption class="d-flex">
					<div class="align-self-center mx-auto">
						<h4 class="mb-0 text-uppercase letterspace-4">'. $title .'</h4>
					</div>
				</figcaption>
				
			</figure>
		';
	
	} elseif( 'bordered' == $layout ){
	
		$output = '
			<figure class="wpb_content_element overlay-info bordered '. $mask .' '. esc_attr( $custom_css_class ).'">
				
				'. $before .'
					'. wp_get_attachment_image( $image, 'large' ) .'
				'. $after.'
				
				<figcaption class="d-flex">
					<div class="align-self-center mx-auto">
						<h4 class="mb-0 text-uppercase letterspace-4">'. $title .'</h4>
					</div>
				</figcaption>
				
			</figure>
		';
	
	} elseif( 'gradient' == $layout ){
	
		$output = '
			<figure class="wpb_content_element overlay overlay4 '. $mask .' '. esc_attr( $custom_css_class ).'">
				
				'. $before .'
					<span>'. wp_get_attachment_image( $image, 'large' ) .'</span>
				'. $after.'
				
				<figcaption class="d-flex">
					<div class="align-self-end mx-auto">
						<h4 class="mb-0 text-uppercase letterspace-4">'. $title .'</h4>
					</div>
				</figcaption>
				
			</figure>
		';
	
	} elseif( 'rounded' == $layout ){
	
		$output = '
			<figure class="wpb_content_element overlay-info rounded '. $mask .' '. esc_attr( $custom_css_class ).'">
				
				'. $before .'
					'. wp_get_attachment_image( $image, 'large' ) .'
				'. $after.'
				
				<figcaption class="d-flex">
					<div class="align-self-center mx-auto">
						<h4 class="mb-0 text-uppercase letterspace-4">'. $title .'</h4>
					</div>
				</figcaption>
				
			</figure>
		';
	
	}

	return $output;
}
add_shortcode( 'brailie_services_image_block', 'ebor_services_image_block_shortcode' );

/**
 * The VC Functions
 */
function ebor_services_image_block_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'brailie-vc-block',
			"name" => esc_html__("Services - Image", 'brailie'),
			"base" => "brailie_services_image_block",
			"category" => esc_html__('brailie WP Theme', 'brailie'),
			'description' => 'Service image block with selectable layouts',
			"params" => array(
				array(
					"type"       => "dropdown",
					"heading"    => esc_html__("Display type", 'brailie'),
					"param_name" => "layout",
					"value"      => array(
						'Standard' => 'standard',
						'Bordered' => 'bordered',
						'Gradient' => 'gradient',
						'Rounded'  => 'rounded'
					)
				),
				array(
					"type"       => "vc_link",
					"heading"    => esc_html__("Link this block?", 'brailie'),
					"param_name" => "link"
				),
				array(
					"type"       => "attach_image",
					"heading"    => esc_html__("Block Image", 'brailie'),
					"param_name" => "image"
				),
				array(
					"type"       => "textfield",
					"heading"    => esc_html__("Block Title", 'brailie'),
					"param_name" => "title",
					'holder'     => 'div'
				),
				array(
					"type"       => "dropdown",
					"heading"    => esc_html__("Clipping Mask", 'brailie'),
					"param_name" => "mask",
					"value"      => array(
						'None' => 'no-mask',
						'Octagon'  => 'octagon',
						'Rhombus'  => 'rhombus',
						'Pentagon' => 'pentagon',
						'Bevel'    => 'bevel',
						'Heptagon' => 'heptagon',
						'Rabbet'   => 'rabbet'
					)
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Extra CSS Class Name", 'stackwordpresstheme'),
					"param_name" => "custom_css_class",
					"description" => '<code>DEVELOPERS ONLY</code> - Style particular content element differently - add a class name and refer to it in custom CSS.',
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'ebor_services_image_block_shortcode_vc' );