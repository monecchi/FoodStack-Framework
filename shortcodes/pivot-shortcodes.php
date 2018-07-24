<?php 

/**
 * Ebor Pivot Button shortcode
 * @uses extract()
 * @uses shortcode_atts()
 * @uses shortcode on page content e.g: [pivot_button url="" class="" target="" text=""]
 */
if(!( function_exists('ebor_pivot_button') )){
	function ebor_pivot_button( $atts, $content = null ){
		extract(shortcode_atts(array(
			'url' => '#',
		    'appearance' => 'btn-success',
		    'target' => '_self',
	        'alt_text' => '',
		    'text' => 'Default Button Text'
		), $atts ));
		ob_start();
		
		if( 'default' == $target )
			$target = '_self';
		
		$content = '';
		$content .= '<a href="'. esc_url($url) .'" class="btn '. esc_attr($appearance) .'" alt="'. esc_attr($alt_text) .'" target="'. esc_attr($target) .'">'. esc_html($text) .'</a>';

		$content .= ob_get_contents();
		ob_end_clean();
		return $content;

	}
	add_shortcode('pivot_button','ebor_pivot_button');
}


/**
 * Ebor Pivot Icon shortcode // custom mrancho color attribute
 * @uses extract()
 * @uses shortcode_atts()
 * @uses shortcode on page content e.g: [pivot_icon icon="" size="" color=""]
 */
if(!( function_exists('ebor_pivot_icon') )){
	function ebor_pivot_icon( $atts ){
		extract(shortcode_atts(array(
			'icon' => '',
			'size' => '',
			'color' => ''
		), $atts ));
		$icon_color = (!empty($atts['color'])) ? 'style="color:'. esc_attr($atts['color']) .' !important;"' : ''; // add style sttribute
		//$icon_color = (!empty($atts['color'])) ? 'icon-white' : ''; // add custom class
		return '<i class="icon '. $icon.' '. $size .'" '. $icon_color .'></i>';
	}
	add_shortcode('pivot_icon','ebor_pivot_icon');
}

/**
 * Ebor Pivot Skill shortcode
 * @uses extract()
 * @uses shortcode_atts()
 * @uses shortcode on page content e.g: [pivot_skill icon="" title=""]
 * @see
 */
if(!( function_exists('ebor_pivot_skill') )){
	function ebor_pivot_skill( $atts ){
		extract(shortcode_atts(array(
			'icon' => '',
			'title' => ''
		), $atts ));
		return '<div class="col-sm-4"><i class="icon '. $icon .' text-white"></i><h2 class="text-white">'. htmlspecialchars_decode($title) .'</h2></div>';
	}
	add_shortcode('pivot_skill','ebor_pivot_skill');
}

/**
 * Ebor Pivot Countdown shortcode
 * @uses extract()
 * @uses shortcode_atts()
 * @uses shortcode on page content e.g: [pivot_countdown date="2016/02/02"]
 * @see
 */
if(!( function_exists('ebor_pivot_countdown') )){
	function ebor_pivot_countdown( $atts ){
		extract(shortcode_atts(array(
			'date' => '2016/02/02',
		), $atts ));
		return '<div class="countdown" data-date="'. $date .'"></div>';
	}
	add_shortcode('pivot_countdown','ebor_pivot_countdown');
}