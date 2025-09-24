<?php
/**
 * Header subpage Block template.
 *
 * @param array $block The block settings and attributes.
 */

// Load values and assign defaults.
global $post;

$text               = get_field('text');
$background_image_id= get_the_post_thumbnail($post->ID, 'full');
$buttons            = get_field('buttons');

// Support custom "anchor" values.
$anchor = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '" ' : '';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wpb-header--subpage';
$class_name .= !empty($block['className']) ? ' ' . $block['className'] : '';
$class_name .= !empty($block['align']) ? ' align' . $block['align'] : '';
$class_name .= $background_image_id ? ' has-background-image' : ' wpb-bg-clr--primary';
?>

<section <?= $anchor ?>class="wpb-header <?= esc_attr($class_name) ?> wpb-wst--large wpb-wsb--large <?= $animate_classes ?>">

    <div class="container">

        <?php if (!empty($text)) :
            if (function_exists('yoast_breadcrumb')) :
                yoast_breadcrumb('<nav class="wpb-breadcrumbs" id="wpb-breadcrumbs" role="navigation">', '</nav>');
            endif; ?>

            <div class="wpb-text wpb-text--70">
                <?= wp_kses_post($text); ?>

                <?php if (isset($buttons) && !empty($buttons)) : ?>
                    <div class="btn-group">
                        <?php get_template_part('snippets/content', 'buttons', $buttons); ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

    </div>

    <?php if ($background_image_id) : ?>
        <figure class="is-background-image">
            <?= $background_image_id ?>
        </figure>
    <?php endif; ?>

</section>
