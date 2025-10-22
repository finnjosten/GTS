<?php

/***
 * GTS register options pages
 */
function wpb_add_option_page() {
    if( function_exists('acf_add_options_page') ) {
        
        // Not really needed for the site ATM
        /* acf_add_options_page(array(
            'page_title' 	=> 'GTS Instellingen',
            'menu_title'	=> 'GTS instellingen',
            'menu_slug' 	=> 'GTS-instellingen',
            'icon_url'      => '/wp-content/themes/GTS-blogs/assets/icons/default/icon_gts_white.svg',
        )); */

        // Ander optie pagina's worden via de plugin aangemaakt.

    }
}
add_action('init', 'wpb_add_option_page');


/***
 * GTS register custom block category
 */
function wpb_custom_block_category($categories, $post) {
    return array_merge(
        $categories,
        [
            [
                'slug'  => 'GTS-blocks',
                'title' => __('GTS Blocks', 'gts_blocks'), 
            ],
            [
                'slug'  => 'GTS-sidebar',
                'title' => __('GTS Sidebar', 'gts_sidebar'), 
            ]
        ]
    );
}
add_filter('block_categories_all', 'wpb_custom_block_category', 10, 2);

/***
 * Get whitespace options from options page and load into acf field "whitespace_options"
 */
function wpb_acf_load_spacing($field) {
    $field['choices'] = array();
    
    $choices = array( 'None', 'Small', 'Medium', 'Large', );

    if (is_array($choices)) {
        foreach ($choices as $choice) {
            $field['choices'][strtolower($choice)] = $choice;
        }
    }

    return $field;
}
add_filter('acf/load_field/name=whitespace', 'wpb_acf_load_spacing');
add_filter('acf/load_field/name=whitespace_top', 'wpb_acf_load_spacing');
add_filter('acf/load_field/name=whitespace_bottom', 'wpb_acf_load_spacing');

/***
 * Get background-color options from options page and load into acf field "backgroundcolor_options"
 */
function wpb_acf_load_background_colors($field) {

    $field['choices'] = array();

    $choices = ['transparent:Transpirant', 'primary:Primair', 'secondary:Secundair', 'dark:Donker'];

    if (!is_array($choices) && is_string($choices)) {
        $choices = explode(",", $choices);
    }
    $choices = array_map('trim', $choices);

    if (is_array($choices)) {
        foreach ($choices as $choice) {
            if(str_contains($choice, ':')) {
                $field['choices'][strtolower(trim(explode(':',$choice)[0]))] = trim(explode(':',$choice)[1]);
            } else {
                $field['choices'][strtolower($choice)] = $choice;
            }
        }
    }

    return $field;
}
add_filter('acf/load_field/name=background_color', 'wpb_acf_load_background_colors');
add_filter('acf/load_field/name=backgroundcolor', 'wpb_acf_load_background_colors');

/***
 * Get button style options from options page and load into acf field "button_style_options"
 */
function wpb_acf_load_button_style($field) {
    global $wuxOptions;

    $choices = ['primary:Primair', 'primary-outline:Primair outline', 'secondary:Secundair', 'secondary-outline:Secundair outline', 'dark:Donker'];

    if (!is_array($choices) && is_string($choices)) {
        $choices = explode(",", $choices);
    }
    $choices = array_map('trim', $choices);

    if (is_array($choices)) {
        foreach ($choices as $choice) {
            if(str_contains($choice, ':')) {
                $field['choices'][strtolower(trim(explode(':',$choice)[0]))] = trim(explode(':',$choice)[1]);
            } else {
                $field['choices'][strtolower($choice)] = $choice;
            }
        }
    }

    return $field;
}
add_filter('acf/load_field/name=button_style', 'wpb_acf_load_button_style');

/***
 * Load horizontal align options into acf field "horizontal_align"
 */
function wpb_acf_load_horizontal_align($field) {
    $field['choices'] = array();

    $choices = array( 'Top', 'Center', 'Bottom', );
    

    if (is_array($choices)) {
        foreach ($choices as $choice) {
            $field['choices'][strtolower($choice)] = $choice;
        }
    }

    return $field;
}
add_filter('acf/load_field/name=horizontal_align', 'wpb_acf_load_horizontal_align');

/***
 * Load button size options into acf field "button_size"
 */
function wpb_acf_load_button_size($field) {
    $field['choices'] = array();

    $choices = array( 'Small', 'Normal', 'Large', ); 

    if (is_array($choices)) {
        foreach ($choices as $choice) {
            $field['choices'][strtolower($choice)] = $choice;
        }
    }

    return $field;
}
add_filter('acf/load_field/name=button_size', 'wpb_acf_load_button_size');

/***
 * Load adjust width options into acf field "adjust_width"
 */
function wpb_acf_load_adjust_width($field) {
    $field['choices'] = array();

    $choices = array( 'Standard', 'Medium', 'Small', );

    if (is_array($choices)) {
        foreach ($choices as $choice) {
            $field['choices'][strtolower($choice)] = $choice;
        }
    }

    return $field;
}
add_filter('acf/load_field/name=adjust_width', 'wpb_acf_load_adjust_width');

/***
 * Load column count options into acf field "column_count"
 */
function wpb_acf_load_column_count($field) {
    $field['choices'] = array();
    
    $choices = array( '1', '2', '3', '4', '5', '6', );
    
    if (is_array($choices)) {
        foreach ($choices as $choice) {
            $field['choices'][strtolower($choice)] = $choice;
        }
    }
    
    return $field;
}
add_filter('acf/load_field/name=column_count', 'wpb_acf_load_column_count');


/***
 * Load button filter options into acf field "product_filter_form_term"
 */
function wpb_acf_load_post_type($field) {
    $field['choices'] = array();

    $choices = array( 'blog' );

    if (is_array($choices)) {
        foreach ($choices as $choice) {
            $field['choices'][strtolower($choice)] = $choice;
        }
    }

    return $field;
}
add_filter('acf/load_field/name=post_type', 'wpb_acf_load_post_type');


/***
 * Customize acf tiny mce toolbars / add custom elements
 */
function gts_tiny_toolbars( $toolbars ) {

    // Uncomment to view format of $toolbars

    // echo '<pre>';
    //     print_r($toolbars);
    // echo '</pre>';
    // die;

    return $toolbars;

}
add_filter( 'acf/fields/wysiwyg/toolbars' , 'gts_tiny_toolbars' );


/***
 * GTS register custom acf block types
 */
function gts_register_acf_blocks() {

    $dirs = [
        wpb_get_dir('/blocks', 'parent'),
    ];
    $blocks = [];

    foreach ($dirs as $dir) {
        if (!is_dir( $dir )) continue;

        if (str_contains($dir, 'GTS')) {
            $theme = 'parent';
        } else {
            $theme = 'unknown';
        }

        foreach (scandir( $dir ) as $result) {
            $block = $dir . '/' . $result;

            if (!is_dir( $block ) || '.' === $result || '..' === $result) continue;
            if (str_starts_with($result, '__')) continue;

            $blocks[] = [
                'data' => $block,
                'theme' => $theme,
            ];
        }
    }

    // Go over all the blocks and register them, but if a block is entered multiple times, only register the child version other wise just register the parent version
    $registered_blocks = [];
    foreach ($blocks as $block) {
        $block_name = basename($block['data']);

        // If the block is already registered, skip it
        if (isset($registered_blocks[$block_name]) && $registered_blocks[$block_name]['theme'] === 'child') {
            continue;
        }

        // If the block is not registered yet, register it
        $registered_blocks[$block_name] = [
            'file' => $block['data'],
            'theme' => $block['theme'],
        ];
    }

    
    foreach ($registered_blocks as $block_name => $block) {
        register_block_type($block['file']);
    }

}
add_action('init', 'gts_register_acf_blocks');


/***
 * GTS register local saving of acf field groups
 */
function gts_load_field_groups($paths) {
    array_unshift($paths, get_template_directory().'/acf-json');
    return $paths;
}
add_filter('acf/settings/load_json', 'gts_load_field_groups');

function gts_save_field_groups( $path ) {
    return get_template_directory().'/acf-json';
}
add_filter('acf/settings/save_json', 'gts_save_field_groups');