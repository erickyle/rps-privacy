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
	
	private static $_opt_name;
	
	/**
	 * Prevent subclasses from generating a constructor.
	 */
	final function __construct( $plugin_name, $version, $plugin_display_name ) {
		// do nothing, could also throw a warning or error.
	}
	
	/**
	* Initialize the options framework based on a plugin's properties
	*
	* @since 				1.0.0
	* @param 				object 				$plugin 				\rpsPluginBoilerplate\includes\Plugin
	* @access 				public
	*/
	static function init( $plugin ) {
		
		if ( class_exists( 'Redux' ) and file_exists( dirname( __FILE__ ) . '/options.json' ) ) {
		
			self::load_options_config( $plugin );
			self::remove_notices();
			self::add_social_links( static::$_opt_name );
			
		}
		
	}

	/**
	 * Gets the opt_name assigned to the Redux Framework options.
	 *
	 * @since 				1.0.0
	 * @return 				string 				$_opt_name 				The opt name for the Redux Framework options.
	 * @access 				public
	 */
	public static function get_opt_name() {
		return self::$_opt_name;
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
		global ${self::$_opt_name};
		
		$opt = ${self::$_opt_name};
		
		if ( isset( $opt[ $option_name ] ) ) {
			return $opt[ $option_name ];
		}
	}

	/**
	 * Loads the options.json file used to initialize Redux Framework.
	 *
	 * @since 				1.0.0
	 * @param 				object 				$plugin 				\rpsPluginBoilerplate\includes\Plugin
	 * @access 				private
	 */
	private static function load_options_config( $plugin ) {

		$args = array();
		$options = json_decode( file_get_contents( dirname( __FILE__ ) . '/options.json' ), true );

		if ( ! empty( $options ) and array_key_exists( 'args', $options ) ) {
		
			$args = $options['args'];
			
			$args['display_name'] = $plugin->get_plugin_display_name();
			$args['display_version'] = $plugin->get_plugin_version();
			$args['menu_title'] = $plugin->get_plugin_display_name();
			$args['page_title'] = $plugin->get_plugin_display_name();
			$args['page_slug'] = $plugin->get_plugin_name();
			$args['intro_text'] = $plugin->get_plugin_short_description();
			$args = array_merge( $args, self::add_social_links() );
			
			static::$_opt_name = '_' . str_ireplace( '-', '_', $plugin->get_plugin_name() );
			
			Redux::setArgs( static::$_opt_name, $args );
			Redux::setSections( static::$_opt_name, self::sections( $plugin ) );
			Redux::setHelpTab( static::$_opt_name, self::help( $plugin ) );
			Redux::setHelpSidebar( static::$_opt_name, self::help_sidebar( $plugin ) );
			
		}
				
	}
	
	/**
	 * Define sections for the options framework.
	 *
	 * @since 				1.0.0
	 * @access 				private
	 * @see 				https://docs.reduxframework.com/core/sections/getting-started-with-sections/
	 */
	private static function sections( $plugin ) {
		
		$sections = array();
		
		$sections[] = array(
			'title' 		=> __( 'Title', 'rps-plugin-boilerplate' ),
			'id' 			=> 'general',
			'desc' 			=> __( 'Description.', 'rps-plugin-boilerplate' ),	
			'icon' 			=> 'el el-cogs',
			'fields' 		=> array(
				//insert field arrays
			),
		);

		foreach( $plugin->get_plugin_components() as $component ) {
			if ( method_exists( $component, 'get_option_sections' ) ) {
				foreach( $component->get_option_sections( self::$_opt_name ) as $section ) {
					$sections[] = $section;
				}
			}
		}
		
		return $sections;

	}
	
	/**
	 * Sets help tabs and content.
	 * 
	 * @since 				1.0.0
	 * @param 				object 				$plugin 				\rpsGoogleAnalytics\includes\Plugin
	 * @access 				private
	 */
	private static function help( $plugin ) {
		$tabs = array();
		return $tabs;
	}
	
	/**
	 * Sets help sidebar content.
	 * 
	 * @since 				1.0.0
	 * @param 				object 				$plugin 				\rpsGoogleAnalytics\includes\Plugin
	 * @access 				private
	 */
	private static function help_sidebar( $plugin ) {
		$content = '';
		return $content;
	}

	/**
	 * Removes demo mode and notices from Redux Framework.
	 *
	 * @since 				1.0.0
	 * @access 				private
	 */
	private static function remove_notices() {
			
		remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
		remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
		
	}

	/**
	 * Adds social media buttons.
	 *
	 * @since 				1.0.0
	 * @return 				array 				$share_icons 			An array of share icons for display in Redux Framework.
	 * @access 				public
	 */
	public static function add_social_links() {
		
		$share_icons = array(
			'share_icons' => array(
				array(
					"url" => "//www.facebook.com/redpixel",
	                "title" => __( 'Like us on Facebook', 'rps-theme-framework' ),
	                "icon" => "el-icon-facebook"
				),
				array(
					"url" => "//twitter.com/redpixelstudios",
	                "title" => __( 'Follow us on Twitter', 'rps-theme-framework' ),
	                "icon" => "el-icon-twitter"
				),
				array(
					"url" => "//www.linkedin.com/company/red-pixel-studios",
	                "title" => __( 'Find us on LinkedIn', 'rps-theme-framework' ),
	                "icon" => "el-icon-linkedin"
				)
			)
		);
		
		return $share_icons;
				
	}

}
