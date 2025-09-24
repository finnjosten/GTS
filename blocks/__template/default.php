<?php
global $buttons;

/**
 * Default Block template.
 *
 * @param array $block The block settings and attributes.
 */

// Load values and assign defaults.
$text               = get_field('text');
$whitespace_top     = get_field('whitespace_top');
$whitespace_bottom  = get_field('whitespace_bottom');
$background_color   = get_field('background_color');
$adjust_width       = get_field('adjust_width');
$background_image_id= get_field('background_image');
$buttons            = get_field('buttons');

// Support custom "anchor" values.
$anchor = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '" ' : '';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wpb-block--default';
$class_name .= !empty($block['className']) ? ' ' . $block['className'] : '';
$class_name .= !empty($block['align']) ? ' align' . $block['align'] : '';
$class_name .= $whitespace_top ? ' wpb-wst--' . $whitespace_top : '';
$class_name .= $whitespace_bottom ? ' wpb-wsb--' . $whitespace_bottom : '';
$class_name .= $background_color ? ' wpb-bg-clr--' . $background_color : '';
$class_name .= $background_image_id ? ' has-background-image' : '';

$container_class = '';
$container_class .= $adjust_width ? ' container--' . $adjust_width : '';

?>

<section <?= $anchor ?>class="wpb-block <?= esc_attr($class_name) ?>">

    <div class="container <?= esc_attr($container_class) ?>">

        <?php if (!empty($text)) : ?>
            <div class="wpb-text">
                <?= wp_kses_post($text); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($buttons) && !empty($buttons)) : ?>
            <div class="btn-group">
                <?php get_template_part('snippets/content', 'buttons', $buttons); ?>
            </div>
        <?php endif; ?>

    </div>

    <?php if ($background_image_id) : ?>
        <figure class="is-background-image">
            <?= wp_get_attachment_image($background_image_id, 'large'); ?>
        </figure>
    <?php endif; ?>

</section>
