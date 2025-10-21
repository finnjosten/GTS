<?php


if (!function_exists('gts_get_menu_array')) {
    function gts_get_menu_array($menu_name) {
        $menu_array = wp_get_nav_menu_items($menu_name);
        $menu = [];

        foreach ($menu_array as $item) {
            if (empty($item->menu_item_parent)) {
                $menu[$item->ID] = [
                    'ID' => $item->ID,
                    'title' => $item->title,
                    'url' => $item->url,
                    'type' => $item->type,
                    'object' => $item->object,
                    'object_id' => $item->object_id,
                    'children' => gts_populate_menu_children($menu_array, $item),
                ];
            }
        }

        return $menu;
    }

    function gts_populate_menu_children($menu_array, $menu_item) {
        $children = [];

        foreach ($menu_array as $i => $item) {
            if ($item->menu_item_parent == $menu_item->ID) {
                $children[$item->ID] = [
                    'ID' => $item->ID,
                    'title' => $item->title,
                    'url' => $item->url,
                    'type' => $item->type,
                    'object' => $item->object,
                    'object_id' => $item->object_id,
                    'term' => get_term($item->object_id),
                    'children' => gts_populate_menu_children($menu_array, $item),
                ];
                unset($menu_array[$i]);
            }
        }

        return $children;
    }
}

if (!function_exists('gts_build_nav_menu')) {
    function gts_build_nav_menu($menu_name, $niveaus = 2)
    {
        $items = gts_get_menu_array($menu_name);
        $currentPageID = is_page() ? get_queried_object()->ID : '';
        $currentPageName = get_queried_object()->label ?? '';
        $currentCategory = is_category() ? get_queried_object_id() : '';

        if (!empty($items)) {
            echo '<ul class="menu menu--' . strtolower($menu_name) . '">';

            // Eerst de normale menu-items weergeven
            foreach ($items as $item) {
                //<li><a href="#">Lorem</a></li>
                echo '<li id="menu-item-' . $item['ID'] . '" class="menu-item';
                if (($currentPageID && $currentPageID == $item['object_id']) || ($currentPageName && $currentPageName == $item['title'])) {
                    echo ' --active';
                }
                if (!empty($item['children']) && $niveaus > 1) {
                    echo ' menu-item--has-children';
                }
                echo '">';

                echo '<a href="' . $item['url'] . '">' . $item['title'] . '</a>';

                /* if (!empty($item['children']) && $niveaus > 1) {
                    echo '<div class="wpb-sub-menu js-sub-menu"><ul>';
                    foreach ($item['children'] as $menuChild) {
                        echo '<li id="menu-item-' . $menuChild['ID'] . '" class="menu-item';
                        if (($currentPageID && $currentPageID == $menuChild['object_id']) || ($currentPageName && $currentPageName == $menuChild['title'])) {
                            echo ' menu-item--current';
                        }
                        if (!empty($menuChild['children']) && $niveaus > 2) {
                            echo ' menu-item-has-children';
                        }
                        echo '">';
                        echo '<a href="' . $menuChild['url'] . '">' . $menuChild['title'] . '</a>';

                        if (!empty($menuChild['children']) && $niveaus > 2) {
                            echo '<div class="wpb-sub-menu js-sub-menu"><ul>';
                            foreach ($menuChild['children'] as $menuChild) {
                                echo '<li id="menu-item-' . $menuChild['ID'] . '" class="menu-item';
                                if (!empty($menuChild['children'])) {
                                    echo ' menu-item-has-children';
                                }
                                echo '">';
                                echo '<a href="' . $menuChild['url'] . '">' . $menuChild['title'] . '</a>';
                                echo '</li>';
                            }
                            echo '</ul></div>';
                        }
                        echo '</li>';
                    }
                    echo '</ul></div>';
                } */

                echo '</li>';
            }

            echo '</ul>';
        }
    }
    add_action('gts_nav_menu', 'gts_build_nav_menu', 60, 2);
}

if (!function_exists('gts_build_footer_menu')) {
    function gts_build_footer_menu($menu_name, $niveaus = 1)
    {
        $items = gts_get_menu_array($menu_name);
        $currentPageID = is_page() ? get_queried_object()->ID : '';
        $currentPageName = get_queried_object()->label ?? '';

        if (!empty($items)) {
            echo '<ul class="wpb-footer-menu wpb-footer-menu--' . strtolower($menu_name) . '">';

            // Display menu items
            foreach ($items as $item) {
                echo '<li id="footer-menu-item-' . $item['ID'] . '" class="footer-menu-item';
                if (($currentPageID && $currentPageID == $item['object_id']) || ($currentPageName && $currentPageName == $item['title'])) {
                    echo ' footer-menu-item--current';
                }
                if (!empty($item['children']) && $niveaus > 1) {
                    echo ' footer-menu-item-has-children';
                }
                echo '">';
                echo '<a href="' . $item['url'] . '">' . $item['title'] . '<i class="fa-solid fa-arrow-right"></i></a>';

                // First level children
                if (!empty($item['children']) && $niveaus > 1) {
                    echo '<ul class="wpb-footer-sub-menu">';
                    foreach ($item['children'] as $menuChild) {
                        echo '<li id="footer-menu-item-' . $menuChild['ID'] . '" class="footer-menu-item';
                        if (($currentPageID && $currentPageID == $menuChild['object_id']) || ($currentPageName && $currentPageName == $menuChild['title'])) {
                            echo ' footer-menu-item--current';
                        }
                        echo '">';
                        echo '<a href="' . $menuChild['url'] . '">' . $menuChild['title'] . '</a>';
                        echo '</li>';
                    }
                    echo '</ul>';
                }

                echo '</li>';
            }

            echo '</ul>';
        }
    }
    add_action('gts_footer_menu', 'gts_build_footer_menu', 60, 2);
}

if (!function_exists('hex_to_rgb')) {
    function hex_to_rgb($hex){
        $hex = ltrim($hex, '#');

        if (strlen($hex) == 3) {
            $r = hexdec($hex[0] . $hex[0]);
            $g = hexdec($hex[1] . $hex[1]);
            $b = hexdec($hex[2] . $hex[2]);
        } elseif (strlen($hex) == 6) {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        } else {
            return false;
        }

        return "$r, $g, $b";
    }
}

/**
 * Format phone number
 */
if ( ! function_exists( 'gts_format_phone' ) ) {
    function gts_format_phone($phone, $type = FALSE) {
        // Sanitize
        $phone = str_replace('+', '', $phone);
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace('-', '', $phone);
        $phone = str_replace('_', '', $phone);

        if ($type == 'tel') {
            if (strpos($phone, '06') === 0) {
                $phone = substr($phone, 1);
            } elseif (strpos($phone, '316') === 0) {
                $phone = substr($phone, 2);
            } elseif (strpos($phone, '31') === 0) {
                $phone = substr($phone, 1);
            }

            return 'tel:0031' . $phone;
        }

        if ($type == 'whatsapp') {

            // Remove 0 if phone number starts with 06
            if (strpos($phone, '06') === 0) {
                $phone = substr($phone, 1);
            }

            return 'https://api.whatsapp.com/send/?phone=+31' . $phone . '&text=Hallo';
        }

        if ($type == 'whatsapp-mobile') {

            // Remove 0 if phone number starts with 06
            if (strpos($phone, '06') === 0) {
                $phone = substr($phone, 1);
            }

            return 'https://api.whatsapp.com/send/?phone=+31' . $phone . '&text=Hallo';
        }

        return $phone;
    }
}

if ( ! function_exists( 'gts_get_saved_posts' ) ) {
    function gts_get_saved_posts() {
        $args = [
            'nopaging' => true,
            'posts_per_page' => -1,
            'post_type' => $_POST['postType'] ?? get_post_types(),
            'post__in' => $_POST['postIDs'],
        ];
        $posts = new WP_Query($args);

        ob_start();
        foreach($posts->posts as $post) {
            if($post->post_type == 'product') {
                include get_template_directory() . '/woocommerce/content-product.php';
            } else {
                include get_template_directory() . '/snippets/article.php';
            }
        }
        $response['html'] = ob_get_clean();
        $response['url'] = base64_encode(implode(',', $_POST['postIDs']));

        wp_send_json_success($response);
    }
    add_action( 'wp_ajax_nopriv_gts_get_saved_posts', 'gts_get_saved_posts' );
    add_action( 'wp_ajax_gts_get_saved_posts', 'gts_get_saved_posts' );
}

if ( ! function_exists( 'gts_get_saved_posts_count' ) ) {
    function gts_get_saved_posts_count() {
        $args = [
            'nopaging' => true,
            'posts_per_page' => -1,
            'post_type' => $_POST['postType'] ?? get_post_types(),
            'post__in' => $_POST['postIDs'],
        ];
        $posts = new WP_Query($args);
        $postCount = count($posts->posts);
        wp_send_json_success($postCount);
    }
    add_action( 'wp_ajax_nopriv_gts_get_saved_posts_count', 'gts_get_saved_posts_count' );
    add_action( 'wp_ajax_gts_get_saved_posts_count', 'gts_get_saved_posts_count' );
}

if ( ! function_exists( 'gts_get_categories_list' ) ) {
    function gts_get_categories_list($post_type) {
        $categories = get_categories(
			[
				'type'                     => $post_type,
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'taxonomy'                 => 'category',
			]
		);
        
        $categories_filtered = array();

        foreach ($categories as $cat) {
            if (empty($cat->category_parent)) {
                $categories_filtered[$cat->term_id]['id'] = $cat->term_id;
                $categories_filtered[$cat->term_id]['name'] = $cat->name;
                $categories_filtered[$cat->term_id]['value'] = $cat->slug;
                $categories_filtered[$cat->term_id]['children'] = populate_children($categories, $cat->term_id);
            }
        }

        return $categories_filtered;
    }

    function populate_children($categories, $parent_id) {
        $children = array();
    
        if (empty($categories)) {
            return $children;
        } else {
            foreach ($categories as $index => $child) {
                if ($child->category_parent == $parent_id) {
                    $children[$index] = array();
                    $children[$index]['ID'] = $child->term_id;
                    $children[$index]['name'] = $child->name;
                    $children[$index]['value'] = $child->slug;
                    $children[$index]['children'] = populate_children($categories, $child->term_id);
                }
            }
        }
    
        return $children;
    }
}

if (!function_exists('classify_search_term')) {
    function classify_search_term($term)
    {
        $decoded_term = urldecode($term);
        $clean_term = trim(strip_tags($decoded_term));

        if (is_numeric($clean_term)) { return 'confused'; }
        if (preg_match('/^[A-Z][a-z]+$/', $clean_term)) { return ['absurd', 'reassuring', 'playful', 'philosophical', 'dramatic', 'musical']; }
        if (preg_match('/^[^a-zA-Z0-9]+$/', $clean_term)) { return 'absurd'; }

        $tech_terms = ['404', 'error', 'server', 'API', 'debug', 'PHP', 'JavaScript', 'database'];
        if (in_array(strtolower($clean_term), array_map('strtolower', $tech_terms))) { return 'tech'; }

        return 'confused';
    }
}

if (! function_exists('get_404_message_templates')) {
    function get_404_message_templates($search_terms)
    {
        $message_templates = [
            'confused' => [
                'messages' => [
                    "Is $search_terms een geheime code? Zelfs onze beste cryptografen zijn perplex!",
                    "Is $search_terms in de kamer met ons? Zelfs de FBI kan hem niet vinden!",
                    "$search_terms klinkt als iets wat alleen een robot zou kunnen verzinnen.",
                    "We hebben zojuist de universiteit gebeld. Niemand begrijpt $search_terms.",
                    "Is dit een buitenaardse communicatie? $search_terms houdt ons in de war.",
                    "Onze computers zijn net zo verward als jij met $search_terms.",
                    "$search_terms is als een geest, overal en nergens tegelijk.",
                    "$search_terms? Dat klinkt als iets uit een parallel universum!",
                    "$search_terms heeft zichzelf zo goed verborgen dat zelfs Google het niet kan vinden!",
                    "Hebben we per ongeluk een glitch in de matrix ontdekt met $search_terms?",
                ],
                'suggestions' => [
                    "Misschien bedoel je een van deze pagina's?",
                    "Laten we doen alsof $search_terms nooit is gebeurd:",
                    "Hier zijn wat normale pagina's ter afleiding:",
                ]
            ],
            'absurd' => [
                'messages' => [
                    "$search_terms is momenteel in een parallelle dimensie aan het brunchen.",
                    "De pagina $search_terms heeft besloten om een sabbatical te nemen. Wie zijn wij om dat tegen te houden?",
                    "$search_terms is net zo onvindbaar als mijn vertrouwen in mijn navigatie-app.",
                    "Breaking news: $search_terms is ontvoerd door wilde internetkatten.",
                    "$search_terms heeft zich ondergedompeld in een existentiële crisis.",
                    "$search_terms heeft een oneindig portaal gevonden en is verdwenen.",
                    "$search_terms is door een wormgat gereisd en komt misschien nooit terug!",
                ],
                'suggestions' => [
                    "Misschien vind je troost in deze alternatieve werkelijkheden:",
                    "Terwijl $search_terms filosofeert, kun je deze pagina's bekijken:",
                    "Een selectie pagina's die wél de realiteit hebben omarmd:",
                ]
            ],
            'reassuring' => [
                'messages' => [
                    "$search_terms is even op een kleine ontdekkingsreis. Geen zorgen!",
                    "Oeps! $search_terms is even kwijt, maar we helpen je graag de juiste weg te vinden.",
                    "De pagina $search_terms speelt momenteel verstoppertje. We zijn aan het zoeken!",
                    "Een beetje zoekraken hoort erbij. $search_terms is vast aan het dagdromen.",
                    "Geen paniek! $search_terms is even aan het bijkomen van een drukke dag.",
                    "$search_terms heeft een korte pauze genomen, maar we zijn hard aan het zoeken!",
                    "$search_terms is vast ergens achter een digitale hoek verstopt.",
                ],
                'suggestions' => [
                    "Misschien vind je wat je zoekt in een van deze pagina's:",
                    "Ondertussen kun je deze interessante pagina's bekijken:",
                    "Terwijl we $search_terms opsporen, check deze content:",
                ]
            ],
            'tech' => [
                'messages' => [
                    "404 Error: $search_terms niet gevonden. Hebben we de juiste coördinaten?",
                    "$search_terms lijkt een 404 Easter Egg te hebben geactiveerd!",
                    "Onze digitale GPS heeft $search_terms even kwijt gespeeld.",
                    "Quantum uncertainty: $search_terms bevindt zich tegelijkertijd wel en niet op deze website.",
                    "Systeemfout: $search_terms heeft de matrix ontweken.",
                ],
                'suggestions' => [
                    "Hier zijn wat gevalideerde pagina's in ons systeem:",
                    "Terwijl onze algoritmen $search_terms herstellen, bekijk deze opties:",
                    "Alternatieve route-suggesties gedetecteerd:",
                ]
            ],
            'playful' => [
                'messages' => [
                    "$search_terms is op vakantie zonder postzegel.",
                    "Oei! $search_terms is net zo spoorloos als mijn laatste dieetplan.",
                    "De pagina $search_terms speelt verstoppertje en is echt goed in verstoppen.",
                    "$search_terms is de Houdini van webpagina's.",
                    "Breaking: $search_terms is ondergedoken in het getuigenprojectie-programma.",
                ],
                'suggestions' => [
                    "Misschien vind je geluk met deze pagina's:",
                    "Ondertussen, hier zijn wat geweldige alternatieven:",
                    "Check deze pagina's die wel zijn blijven hangen:",
                ]
            ],
            'philosophical' => [
                'messages' => [
                    "$search_terms is momenteel verdwaald in de filosofische ruimte tussen bestaan en niet-bestaan.",
                    "Zelfs Schrodinger zou $search_terms niet kunnen vinden - tegelijkertijd aanwezig en afwezig.",
                    "$search_terms heeft besloten om een existentiële pauze te nemen.",
                    "Is $search_terms werkelijk verdwenen, of is dit slechts een illusie van onze beperkte perceptie?",
                    "De pagina $search_terms contempleerde het universum en raakte onderweg zoek.",
                ],
                'suggestions' => [
                    "Misschien vind je verlichting in deze pagina's:",
                    "Terwijl we filosoferen, bekijk deze concrete alternatieven:",
                    "Een pragmatische selectie terwijl $search_terms filosofeert:",
                ]
            ],
            'dramatic' => [
                'messages' => [
                    "BREAKING NEWS: $search_terms is spoorloos verdwenen in een epische digitale ontsnapping!",
                    "Drama alert! $search_terms heeft de website zonder afscheidsbrief verlaten.",
                    "De plot twist: $search_terms is net zo onvindbaar als de ontbrekende sokken in de wasmachine.",
                    "Soap opera scenario: $search_terms is ondergedoken na een dramatische exit.",
                    "Sensationeel nieuws: $search_terms is ontsnapt aan de digitale realiteit!",
                ],
                'suggestions' => [
                    "Plot twist: bekijk deze alternatieve verhaallijnen:",
                    "Terwijl het drama ontvouwt, misschien deze pagina's:",
                    "Een nieuwe scène begint met:",
                ]
            ],
            'nerdy' => [
                'messages' => [
                    "ERROR 404: $search_terms niet gevonden. Activeer nerd-modus...",
                    "$search_terms heeft een critical fail gemaakt in de route-checking algoritme.",
                    "Computational error: $search_terms voldoet niet aan de website-specificatie.",
                    "Debug log: $search_terms = null. Systeemcrash gedetecteerd.",
                    "Quantum bug geïdentificeerd: $search_terms bevindt zich in een oneindige lus.",
                ],
                'suggestions' => [
                    "Alternatieve debugroutes:",
                    "Herlaad met deze pagina's:",
                    "Systeemherstel suggereert:",
                ]
            ],
            'foodie' => [
                'messages' => [
                    "$search_terms is net zo vermist als mijn dieetplannen bij een all-you-can-eat buffet.",
                    "Oeps! $search_terms is weggevlucht als een ontsnapte pannenkoek.",
                    "De pagina $search_terms is op culinair avontuur zonder retourticket.",
                    "$search_terms heeft zich verstopt tussen de digitale keukenkastjes.",
                    "Breaking: $search_terms is ondergedoken in de sausvan vergeetachtigheid.",
                ],
                'suggestions' => [
                    "Smakelijke alternatieve gerechten:",
                    "Terwijl $search_terms kookt, bekijk deze heerlijkheden:",
                    "Een nieuw menu met:",
                ]
            ],
            'musical' => [
                'messages' => [
                    "$search_terms zingt: 'Where oh where has my webpage gone?'",
                    "De ballade van $search_terms: Een epische zoektocht naar bestaan.",
                    "$search_terms is de hoofdrolspeler in de musical 'Lost in Translation'.",
                    "Muzikale plotwending: $search_terms is ondergedoken in een meerstemmige compositie.",
                    "De operette van $search_terms: Een tragi-komische verdwijning.",
                ],
                'suggestions' => [
                    "Volgende akte met deze pagina's:",
                    "Een nieuw nummer begint met:",
                    "Muzikale omleiding:",
                ]
            ]
        ];
        return $message_templates;
    }
}

if( ! function_exists( 'get_funny_404_message' )){
    function get_funny_404_message($search_terms) {
        $decoded_search_terms   = urldecode($search_terms);
        $category               = classify_search_term($search_terms);
        $search_terms           = '<strong>' . trim(strtolower($decoded_search_terms)) . '</strong>';

        $message_templates = get_404_message_templates($search_terms);

        if (is_array($category)) {
            $style = $category[array_rand($category)];
        }
        else if ($category) {
            $style = $category;
        } else {
            $style = array_rand($message_templates);
        }
        
        $messages = $message_templates[$style]['messages'];
        $suggestions = $message_templates[$style]['suggestions'];
        
        $message = $messages[array_rand($messages)];
        $suggestion_text = $suggestions[array_rand($suggestions)];

        
        return $message . '</br><strong>' . $suggestion_text . '</strong>';
    }
}

/**
 * 
 * wpb_dump
 *
 * Dumps the variable input to diagnose it. You can choose to either use vardump or print_r
 * 
 **/
if ( ! function_exists( 'wpb_dump' ) ) {
    function wpb_dump($variable, $use_print_r = false) {
        // Variable : String or Array | Method 
        if ($use_print_r == false) {
            echo '<pre>';
            var_dump($variable);
            echo '</pre>';
        } else {
            echo '<pre>';
            print_r($variable);
            echo '</pre>';
        }
    }
}

function wpb_register_sidebar() {
    register_sidebar( array(
        'name' => 'Sidebar',
        'id' => 'wpb-sidebar',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ) );
}
add_action( 'widgets_init', 'wpb_register_sidebar' );


/**
 * Check if a hex code is best fitted with black or white text
 * @param string $hex_code hex code with or without #
 * @param string|null $prefix string that will be added on return default '#'
 * @return string
 */
function wpb_calculate_text_color($hex_code, $prefix = '#'){
    $hex_code = str_replace('#', '', $hex_code);
    $r_hex = substr($hex_code,0,2);
    $g_hex = substr($hex_code,2,2);
    $b_hex = substr($hex_code,4,2);

    $r = (hexdec($r_hex)) / 255;
    $g = (hexdec($g_hex)) / 255;
    $b = (hexdec($b_hex)) / 255;

    $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
    // human eye sees 60% easier
    if($brightness > .6){
        return $prefix != null ? $prefix.'000000' : '000000';
    }else{
        return $prefix != null ? $prefix.'ffffff' : 'ffffff';
    }
}




function wpb_is_bot() {
    $bots = [
        'Googlebot',
        'Bingbot',
        'Slurp',
        'DuckDuckBot',
        'Baiduspider',
        'YandexBot',
        'Sogou',
        'Exabot',
        'facebot',
        'ia_archiver',
        'MJ12bot',
        'AhrefsBot',
        'msnbot',
        'TurnitinBot',
        'Feedfetcher-Google',
        'SemrushBot',
        'BLEXBot',
        'DotBot',
        'Mail.RU_Bot',
        'SeznamBot',
        'YandexBot',
        'SISTRIX Crawler',
        'SISTRIX Optimizer',
        'SISTRIX Smart',
        'SISTRIX Market',
        'SISTRIX Market Intelligence',
        'SISTRIX Market Insights',
        'SISTRIX Market Watch',
        'SISTRIX Market Explorer',
        'SISTRIX Market Radar',
    ];

    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (in_array($user_agent, $bots)) {
        return true;
    }
    return false;
}


if (!function_exists('wpb_replace_placeholders')) {
    function wpb_replace_placeholders($text) {
        return str_replace(['{{SITE_NAME}}', '{{SITE_URL}}'], [get_bloginfo('name'), get_bloginfo('url')], $text);
    }
}


if (!function_exists("wpb_get_post_thumbnail")) {
    function wpb_get_post_thumbnail($post_id, $size = 'full') {
        $image = get_the_post_thumbnail($post_id, $size);

        if (empty($image)) {
            global $wuxOptions;
            $fallback_image = $wuxOptions->get_setting('default-thumbnail');

            $image = wp_get_attachment_image($fallback_image, $size);
        }

        return $image;
    }
}

if (!function_exists("wpb_gsap_class")) {
    /**
     * Generate GSAP animation class for elements.
     * 
     * @param string|null $animation_type The type of animation to apply.
     * @param bool $echo Whether to echo the class or return it.
     * @return string|null Returns the class if $echo is false, otherwise echoes it.
     */
    function wpb_gsap_class(string|null $animation_type = null, bool $echo = true): string|null {
        $base_class = 'wpb-gsap-animate';

        if (!empty($animation_type)) {
            $full_class = $base_class . ' ' . $base_class . '--' . sanitize_html_class($animation_type);
        } else {
            $full_class = $base_class;
        }

        if ($echo) {
            echo esc_attr($full_class);
            return null;
        }

        return esc_attr($full_class);
    }
}

if (!function_exists("wpb_get_file")) {
    /**
     * Get theme file > Get the file path for the parent or child theme. Or force it to return either parent or child theme file.
     * DOES NOT include or require the file, it only returns the path relative to the needed theme.
     * Priority is Force param > Child theme > Parent theme
     * 
     * @param string $file The file path relative to the theme directory.
     * @param string|null $force Optional parameter to force the return of either 'parent' or 'child' theme file.
     * @return string|bool The directory path of the parent or child theme. Or false if neither file exists.
     */
    function wpb_get_file(string $file, string|null $force = null): string|bool {
        if (str_starts_with($file, '/')) $dir = ltrim($file, '/');

        $child_file = get_stylesheet_directory() . '/' . $file;
        $parent_file = get_template_directory() . '/' . $file;

        if ($force == 'child' && file_exists($child_file)) {
            return $child_file;
        } else if ($force == 'parent' && file_exists($parent_file)) {
            return $parent_file;
        }

        if (file_exists($child_file)) {
            return $child_file;
        } else if (file_exists($parent_file)) {
            return $parent_file;
        } else {
            // If neither file exists, return an empty string or handle the error as needed
            return false;
        }
    }
}

if (!function_exists("wpb_get_dir")) {
    /**
     * Get theme dir > Get the directory path for the parent or child theme. Or force it to return either parent or child theme file.
     * DOES NOT include or require the directory, it only returns the path relative to the needed theme.
     * Priority is Force param > Child theme > Parent theme
     * 
     * @param string $dir The directory path relative to the theme directory.
     * @param string|null $force Optional parameter to force the return of either 'parent' or 'child' theme file.
     * @return string|bool The directory path of the parent or child theme. Or false if neither file exists.
     */
    function wpb_get_dir(string $dir, string|null $force = null): string|bool {
        if (str_starts_with($dir, '/')) $dir = ltrim($dir, '/');

        $child_dir = get_stylesheet_directory() . '/' . $dir;
        $parent_dir = get_template_directory() . '/' . $dir;

        if ($force == 'child' && is_dir($child_dir)) {
            return $child_dir;
        } else if ($force == 'parent' && is_dir($parent_dir)) {
            return $parent_dir;
        }

        if (is_dir($child_dir)) {
            return $child_dir;
        } else if (is_dir($parent_dir)) {
            return $parent_dir;
        } else {
            // If neither file exists, return an empty string or handle the error as needed
            return false;
        }
    }

    /**
     * Alias of wpb_get_dir().
     *
     * @param string      $dir   Relative path from the theme directory.
     * @param string|null $force Force 'parent' or 'child' theme directory.
     *
     * @return string|false Path to theme directory or false if not found.
     * @see wpb_get_dir()
     */
    function wpb_get_directory(string $dir, ?string $force = null): string|false {
        return wpb_get_dir($dir, $force);
    }
}