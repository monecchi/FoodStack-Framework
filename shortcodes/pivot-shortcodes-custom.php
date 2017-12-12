<?php

/**
 * Call a navigation menu using a shortcode
 * @uses shortcode_atts()
 * @uses wp_nav_menu()
 * @uses shortcode on page content e.g: [nav_menu name="-your menu name-" class="-your class-"]
 * @return navigation menu
 * @see  http://stephanieleary.com/2010/07/call-a-navigation-menu-using-a-shortcode/
 */
if(!( function_exists('print_menu_shortcode') )) {
	function print_menu_shortcode($atts, $content = null) {
		$args = shortcode_atts( 
		    array(
		        'name' => null,
		        'class' => ''
		    ), 
		    $atts
		);
		
		$name = esc_attr( $args['name'] );
		$menu_class = esc_attr( $args['class'] );

		if ( has_nav_menu( 'secondary' ) ){
			echo '<div class="mrancho-secondary-navigation">';
			return wp_nav_menu( array( 'menu' => $name, 'theme_location' => 'secondary', 'depth' => 1, 'container' => 'nav', 'container_class'   => 'secondary-navigation', 'menu_class' => $menu_class, 'walker' => new WP_Icon_Walker() ) );
			 echo '</div>'; 
		} else {
			return wp_nav_menu( array( 'menu' => $name, 'menu_class' => $class, 'echo' => false ) );			
		}
	}

	add_shortcode('nav_menu', 'print_menu_shortcode');
}



/**
 * Mrancho Custom Pivot Icon shortcode
 * @uses extract()
 * @uses shortcode_atts()
 * @uses shortcode on page content e.g: [mrancho_icon icon="" class="" size="" caption=""]
 */
if(!( function_exists('mrancho_pivot_icon') )){
	function mrancho_pivot_icon( $atts ){
		
		$short_icon = ''; // Remove the . before the $short_btn variable the first time it appears. 

		$args = shortcode_atts( 
		    array(
		        'icon' => '',
		        'class' => '',
		        'size' => '',
		        'caption' => ''
		    ), 
		    $atts
		);
		//$w = (int) $args['w'];
		//$h = (int) $args['h'];
		$icon = esc_attr( $args['icon'] );
		$class = esc_attr( $args['class'] );
	    $size = esc_attr( $args['size'] );
	    $caption = esc_html( $args['caption'] );
		
	    $caption = (empty($caption)) ? '' : ''. $caption .'';
		
		switch($atts['size']){
		case 'xsmall':
			$style = 'font-size-20';
			break;
		case 'small':
			$style = 'font-size-30';
			break;
		case 'medium':
			$style = 'font-size-40';
			break;
		case 'big':
			$style = 'font-size-50';
			break;
		case 'large':
			$style = 'font-size-80';
			break;
		default:
			$style = 'medium';
			break;
		}
		
        if (!empty($caption)) {	
		//$short_icon .= '<i class="icon '.$icon.' '. $size .' '.$class.'"></i>';	
		$short_icon =
        '<div class="featured-icon">
            <i class="icon '.$icon.' '. $size .' '.$class.'"></i>
            <h5>'.$caption.'</h5>
        </div>';
		} else {
		//$short_icon .= '<i class="icon '.$icon.' '. $size .' '.$class.'"></i>';	
		//$short_icon .=  (empty($caption)) ? '' : '<h5>'. $caption .'</h5>';
		$short_icon =
        '<div class="featured-icon">
            <i class="icon '.$icon.' '. $size .' '.$class.'"></i>
        </div>';		
		}

		return $short_icon;
    }
	add_shortcode('mrancho_icon', 'mrancho_pivot_icon');		
}


/**
* Html Tags Shortcode - custom mrancho
* Html tags: div, span, a, p, iframe, img, etc.
* @uses shortcode on page content e.g: [tag type="span" class="myClass" id="firstSpan"]Lorem ipsum dolor sit amet[/tag]
*/
if(!( function_exists('tag_shortcode') )){
	
function tag_shortcode( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'class' => 'shortcode_class',
    'id' => '',
    'type' => 'div', // if a html tag type is not specified, it defaults to div
    'src' =>  '',
    'url' =>  '',
    'style' => ''
  ), $atts ) );
  
  return '<' . esc_attr($type) . ' src="' . esc_url($src) . '" id="' . esc_attr($id) . '" class="' . esc_attr($class) . '" style="' . esc_attr($style) . '">' . do_shortcode($content) . '</' . esc_attr($type) . '>';
  
}
add_shortcode( 'tag', 'tag_shortcode' );

}

/**
 * Ebor Pivot ul tag (list) shortcode
 * @uses extract()
 * @uses shortcode_atts()
 * @uses shortcode on page content e.g: [pivot_button url="" class="" target="" text=""]
 * @see  http://getbootstrapadmin.com/remark/base/uikit/list.html
 */
if(!( function_exists('ul_shortcode') )){
function ul_shortcode($atts, $content) {
		extract(shortcode_atts(array(
			'type'  => '',		
			'class' => '',
			'style'  => 'default'	
		), $atts ));
	
		switch($atts['style']){
		case 'basic':
			$style = 'list-group-full';
			break;
		case 'large':
			$style = 'icons-large';
			break;
		case 'bordered':
			$style = 'list-group-bordered';
			break;
		case 'dividered':
			$style = 'list-group-dividered list-group-full';
			break;
		case 'gap':
			$style = 'list-group-gap';
			break;
		default:
			$style = 'icons-large';
			break;
		}
		
    $content = do_shortcode($content);
    $class = (empty( $class)) ? '' : '';
    return '<ul class="list-group '.$style.' '.$type.' '.$class.'">'.$content.'</ul>';
}
add_shortcode('ul', 'ul_shortcode');
}

/**
 * Ebor Pivot li tag shortcode
 * @uses extract()
 * @uses shortcode_atts()
 * @uses shortcode on page content e.g: [pivot_button url="" class="" target="" text=""]
 * @see  http://getbootstrapadmin.com/remark/base/uikit/list.html
 */
if(!( function_exists('li_shortcode') )){ 
	// li Shortcode function
function li_shortcode($atts, $content) {
		extract(shortcode_atts(array(
			'icon' => '',
			'class' => '',
			'type' => ''
		), $atts ));
		
		switch($atts['type']){
		case 'normal':
			$type = 'list-group-item';
			break;
		case 'inline':
			$type = 'list-group-item inline';
			break;
		default:
			$style = 'list-group-item';
			break;
		}		
		
    $content = do_shortcode($content);
    $icon = (empty($icon)) ? '' : '<i class="'.$icon.'"></i>';

    return '<li class="'.$type.' '.$class.'">'.$icon.$content.'</li>';
}
add_shortcode('li', 'li_shortcode');
}


// Shortcode hack // remove <br> tags after the following shortcodes
/*
function the_content_filter($content) {
    $block = join("|",array("ul", "li"));
    $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
    $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
return $rep;
}
add_filter("the_content", "the_content_filter");
*/

// add_filter("the_content", "the_content_filter");
// function the_content_filter($content) {
// 	// array of custom shortcodes requiring the fix 
// 	$block = join("|",array("ul","li","pivot_icon", "pivot_button", "mrancho_icon", "contact-form-7"));
// 	// opening tag
// 	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
		
// 	// closing tag
// 	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
// 	return $rep;
// }