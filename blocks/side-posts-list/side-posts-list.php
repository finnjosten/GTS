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
<ul class="posts" <?= $anchor ?>>

    <?php if (!empty($blogs)) : ?>
        <?php foreach ($blogs as $blog_id) : ?>
            <li>
                <?php get_template_part('snippets/blog/list', 'card', [ "blog_id" => $blog_id]); ?>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>

</ul>