<?php

/**
 * Header subpage Block template.
 *
 * @param array $block The block settings and attributes.
 */

// Load values and assign defaults.
global $post;

$text       = get_field('text');
$buttons    = get_field('buttons');
$post_thumbnail = get_the_post_thumbnail($post->ID, 'full');
if (!$post_thumbnail) {
    $image = wp_get_attachment_image(get_field('image'), 'full');
} else {
    $image = $post_thumbnail;
}

$variant    = get_field('variant');
$articles   = get_field('articles');

// Support custom "anchor" values.
$anchor = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '" ' : '';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wpb-header--home';
$class_name .= !empty($block['className']) ? ' ' . $block['className'] : '';
$class_name .= !empty($block['align']) ? ' align' . $block['align'] : '';
$class_name .= $image && $variant == 'default' ? ' has-background-image' : ' wpb-bg-clr--primary';
$class_name .= $variant ? ' wpb-var--' . $variant : 'wpb-var--default';
?>

<section <?= $anchor ?>class="wpb-header <?= esc_attr($class_name) ?> wpb-wst--large wpb-wsb--large">

    <div class="container container--large <?= wpb_gsap_class('fade-up') ?>">

        <?php if (!empty($text)) : ?>
            <div class="wpb-text <?= $variant == 'default' ? 'wpb-text--70' : '' ?>" <?= $variant == 'default' ? 'style="margin: 0 auto;"' : '' ?>>
                <?= wp_kses_post($text); ?>
                <?php if (isset($buttons) && !empty($buttons)) : ?>
                    <div class="btn-group btn-group--center">
                        <?php get_template_part('snippets/content', 'buttons', $buttons); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($articles)) :
            if ($variant == 'articles') {
                $articles = array_slice($articles, 0, 3);
        ?>
                <div class="wpb-articles-group">
                    <?php foreach ($articles as $article_id) {
                        get_template_part('snippets/content', 'post', ["post_id" => $article_id, 'card_style' => 'image']);
                    } ?>
                </div>
            <?php } else if ($variant == 'slider') { ?>
                <div class="owl-carousel owl-carousel--header">
                    <?php foreach ($articles as $article_id) :
                        get_template_part('snippets/content', 'post', ["post_id" => $article_id, 'card_style' => 'image']);
                    endforeach; ?>
                </div>
        <?php }
        endif; ?>

    </div>

    <?php if ($image && $variant == 'default') : ?>
        <figure class="is-background-image">
            <?= $image ?>
        </figure>
    <?php endif; ?>

    <?php if ($variant == 'slider') { ?>
        <script>
            jQuery(document).ready(function($) {
                const selector = '.owl-carousel--header';
                const carouselSettings = {
                    loop: true,
                    margin: 18,
                    nav: false,

                    mouseDrag: true,
                    touchDrag: true,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    autoplaySpeed: 5000,
                    smartSpeed: 1000,
                    autoplayHoverPause: false,
                    slideTransition: "linear",

                    responsive: {
                        0: {
                            items: 1.2
                        },
                        576: {
                            items: 1.6
                        },
                        768: {
                            items: 2
                        },
                        992: {
                            items: 2.7
                        },
                        1400: {
                            items: 3
                        },
                    }
                };

                // Initialize the carousel with settings
                const carousel = $(selector).owlCarousel(carouselSettings);

                carousel.trigger('play.owl.autoplay', [0]);
            });
        </script>
    <?php } ?>

</section>