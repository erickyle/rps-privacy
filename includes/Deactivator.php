<?php

namespace rpsPluginBoilerplate\includes;

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since 				1.0.0
 * @package 			rps-plugin-boilerplate
 * @subpackage 			rps-plugin-boilerplate/includes
 * @author 				Red Pixel Studios <support@redpixel.com>
 */
class Deactivator {

	/**
	 * Runs on plugin deactivation.
	 *
	 * @since 				1.0.0
	 */
	public static function deactivate() {
		self::remove_role();
	}
	
	/**
	 * Deletes the plugin role.
	 *
	 * @since 				1.0.0
	 */
	private static function remove_role() {
		
		$plugin = Plugin::get_instance();
		remove_role( $plugin->get_plugin_name() );
		
	}

}
