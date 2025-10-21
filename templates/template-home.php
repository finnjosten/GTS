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
        <p>No blogs found</p>
    <?php endif; ?>

    <!-- Pagination -->
    <ul class="actions pagination">
        <li><a href="" class="disabled button large previous">Previous Page</a></li>
        <li><a href="#" class="button large next">Next Page</a></li>
    </ul>

</div>

<!-- Sidebar -->
<section id="sidebar">

    <!-- Intro -->
    <section id="intro">
        <header>
            <h2>GreenTech Solutions</h2>
            <p>Lorem ipsum</p>
        </header>
    </section>

    <!-- Mini Posts -->
    <section>
        <div class="mini-posts">

            <!-- Mini Post -->
            <article class="mini-post">
                <header>
                    <h3><a href="single.html">Vitae sed condimentum</a></h3>
                    <time class="published" datetime="2015-10-20">October 20, 2015</time>
                    <a href="#" class="author"><img src="<?= get_site_url(null, 'wp-content/themes/GTS/assets/img/avatar.jpg') ?>" alt="" /></a>
                </header>
                <a href="single.html" class="image"><img src="<?= get_site_url(null, 'wp-content/themes/GTS/assets/img/pic04.jpg') ?>" alt="" /></a>
            </article>

            <!-- Mini Post -->
            <article class="mini-post">
                <header>
                    <h3><a href="single.html">Rutrum neque accumsan</a></h3>
                    <time class="published" datetime="2015-10-19">October 19, 2015</time>
                    <a href="#" class="author"><img src="<?= get_site_url(null, 'wp-content/themes/GTS/assets/img/avatar.jpg') ?>" alt="" /></a>
                </header>
                <a href="single.html" class="image"><img src="<?= get_site_url(null, 'wp-content/themes/GTS/assets/img/pic05.jpg') ?>" alt="" /></a>
            </article>

            <!-- Mini Post -->
            <article class="mini-post">
                <header>
                    <h3><a href="single.html">Odio congue mattis</a></h3>
                    <time class="published" datetime="2015-10-18">October 18, 2015</time>
                    <a href="#" class="author"><img src="<?= get_site_url(null, 'wp-content/themes/GTS/assets/img/avatar.jpg') ?>" alt="" /></a>
                </header>
                <a href="single.html" class="image"><img src="<?= get_site_url(null, 'wp-content/themes/GTS/assets/img/pic06.jpg') ?>" alt="" /></a>
            </article>

            <!-- Mini Post -->
            <article class="mini-post">
                <header>
                    <h3><a href="single.html">Enim nisl veroeros</a></h3>
                    <time class="published" datetime="2015-10-17">October 17, 2015</time>
                    <a href="#" class="author"><img src="<?= get_site_url(null, 'wp-content/themes/GTS/assets/img/avatar.jpg') ?>" alt="" /></a>
                </header>
                <a href="single.html" class="image"><img src="<?= get_site_url(null, 'wp-content/themes/GTS/assets/img/pic07.jpg') ?>" alt="" /></a>
            </article>

        </div>
    </section>

    <!-- Posts List -->
    <section>
        <ul class="posts">
            <li>
                <article>
                    <header>
                        <h3><a href="single.html">Lorem ipsum fermentum ut nisl vitae</a></h3>
                        <time class="published" datetime="2015-10-20">October 20, 2015</time>
                    </header>
                    <a href="single.html" class="image"><img src="<?= get_site_url(null, 'wp-content/themes/GTS/assets/img/pic08.jpg') ?>" alt="" /></a>
                </article>
            </li>
            <li>
                <article>
                    <header>
                        <h3><a href="single.html">Convallis maximus nisl mattis nunc id lorem</a></h3>
                        <time class="published" datetime="2015-10-15">October 15, 2015</time>
                    </header>
                    <a href="single.html" class="image"><img src="<?= get_site_url(null, 'wp-content/themes/GTS/assets/img/pic09.jpg') ?>" alt="" /></a>
                </article>
            </li>
            <li>
                <article>
                    <header>
                        <h3><a href="single.html">Euismod amet placerat vivamus porttitor</a></h3>
                        <time class="published" datetime="2015-10-10">October 10, 2015</time>
                    </header>
                    <a href="single.html" class="image"><img src="<?= get_site_url(null, 'wp-content/themes/GTS/assets/img/pic10.jpg') ?>" alt="" /></a>
                </article>
            </li>
            <li>
                <article>
                    <header>
                        <h3><a href="single.html">Magna enim accumsan tortor cursus ultricies</a></h3>
                        <time class="published" datetime="2015-10-08">October 8, 2015</time>
                    </header>
                    <a href="single.html" class="image"><img src="<?= get_site_url(null, 'wp-content/themes/GTS/assets/img/pic11.jpg') ?>" alt="" /></a>
                </article>
            </li>
            <li>
                <article>
                    <header>
                        <h3><a href="single.html">Congue ullam corper lorem ipsum dolor</a></h3>
                        <time class="published" datetime="2015-10-06">October 7, 2015</time>
                    </header>
                    <a href="single.html" class="image"><img src="<?= get_site_url(null, 'wp-content/themes/GTS/assets/img/pic12.jpg') ?>" alt="" /></a>
                </article>
            </li>
        </ul>
    </section>

    <!-- About -->
    <section class="blurb">
        <h2>About</h2>
        <p>Mauris neque quam, fermentum ut nisl vitae, convallis maximus nisl. Sed mattis nunc id lorem euismod amet placerat. Vivamus porttitor magna enim, ac accumsan tortor cursus at phasellus sed ultricies.</p>
        <ul class="actions">
            <li><a href="#" class="button">Learn More</a></li>
        </ul>
    </section>

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