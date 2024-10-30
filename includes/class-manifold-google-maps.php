<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.itpathsolutions.com/
 * @since      1.0.0
 *
 * @package    Manifold_Google_Maps
 * @subpackage Manifold_Google_Maps/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Manifold_Google_Maps
 * @subpackage Manifold_Google_Maps/includes
 * @author     itpathsolutions <bhumip@itpathsolutions.co.in>
 */
class Manifold_Google_Maps {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Manifold_Google_Maps_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'MANIFOLD_GOOGLE_MAPS_VERSION' ) ) {
			$this->version = MANIFOLD_GOOGLE_MAPS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'manifold-google-maps';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Manifold_Google_Maps_Loader. Orchestrates the hooks of the plugin.
	 * - Manifold_Google_Maps_i18n. Defines internationalization functionality.
	 * - Manifold_Google_Maps_Admin. Defines all hooks for the admin area.
	 * - Manifold_Google_Maps_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-manifold-google-maps-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-manifold-google-maps-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-manifold-google-maps-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-manifold-google-maps-public.php';

		$this->loader = new Manifold_Google_Maps_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Manifold_Google_Maps_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Manifold_Google_Maps_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Manifold_Google_Maps_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		$this->loader->add_action('init', $plugin_admin, 'manifold_google_maps_register_post');
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'manifold_google_maps_add_custom_meta_box');
		$this->loader->add_action('save_post', $plugin_admin, 'manifold_google_maps_save_custom_meta_box','',3);
		$this->loader->add_action('manage_marker_posts_columns', $plugin_admin, 'manifold_google_maps_image_columns');
		$this->loader->add_action('manage_marker_posts_custom_column', $plugin_admin, 'manifold_google_maps_gallery_columns_content', 10, 2);
		$this->loader->add_action('plugin_action_links_'.$this->plugin_name.'/'.$this->plugin_name.'.php', $plugin_admin, 'manifold_google_maps_action_links', 10, 1);
		
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'manifold_google_maps_setup_menu'); 
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_manifold_google_maps_settings' );

		$this->loader->add_action( 'map_add_form_fields', $plugin_admin, 'manifold_google_maps_taxonomy_add_new_meta_field', 10, 2);
		$this->loader->add_action( 'map_edit_form_fields', $plugin_admin, 'manifold_google_maps_taxonomy_edit_meta_field', 10, 1);
		$this->loader->add_action( 'edited_map', $plugin_admin, 'manifold_google_maps_save_taxonomy_custom_meta', 10, 2);
		$this->loader->add_action( 'create_map', $plugin_admin, 'manifold_google_maps_save_taxonomy_custom_meta', 10, 2);
		$this->loader->add_action( 'admin_init', $plugin_admin, 'manifold_google_maps_type_add_dynamic_hooks', 10, 2);
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'manifold_google_maps_general_admin_notice');
		$this->loader->add_action( 'admin_head', $plugin_admin, 'manifold_google_maps_marker_image_label');
		$this->loader->add_action( 'admin_head', $plugin_admin, 'manifold_google_maps_publish_admin_hook');		

		$this->loader->add_filter( 'manage_edit-map_columns', $plugin_admin, 'manifold_google_maps_remove_description_taxonomy_map');
		$this->loader->add_filter( 'admin_post_thumbnail_html', $plugin_admin, 'manifold_google_maps_change_featured_image_text');
		

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Manifold_Google_Maps_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'init', $plugin_public, 'manifold_google_maps_register_shortcodes' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Manifold_Google_Maps_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
