<?php
/**
 * GTS engine room
**/

if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '81.173.58.132') {
    //ini_set('display_errors', '1'); ini_set('display_startup_errors', '1'); error_reporting(E_ALL);
}

$theme = wp_get_theme( 'GTS' );
$GTS = (object) array(
    'version' => $theme['Version'],
);


require get_template_directory() . '/inc/classes/class-gts.php';

require 'inc/acf-functions.php';
require 'inc/classes/class-gts-helper.php';
require 'inc/gts-functions.php';
require 'inc/yoast-functions.php';