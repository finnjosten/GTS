<?php
global $buttons;

/**
 * Blurb Block template.
 *
 * @param array $block The block settings and attributes.
 */

// Load values and assign defaults.
$text               = get_field('text');

$whitespace_top     = get_field('whitespace_top');
$whitespace_bottom  = get_field('whitespace_bottom');
$background_color   = get_field('background_color');

$adjust_width       = get_field('adjust_width');
$horizontal_align   = get_field('horizontal_align');
$buttons            = get_field('buttons');

// Support custom "anchor" values.
$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wpb-block--blurb';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}
if (!empty($whitespace_top)) {
    $class_name .= ' wpb-wst--' . $whitespace_top;
}
if (!empty($whitespace_bottom)) {
    $class_name .= ' wpb-wsb--' . $whitespace_bottom;
}
if (!empty($background_color)) {
    $class_name .= ' wpb-bg-clr--' . $background_color;
}
if (!empty($background_image_id)) {
    $class_name .= ' has-background-image';
}

$container_class = '';
if (!empty($adjust_width)) {
    $container_class .= ' container--' . $adjust_width;
}
if (!empty($horizontal_align)) {
    $container_class .= ' align-' . $horizontal_align;
}

$column_count = get_field('column_count');

$gc = ' d-grid g-20';
if ($column_count == 1) {
    $gc .= ' cols-1';
} elseif ($column_count == 2) {
    $gc .= ' cols-1 cols-sm-2';
} elseif ($column_count == 3) {
    $gc .= ' cols-1 cols-md-3';
} elseif ($column_count == 4) {
    $gc .= ' cols-1 cols-sm-2 cols-lg-4';
} elseif ($column_count == 5) {
    $gc .= ' cols-2 cols-md-3 cols-lg-5';
} elseif ($column_count == 6) {
    $gc .= ' cols-2 cols-md-3 cols-xl-6';
}

?>

<section <?= $anchor; ?>class="wpb-block <?= esc_attr($class_name); ?>">

    <div class="container <?= esc_attr($container_class); ?>">

        <?php if (!empty($text)) { ?>
            <div class="wpb-text">
                <?= wp_kses_post($text); ?>
            </div>
        <?php } ?>

        <?php if (have_rows('blurbs')): ?>
            <div class="<?= $gc; ?>">
                <?php while (have_rows('blurbs')) : the_row();
                    $image_id = get_sub_field('blurb')['image'];
                    $text = get_sub_field('blurb')['text'];
                    $url = get_sub_field('blurb')['url'];
                ?>

                    <div class="wpb-card wpb-card--blurb">
                        <?php if ($image_id) : ?>
                            <div class="wpb-card__header">
                                <?= wp_get_attachment_image($image_id, 'large'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($text) : ?>
                            <div class="wpb-card__body">
                                <div class="wpb-text">
                                    <?= $text; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php
                        if ($url) : ?>
                            <div class="wpb-card__footer">
                                <a class="btn btn--primary" <?php if ('' != $url['target']) : ?> target="<?= $url['target']; ?>" <?php endif; ?> href="<?= $url['url']; ?>">
                                    <?= $url['title']; ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                <?php endwhile; ?>
            </div>
        <?php endif; ?>

    </div>

</section>