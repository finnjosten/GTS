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


<article class="post">
    <header>
        <div class="title">
            <h2><a href="<?= $link ?>"><?= $title ?></a></h2>
            <p><?= $small_excerpt ?></p>
        </div>
        <div class="meta">
            <time class="published" datetime="<?= $updated_at['code'] ?>"><?= $updated_at['clean'] ?></time>
            <a href="#" class="author"><span class="name"><?= $author->display_name ?></span><img src="<?= get_avatar_url($author->ID) ?>" alt="" /></a>
        </div>
    </header>
    <a href="<?= $link ?>" class="image featured"><img src="<?= wp_get_attachment_image_url($image, 'full') ?>" alt="" /></a>
    <p><?= $excerpt ?></p>
    <footer>
        <ul class="actions">
            <li><a href="<?= $link ?>" class="button large"><?= __('Continue Reading', "GTS") ?></a></li>
        </ul>
        <ul class="stats">
            <?php if ($taxonomie) : ?>
                <li><a href="#"><?= $taxonomie->name ?? __('General', "GTS") ?></a></li>
            <?php endif; ?>
            <li><a href="#" class="icon solid fa-heart"><?= $like_count ?></a></li>
            <li><a href="#" class="icon solid fa-comment"><?= $comment_count ?></a></li>
        </ul>
    </footer>
</article>