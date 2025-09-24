<?php
global $buttons;

/**
 * Default Block template.
 *
 * @param array $block The block settings and attributes.
 */

// Load values and assign defaults.
$text                   = get_field('text');
$whitespace_top         = get_field('whitespace_top');
$whitespace_bottom      = get_field('whitespace_bottom');
$background_color       = get_field('background_color');
$adjust_width           = get_field('adjust_width');
$background_image_id    = get_field('background_image');
$buttons                = get_field('buttons');
$column_sizes           = get_field('column_sizes');


// Support custom "anchor" values.
$anchor = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '" ' : '';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wpb-block--search';
$class_name .= !empty($block['className']) ? ' ' . $block['className'] : '';
$class_name .= !empty($block['align']) ? ' align' . $block['align'] : '';
$class_name .= $whitespace_top ? ' wpb-wst--' . $whitespace_top : '';
$class_name .= $whitespace_bottom ? ' wpb-wsb--' . $whitespace_bottom : '';
$class_name .= $background_color ? ' wpb-bg-clr--' . $background_color : '';

$container_class = '';
$container_class .= $adjust_width   ? ' container--' . $adjust_width : '';
$container_class .= $column_sizes   ? ' wpb-cols--' . $column_sizes : ' wpb-cols--50-50';
?>

<section <?= $anchor ?>class="wpb-block <?= esc_attr($class_name) ?>">

    <div class="container d-grid <?= esc_attr($container_class) ?>">

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

        <form class="wpb-search-form" action="/">
            <input class="form-control" type="text" name="s" placeholder="<?= __('Waar ben je naar op zoek?', 'GTS') ?>">
            <button type="submit">
                <i class="fa-solid fa-search"></i>
            </button>
        </form>
    </div>

</section>