<?php

/**
 * Text Block & blog template.
 *
 * @param array $block The block settings and attributes.
 */

$text               = get_field('text');
$blog_id            = get_field('blog');
$buttons            = get_field('buttons');

$whitespace_top     = get_field('whitespace_top');
$whitespace_bottom  = get_field('whitespace_bottom');
$background_color   = get_field('background_color');
$adjust_width       = get_field('adjust_width');
$horizontal_align   = get_field('horizontal_align');
$column_sizes       = get_field('column_sizes');
$blog_align         = get_field('blog_align');

$container_class = '';
$container_class .= $adjust_width       ? ' container--' . $adjust_width : '';
$container_class .= $horizontal_align   ? ' align-' . $horizontal_align : '';
$container_class .= $column_sizes       ? ' wpb-cols--' . $column_sizes : ' wpb-cols--50-50';
$container_class .= $blog_align         ? ' wpb-order-reverse' : '';


// Support custom "anchor" values.
$anchor = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '" ' : '';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wpb-block--text-blog';
$class_name .= !empty($block['className']) ? ' ' . $block['className'] : '';
$class_name .= !empty($block['align']) ? ' align' . $block['align'] : '';
$class_name .= $whitespace_top ? ' wpb-wst--' . $whitespace_top : '';
$class_name .= $whitespace_bottom ? ' wpb-wsb--' . $whitespace_bottom : '';
$class_name .= $background_color ? ' wpb-bg-clr--' . $background_color : '';
?>

<section <?= $anchor ?>class="wpb-block <?= esc_attr($class_name) ?>">

    <?php if (!empty($text) || !empty($blog)) : ?>
        <div class="container d-grid <?= esc_attr($container_class) ?>">
            <?php if (!empty($text)) : ?>
                <div class="wpb-text">
                    <?= wp_kses_post($text); ?>
                    <?php get_template_part('snippets/content', 'buttons', $buttons); ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($blog_id)) : ?>
                <?= get_template_part('snippets/content', 'post', ['blog_id' => $blog_id]); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</section>