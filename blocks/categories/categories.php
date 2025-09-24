<?php

/**
 * Featured Block template.
 *
 * @param array $block The block settings and attributes.
 */
// Load values and assign defaults.
$text       = get_field('text');
$categories = get_field('categories');

$whitespace_top     = get_field('whitespace_top');
$whitespace_bottom  = get_field('whitespace_bottom');
$background_color   = get_field('background_color');
$adjust_width       = get_field('adjust_width');


// Support custom "anchor" values.
$anchor = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '" ' : '';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wpb-block--categories';
$class_name .= !empty($block['className']) ? ' ' . $block['className'] : '';
$class_name .= !empty($block['align']) ? ' align' . $block['align'] : '';
$class_name .= $whitespace_top ? ' wpb-wst--' . $whitespace_top : '';
$class_name .= $whitespace_bottom ? ' wpb-wsb--' . $whitespace_bottom : '';
$class_name .= $background_color ? ' wpb-bg-clr--' . $background_color : '';

$container_class = '';
$container_class .= $adjust_width ? ' container--' . $adjust_width : '';
?>

<section <?= $anchor ?>class="wpb-block <?= esc_attr($class_name) ?>">

    <div class="wpb-section__header">
        <div class="container <?= esc_attr($container_class) ?>">
            <?php if (!empty($text)) : ?>
                <div class="wpb-text">
                    <?= wp_kses_post($text); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($categories)) { ?>
        <div class="wpb-section__body">
            <div class="container <?= esc_attr($container_class) ?>">
                <?php foreach ($categories as $cat) {
                    $cat_description = $cat->description;
                    $cat_image = get_field('category_thumbnail', 'term_' . $cat->term_id);
                    $cat_icon = get_field('icon', 'term_' . $cat->term_id);
                ?>
                    <a href="<?= get_term_link($cat) ?>" class="wpb-card wpb-card--category">
                        <div class="wpb-card__header">
                            <?php if (!empty($cat_image)) { ?>
                                <div class="wpb-card__image">
                                    <?= wp_get_attachment_image($cat_image, 'medium') ?>
                                </div>
                            <?php } ?>
                            <div class="wpb-card__body">
                                <h3>
                                    <?php if ($cat_icon) { ?>
                                        <i class="wpb-icon" style="--src: url(<?= $cat_icon; ?>);"></i>
                                    <?php } ?>
                                    <?= $cat->name ?>
                                </h3>
                                <?php if (!empty($cat_description)) { ?>
                                    <p class="card-description"><?= $cat_description; ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

</section>