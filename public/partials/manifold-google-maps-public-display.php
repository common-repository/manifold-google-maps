<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.itpathsolutions.com/
 * @since      1.0.0
 *
 * @package    Manifold_Google_Maps
 * @subpackage Manifold_Google_Maps/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
if($atts['cat']){
    $term = get_term_by( 'slug', $atts['cat'], 'map' );
}

if(!empty($term)) {
    $t_id = $term->term_id;
    $term_meta = get_option( "taxonomy_$t_id" ); 
    $args = array(
            'posts_per_page' => -1,
            'post_type' => 'marker',
            'tax_query' => array(
                array(
                    'taxonomy' => 'map',
                    'field' => 'slug',
                    'terms' => $atts['cat'],
                )
            )
        );
    $markers = get_posts($args);
    ?>
    <markers data-maptype="<?php echo esc_attr($term_meta['maptype']); ?>" data-maptheme="<?php echo esc_attr($term_meta['maptheme']); ?>" data-zoomlevel="<?php echo esc_attr($term_meta['zoomlevel']); ?>">
    <?php
        foreach ($markers as $key => $marker) { 
            $lat = esc_attr(get_post_meta($marker->ID, 'manifold-google-maps-lat', true));
            $long = esc_attr(get_post_meta($marker->ID, 'manifold-google-maps-long', true));
            $address = esc_attr(get_post_meta($marker->ID, 'manifold-google-maps-address', true));
            $phone = esc_attr(get_post_meta($marker->ID, 'manifold-google-maps-phone', true));
            $email = esc_attr(get_post_meta($marker->ID, 'manifold-google-maps-email', true));
            $weblink = esc_url(get_post_meta($marker->ID, 'manifold-google-maps-weblink', true));
            $description = esc_textarea(get_post_meta($marker->ID, 'manifold-google-maps-description', true));
            $markerIcon = esc_url(wp_get_attachment_url(get_post_thumbnail_id($marker->ID), 'thumbnail'));
            

            echo '<marker data-markerid="'.esc_attr($key).'" class="location-marker" id="'.esc_attr($key).'" title="'.esc_attr($marker->post_title).'" phone="'.$phone.'" info="'.$description.'" address="'.$address.'" name="'.esc_attr($marker->post_title).'" lat="'.$lat.'" lng="'.$long.'" email="'.$email.'" weblink="'.$weblink.'" markerIcon="'.$markerIcon.'"></marker>';
        }
    ?>
    </markers>
    <div id="location-map" style="width: <?php echo esc_attr($term_meta['width']).esc_attr($term_meta['width_value']); ?>;height: <?php echo esc_attr($term_meta['height']).esc_attr($term_meta['height_value']); ?>"></div>
<?php } else {
    echo ' <div id="location-map"></div>';
    echo _e('There is an issue with the shortcode, Please <a href="'.site_url().'/wp-admin/edit-tags.php?taxonomy=map&post_type=marker">copy shortcode from here!</a>', 'manifold-google-maps');
}