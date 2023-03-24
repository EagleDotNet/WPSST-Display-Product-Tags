<?php
/*
Plugin Name:  WPSST Display Product Tags
Plugin URI:   https://www.syriasmart.net
Description:  Display product tags with shorcode [display_product_tags]. 
Version:      1.0
Author:       Syria Smart Technology 
Author URI:   https://www.syriasmart.net
License:      GPL v2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wpsst-display-product-tags
Domain Path:  /languages
*/

function display_product_tags($atts){
    ob_start();

    $args = array(
        'taxonomy' => 'product_tag',
        'orderby' => 'name',
        'show_count' => 0,
        'pad_counts' => 0,
        'hierarchical' => 1,
        'title_li' => '',
        'hide_empty' => 0
    );
    ?>
    <ul class="product-tags">
        <?php
        $tags = get_terms( $args );
        foreach ( $tags as $tag ) :
            $tag_link = get_tag_link( $tag->term_id );
            // $tag_image = z_taxonomy_image_url($tag->term_id); // تحديد الصورة للوسم
            ?>
            <li class="product-tag">
                <a href="<?php echo esc_url( $tag_link ); ?>" title="<?php echo esc_attr( $tag->name ); ?>">
                    <!-- <?php if(!empty($tag_image)) { ?><img src="<?php echo esc_url($tag_image); ?>" alt="<?php echo esc_attr( $tag->name ); ?>"><?php } ?> -->
                    <?php echo $tag->name; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php
    return ob_get_clean();
}
add_shortcode( 'display_product_tags', 'display_product_tags' );
