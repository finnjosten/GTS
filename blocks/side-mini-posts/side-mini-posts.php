<?php

/**
 * Featured Block template.
 *
 * @param array $block The block settings and attributes.
 */
// Load values and assign defaults.
$post_type          = 'blog';
$blogs              = get_field('blogs');

$auto_fill          = get_field('auto_fill');
$blog_count         = get_field('blog_count');
$blog_offset        = get_field('blog_offset');


// Support custom "anchor" values.
$anchor = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '" ' : '';

// If posts are empty, retrieve default posts.
if (empty($blogs) || $auto_fill) {
    $blogs = get_posts(array(
        'post_type'         => $post_type,
        'post_status'       => 'publish',
        'fields'            => 'ids',
        'posts_per_page'    => $blog_count ?? 4,
        'offset'            => $blog_offset ?? 0,
    ));
}
?>
<div class="mini-posts" <?= $anchor ?>>

    <?php if (!empty($blogs)) : ?>
        <div class="inner">
            <?php foreach ($blogs as $blog_id) :
                get_template_part('snippets/blog/mini', 'card', [ "blog_id" => $blog_id]);
            endforeach; ?>
        </div>
    <?php endif; ?>

</div>