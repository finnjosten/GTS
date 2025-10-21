<?php

/**
 * GTS main Class
 *
 */

if (! defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/class-tgm-plugin-activation.php';

if (! class_exists('GTS')) {

    /**
     * The main GTS class
     */
    class GTS {

        /**
         * Instance
         */
        private static $instance;

        /**
         * Initiator
         */
        public static function get_instance() {
            if (! isset(self::$instance)) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        public function __construct() {
            add_action('init',                      array($this, 'init'));
            add_action('after_setup_theme',         array($this, 'setup'));
            add_action('wp_enqueue_scripts',        array($this, 'scripts'), 10);
            add_action('admin_enqueue_scripts',     array($this, 'admin_scripts'), 10);
            add_action('admin_menu',                array($this, 'admin_menu'));
            add_action('upload_mimes',              array($this, 'upload_mimes'));
            add_filter('body_class',                array($this, 'add_body_class'));
            add_filter('after_switch_theme',        array($this, 'create_menus_and_pages'));

            
            add_action('wp_head',                   array($this, 'add_header_code'), 0);
            add_action('wp_body_open',              array($this, 'add_body_code'), 0);

            // Any other actions should be added before here as this will switch the theme in the end
            add_filter('after_switch_theme',        array($this, 'create_child_theme'));
        }

        public function init() {

            /* Remove all blocks except shortcode */
            if (is_admin()) {
                function wpb_allowed_block_types($allowed_blocks, $block_editor_context)
                {

                    if ($block_editor_context->post && $block_editor_context->post->post_type === 'blog') {
                        $default = [
                            'core/shortcode',
                            'core/paragraph',
                            'core/heading',
                            'core/list',
                            'core/quote',
                            'core/pullquote',
                            'core/image',
                            'core/gallery',
                            'core/video',
                        ];
                        return $default;
                    } else if ($block_editor_context->name === 'core/edit-widgets') {
                        $default = [
                            'core/shortcode',
                            'core/paragraph',
                            'core/heading',
                            'core/list',
                            'core/categories',
                            'core/search',
                            'core/quote',
                        ];
                        return $default;
                    }

                    $acf = acf_get_block_types();
                    $blocks = [];
                    foreach ($acf as $block) {
                        $blocks[] = $block['name'];
                    }
                    $custom = [
                        'core/shortcode',
                    ];
                    return array_merge($custom, $blocks);
                }
                add_filter('allowed_block_types_all', 'wpb_allowed_block_types', 10, 2);
            }
        }

        public function setup() {

            add_theme_support('title-tag');
            add_theme_support('post-thumbnails');
            define('DISALLOW_FILE_EDIT', true);

            register_nav_menu('mainmenu', 'Hoofdmenu');
            register_nav_menu('sidemenu', 'Sidemenu');

            add_action('tgmpa_register', array($this, 'register_required_plugins'));
        }

        public function register_required_plugins() {
            $plugins = array(
                array(
                    'name'      => 'Secure Custom Fields',
                    'slug'      => 'secure-custom-fields',
                    'required'  => false,
                    'force_activation' => false,
                    'force_deactivation' => false,
                ),
                array(
                    'name'      => 'Yoast SEO',
                    'slug'      => 'wordpress-seo',
                    'required'  => false,
                    'force_activation' => false,
                    'force_deactivation' => false,
                ),
                array(
                    'name'      => 'Admin and Site Enhancements (ASE)',
                    'slug'      => 'admin-site-enhancements',
                    'required'  => false,
                    'force_activation' => false,
                    'force_deactivation' => false,
                ),
                array(
                    'name'      => 'WP Super Cache',
                    'slug'      => 'wp-super-cache',
                    'required'  => false,
                    'force_activation' => false,
                    'force_deactivation' => false,
                ),
            );
            $config = array(
                'id'                 => 'GTS',
                'default_path'       => '',
                'menu'               => 'tgmpa-install-plugins',
                'has_notices'        => true,
                'dismissable'        => true,
                'is_automatic'       => true,
                'notice_recommended' => true,
            );
            tgmpa($plugins, $config);
        }

        public function scripts() {
            global $GTS;

            /**
             * Styles
             */
            // Alle files in de assets/css map worden gemerged (behalve admin-style.css)
            wp_enqueue_style('gts-style',           get_template_directory_uri() . '/style.css',                            false, $GTS->version, 'all');
            wp_enqueue_style('gts-style-core',      get_template_directory_uri() . '/assets/sass/main.css',                 false, $GTS->version, 'all');
            wp_enqueue_style('gts-fa',              get_template_directory_uri() . '/assets/css/fontawesome-all.min.css',   false, $GTS->version, 'all');

            /**
             * Scripts
             */
            wp_enqueue_script('gts-main-js',        get_template_directory_uri() . '/assets/js/main.js',                    array('jquery'), $GTS->version, true);
            wp_enqueue_script('gts-util-js',        get_template_directory_uri() . '/assets/js/util.js',                    array('jquery'), $GTS->version, true);
            wp_enqueue_script('gts-breakpoints-js', get_template_directory_uri() . '/assets/js/breakpoints.min.js',         array('jquery'), $GTS->version, true);
            wp_enqueue_script('gts-browser-js',     get_template_directory_uri() . '/assets/js/browser.min.js',             array('jquery'), $GTS->version, true);

            /**
             * Dequeue scripts and styles in front-end
             */
            /* if (!is_admin()) {

                $scripts = array(
                    "jquery-ui-widget",
                    "jquery-ui-mouse",
                    "jquery-ui-accordion",
                    "jquery-ui-autocomplete",
                    "jquery-ui-slider",
                    "jquery-ui-tabs",
                    "jquery-ui-draggable",
                    "jquery-ui-droppable",
                    "jquery-ui-selectable",
                    "jquery-ui-position",
                    "jquery-ui-datepicker",
                    "jquery-ui-resizable",
                    "jquery-ui-dialog",
                    "jquery-ui-button",
                );

                foreach ($scripts as $script) {
                    wp_deregister_script($script);
                }

                $styles = array(
                    "wc-blocks-style",
                    "wp-block-library",
                    "wp-block-library-theme",
                    "wc-block-style",
                    "global-styles",
                );

                foreach ($styles as $style) {
                    wp_deregister_style($style);
                }

                remove_action('wp_head', 'print_emoji_detection_script', 7);
                remove_action('admin_print_scripts', 'print_emoji_detection_script');
                remove_action('wp_print_styles', 'print_emoji_styles');
                remove_action('admin_print_styles', 'print_emoji_styles');
                remove_filter('the_content_feed', 'wp_staticize_emoji');
                remove_filter('comment_text_rss', 'wp_staticize_emoji');
                remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

                // Remove from TinyMCE
                add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
            }*/
        }

        public function admin_scripts() {
            wp_enqueue_style('admin-style',      get_template_directory_uri() . '/assets/css/admin-style.css');
        }

        public function login_scripts() {
            ?>
            <style type="text/css">
                #login h1 a,
                .login h1 a {
                    background-image: url(<?= get_field('logo', 'option') ?>);
                    width: 256px;
                    height: 32px;
                    background-size: contain;
                    background-repeat: no-repeat;
                    padding-bottom: 30px;
                }
            </style>
            <?php
        }


        public function admin_menu() {
            remove_menu_page('edit-comments.php');
        }

        public function upload_mimes($mimes) {
            $mimes['svg'] = 'image/svg+xml';
            return $mimes;
        }

        public function add_body_class($classes) {

            $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);

            
            // Initialize browser variable
            $browser = "unknown";

            // Check if user agent contains specific strings for each browser
            if (strpos($user_agent, 'firefox') !== false) {
                $browser = 'firefox';
            } elseif (strpos($user_agent, 'chrome') !== false) {
                $browser = 'chrome';
            } elseif (strpos($user_agent, 'safari') !== false) {
                $browser = 'safari';
            } elseif (strpos($user_agent, 'opera') !== false || strpos($user_agent, 'opr') !== false) {
                $browser = 'opera';
            } elseif (strpos($user_agent, 'edge') !== false) {
                $browser = 'edge';
            } elseif (strpos($user_agent, 'msie') !== false || strpos($user_agent, 'trident') !== false) {
                $browser = 'internet-explorer';
            }

            $classes[] = 'ua-' . $browser;
            return $classes;
        }



            

        public function add_header_code() {

            global $wuxOptions;

            $fonts = [
                'primary'   => "Poppins--sans-serif",
                'secondary' => "Poppins--sans-serif",
                'special'   => "Ubuntu--sans-serif",
            ];

            $fontsDir = get_template_directory() . '/assets/fonts/';
            $fontsURL = get_template_directory_uri() . '/assets/fonts/';
            $cssVariables = "";
            ?>
            <style>
                <?php
                foreach ($fonts as $key => $font) {
                    $folderName = str_replace(' ', '_', $font);

                    $fontType = 'sans-serif';
                    $customTypes = [
                        '--serif'       => 'serif',
                        '--sans-serif'  => 'sans-serif',
                        '--system-ui'   => 'system-ui',
                        '--cursive'     => 'cursive',
                        '--monospace'   => 'monospace'
                    ];

                    foreach ($customTypes as $suffix => $type) {
                        if (str_contains($folderName, $suffix)) {
                            $fontType = $type;
                            $folderName = substr($folderName, 0, strpos($folderName, $suffix));
                            break;
                        }
                    }

                    $fontFolderPath = $fontsDir . $font;
                    $fontFolderURL = $fontsURL . $font;

                    if (!is_dir($fontFolderPath)) continue;

                    $fontFiles = glob("$fontFolderPath/*.{ttf,woff,woff2,eot,otf}", GLOB_BRACE);
                    if (empty($fontFiles)) continue;

                    $fontFamilyName = str_replace('_', ' ', $folderName);
                    $cssVariables .= "--font-$key: '$fontFamilyName', $fontType;\n";

                    foreach ($fontFiles as $fontFile) {
                        $fontFileName = basename($fontFile);
                        $fontWeight = 'normal';
                        $fontStyle = 'normal';
                        $fontWeight = strpos($fontFileName, 'Bold') !== false ? 'bold' : (strpos($fontFileName, 'Light') !== false ? '300' : (strpos($fontFileName, 'Medium') !== false ? '500' : (strpos($fontFileName, 'Thin') !== false ? '100' : 'normal')));
                        $fontStyle  = strpos($fontFileName, 'Italic') !== false ? 'italic' : 'normal';

                        echo "@font-face{font-family:'$fontFamilyName';src:url('$fontFolderURL/$fontFileName')format('truetype');font-weight:$fontWeight;font-style:$fontStyle;font-display:block;}" . PHP_EOL;
                    }
                }


                $br = 8;

                if ($br > 0) {
                    $br_small = $br / 2;
                    $br_large = $br * 2;
                } else {
                    $br_small = 0;
                    $br_large = 0;
                }

                ?> :root {
                    --wpb-br--small:            <?= $br_small ?>px;
                    --wpb-br:                   <?= $br ?>px;
                    --wpb-br--large:            <?= $br_large ?>px;

                    --clr-heading:              <?= "#0f0707" ?>;
                    --clr-text:                 <?= "#333333" ?>;
                    --clr-heading-dark:         <?= "#ffffff" ?>;
                    --clr-text-dark:            <?= "#f4f4f4" ?>;

                    --clr-heading-primary:      <?= "#ffffff" ?>;
                    --clr-text-primary:         <?= "#f4f4f4" ?>;
                    --clr-heading-secondary:    <?= "#ffffff" ?>;
                    --clr-text-secondary:       <?= "#f4f4f4" ?>;

                    /*--clr-heading-tertiary:     <?= "#0f0707" ?>;*/
                    /*--clr-text-tertiary:        <?= "#f4f4f4" ?>;*/

                    --clr-primary:              <?= "#55b030" ?>;
                    --clr-primary-rgb:          <?= hex_to_rgb("#55b030") ?? "0,0,0" ?>;
                    --clr-primary-hover:        <?= "#368746" ?>;

                    --clr-secondary:            <?= "#2b62af" ?>;
                    --clr-secondary-rgb:        <?= hex_to_rgb("#2b62af") ?? "0, 0, 0" ?>;
                    --clr-secondary-hover:      <?= "#5b7eaf" ?>;

                    /*--clr-tertiary:             <?= "#ff4444" ?>;*/
                    /*--clr-tertiary-hover:       <?= "#ff6868" ?>;*/

                    --clr-card-text:            <?= "#0f0707" ?>;
                    --clr-card-bg:              <?= "#ffffff" ?>;
                    --clr-card-border:          <?= "#55b030" ?>;
                    --card-border:              <?= "0px" ?>;

                    --clr-dark:                 <?= "#141414" ?>;
                    --clr-dark-rgb:             <?= hex_to_rgb("#141414") ??  "0, 0, 0" ?>;
                    --clr-light:                <?= "#eaeaea" ?>;
                    --clr-light-rgb:            <?= hex_to_rgb("#eaeaea") ?? "0, 0, 0" ?>;

                    --clr-background:           <?= "#ffffff" ?>;

                    --clr-sidebar:              <?= "#eaeaea" ?>;
                    --clr-sidebar-search:       <?= "#f4f4f4" ?>;

                    --bg-asset:                 <?= '' ?>;
                    --bg-asset-2:               <?= '' ?>;

                    --header-bg-clr:            <?= "#ffffff" ?>;
                    --footer-bg-clr:            <?= "#ffffff" ?>;
                    --header-logo-width:        <?= "250" ?>px;
                    --footer-logo-width:        <?= "400" ?>px;

                    --pd-sidebar:               <?= "20" ?>px;

                    <?= $cssVariables ?>
                }
            </style>
            <?php
            ?>
            <meta charset="<?php bloginfo('charset'); ?>">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <?php
        }

        public function add_body_code() {
        }

    }

    /**
     * Initialize class
     */
    GTS::get_instance();
}
