<?php

namespace rpsPluginBoilerplate\includes;

use \rpsPluginBoilerplate\admin\options\Options;
use \rpsPluginBoilerplate\admin\Admin;
use \rpsPluginBoilerplate\frontend\Frontend;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since 				1.0.0
 * @package 			rps-plugin-boilerplate
 * @subpackage 			rps-plugin-boilerplate/includes
 * @author 				Red Pixel Studios <support@redpixel.com>
 */
class Plugin {

    /**
     * @var Singleton The reference to Plugin instance of this class
     */
    private static $instance;
    
    /**
     * Returns the Plugin instance of this class.
     *
     * @return Singleton The Plugin instance.
     */
    public static function get_instance()
    {
        if (null === static::$instance) {
            static::$instance = new static('');
            static::$instance->init();
        }
        
        return static::$instance;
    }

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				Loader 				$loader 						Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The path to the plugin relative to the site root and suitable for use with WP_Filesystem.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				string 				$plugin_path 					The path to the plugin relative to site root.
	 */
	protected $plugin_path;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				string 				$plugin_name 					The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The display name of this plugin.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				string 				$plugin_display_name 			The string used to uniquely identify this plugin.
	 */
	protected $plugin_display_name;

	/**
	 * The short description of the plugin used for display.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				string 				$plugin_short_description 		The string used to briefly describe what the plugin does.
	 */
	protected $plugin_short_description;

	/**
	 * The current version of the plugin.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				string 				$plugin_version 				The current version of the plugin.
	 */
	protected $plugin_version;

	/**
	 * The plugin author.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				string 				$plugin_author 					The author of the plugin.
	 */
	protected $plugin_author;

	/**
	 * The path to configuration files used by the plugin.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				string 				$plugin_config_path 			The path to the configuration files used by the plugin.
	 */
	protected $plugin_config_path;

	/**
	 * The path to cache files used by the plugin.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				string 				$plugin_config_cache_path 		The path to the cache files used by the plugin.
	 */
	protected $plugin_config_cache_path;

	/**
	 * The url to configuration files used by the plugin.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				string 				$plugin_config_url 				The url to the configuration files used by the plugin.
	 */
	protected $plugin_config_url;

	/**
	 * The url to configuration files used by the plugin.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				string 				$plugin_config_cache_url 		The url to the configuration files used by the plugin.
	 */
	protected $plugin_config_cache_url;

	/**
	 * The components.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				[stdObject]			$plugin_components 				The components used in the plugin.
	 */
	protected $plugin_components;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since 				1.0.0
	 * @param 				string 				$version 						The version of the plugin.
	 * @access 				public
	 */
	public function __construct( $version ) {

		$this->plugin_name = 'rps-plugin-boilerplate';
		$this->plugin_display_name = 'RPS Plugin Boilerplate';
		$this->plugin_short_description = __( 'Short description no more than 150 characters', 'rps-plugin-boilerplate' );
		$this->plugin_version = $version;
		$this->plugin_components = array();
		static::$instance = $this;

	}
	

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since 				1.0.0
	 * @access 				public
	 */
	public function init() {

		$this->set_plugin_path();
		$this->set_plugin_config_paths();

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_shortcode_hooks();
		
		foreach ( $this->get_plugin_components() as $component ) {
			if ( method_exists( $component, 'init' ) ) {
				$component->init( $this );
			}
		}			
		
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Setup the options framework if necessary.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since 				1.0.0
	 * @access 				private
	 */
	private function load_dependencies() {

		Options::init( $this );
		$this->loader = new Loader();
	
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since 				1.0.0
	 * @access 				private
	 */
	private function set_locale() {

		$i18n = new Internationalization();
		$i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality of the plugin.
	 *
	 * @since 				1.0.0
	 * @access 				private
	 */
	private function define_admin_hooks() {

		$admin = new Admin( $this );
		
		$this->loader->add_action( 'admin_menu', $admin, 'rps_admin_menu', 11 );
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts' );
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality of the plugin.
	 *
	 * @since 				1.0.0
	 * @access 				private
	 */
	private function define_public_hooks() {

		$frontend = new Frontend( $this );

		$this->loader->add_action( 'wp_enqueue_scripts', $frontend, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $frontend, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $frontend, 'register_taxonomies' );
		$this->loader->add_action( 'init', $frontend, 'register_posts' );
		$this->loader->add_action( 'widgets_init', 'rpsPluginBoilerplate\widgets\Widgets', 'register_widgets' );
		
	}

	/**
	 * Register all of the hooks related to the shortcode functionality of the plugin.
	 *
	 * @since 				1.0.0
	 * @access 				private
	 */
	private function define_shortcode_hooks() {

		$shortcodes = new Shortcodes( $this );
		//$this->loader->add_shortcode( 'shortcode', $shortcodes, 'example_shortcode_callback' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 				1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * Sets the path to the plugin relative to the filesystem root and suitable for use with WP_Filesystem.
	 *
	 * @since 				1.0.0
	 */
	private function set_plugin_path() {
	    
	    global $wp_filesystem;
	    
	    if ( empty( $wp_filesystem ) ) {
	        require_once( ABSPATH .'/wp-admin/includes/file.php' );
	        WP_Filesystem();
	    }
	    
	    if ( ! empty( $wp_filesystem->abspath() ) ) {
			$this->plugin_path = str_replace( ABSPATH, $wp_filesystem->abspath(), dirname( dirname( __FILE__ ) ) );
		}
		else {
			$this->plugin_path = dirname( dirname( __FILE__ ) );
		}
			
	}
	
	/**
	 * Gets the path to the plugin relative to the filesystem root and suitable for use with WP_Filesystem.
	 *
	 * @since 				1.0.0
	 * @return 				string 				The path to the plugin relative to filesystem root.
	 */
	public function get_plugin_path() {
		return $this->plugin_path;
	}

	/**
	 * Sets the path and url to the plugin configuration files and creates a directory for the plugin if one does not already exist.
	 *
	 * @since 				1.0.0
	 */
	private function set_plugin_config_paths() {
		
		$path = '';
		$url = '';
		$cache_path = '';
		$cache_url = '';
		
		$wp_upload_path = wp_upload_dir();
		
		if ( ! is_wp_error( $wp_upload_path ) ) { 
			
			if ( isset( $wp_upload_path['basedir'] ) and ! empty( $wp_upload_path['basedir'] ) ) {
			
				$path = trailingslashit( trailingslashit( $wp_upload_path['basedir'] ) . 'rps/' . self::get_plugin_name() );
				$cache_path = $path . 'cache/';
				
				wp_mkdir_p( $cache_path );
				
				$url = trailingslashit( trailingslashit( $wp_upload_path['baseurl'] ) . 'rps/' . self::get_plugin_name() );
				$cache_url = $url . 'cache/';
				
			}
						
		}
		
/*
		error_log( print_r( $wp_upload_path, true ) );
		error_log( print_r( $path, true ) );
		error_log( print_r( $url, true ) );
*/
		
		$this->plugin_config_path = $path;
		$this->plugin_config_url = $url;
		$this->plugin_config_cache_path = $cache_path;
		$this->plugin_config_cache_url = $cache_url;
		
	}

	/**
	 * Retrieve the path to the plugin configuration files.
	 *
	 * @since 				1.0.0
	 * @return 				string 				The path to the plugin configuration files relative to filesystem root.
	 */
	public function get_plugin_config_path() {
		return $this->plugin_config_path;
	}

	/**
	 * Retrieve the path to the plugin cache files.
	 *
	 * @since 				1.0.0
	 * @return 				string 				The path to the plugin cache files relative to filesystem root.
	 */
	public function get_plugin_config_cache_path() {
		return $this->plugin_config_cache_path;
	}

	/**
	 * Retrieve the url to the plugin configuration files.
	 *
	 * @since 				1.0.0
	 * @return 				string 				The url to the plugin configuration files relative to filesystem root.
	 */
	public function get_plugin_config_url() {
		return $this->plugin_config_url;
	}

	/**
	 * Retrieve the url to the plugin configuration cache files.
	 *
	 * @since 				1.0.0
	 * @return 				string 				The absolute url to the plugin configuration cache files.
	 */
	public function get_plugin_config_cache_url() {
		return $this->plugin_config_cache_url;
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since 				1.0.0
	 * @return 				string 				The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Get the components used in the plugin.
	 *
	 * @since 				1.0.0
	 * @return 				string 				The components used in the plugin.
	 */
	public function get_plugin_components() {
		return $this->plugin_components;
	}

	/**
	 * Add a component to the components used in the plugin.
	 *
	 * @since 				1.0.0
	 * @return 				\stdClass 		$component			The component to be added.
	 */
	public function add_plugin_component( $component ) {		
		$this->plugin_components[] = $component;
	}

	/**
	 * The name of the plugin used to display within the context of WordPress.
	 *
	 * @since 				1.0.0
	 * @return 				string 				The name of the plugin for display.
	 */
	public function get_plugin_display_name() {
		return $this->plugin_display_name;
	}

	/**
	 * The short description of the plugin used to display within the context of WordPress.
	 *
	 * @since 				1.0.0
	 * @return 				string 				The short description of the plugin for display.
	 */
	public function get_plugin_short_description() {
		return $this->plugin_short_description;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since 				1.0.0
	 * @return 				string 				The version number of the plugin.
	 */
	public function get_plugin_version() {
		return $this->plugin_version;
	}

	/**
	 * Retrieve the author of the plugin.
	 *
	 * @since 				1.0.0
	 * @return 				string 				The author of the plugin.
	 */
	public function get_plugin_author() {
		return $this->plugin_author;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since 				1.0.0
	 * @return 				Plugin_Loader 		Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

}
