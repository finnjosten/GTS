<?php
/**
 * Text-shortcode Block template.
 *
 * @param array $block The block settings and attributes.
 */

$shortcode          = get_field('shortcode');
$whitespace_top     = get_field('whitespace_top');
$whitespace_bottom  = get_field('whitespace_bottom');
$background_color   = get_field('background_color');
$adjust_width       = get_field('adjust_width');
$only_text          = get_field('only_text');

// Support custom "anchor" values.
$anchor = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '" ' : '';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wpb-block--shortcode';
$class_name .= !empty($block['className']) ? ' ' . $block['className'] : '';
$class_name .= $whitespace_top ? ' wpb-wst--' . $whitespace_top : '';
$class_name .= $whitespace_bottom ? ' wpb-wsb--' . $whitespace_bottom : '';
$class_name .= $background_color ? ' wpb-bg-clr--' . $background_color : '';

// Container class
$container_class = '';
$container_class .= $adjust_width ? ' container--' . $adjust_width : '';

?>

<section <?= $anchor ?>class="wpb-block <?= esc_attr($class_name) ?>">
    <div class="container <?= esc_attr($container_class) ?>">

        <?php if ($shortcode) : ?>

            <?php if ($only_text) : ?>
                <div class="wpb-text">
                    <?= do_shortcode($shortcode); ?>
                </div>
            <?php else : ?>
                <?= do_shortcode($shortcode); ?>
            <?php endif; ?>
            
        <?php endif; ?>

    </div>
</section>