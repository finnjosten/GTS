<?php

/**
 * Featured Block template.
 *
 * @param array $block The block settings and attributes.
 */
// Load values and assign defaults.
$post_type          = 'post';
$text               = get_field('text');
$blogs              = get_field('blogs');

$whitespace_top     = get_field('whitespace_top');
$whitespace_bottom  = get_field('whitespace_bottom');
$background_color   = get_field('background_color');
$adjust_width       = get_field('adjust_width');

$auto_fill          = get_field('auto_fill');
$blog_count         = get_field('blog_count');
$blog_offset        = get_field('blog_offset');

$button_style       = get_field('button_style');


// Support custom "anchor" values.
$anchor = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '" ' : '';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wpb-block--featured';
$class_name .= !empty($block['className']) ? ' ' . $block['className'] : '';
$class_name .= !empty($block['align']) ? ' align' . $block['align'] : '';
$class_name .= $whitespace_top ? ' wpb-wst--' . $whitespace_top : '';
$class_name .= $whitespace_bottom ? ' wpb-wsb--' . $whitespace_bottom : '';
$class_name .= $background_color ? ' wpb-bg-clr--' . $background_color : '';

$container_class = '';
$container_class .= $adjust_width ? ' container--' . $adjust_width : '';

// If posts are empty, retrieve default posts.
if (empty($blogs) || $auto_fill) {
    $blogs = get_posts(array(
        'post_type'         => $post_type,
        'post_status'       => 'publish',
        'fields'            => 'ids',
        'posts_per_page'    => $blog_count ?? 3,
        'offset'            => $blog_offset ?? 0,
    ));
}
?>

<section <?= $anchor ?>class="wpb-block <?= esc_attr($class_name) ?>">

    <div class="wpb-section__header">
        <div class="container <?= esc_attr($container_class) ?>">

            <?php if (!empty($text)) : ?>
                <div class="wpb-text">
                    <?= wp_kses_post($text); ?>
                </div>
            <?php endif; ?>

            <div class="button-group">
                <a href="<?= get_post_type_archive_link($post_type); ?>" class="btn btn--<?= $button_style ?? "primary" ?>">
                    <?= __('Alle berichten', 'GTS'); ?>
                </a>
            </div>

        </div>
    </div>

    <div class="container <?= esc_attr($container_class) ?>">

        <?php if (!empty($blogs)) : ?>
            <div class="inner">
                <?php foreach ($blogs as $blog_id) :
                    get_template_part('snippets/content', 'post', [ "post_id" => $blog_id, 'card_style' => 'default']);
                endforeach; ?>
            </div>
        <?php endif; ?>

    </div>

</section>