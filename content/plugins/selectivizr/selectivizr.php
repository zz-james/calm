<?php
/*
Plugin Name: Selectivizr for WordPress
Plugin URI: http://www.ramoonus.nl/wordpress/selectivizr/
Description: Selectivizr is a JavaScript utility that emulates CSS3 pseudo-classes and attribute selectors in Internet Explorer 6-8. 
Version: 2.0.3.1
Author: Ramoonus
Author URI: http://www.ramoonus.nl/
*/

// init
function rw_selectivizr() {
    wp_enqueue_script('selectivizr',plugins_url( '/js/selectivizr.js' , __FILE__ ), array(), '1.0.b3' );
} 
// load
add_action('wp_head', 'rw_selectivizr');
?>