<?php

namespace rpsPluginBoilerplate\includes;

/**
 * Registers shortcodes.
 *
 * This class defines all code necessary to register shortcodes.
 *
 * @since 				1.0.0
 * @package 			rps-plugin-boilerplate
 * @subpackage 			rps-plugin-boilerplate/includes
 * @author 				Red Pixel Studios <support@redpixel.com>
 */
class Shortcodes {
	
	/**
	 * The plugin.
	 *
	 * @since 				1.0.0
	 * @var 				object 				$plugin 				\rpsPluginBoilerplate\includes\Plugin
	 * @access 				private
	 */
	private $plugin;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 				1.0.0
	 * @param 				object 				$plugin 				\rpsPluginBoilerplate\includes\Plugin
	 */
	public function __construct( $plugin ) {

		$this->plugin = $plugin;

	}

	/**
	 * Example shortcode callback.
	 *
	 * @since 				1.0.0
	 * @access 				public
	 */
	public static function example_shortcode_callback() {
		return $shortcode;
	}
	
}
