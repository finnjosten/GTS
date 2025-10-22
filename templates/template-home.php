<?php

/**
 * Template Name: GTS Home
 * 
 * @package GTS
 */
?>

<?= get_header(); ?>

<?php
    $blogs = [];

    $args = [
        'post_type'   => 'blog',
        'post_status' => 'publish',
        'orderby'     => 'date',
        'order'       => 'DESC',
    ];

    $blogs = get_posts($args);
?>

<!-- Main -->
<div id="main">

    <?php if (!empty($blogs)) : ?>
        <?php foreach($blogs as $i => $blog) : ?>
            <?php get_template_part('snippets/blog/blog', 'card', ['blog' => $blog, 'i' => $i]); ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p><?= __('No blogs found', 'GTS') ?></p>
    <?php endif; ?>

    <!-- Pagination -->
    <ul class="actions pagination">
        <li><a href="" class="disabled button large previous"><?= __('Previous Page', 'GTS') ?></a></li>
        <li><a href="#" class="button large next"><?= __('Next Page', 'GTS') ?></a></li>
    </ul>

</div>

<!-- Sidebar -->
<section id="sidebar">

    <?php if (is_active_sidebar('sidebar-gts')) : ?>
        <?php dynamic_sidebar('sidebar-gts'); ?>
    <?php endif; ?>

    <!-- Footer -->
    <section id="footer">
        <ul class="icons">
            <li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
            <li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
            <li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
            <li><a href="#" class="icon solid fa-rss"><span class="label">RSS</span></a></li>
            <li><a href="#" class="icon solid fa-envelope"><span class="label">Email</span></a></li>
        </ul>
        <p class="copyright">&copy; Untitled.</p>
    </section>

</section>


<?= get_footer(); ?>