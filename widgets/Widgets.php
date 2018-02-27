<?php

namespace rpsPluginBoilerplate\widgets;

/**
 * Registers widgets.
 *
 * This class defines all code necessary to register widgets.
 *
 * @since 				1.0.0
 * @package 			rps-plugin-boilerplate
 * @subpackage 			rps-plugin-boilerplate/widgets
 * @author 				Red Pixel Studios <support@redpixel.com>
 */
class Widgets {
	
	public static function register_widgets() {
		register_widget( 'rpsPluginBoilerplate\widgets\Widget' );
	}
	
}

?>