<?php
    $blog = $args['blog'] ?? null;
    $index = $args['i'] ?? 0;

    if (!$blog && isset($args['blog_id'])) {
        $blog = get_post($args['blog_id']);
    } else if (!$blog) {
        return;
    }

    $title          = $blog->post_title ?? 'Unnamed blog';
    $small_excerpt  = get_field('small_excerpt', $blog->ID) ?? '';
    $excerpt        = get_field('excerpt', $blog->ID) ?? '';
    $image          = get_field('image', $blog->ID) ?? '';
    $link           = get_permalink($blog->ID) ?? '#';
    $author         = get_userdata($blog->post_author);
    $taxonomie      = get_the_terms( $blog->ID, 'blog-category' )[0] ?? null;

    $updated_at['code']     = date('Y-m-d', strtotime($blog->post_modified)) ?? '';
    $updated_at['clean']    = date('F j, Y', strtotime($blog->post_modified)) ?? '';


    $like_count     = get_field('like_count', $blog->ID);
    $comment_count  = get_field('comment_count', $blog->ID);
?>

<article class="mini-post">
    <header>
        <h3>
            <a href="<?= esc_url($link) ?>">
                <?= esc_html($title) ?>
            </a>
        </h3>
        
        <time class="published" datetime="<?= esc_attr($updated_at['code']) ?>">
            <?= esc_html($updated_at['clean']) ?>
        </time>

        <a href="#" class="author">
            <img src="<?= get_avatar_url($author->ID) ?>" alt="" />
        </a>
    </header>

    <a href="<?= esc_url($link) ?>" class="image">
        <img src="<?= wp_get_attachment_image_url($image, 'small') ?>" alt="" />
    </a>
</article>