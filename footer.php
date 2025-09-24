            <?php 
                do_action('gts_before_footer');
                get_template_part( 'snippets/footer/footer', "primary" );
                do_action('gts_after_footer');
                wp_footer(); 
            ?>

        </div>
    </body>
</html>