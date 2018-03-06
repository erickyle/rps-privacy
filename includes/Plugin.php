<?php

namespace rpsPluginBoilerplate\includes;

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
     * @var 				Plugin 				$instance 				Singleton The reference to Plugin instance of this class
     */
    private static $instance;
    
    /**
     * Returns the Plugin instance of this class.
     *
     * @since 				1.0.0
     * @access 				public
     * @return 				Plugin 										Singleton The Plugin instance.
     */
    public static function get_instance() {

        if ( null === static::$instance ) {
            static::$instance = new static( '' );
            static::$instance->init();
        }
        
        return static::$instance;

    }

	/**
	 * The loader responsible for maintaining and registering all hooks that power the plugin.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				Loader 				$loader 						Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The name of the plugin used to uniquely identify it within the context of WordPress
	 * and to define internationalization functionality.
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
	 * The components.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				array				$plugin_components 				The components used in the plugin.
	 */
	protected $plugin_components;

	/**
	 * The plugin caps.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				array 				$plugin_caps 					The plugin caps.
	 */
	protected $plugin_caps;
	
	/**
	 * The path to the plugin root.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				array 				$plugin_path 					The plugin path.
	 */
	protected $plugin_path;

	/**
	 * The plugin filesystem.
	 *
	 * @since 				1.0.0
	 * @access 				protected
	 * @var 				Filesystem 			$filesystem 					The plugin filesystem.
	 */
	protected $filesystem;

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

		$this->set_plugin_name( 'rps-plugin-boilerplate' );
		$this->set_plugin_display_name( 'RPS Plugin Boilerplate' );
		$this->set_plugin_short_description( __( 'Short description no more than 150 characters.', 'rps-plugin-boilerplate' ) );
		$this->set_plugin_version( $version );
		$this->set_plugin_author( 'Red Pixel Studios' );
		
		$this->plugin_components = array();
		$this->plugin_caps = array();
		
		$this->filesystem = null;
		
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
		
		$this->set_filesystem( new \rps\components\wpUtilities\v1_0_0\FileSystem( $this ) );
		$this->load_dependencies();
		$this->set_locale();		
		$this->init_options();

		$this->define_public_hooks();
		$this->define_admin_hooks();
		$this->define_shortcode_hooks();
				
		$this->init_components();
		
	}
	
	/**
	 * Initialize options.
	 *
	 * @since 1.0.0
	 */
	private function init_options() {
		\rpsPluginBoilerplate\admin\options\Options::init( $this );
	}

	/**
	 * Initialize plugin components registered by plugin bootstrap.
	 *
	 * @since 				1.0.0
	 */
	private function init_components() {
		
		foreach ( $this->get_plugin_components() as $component ) {
			if ( method_exists( $component, 'init' ) ) {
				$component->init( $this );
			}
		}

	}

	/**
	 * Load the required dependencies for this plugin.
	 * Create an instance of the loader which will be used to register the hooks with WordPress.
	 *
	 * @since 				1.0.0
	 * @access 				private
	 */
	private function load_dependencies() {
		$this->loader = new Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 * Uses the Plugin_i18n class in order to set the domain and to register the hook with WordPress.
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
	 * Register all of the hooks related to the general functionality of the plugin.
	 * Loaded in admin and frontend.
	 *
	 * @since 				1.0.0
	 * @access 				private
	 */
	private function define_common_hooks() {

		$common = new \rpsPluginBoilerplate\common\Common( $this );
		
		$this->loader->add_action( 'init', $common, 'register_taxonomies' );
		$this->loader->add_action( 'init', $common, 'register_posts' );
		$this->loader->add_action( 'widgets_init', 'rpsPluginBoilerplate\widgets\Widgets', 'register_widgets' );
		
	}

	/**
	 * Register all of the hooks related to the admin area functionality of the plugin.
	 * Loaded when is_admin() is true.
	 *
	 * @since 				1.0.0
	 * @access 				private
	 */
	private function define_admin_hooks() {

		if ( is_admin() ) {
		
			$admin = new \rpsPluginBoilerplate\admin\Admin( $this );
			
			$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts' );
			
		}
		
	}

	/**
	 * Register all of the hooks related to the frontend functionality of the plugin.
	 * Loaded when is_admin() is false.
	 *
	 * @since 				1.0.0
	 * @access 				private
	 */
	private function define_public_hooks() {

		if ( ! is_admin() ) {
		
			$frontend = new \rpsPluginBoilerplate\frontend\Frontend( $this );
	
			$this->loader->add_action( 'wp_enqueue_scripts', $frontend, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $frontend, 'enqueue_scripts' );
			
		}
		
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
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since 				1.0.0
	 * @return 				Plugin_Loader 		Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Set plugin_name.
	 *
	 * @since 				1.0.0
	 */
	public function set_plugin_name( $plugin_name ) {
		$this->plugin_name = sanitize_key( $plugin_name );
	}
	/**
	 * Get plugin_name.
	 *
	 * @since 				1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}


	/**
	 * Set plugin_display_name.
	 *
	 * @since 				1.0.0
	 */
	public function set_plugin_display_name( $plugin_display_name ) {
		$this->plugin_display_name = esc_html( $plugin_display_name );
	}
	/**
	 * Get plugin_display_name.
	 *
	 * @since 				1.0.0
	 */
	public function get_plugin_display_name() {
		return $this->plugin_display_name;
	}


	/**
	 * Set plugin_short_description.
	 *
	 * @since 				1.0.0
	 */
	public function set_plugin_short_description( $plugin_short_description ) {
		$this->plugin_short_description = esc_html( $plugin_short_description );
	}
	/**
	 * Get plugin_short_description.
	 *
	 * @since 				1.0.0
	 */
	public function get_plugin_short_description() {
		return $this->plugin_short_description;
	}


	/**
	 * Set plugin_version.
	 *
	 * @since 				1.0.0
	 */
	public function set_plugin_version( $plugin_version ) {
		$this->plugin_version = $plugin_version;
	}
	/**
	 * Get plugin_version.
	 *
	 * @since 				1.0.0
	 */
	public function get_plugin_version() {
		return $this->plugin_version;
	}


	/**
	 * Set plugin_author.
	 *
	 * @since 				1.0.0
	 */
	public function set_plugin_author( $plugin_author ) {
		$this->plugin_author = esc_html( $plugin_author );
	}
	/**
	 * Get plugin_author.
	 *
	 * @since 				1.0.0
	 */
	public function get_plugin_author() {
		return $this->plugin_author;
	}

	
	/**
	 * Add a cap to the caps used in the plugin.
	 *
	 * @since 				1.0.0
	 */
	public function add_plugin_cap( $cap ) {		
		$this->plugin_caps[] = sanitize_key( $cap );
	}
	/**
	 * Get the caps used in the plugin suitable for role creation.
	 *
	 * @since 				1.0.0
	 * @return 				array 				$caps 						The caps used in the plugin.
	 */
	public function get_plugin_caps_for_role() {
		
		$caps = array();
		
		foreach ( $this->get_plugin_caps() as $cap ) {
			$caps[$cap] = true;
		}
		
		return $caps;
		
	}
	/**
	 * Get the caps used in the plugin.
	 *
	 * @since 				1.0.0
	 */
	public function get_plugin_caps() {
		return $this->plugin_caps;
	}


	/**
	 * Set plugin_path.
	 *
	 * @since 				1.0.0
	 */
	public function set_plugin_path( $plugin_path ) {
		$this->plugin_path = filter_var( $plugin_path, FILTER_SANITIZE_URL );
	}
	/**
	 * Get plugin_path.
	 *
	 * @since 				1.0.0
	 */
	public function get_plugin_path() {
		return $this->plugin_path;
	}


	/**
	 * Set the plugin filesystem.
	 *
	 * @since 				1.0.0
	 */
	public function set_filesystem( $filesystem ) {
		
		if ( $filesystem instanceof \rps\components\wpUtilities\v1_0_0\FileSystem ) {
			$this->filesystem = $filesystem;
		}
		
	}
	/**
	 * Get the plugin filesystem.
	 *
	 * @since 				1.0.0
	 */
	public function get_filesystem() {
		return $this->filesystem;
	}


	/**
	 * Add a component to the components used in the plugin.
	 *
	 * @since 				1.0.0
	 */
	public function add_plugin_component( $component ) {		
		$this->plugin_components[] = $component;
	}
	/**
	 * Get the components used in the plugin.
	 *
	 * @since 				1.0.0
	 */
	public function get_plugin_components() {
		return $this->plugin_components;
	}

}
