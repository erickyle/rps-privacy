<?php

namespace rpsPluginBoilerplate\common;

/**
 * The common functionality of the plugin.
 *
 * @since 				1.0.0
 * @package 			rps-plugin-boilerplate
 * @subpackage 			rps-plugin-boilerplate/common
 * @author 				Red Pixel Studios <support@redpixel.com>
 */
class Common {

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
	 * Register taxonomies.
	 *
	 * @since 				1.0.0
	 */
	static function register_taxonomies() {

		register_taxonomy( 'plugin_name_taxonomy', null, array(
			'label' => __( 'Terms', 'rps-plugin-boilerplate' ),
			'labels' => array(
				'name' => _x( 'Terms', 'taxonomy general name', 'rps-plugin-boilerplate' ),
				'singular_name' => _x( 'Term', 'taxonomy singular name', 'rps-plugin-boilerplate' ),
				'menu_name' => __( 'Terms', 'rps-plugin-boilerplate' ),
				'all_items' => __( 'All Terms', 'rps-plugin-boilerplate' ),
				'edit_item' => __( 'Edit Term', 'rps-plugin-boilerplate' ),
				'view_item' => __( 'View Term', 'rps-plugin-boilerplate' ),
				'update_item' => __( 'Update Term', 'rps-plugin-boilerplate' ),
				'add_new_item' => __( 'Add New Term', 'rps-plugin-boilerplate' ),
				'new_item_name' => __( 'New Term Name', 'rps-plugin-boilerplate' ),
				'parent_item' => __( 'Parent Term', 'rps-plugin-boilerplate' ),
				'parent_item_colon' => __( 'Parent Terms:', 'rps-plugin-boilerplate' ),
				'search_items' => __( 'Search Terms', 'rps-plugin-boilerplate' ),
				'popular_items' => __( 'Popular Terms', 'rps-plugin-boilerplate' ),
				'separate_items_with_commas' => __( 'Separate terms with commas', 'rps-plugin-boilerplate' ),
				'add_or_remove_items' => __( 'Add or remove terms', 'rps-plugin-boilerplate' ),
				'choose_from_most_used' => __( 'Choose from the most used terms', 'rps-plugin-boilerplate' ),
				'not_found' => __( 'No terms found', 'rps-plugin-boilerplate' ),
			),
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud' => false,
			'show_admin_column' => false,
			'hierarchical' => true,
			//'update_count_callback' => _update_generic_term_count (if associating with attachments)
			'query_var' => 'activity',
			'rewrite' => true,
			'capabilities' => array(
				'manage_terms' => 'manage_categories',
				'edit_terms' => 'manage_categories',
				'delete_terms' => 'manage_categories',
				'assign_terms' => 'edit_posts',
			),
			'sort' => false,
		) );
	
	}

	/**
	 * Register post types.
	 *
	 * @since 				1.0.0
	 */
	static function register_posts() {

		register_post_type( 'plugin_name_cpt', array(
			'label' => __( 'Items', 'rps-plugin-boilerplate' ),
			'labels' => array(
				'name' => __( 'Items', 'rps-plugin-boilerplate' ), 
				'singular_name' => __( 'Item', 'rps-plugin-boilerplate' ),
				'menu_name' => __( 'Item', 'rps-plugin-boilerplate' ),
				'all_items' => __( 'All Items', 'rps-plugin-boilerplate' ),
				'add_new' => _x( 'Add New', 'item', 'rps-plugin-boilerplate' ),
				'add_new_item' => __( 'Add New Item', 'rps-plugin-boilerplate' ),
				'edit_item' => __( 'Edit Item', 'rps-plugin-boilerplate' ),
				'new_item' => __( 'New Item', 'rps-plugin-boilerplate' ),
				'view_item' => __( 'View Item', 'rps-plugin-boilerplate' ),
				'search_items' => __( 'Search Items', 'rps-plugin-boilerplate' ),
				'not_found' => __( 'No items found', 'rps-plugin-boilerplate' ),
				'not_found_in_trash' => __( 'No items found in trash', 'rps-plugin-boilerplate' ),
			),
			'description' => __( 'A custom post type for Items.', 'rps-plugin-boilerplate' ),
			'public' => true,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'show_in_menu' => true,
			'show_in_admin_bar' => true,
			'menu_position' => null,
			'menu_icon' => null,
			'capability_type' => 'post',
		/*
			'capabilities' => array(
				'edit_post' => 'manage_plugin_name_items',
				'read_post' => 'manage_plugin_name_items',
				'delete_post' => 'manage_plugin_name_items',
				'edit_posts' => 'manage_plugin_name_items',
				'edit_others_posts' => 'manage_plugin_name_items',
				'publish_posts' => 'manage_plugin_name_items',
				'read_private_posts' => 'manage_plugin_name_items',
				'delete_posts' => 'manage_plugin_name_items',
				'delete_private_posts' => 'manage_plugin_name_items',
				'delete_published_posts' => 'manage_plugin_name_items',
				'delete_others_posts' => 'manage_plugin_name_items',
				'edit_private_posts' => 'manage_plugin_name_items',
				'edit_published_posts' => 'manage_plugin_name_items'
			),
		*/
			'map_meta_cap' => true,
			'hierarchical' => false,
			'supports' => array(
				'title',
				'editor',
				//'author',
				//'thumbnail',
				//'excerpt',
				//'trackbacks',
				//'custom-fields',
				//'comments',
				//'revisions',
				//'page-attributes',
				//'post-formats',
				//'publicize',
			),
			//'register_meta_box_cb' => '',
			'taxonomies' => array( 'plugin_name_taxonomy' ),
			'has_archive' => true,
		/*
			'rewrite' => array(
				'slug' => 'item',
			),
		*/
			'can_export' => true
		));
	}

}
