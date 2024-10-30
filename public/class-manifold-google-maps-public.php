<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.itpathsolutions.com/
 * @since      1.0.0
 *
 * @package    Manifold_Google_Maps
 * @subpackage Manifold_Google_Maps/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Manifold_Google_Maps
 * @subpackage Manifold_Google_Maps/public
 * @author     itpathsolutions <bhumip@itpathsolutions.co.in>
 */
class Manifold_Google_Maps_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Manifold_Google_Maps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Manifold_Google_Maps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/manifold-google-maps-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Manifold_Google_Maps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Manifold_Google_Maps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/manifold-google-maps-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'googlemaps', 'https://maps.googleapis.com/maps/api/js?libraries=geometry&key='.get_option('manifold_google_maps_googlekey'), array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'manifold_google_maps_js' , array( 
    			'ajax_url' => admin_url( 'admin-ajax.php' ),
    		 	'manifold_google_maps_key' => get_option('manifold_google_maps_googlekey')
    		) 
    	);



	}

	/**
	 * Added shorcode for the public-facing side of the site.
	 *
	 * @since    1.0.1
	 */
	public function manifold_google_maps_get_markers($atts, $content = null){
		ob_start();
			require( plugin_dir_path( __FILE__ ) . 'partials/manifold-google-maps-public-display.php' );
		return ob_get_clean();
	}

	/**
	 * Register the shortcode for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function manifold_google_maps_register_shortcodes() {
	    add_shortcode( 'manifold-google-maps', array( $this, 'manifold_google_maps_get_markers') );
	}

}
