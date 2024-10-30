<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.itpathsolutions.com/
 * @since      1.0.0
 *
 * @package    Manifold_Google_Maps
 * @subpackage Manifold_Google_Maps/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Manifold_Google_Maps
 * @subpackage Manifold_Google_Maps/admin
 * @author     itpathsolutions <bhumip@itpathsolutions.co.in>
 */
class Manifold_Google_Maps_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	private $option_name = 'manifold_google_maps';

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/manifold-google-maps-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-prettyPhoto', plugin_dir_url( __FILE__ ) . 'css/prettyPhoto.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/manifold-google-maps-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-prettyPhoto', plugin_dir_url( __FILE__ ) . 'js/jquery.prettyPhoto.js', array( 'jquery' ), $this->version, false );
		
		if(!empty(get_option('manifold_google_maps_googlekey'))){
			$cpt_marker = 'marker';
		  	$screen = get_current_screen();
		  	 if( is_object( $screen ) && $cpt_marker == $screen->post_type ){
		  	 	wp_register_script($this->plugin_name.'-googleautocomplete', 'https://maps.googleapis.com/maps/api/js?key='.get_option('manifold_google_maps_googlekey').'&libraries=places&sensor=false', array ('jquery'), $this->version);
				wp_enqueue_script($this->plugin_name.'-googleautocomplete');
			}
		}

    	wp_localize_script( $this->plugin_name, 'manifold_google_maps_admin_js' , array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'manifold_google_maps_key' => get_option('manifold_google_maps_googlekey')) );

	}

	/**
	 * Register the post type marker and taxonomy Maps.
	 *
	 * @since    1.0.0
	 * @access public
	*/
	public function manifold_google_maps_register_post(){
       $labels = array(
                'name'               => __('Markers', $this->plugin_name),
                'singular_name'      => 'Marker',
                'add_new'            => __('Add New Marker', $this->plugin_name),
                'add_new_item'       => __('Add New Marker', $this->plugin_name),
                'edit_item'          => __('Edit Marker', $this->plugin_name),
                'new_item'           => __('New Marker', $this->plugin_name),
                'all_items'          => __('All Markers', $this->plugin_name),
                'view_item'          => __('View Marker', $this->plugin_name),
                'search_items'       => __('Search Markers', $this->plugin_name),
                'not_found'          => __('No Markers found', $this->plugin_name),
                'not_found_in_trash' => __('No Markers found in Trash', $this->plugin_name),
                'parent_item_colon'  => '',
                'menu_name'          => __('Maps', $this->plugin_name)
            );
         
        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'exclude_from_search' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'menu_icon' 		 => 'dashicons-location-alt',
            'rewrite'            => array( 'slug' => 'marker' ),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => true,
            'menu_position'      => null,
            'supports'           => array( 'title', 'thumbnail', 'categories')
        );         
        register_post_type( 'marker', $args );

		$labels = array(
		    'name' => _x( 'Maps', $this->plugin_name ),
		    'singular_name' => _x( 'Maps', $this->plugin_name ),
		    'search_items' =>  __( 'Search Maps', $this->plugin_name ),
		    'all_items' => __( 'All Maps', $this->plugin_name),
		    'parent_item' => __( 'Parent Maps', $this->plugin_name),
		    'parent_item_colon' => __( 'Parent Maps:', $this->plugin_name),
		    'edit_item' => __( 'Edit Map', $this->plugin_name), 
		    'update_item' => __( 'Update Map', $this->plugin_name ),
		    'add_new_item' => __( 'Add New Map', $this->plugin_name ),
		    'new_item_name' => __( 'New Map Name', $this->plugin_name ),
		    'menu_name' => __( 'Maps', $this->plugin_name),
		);
		register_taxonomy('map',array('marker'), array(
			'public' => false,
		    'hierarchical' => true,
		    'labels' => $labels,
		    'show_ui' => true,
		    'show_in_rest' => true,
		    'show_admin_column' => true,
		    'query_var' => true,
		    'rewrite' => array( 'slug' => 'map' ),
		));
    }

    /**
	 * Change the featured image metabox title text
	 *
	 * @since    1.0.0
	 * @access public
	*/
	public function manifold_google_maps_marker_image_label() {
	    remove_meta_box( 'postimagediv', 'marker', 'side' );
	    add_meta_box( 'postimagediv', __( 'Marker pin image', $this->plugin_name ), 'post_thumbnail_meta_box', 'marker', 'side' );
	}

	public function manifold_google_maps_change_featured_image_text( $content ) {
	    if ( 'marker' === get_post_type() ) {
	        $content = str_replace( 'Set featured image', __( 'Set marker pin image', $this->plugin_name), $content );
	        $content = str_replace( 'Remove featured image', __( 'Remove marker pin image', $this->plugin_name), $content );
	    }
	    return $content;
	}

    /**
	 * Setup settings menu
	 *
	 * @since    1.0.0
	 * @access public
	*/
	public function manifold_google_maps_setup_menu(){
		add_submenu_page( 'edit.php?post_type=marker', 'Settings', 'Settings','manage_options', 'manifold-google-maps', array($this, 'manifold_google_maps_setting'));
	} 

	/**
	 * Settings page view file
	 *
	 * @since    1.0.0
	 * @access public
	*/
    public function manifold_google_maps_setting() {
        include( plugin_dir_path( __FILE__ ) . 'partials/manifold-google-maps-admin-display.php' );
    }
    /**
	 * custom post type error message when key field is empty
	 *
	 * @since    1.0.0
	 * @access public
	*/
    public function manifold_google_maps_general_admin_notice(){
	    global $pagenow;
	    if(empty(get_option('manifold_google_maps_googlekey'))){
		    if ( 'marker' === get_post_type() ) {
		         echo '<div class="notice notice-warning">
		             <p>Before you start using Manifold Google Maps, please note that it is necessary to register your API key to work properly. <a href="'.admin_url( 'edit.php?post_type=marker&page=manifold-google-maps' ) .'">' . __('Settings') . '</a></p>
		         </div>';
		    }
		}
	}
    
	/**
	 * Register custom meta box for the custom post type Marker.
	 *
	 * @since    1.0.0
	 * @access public
	*/
	public function manifold_google_maps_add_custom_meta_box() {
	    add_meta_box("manifold-google-maps-information", "Marker Details", array( $this, "manifold_google_maps_custom_meta_box_markup"), "marker", "normal", "high", null);
	}

	/**
	 * View of meta box for the custom post type Marker.
	 *
	 * @since    1.0.0
	 * @access public
	*/
	public function manifold_google_maps_custom_meta_box_markup($object) {
	    wp_nonce_field(basename(__FILE__), "meta-box-nonce");
	    
	    ?>
	        <div class="map-options">
	            <label for="manifold-google-maps-address">Address (Autocomplete)</label>
	            <input name="manifold-google-maps-address" id="manifold-google-maps-address" type="text" value="<?php echo esc_attr(get_post_meta($object->ID, "manifold-google-maps-address", true)); ?>" required>
	        </div>
	        <div class="map-options">
	            <label for="manifold-google-maps-lat">Latitude</label>
	            <input name="manifold-google-maps-lat" id="manifold-google-maps-lat" type="text" value="<?php echo esc_attr(get_post_meta($object->ID, "manifold-google-maps-lat", true)); ?>" required>
	        </div>
	        <div class="map-options">
	            <label for="manifold-google-maps-long">Longitude</label>
	            <input name="manifold-google-maps-long" id="manifold-google-maps-long" type="text" value="<?php echo esc_attr(get_post_meta($object->ID, "manifold-google-maps-long", true)); ?>" required>
	        </div>
	        <div class="map-options">
	            <label for="manifold-google-maps-phone">Phone (Format: 123-123-1234)</label>
	            <input name="manifold-google-maps-phone" type="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="<?php echo esc_attr(get_post_meta($object->ID, "manifold-google-maps-phone", true)); ?>">
	        </div>
	        <div class="map-options">
	            <label for="manifold-google-maps-weblink">Website Link (Format: https://wordpress.org)</label>
	            <input name="manifold-google-maps-weblink" type="url" value="<?php echo esc_url(get_post_meta($object->ID, "manifold-google-maps-weblink", true)); ?>">
	        </div>
	        <div class="map-options">
	            <label for="manifold-google-maps-email">E-mail</label>
	            <input name="manifold-google-maps-email" type="email" value="<?php echo esc_attr(get_post_meta($object->ID, "manifold-google-maps-email", true)); ?>">
	        </div>
	        <div class="map-options">
	        	<label for="manifold-google-maps-description">Description</label>
	        	<textarea name="manifold-google-maps-description" id="manifold-google-maps-description" rows="5" cols="30"><?php echo esc_textarea(get_post_meta($object->ID, "manifold-google-maps-description", true)); ?></textarea>
	        </div>
	    <?php  

	}

	/**
	 * Save meta fields of the custom post type Marker.
	 *
	 * @since    1.0.0
	 * @access public
	*/
	public function manifold_google_maps_save_custom_meta_box($post_id, $post, $update) {
		
	    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
	        return $post_id;

	    if(!current_user_can("edit_post", $post_id))
	        return $post_id;

	    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
	        return $post_id;

	    $slug = "marker";
	    
	    if($slug != $post->post_type)
	        return $post_id;
		

		$manifold_google_maps_address = sanitize_text_field($_POST["manifold-google-maps-address"]);
		$manifold_google_maps_lat = sanitize_text_field($_POST["manifold-google-maps-lat"]);
		$manifold_google_maps_long = sanitize_text_field($_POST["manifold-google-maps-long"]);
		$manifold_google_maps_description = sanitize_text_field($_POST["manifold-google-maps-description"]);
		$manifold_google_maps_phone = sanitize_text_field($_POST["manifold-google-maps-phone"]);
		$manifold_google_maps_weblink = sanitize_text_field($_POST["manifold-google-maps-weblink"]);
		$manifold_google_maps_email = sanitize_email($_POST["manifold-google-maps-email"]);


	    isset($manifold_google_maps_address) ? update_post_meta($post_id, "manifold-google-maps-address", $manifold_google_maps_address) : '';
	    isset($manifold_google_maps_lat) ? update_post_meta($post_id, "manifold-google-maps-lat", $manifold_google_maps_lat) : '';
	    isset($manifold_google_maps_long) ? update_post_meta($post_id, "manifold-google-maps-long", $manifold_google_maps_long) : '';
	    isset($manifold_google_maps_description) ? update_post_meta($post_id, "manifold-google-maps-description", $manifold_google_maps_description) : '';
	    isset($manifold_google_maps_phone) ? update_post_meta($post_id, "manifold-google-maps-phone", $manifold_google_maps_phone) : '';
	    isset($manifold_google_maps_weblink) ? update_post_meta($post_id, "manifold-google-maps-weblink", $manifold_google_maps_weblink) : '';
	    isset($manifold_google_maps_email) ? update_post_meta($post_id, "manifold-google-maps-email", $manifold_google_maps_email) : '';
	}

	/**
	 * Add Marker Icon column heading
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function manifold_google_maps_image_columns($defaults) {  
	    $defaults['marker_icon'] = 'Marker Icon';
	    return $defaults;  
	}

    /**
	 * show marker pin image in column of taxonomy map
	 *
	 * @since  1.0.0
	 * @access public
	 */
    public function manifold_google_maps_gallery_columns_content($column_name, $post_ID) {

        if ($column_name == 'marker_icon') {
            $url = wp_get_attachment_url( get_post_thumbnail_id($post_ID), 'thumbnail' );
            if ($url) {
                echo '<img src="' . esc_url($url) . '" />';
            } else{
            	 echo '<img src="' . plugin_dir_url( dirname( __FILE__ ) ).'admin/images/default-pin.png" width="50">';
            }
        }
    }

    /**
	 * Add meta fields for taxonomy Maps
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function manifold_google_maps_taxonomy_add_new_meta_field() {
		// this will add the custom meta field to the add new term page
		?>
		<div class="form-field term-width-wrap form-required">
			<label for="term_meta[width]"><?php _e( 'Map Width', 'manifold-google-maps' ); ?></label>
			<input type="number" name="term_meta[width]" id="term_meta[width]" value="">
			<select name="term_meta[width_value]">
                <option value="%" selected="">%</option>
                <option value="px">px</option>
            </select>
		</div>
		<div class="form-field term-height-wrap form-required">
			<label for="term_meta[height]"><?php _e( 'Map Height', 'manifold-google-maps' ); ?></label>
			<input type="number" name="term_meta[height]" id="term_meta[height]" value="">
			<select name="term_meta[height_value]">
                <option value="px" selected="">px</option>
                <option value="%">%</option>
            </select>
		</div>
		<div class="form-field term-zoomlevel-wrap form-required">
			<label for="term_meta[zoomlevel]"><?php _e( 'Zoom Level', 'manifold-google-maps' ); ?></label>
			<input type="number" name="term_meta[zoomlevel]" id="term_meta[zoomlevel]" value="8">
		</div>
		<div class="form-field term-type-wrap">
			<label><?php _e( 'Map Type', 'manifold-google-maps' ); ?></label>
			<fieldset>
				<label>
					<input type="radio" name="term_meta[maptype]" id="term_meta[roadmap]" value="roadmap" checked>
					<label for="term_meta[roadmap]" class="form-wrap-itp"><?php _e( 'Roadmap', 'manifold-google-maps' ); ?></label>
				</label>
				<br>
				<label>
					<input type="radio" name="term_meta[maptype]" id="term_meta[satellite]" value="satellite">
					<label for="term_meta[satellite]" class="form-wrap-itp"><?php _e( 'Satellite', 'manifold-google-maps' ); ?></label>
					
				</label>
				<br>
				<label>
					<input type="radio" name="term_meta[maptype]" id="term_meta[hybrid]" value="hybrid">
					<label for="term_meta[hybrid]" class="form-wrap-itp"><?php _e( 'Hybrid', 'manifold-google-maps' ); ?></label>
				</label>
				<br>
				<label>
					<input type="radio" name="term_meta[maptype]" id="term_meta[terrain]" value="terrain">
					<label for="term_meta[terrain]" class="form-wrap-itp"><?php _e( 'Terrain', 'manifold-google-maps' ); ?></label>
				</label>
			</fieldset>
			<div class="map-placeholder" id="roadmap">
				<a href="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/roadmap.png" rel="prettyPhoto" title="<?php _e( 'Roadmap', 'manifold-google-maps' ); ?>" target="_blank">
					<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/roadmap.png" />
				</a>
			</div>
			<div class="map-placeholder" id="satellite" style='display:none'>
				<a href="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/satellite.png" rel="prettyPhoto" title="<?php _e( 'Satellite', 'manifold-google-maps' ); ?>" target="_blank">
					<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/satellite.png" />
				</a>
			</div>
			<div class="map-placeholder" id="hybrid" style='display:none'>
				<a href="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/hybrid.png" rel="prettyPhoto" title="<?php _e( 'Hybrid', 'manifold-google-maps' ); ?>" target="_blank">
					<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/hybrid.png">
				</a>
			</div>
			<div class="map-placeholder" id="terrain" style='display:none'>
				<a href="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/terrain.png" rel="prettyPhoto" title="<?php _e( 'Terrain', 'manifold-google-maps' ); ?>" target="_blank">
					<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/terrain.png">
				</a>
			</div>
		</div>
		<div class="form-field term-theme-wrap">
			<label><?php _e( 'Select Theme', 'manifold-google-maps' ); ?></label>
			<fieldset>
				<label>
					<input type="radio" name="term_meta[maptheme]" id="term_meta[silver]" value="silver" checked>
					<label for="term_meta[silver]" class="form-wrap-itp"><?php _e( 'Silver', 'manifold-google-maps' ); ?></label>
				</label>
				<br>
				<label>
					<input type="radio" name="term_meta[maptheme]" id="term_meta[retro]" value="retro">
					<label for="term_meta[retro]" class="form-wrap-itp"><?php _e( 'Retro', 'manifold-google-maps' ); ?></label>
					
				</label>
				<br>
				<label>
					<input type="radio" name="term_meta[maptheme]" id="term_meta[night]" value="night">
					<label for="term_meta[night]" class="form-wrap-itp"><?php _e( 'Night', 'manifold-google-maps' ); ?></label>
				</label>
				<br>
				<label>
					<input type="radio" name="term_meta[maptheme]" id="term_meta[hiding]" value="hiding">
					<label for="term_meta[hiding]" class="form-wrap-itp"><?php _e( 'Default', 'manifold-google-maps' ); ?></label>
				</label>
			</fieldset>
			<div class="theme-placeholder" id="silver">
				<a href="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/silver.png" rel="prettyPhoto" title="<?php _e( 'Silver', 'manifold-google-maps' ); ?>" target="_blank">
					<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/silver.png" />
				</a>
			</div>
			<div class="theme-placeholder" id="retro" style='display:none'>
				<a href="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/retro.png" rel="prettyPhoto" title="<?php _e( 'Retro', 'manifold-google-maps' ); ?>" target="_blank">
					<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/retro.png" />
				</a>
			</div>
			<div class="theme-placeholder" id="night" style='display:none'>
				<a href="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/night.png" rel="prettyPhoto" title="<?php _e( 'Night', 'manifold-google-maps' ); ?>" target="_blank">
					<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/night.png">
				</a>
			</div>
			<div class="theme-placeholder" id="hiding" style='display:none'>
				<a href="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/default.png" rel="prettyPhoto" title="<?php _e( 'Default', 'manifold-google-maps' ); ?>" target="_blank">
					<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>admin/images/default.png">
				</a>
			</div>
		</div>
	<?php
	}
	
    /**
	 * Edit fields for taxonomy maps
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function manifold_google_maps_taxonomy_edit_meta_field($term) {
		
		// put the term ID into a variable
		$t_id = $term->term_id;
		
		// retrieve the existing value(s) for this meta field. This returns an array
		$term_meta = get_option( "taxonomy_$t_id" ); 
		?>
		<tr class="form-field term-width-wrap form-required">
		<th scope="row" valign="top"><label for="term_meta[width]"><?php _e( 'Map Width', 'manifold-google-maps' ); ?></label></th>
			<td>
				<input type="number" name="term_meta[width]" id="term_meta[width]" value="<?php echo esc_attr( $term_meta['width'] ) ? esc_attr( $term_meta['width'] ) : ''; ?>">
				<select name="term_meta[width_value]">
	                <option value="px" <?php selected( esc_attr( $term_meta['width_value'] ), 'px' ); ?>>px</option>
	                <option value="%" <?php selected( esc_attr( $term_meta['width_value'] ), '%' ); ?>>%</option>
	            </select>
			</td>
		</tr>
		<tr class="form-field term-height-wrap form-required">
		<th scope="row" valign="top"><label for="term_meta[height]"><?php _e( 'Map Height', 'manifold-google-maps' ); ?></label></th>
			<td>
				<input type="number" name="term_meta[height]" id="term_meta[height]" value="<?php echo esc_attr( $term_meta['height'] ) ? esc_attr( $term_meta['height'] ) : ''; ?>">
				<select name="term_meta[height_value]">
	                <option value="px" <?php selected( esc_attr( $term_meta['height_value'] ), 'px' ); ?>>px</option>
	                <option value="%" <?php selected( esc_attr( $term_meta['height_value'] ), '%' ); ?>>%</option>
	            </select>
			</td>
		</tr>
		<tr class="form-field term-zoomlevel-wrap form-required">
		<th scope="row" valign="top"><label for="term_meta[zoomlevel]"><?php _e( 'Zoom Level', 'manifold-google-maps' ); ?></label></th>
			<td>
				<input type="number" name="term_meta[zoomlevel]" id="term_meta[zoomlevel]" value="<?php echo esc_attr( $term_meta['zoomlevel'] ) ? esc_attr( $term_meta['zoomlevel'] ) : '8'; ?>">
			</td>
		</tr>
		<tr class="form-field term-type-wrap">
			<th scope="row" valign="top"><label for="term_meta[maptype]"><?php _e( 'Select Map Type', 'manifold-google-maps' ); ?></label></th>
			<td>
				<fieldset>
					<label>
						<input type="radio" name="term_meta[maptype]" id="term_meta[roadmap]" value="roadmap" <?php checked( esc_attr( $term_meta['maptype'] ), 'roadmap' ); ?>>
						<label for="term_meta[roadmap]"><?php _e( 'Roadmap', 'manifold-google-maps' ); ?></label>
					</label>
					<br>
					<label>
						<input type="radio" name="term_meta[maptype]" id="term_meta[satellite]" value="satellite" <?php checked( esc_attr( $term_meta['maptype'] ), 'satellite' ); ?>>
						<label for="term_meta[satellite]"><?php _e( 'Satellite', 'manifold-google-maps' ); ?></label>
					</label>
					<br>
					<label>
						<input type="radio" name="term_meta[maptype]" id="term_meta[hybrid]" value="hybrid" <?php checked( esc_attr( $term_meta['maptype'] ), 'hybrid' ); ?>>
						<label for="term_meta[hybrid]"><?php _e( 'Hybrid', 'manifold-google-maps' ); ?></label>
					</label>
					<br>
					<label>
						<input type="radio" name="term_meta[maptype]" id="term_meta[terrain]" value="terrain" <?php checked( esc_attr( $term_meta['maptype'] ), 'terrain' ); ?>>
						<label for="term_meta[terrain]"><?php _e( 'Terrain', 'manifold-google-maps' ); ?></label>
					</label>
				</fieldset>
			</td>
		</tr>
		<tr class="form-field term-type-wrap">
			<th scope="row" valign="top"><label for="term_meta[maptheme]"><?php _e( 'Select Theme', 'manifold-google-maps' ); ?></label></th>
			<td>				
				<fieldset>
					<label>
						<input type="radio" name="term_meta[maptheme]" id="term_meta[silver]" value="silver" <?php checked( esc_attr( $term_meta['maptheme'] ), 'silver' ); ?>>
						<label for="term_meta[silver]"><?php _e( 'Silver', 'manifold-google-maps' ); ?></label>
					</label>
					<br>
					<label>
						<input type="radio" name="term_meta[maptheme]" id="term_meta[retro]" value="retro" <?php checked( esc_attr( $term_meta['maptheme'] ), 'retro' ); ?>>
						<label for="term_meta[retro]"><?php _e( 'Retro', 'manifold-google-maps' ); ?></label>
					</label>
					<br>
					<label>
						<input type="radio" name="term_meta[maptheme]" id="term_meta[night]" value="night" <?php checked( esc_attr( $term_meta['maptheme'] ), 'night' ); ?>>
						<label for="term_meta[night]"><?php _e( 'Night', 'manifold-google-maps' ); ?></label>
					</label>
					<br>
					<label>
						<input type="radio" name="term_meta[maptheme]" id="term_meta[hiding]" value="hiding" <?php checked( esc_attr( $term_meta['maptheme'] ), 'hiding' ); ?>>
						<label for="term_meta[hiding]"><?php _e( 'Default', 'manifold-google-maps' ); ?></label>
					</label>
				</fieldset>
			</td>
		</tr>
		<?php
	}

	/**
	 * Save extra taxonomy fields callback function.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function manifold_google_maps_save_taxonomy_custom_meta( $term_id ) {
		$term_meta_array = map_deep( $_POST['term_meta'], 'sanitize_text_field' );
		/*echo "<pre>";
		print_r($term_meta_array);
		exit;*/

		if ( isset( $term_meta_array ) ) {
			$t_id = $term_id;
			$term_meta = get_option( "taxonomy_$t_id" );
			$cat_keys = array_keys( $term_meta_array );
			foreach ( $cat_keys as $key ) {
				if (isset($term_meta_array[$key])) {
					$term_meta[$key] = $term_meta_array[$key];
				}
			}
			// Save the option array.
			update_option( "taxonomy_$t_id", $term_meta );
		}
	} 

	/**
	 * Remove description field from taxonomy Map
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function manifold_google_maps_remove_description_taxonomy_map( $columns ) {
	    if( isset( $columns['description'] ) )
	        unset( $columns['description'] );       
	    return $columns;
	}

	/**
	 * Add custom columns for taxonomy Map
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function  manifold_google_maps_type_add_dynamic_hooks() {
		$taxonomy = 'map';
		add_filter( 'manage_' . $taxonomy . '_custom_column', array($this, 'manifold_google_maps_type_taxonomy_rows'),15, 3 );
		add_filter( 'manage_edit-' . $taxonomy . '_columns',  array($this, 'manifold_google_maps_type_taxonomy_columns') );
	}

	/**
	 * Add extra meta field on taxonomy listing page
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function manifold_google_maps_type_taxonomy_columns( $original_columns ) {
		$new_columns = $original_columns;
		array_splice( $new_columns, 2 );
		$new_columns['maptype'] = esc_html__( 'Map Type', 'manifold-google-maps' );
		$new_columns['map_shortcode'] = esc_html__( 'Shortcode', 'manifold-google-maps' );
		return array_merge( $new_columns, $original_columns );
	}

	/**
	 * Fetch extra meta fields on taxonomy listing page
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function manifold_google_maps_type_taxonomy_rows( $row, $column_name, $term_id ) {
		$t_id = $term_id;
		$term = get_term( $t_id, 'map' );
		$term_meta = get_option( "taxonomy_$t_id" );
		if ( 'maptype' === $column_name ) {
			//echo esc_attr( $term_meta['maptype'] );
		    if (esc_attr( $term_meta['maptype'] ) == "satellite") {
		        return $row . '<img src="'.plugin_dir_url( dirname( __FILE__ ) ).'admin/images/satellite.png" alt="Satellite" width="100px"><p>Satellite</p>';
		    } else if (esc_attr( $term_meta['maptype'] ) == "hybrid") {
		        return $row . '<img src="'.plugin_dir_url( dirname( __FILE__ ) ).'admin/images/hybrid.png" alt="Hybrid" width="100px"><p>Hybrid</p>';
		    } else if (esc_attr( $term_meta['maptype'] ) == "terrain") {
		        return $row . '<img src="'.plugin_dir_url( dirname( __FILE__ ) ).'admin/images/terrain.png" alt="Terrain" width="100px"><p>Terrain</p>';
		    } else {
		        return $row . '<img src="'.plugin_dir_url( dirname( __FILE__ ) ).'admin/images/roadmap.png" alt="Roadmap" width="100px"><p>Roadmap</p>';
		    }   
		}
		if ( 'map_shortcode' === $column_name ) {
			$InputID = 'map-shodtcode'.$t_id;
			echo '<input type="text" class="map-shotcode" id="'.esc_attr($InputID).'" value="[manifold-google-maps cat&#61;&#34;'.esc_attr($term->slug).'&#34;]">
			<a href="#" class="copy-shortcode" onclick="copyshortcodetext(&#34;'.esc_attr($InputID).'&#34;)">Copy</a>';
		}
	}

	/**
	 * Register general section on pluign setting page
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function register_manifold_google_maps_settings() {
        // Add a General section
		add_settings_section(
			$this->option_name. '_general',
			'',
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);
		// Add a google key field
		add_settings_field(
			$this->option_name . '_googlekey',
			__( 'Google Map API key', 'manifold-google-maps' ),
			array( $this, $this->option_name . '_googlekey_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_googlekey' )
		);
		// Register the google key field
		register_setting( $this->plugin_name, $this->option_name . '_googlekey', 'string' );
	} 

	/**
	 * Render the text for the general section
	 *
	 * @since  	1.0.0
	 * @access 	public
	*/
	public function manifold_google_maps_general_cb() {
		
	}

	/**
	 * Render the number input for this plugin
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function manifold_google_maps_googlekey_cb() {
		$get_google_key = get_option( $this->option_name . '_googlekey' );
		echo '<input type="text" name="' . esc_attr($this->option_name) . '_googlekey' . '" id="' . esc_attr($this->option_name) . '_googlekey' . '" value="' . esc_attr($get_google_key) . '">';
		echo '<p><a class="" target="_blank" href="https://www.itpathsolutions.com/simple-way-to-create-a-google-maps-api-key/">' . __( 'Create Google Map key by yourself', 'manifold_google_maps' ) . '</a><p>or</p> <a class="" target="_blank" href="mailto:info@itpathsolutions.com">' . __( 'Let us help you to get it', 'manifold_google_maps' ) . '</a></p>';
	} 

	/**
	 * Setting link on plugin page
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function manifold_google_maps_action_links( $links) {
      	$links[] = '<a href="'.admin_url( 'edit.php?post_type=marker&page=manifold-google-maps' ) .'">' . __('Settings') . '</a>';
		return $links;
    }  

    public function manifold_google_maps_publish_admin_hook(){
    	global $post_type;
		if( 'marker' == $post_type){
		    echo"<script language=\"javascript\" type=\"text/javascript\">
		        jQuery(document).ready(function() {
		            jQuery('#publish').click(function() {
		                var form_data = jQuery('#post').serializeArray();
		                form_data = jQuery.param(form_data);
		                var data = {
		                    action: 'my_pre_submit_validation',
		                    security: '";echo wp_create_nonce( 'pre_publish_validation' ); echo"',
		                    form_data: form_data
		                };
		            });
		        });
		    </script>";
		}
	}
}
