<?php
/*
Plugin Name:  WPSST Display Product Tags
Plugin URI:   https://www.syriasmart.net
Description:  Display product tags with shorcode for Grid [ka_display_all_tags] for Slider [ka_display_tags_slider]. 
Version:      1.0
Author:       Syria Smart Technology 
Author URI:   https://www.syriasmart.net
License:      GPL v2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wpsst-display-product-tags
Domain Path:  /languages
*/

function ka_get_tag_image($term_id)
{
    $tag_image_id = get_term_meta($term_id, 'tag_image_id', true);
    if ($tag_image_id) {
        $image_size = apply_filters('woocommerce_product_tag_thumbnail_size', 'woocommerce_thumbnail');
        $image = wp_get_attachment_image_src($tag_image_id, $image_size);
        if ($image) {
            return $image[0];
        }
    }
    $products = get_posts(
        array(
            'post_type' => 'product',
            'numberposts' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_tag',
                    'field' => 'slug',
                    'terms' => $tag->slug,
                ),
            ),
        )
    );
    if (!empty($products)) {
        $product_count = count($products);
        $random_index = rand(0, $product_count - 1);
        $product_id = $products[$random_index]->ID;
        $image_id = get_post_thumbnail_id($product_id);
        if ($image_id) {
            return wp_get_attachment_url($image_id);
        }
    }
    return false;
}

add_shortcode('ka_display_all_tags', 'ka_display_all_tags_func');

function ka_display_all_tags_func()
{
    $tags = get_terms(
        array(
            'taxonomy' => 'product_tag',
            'hide_empty' => false,
        )
    );
    $output = '';
    if (!empty($tags)) {
        $output .= '<div class="row">';
        foreach ($tags as $tag) {
            $products = get_posts(
                array(
                    'post_type' => 'product',
                    'numberposts' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_tag',
                            'field' => 'slug',
                            'terms' => $tag->slug,
                        ),
                    ),
                )
            );
            if (!empty($products)) {
                $output .= '<div class="col-md-3 col-sm-6 col-xs-6">';
                $output .= '<div class="tag-image">';
                $output .= '<a href="' . get_term_link($tag) . '">';
                $tag_image = ka_get_tag_image($tag->term_id);
                if ($tag_image) {
                    $output .= '<img src="' . esc_url(wp_get_attachment_url($tag_image)) . '" alt="' . $tag->name . '">';
                } else {
                    $product_id = $products[array_rand($products)]->ID;
                    $image_url = get_the_post_thumbnail_url($product_id, 'woocommerce_thumbnail');
                    if ($image_url) {
                        $output .= '<img src="' . esc_url($image_url) . '" alt="' . $tag->name . '">';
                    } else {
                        $output .= '<img src="' . esc_url(ka_get_default_tag_image_url()) . '" alt="' . $tag->name . '">';
                    }
                }
                $output .= '</a>';
                $output .= '<div class="tag-name">' . $tag->name . '</div>';
                $output .= '</div>';
                $output .= '</div>';
            }
        }
        $output .= '</div>';
    }
    wp_enqueue_style('plugin-name-style', plugin_dir_url(__FILE__) . 'assets/css/grid-style.css');
    return $output;
}

function ka_display_tags_slider_func()
{
    ob_start();

    $tags = get_terms(
        array(
            'taxonomy' => 'product_tag',
            'hide_empty' => false,
        )
    );
    if (!empty($tags)) {
        echo '<div class="swiper-container">';
        echo '<div class="swiper-wrapper">';
        foreach ($tags as $tag) {
            $products = get_posts(
                array(
                    'post_type' => 'product',
                    'numberposts' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_tag',
                            'field' => 'slug',
                            'terms' => $tag->slug,
                        ),
                    ),
                )
            );
            if (!empty($products)) {
                echo '<div class="swiper-slide">';
                echo '<div class="tag-image">';
                echo '<a href="' . get_term_link($tag) . '">';
                $tag_image = ka_get_tag_image($tag->term_id);
                if ($tag_image) {
                    echo '<img src="' . esc_url(wp_get_attachment_url($tag_image)) . '" alt="' . $tag->name . '">';
                } else {
                    $product_id = $products[array_rand($products)]->ID;
                    $image_url = get_the_post_thumbnail_url($product_id, 'woocommerce_thumbnail');
                    if ($image_url) {
                        echo '<img src="' . esc_url($image_url) . '" alt="' . $tag->name . '">';
                    } else {
                        echo '<img src="' . esc_url(ka_get_default_tag_image_url()) . '" alt="' . $tag->name . '">';
                    }
                }
                echo '</a>';
                echo '<div class="tag-name">' . $tag->name . '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
        echo '</div>';
        echo '<div class="swiper-pagination"></div>';
        echo '<div class="swiper-button-prev"></div>';
        echo '<div class="swiper-button-next"></div>';
        echo '</div>';
    }

    wp_enqueue_style('swiper-style', plugin_dir_url(__FILE__) . 'assets/css/swiper.min.css');
    wp_enqueue_script('swiper-script', plugin_dir_url(__FILE__) . 'assets/js/swiper.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('plugin-script', plugin_dir_url(__FILE__) . 'assets/js/plugin.js', array('swiper-script'), '1.0.0', true);

    $output = ob_get_clean();
    return $output;
}
add_shortcode('ka_display_tags_slider', 'ka_display_tags_slider_func');

?>