<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.itpathsolutions.com/
 * @since      1.0.0
 *
 * @package    Manifold_Google_Maps
 * @subpackage Manifold_Google_Maps/admin/partials
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2 class="itp-setting-heading">Google Map Settings</h2>  
     <!--NEED THE settings_errors below so that the errors/success messages are shown after submission - wasn't working once we started using add_menu_page and stopped using add_options_page so needed this-->
    <?php settings_errors(); ?>  
    <form method="POST" action="options.php" class="itp-map-search-form">  
        <?php 
            settings_fields( $this->plugin_name );
            do_settings_sections( $this->plugin_name );  ?>
            <div class="map-submit-button"><?php submit_button(__( 'Save Google Map Key', 'manifold-google-maps' )); ?></div> 
    </form> 
    <div>
        <a href="<?php echo site_url() ?>/wp-admin/edit-tags.php?taxonomy=map&post_type=marker" class="button button-primary button-large"><?php  echo __( 'Start adding Maps from here', 'manifold-google-maps' ); ?></a>
    </div>
    <div class="menifold-help-steps">
        <h2><?php  echo __( 'To use the plugin simply insert your shortcode into post, page or widget.', 'manifold-google-maps' ); ?></h2>
        <ul>
            <li><?php  echo __( 'Create Google Map Key - add that key in plugin settings', 'manifold-google-maps' ); ?></li>
            <li><?php  echo __( 'Create Maps to create shortcode', 'manifold-google-maps' ); ?></li>
            <li><?php  echo __( 'Add marker and assign marker to category', 'manifold-google-maps' ); ?></li>
            <li><?php  echo __( 'Add the shortcode [manifold-google-maps cat="YOUR_MAP_CATEGORY_SLUG"] where you want to display the map.', 'manifold-google-maps' ); ?></li>
        </ul>
    </div>
</div>