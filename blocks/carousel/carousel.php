<?php
/**
 * Carousel Block template.
 *
 * @param array $block The block settings and attributes.
 */

// Load values and assign defaults.
$block_id           = substr(preg_replace('/[^a-f0-9]/', '', $block['id']), 0, 4);

$post_type          = 'post';
$text               = get_field('text');
$blogs              = get_field('blogs');

$whitespace_top     = get_field('whitespace_top');
$whitespace_bottom  = get_field('whitespace_bottom');
$background_color   = get_field('background_color');
$adjust_width       = get_field('adjust_width');
$column_count       = get_field('column_count') ?: 3;

// Support custom "anchor" values.
$anchor = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '" ' : '';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wpb-block--carousel';
$class_name .= !empty($block['className']) ? ' ' . $block['className'] : '';
$class_name .= !empty($block['align']) ? ' align' . $block['align'] : '';
$class_name .= $whitespace_top ? ' wpb-wst--' . $whitespace_top : '';
$class_name .= $whitespace_bottom ? ' wpb-wsb--' . $whitespace_bottom : '';
$class_name .= $background_color ? ' wpb-bg-clr--' . $background_color : '';

$auto_fill          = get_field('auto_fill');
$blog_count         = get_field('blog_count');
$blog_offset        = get_field('blog_offset');

$container_class = '';
$container_class .= $adjust_width ? ' container--' . $adjust_width : '';

// If posts are empty, retrieve default posts.
if (empty($blogs) || $auto_fill) {
    $blogs = get_posts(array(
        'post_type'         => $post_type,
        'post_status'       => 'publish',
        'fields'            => 'ids',
        'posts_per_page'    => $blog_count ?? 4,
        'offset'            => $blog_offset ?? 0,
    ));
}
?>

<section <?= $anchor ?>class="wpb-block <?= esc_attr($class_name) ?>">

    <?php if (!empty($text)) : ?>
        <div class="wpb-section__header">
            <div class="container <?= esc_attr($container_class) ?>">
                <div class="wpb-text">
                    <?= wp_kses_post($text); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="wpb-section__body">
        <div class="container <?= esc_attr($container_class) ?>">
            <?php if (!empty($blogs)) : ?>
                <div class="owl-carousel owl-carousel--blogs owl-carousel--blogs--<?= $block_id ?>-<?= $column_count ?>">
                    <?php foreach ($blogs as $blog_id) :
                        get_template_part('snippets/content', 'post', ["post_id" => $blog_id]);
                    endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($blogs)) {
        $slide_gap = get_field('slide_gap');
        $loop = get_field('loop') ? 'true' : 'false';
        $nav = get_field('nav') ? 'true' : 'false';
        $autoplay = get_field('autoplay') ? 'true' : 'false';
        $smooth_scroll = get_field('smooth_scroll') ? 'true' : 'false';
    ?>
        <script>
            jQuery(document).ready(function($) {
                const blockId = '<?= $block_id ?>';
                const count = <?= $column_count ?>;
                const smoothScroll = <?= $smooth_scroll ?>;
                const autoplay = <?= $autoplay ?>;
                const selector = '.owl-carousel--blogs--' + blockId + '-' + count;

                const carouselSettings = {
                    loop: <?= $loop ?>,
                    margin: <?= $slide_gap ?: 18 ?>,
                    nav: <?= $nav ?>,
                    responsive: {
                        0: {
                            items: 1
                        },
                        576: {
                            items: Math.max(1, count - 3)
                        },
                        768: {
                            items: Math.min(3, Math.max(2, count - 2))
                        },
                        992: {
                            items: Math.min(4, Math.max(3, count - 1))
                        },
                        1200: {
                            items: count
                        }
                    }
                };

                if (autoplay) {
                    carouselSettings.autoplay = true;
                    carouselSettings.autoplayTimeout = 5000;
                    carouselSettings.autoplayHoverPause = true;
                    carouselSettings.smartSpeed = 1000;
                }

                if (smoothScroll) {
                    carouselSettings.mouseDrag = true;
                    carouselSettings.touchDrag = true;
                    carouselSettings.autoplaySpeed = 5000;
                    carouselSettings.autoplayHoverPause = false;
                    carouselSettings.slideTransition = "linear";
                }

                const carousel = $(selector).owlCarousel(carouselSettings);

                if (smoothScroll) {
                    carousel.trigger('play.owl.autoplay', [0]);
                }
            });
        </script>
    <?php } ?>

</section>