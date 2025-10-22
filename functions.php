<?php
/**
 * GTS engine room
**/

$theme = wp_get_theme( 'GTS' );
$GTS = (object) array(
    'version' => $theme['Version'],
);


require get_template_directory() . '/inc/classes/class-gts.php';

require 'inc/acf-functions.php';
require 'inc/classes/class-gts-helper.php';
require 'inc/gts-functions.php';
require 'inc/yoast-functions.php';