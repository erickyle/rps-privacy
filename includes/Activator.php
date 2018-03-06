<?php

namespace rpsPluginBoilerplate\includes;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since 				1.0.0
 * @package 			rps-plugin-boilerplate
 * @subpackage 			rps-plugin-boilerplate/includes
 * @author 				Red Pixel Studios <support@redpixel.com>
 */
class Activator {

	/**
	 * Runs on plugin activation.
	 *
	 * @since 				1.0.0
	 */
	public static function activate() {
		self::add_role();
	}
	
	/**
	 * Adds the plugin role.
	 *
	 * @since 				1.0.0
	 */
	private static function add_role() {
		
		$plugin = Plugin::get_instance();
				
		add_role(
			$plugin->get_plugin_name(),
			$plugin->get_plugin_display_name(),
			$plugin->get_plugin_caps_for_role()
		);
		
	}

}
