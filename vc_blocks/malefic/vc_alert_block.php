<?php 

/**
 * The Shortcode
 */
function ebor_alert_block_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'type' => 'warning'
			), $atts 
		) 
	);
	
	if( 'warning' == $type ){
		$output = '<div class="alert alert-warning">'. htmlspecialchars_decode($content) .'</div>';
	} elseif( 'danger' == $type ){
		$output = '<div class="alert alert-danger">'. htmlspecialchars_decode($content) .'</div>';
	} elseif( 'success' == $type ){
		$output = '<div class="alert alert-success">'. htmlspecialchars_decode($content) .'</div>';
	} elseif( 'info' == $type ){
		$output = '<div class="alert alert-info">'. htmlspecialchars_decode($content) .'</div>';
	} elseif( 'warningDismiss' == $type ){
		$output = '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>'. htmlspecialchars_decode($content) .'</div>';
	} elseif( 'dangerDismiss' == $type ){
		$output = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'. htmlspecialchars_decode($content) .'</div>';
	} elseif( 'successDismiss' == $type ){
		$output = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'. htmlspecialchars_decode($content) .'</div>';
	} elseif( 'infoDismiss' == $type ){
		$output = '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>'. htmlspecialchars_decode($content) .'</div>';
	}
	return $output;
}
add_shortcode( 'malefic_alert_block', 'ebor_alert_block_shortcode' );

/**
 * The VC Functions
 */
function ebor_alert_block_shortcode_vc() {
	vc_map( 
		array(
			"icon" => 'malefic-vc-block',
			"name" => esc_html__("Alert Bar", 'malefic'),
			"base" => "malefic_alert_block",
			"category" => esc_html__('malefic WP Theme', 'malefic'),
			'description' => 'An alert bar ideal for drawing attention.',
			"params" => array(
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Alert Content", 'malefic'),
					"param_name" => "content",
					'holder' => 'div'
				),
				array(
					'type' => 'dropdown',
					'heading' => "Display Type",
					'param_name' => 'type',
					'value' => array(
						'Warning' => 'warning',
						'Danger' => 'danger',
						'Success' => 'success',
						'Info' => 'info',
						'Warning With Dismiss' => 'warningDismiss',
						'Danger With Dismiss' => 'dangerDismiss',
						'Success With Dismiss' => 'successDismiss',
						'Info With Dismiss' => 'infoDismiss',
					),
					'description' => "Choose a display style for this alert."
				)
			)
		) 
	);
}
add_action( 'vc_before_init', 'ebor_alert_block_shortcode_vc' );