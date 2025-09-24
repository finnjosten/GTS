<?php
/**
 * Media Block template.
 *
 * @param array $block The block settings and attributes.
 */

// Load values and assign defaults.
$text               = get_field('text');
$images             = get_field('images');
$whitespace_top     = get_field('whitespace_top');
$whitespace_bottom  = get_field('whitespace_bottom');
$background_color   = get_field('background_color');
$background_image_id= get_field('background_image');
$adjust_width       = get_field('adjust_width');
$horizontal_align   = get_field('horizontal_align');
$buttons            = get_field('buttons');

// Support custom "anchor" values.
$anchor = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '" ' : '';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wpb-block--media';
$class_name .= !empty($block['className']) ? ' ' . $block['className'] : '';
$class_name .= !empty($block['align']) ? ' align' . $block['align'] : '';
$class_name .= $whitespace_top ? ' wpb-wst--' . $whitespace_top : '';
$class_name .= $whitespace_bottom ? ' wpb-wsb--' . $whitespace_bottom : '';
$class_name .= $background_color ? ' wpb-bg-clr--' . $background_color : '';
$class_name .= $background_image_id ? ' has-background-image' : '';

$container_class = '';
$container_class .= $adjust_width ? ' container--' . $adjust_width : '';
$container_class .= $horizontal_align ? ' align-' . $horizontal_align : '';

// Set grid column classes based on the number of columns.
$column_count = get_field('column_count');
switch ($column_count) {
    case 1:
        $gc = ' d-grid g-20 cols-1';
        break;
    case 2:
        $gc = ' d-grid g-20 cols-1 cols-sm-2';
        break;
    case 3:
        $gc = ' d-grid g-20 cols-1 cols-md-3';
        break;
    case 4:
        $gc = ' d-grid g-20 cols-1 cols-sm-2 cols-lg-4';
        break;
    case 5:
        $gc = ' d-grid g-20 cols-2 cols-md-3 cols-lg-5';
        break;
    case 6:
        $gc = ' d-grid g-20 cols-2 cols-md-3 cols-xl-6';
        break;
    default:
        $gc = ' d-grid g-20 cols-1';
}

?>

<section <?= $anchor ?>class="wpb-block <?= esc_attr($class_name) ?>">

    <div class="container <?= esc_attr($container_class) ?>">

        <?php if (!empty($text)) : ?>
            <div class="wpb-text">
                <?= wp_kses_post($text); ?>
                
                <?php if (isset($buttons) && !empty($buttons)) : ?>
                    <div class="btn-group">
                        <?php get_template_part('snippets/content', 'buttons', $buttons); ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <?php if ($images) : ?>
            <div class="inner<?= $gc; ?>">
                <?php foreach ($images as $image_id) : ?>
                    <?php if ($image_id) : ?>
                        <figure class="wpb-image">
                            <?= wp_get_attachment_image($image_id, 'large'); ?>
                        </figure>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>

</section>