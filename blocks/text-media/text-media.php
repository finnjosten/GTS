<?php
/**
 * Text-media Block template.
 *
 * @param array $block The block settings and attributes.
 */

$text               = get_field('text');
$image_id           = get_field('image');
$whitespace_top     = get_field('whitespace_top');
$whitespace_bottom  = get_field('whitespace_bottom');
$background_color   = get_field('background_color');
$background_image_id= get_field('background_image');
$adjust_width       = get_field('adjust_width');
$horizontal_align   = get_field('horizontal_align');
$buttons            = get_field('buttons');
$column_sizes       = get_field('column_sizes');

// Support custom "anchor" values.
$anchor = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '" ' : '';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wpb-block--text-media';
$class_name .= !empty($block['className']) ? ' ' . $block['className'] : '';
$class_name .= !empty($block['align']) ? ' align' . $block['align'] : '';
$class_name .= $whitespace_top ? ' wpb-wst--' . $whitespace_top : '';
$class_name .= $whitespace_bottom ? ' wpb-wsb--' . $whitespace_bottom : '';
$class_name .= $background_color ? ' wpb-bg-clr--' . $background_color : '';
$class_name .= $background_image_id ? ' has-background-image' : '';

// Container class
$container_class = '';
$container_class .= $column_sizes       ? ' wpb-cols--' . $column_sizes : ' wpb-cols--50-50';
$container_class .= $adjust_width ? ' container--' . $adjust_width : '';
$container_class .= $horizontal_align ? ' align-' . $horizontal_align : '';
?>

<section <?= $anchor ?>class="wpb-block <?= esc_attr($class_name) ?>">
    <div class="container d-grid<?= esc_attr($container_class) ?>">

        <?php if (!empty($text)) : ?>
            <div class="wpb-text">
                <?= wp_kses_post($text); ?>

                <?php if (!empty($buttons)) : ?>
                    <div class="btn-group">
                        <?php get_template_part('snippets/content', 'buttons', $buttons); ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <?php if ($image_id) : ?>
            <figure class="wpb-image <?= get_field('media_align') ?>">
                <?= wp_get_attachment_image($image_id, 'full') ?>
            </figure>
        <?php endif; ?>

    </div>

    <?php if ($background_image_id) : ?>
        <figure class="is-background-image">
            <?= wp_get_attachment_image($background_image_id, 'full') ?>
        </figure>
    <?php endif; ?>

</section>