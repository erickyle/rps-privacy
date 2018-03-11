<?php

namespace rpsPluginBoilerplate\admin\options;
use \Redux;
use \ReduxFrameworkPlugin;

/**
 * Loader for the Redux Framework options.
 *
 * Defines the plugin name, version and loads the options-init.php file if available.
 * Disables some of the notices built into the Redux Framework.
 *
 * @since 				1.0.0
 * @package 			rps-plugin-boilerplate
 * @subpackage 			rps-plugin-boilerplate/admin
 * @author 				Red Pixel Studios <support@redpixel.com>
 */
class Options {
	
	const OPT_NAME = 'rps_plugin_boilerplate';
	
	/**
	 * Prevent subclasses from generating a constructor.
	 */
	final function __construct() {}
	
	/**
	* Initialize the options framework based on a plugin's properties
	*
	* @since 				1.0.0
	* @param 				object 				$plugin 				\rpsPluginBoilerplate\includes\Plugin
	* @access 				public
	*/
	static function init( $plugin ) {
		
		self::set_sections();
		\rps\components\reduxFramework\v1_0_0\ReduxFramework::init( $plugin, self::OPT_NAME );
		
	}

	/**
	 * Ready the options.
	 *
	 * @since 				1.0.0
	 * @access 				public
	 */
	public static function ready() {
		Redux::init( self::OPT_NAME );
	}

	/**
	 * Gets the opt_name assigned to the Redux Framework options.
	 *
	 * @since 				1.0.0
	 * @access 				public
	 */
	public static function get_opt_name() {
		return self::OPT_NAME;
	}
		
	/**
	 * Gets a specified option.
	 * 
	 * @since 				1.0.0
	 * @param 				string 				$option_name 			The name of the option to retrieve.
	 * @return 				mixed 										The value of the option.
	 * @access 				public
	 */
	public static function get_option( $option_name ) {
	
		global ${self::OPT_NAME};
		
		$opt = ${self::OPT_NAME};
		
		if ( isset( $opt[ $option_name ] ) ) {
			return $opt[ $option_name ];
		}
	
	}
	
	/**
	 * Define sections for the options framework.
	 *
	 * @since 				1.0.0
	 * @access 				private
	 * @see 				https://docs.reduxframework.com/core/sections/getting-started-with-sections/
	 */
	private static function set_sections() {
		
		Redux::setSection( self::OPT_NAME, array(
			'id' 					=> 'section',
			'title' 				=> __( 'Preferences', 'rps-plugin-boilerplate' ),
			'subtitle' 				=> '',
			'desc'	 				=> __( 'Preference settings for RPS Open Graph.', 'rps-plugin-boilerplate' ),
			'icon' 					=> 'rps rps-settings',
			'subsection' 			=> false,
		) );
		
		Redux::setField( self::OPT_NAME, array(
			'section_id' 			=> 'section',
			'id' 					=> 'section-switch',
			'type' 					=> 'switch',
			'title' 				=> __( 'Enable', 'rps-plugin-boilerplate' ),
			'subtitle' 				=> __( 'Specify if OpenGraph meta tags should be output.', 'rps-plugin-boilerplate' ),
			'default' 				=> false,
		) );
		
	}
	
}
