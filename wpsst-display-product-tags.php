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

function display_product_tags($atts)
{
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
    <style>
        .product-tags {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 20px;
        }

        @media screen and (max-width: 767px) {
            .product-tags {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .product-tag {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .product-tag a {
            display: block;
            width: 100%;
            height: 100%;
            text-align: center;
        }

        .product-tag img {
            width: 100%;
            height: auto;
            max-width: 100px;
        }

        .product-tag span {
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
    <ul class="product-tags">
        <?php
        $tags = get_terms($args);
        foreach ($tags as $tag):
            $tag_link = get_tag_link($tag->term_id);
            ?>
            <li class="product-tag">
                <a href="<?php echo esc_url($tag_link); ?>" title="<?php echo esc_attr($tag->name); ?>">
                    <?php
                    if (function_exists('cpti_get_term_image_url') && cpti_get_term_image_url($tag->term_id)) {
                        ?>
                        <img src="<?php echo cpti_get_term_image_url($tag->term_id); ?>"
                            alt="<?php echo esc_attr($tag->name); ?>" />
                        <?php
                    } else {
                        echo $tag->name;
                    }
                    ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php
    return ob_get_clean();
}
add_shortcode('display_product_tags', 'display_product_tags');