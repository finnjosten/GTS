<?php

/**
 * Text Block template.
 *
 * @param array $block The block settings and attributes.
 */

$text               = get_field('text');
$title              = get_field('block_title');
$text_left          = get_field('text_column_1');
$text_right         = get_field('text_column_2');
$whitespace_top     = get_field('whitespace_top');
$whitespace_bottom  = get_field('whitespace_bottom');
$background_color   = get_field('background_color');
$adjust_width       = get_field('adjust_width');
$buttons            = get_field('buttons');

$column_sizes       = get_field('column_sizes');
$column_sizes       = $column_sizes ? $column_sizes : '50-50';

$text_size          = get_field('text_size');
$text_size          = $text_size ? $text_size : '70';

// Support custom "anchor" values.
$anchor = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '" ' : '';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wpb-block--text';
$class_name .= !empty($block['className']) ? ' ' . $block['className'] : '';
$class_name .= !empty($block['align']) ? ' align' . $block['align'] : '';
$class_name .= $whitespace_top ? ' wpb-wst--' . $whitespace_top : '';
$class_name .= $whitespace_bottom ? ' wpb-wsb--' . $whitespace_bottom : '';
$class_name .= $background_color ? ' wpb-bg-clr--' . $background_color : '';

$container_class = 'container';
$container_class .= $adjust_width ? ' container--' . $adjust_width : '';

?>

<section <?= $anchor ?>class="wpb-block <?= esc_attr($class_name) ?>">

    <?php if ($title) : ?>
        <div class="<?= $container_class ?>">
            <div class="wpb-text wpb-text--wide">
                <h2 class="wpb-text__title"><?= $title ?></h2>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($text)) : ?>
        <div class="<?= $container_class ?>">
            <div class="wpb-text wpb-text--<?= $text_size ?>">
                <?= wp_kses_post(wpb_replace_placeholders($text)); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($text_left) || !empty($text_right)) : ?>
        <div class="<?= $container_class ?> d-grid wpb-cols--<?= $column_sizes ?>">
            <?php if (!empty($text_left)) : ?>
                <div class="wpb-text wpb-text--small">
                    <?= wp_kses_post($text_left); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($text_right)) : ?>
                <div class="wpb-text wpb-text--small">
                    <?= wp_kses_post($text_right); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($buttons)) : ?>
        <div class="<?= $container_class ?>">
            <div class="btn-group">
                <?php get_template_part('snippets/content', 'buttons', $buttons); ?>
            </div>
        </div>
    <?php endif; ?>

</section>