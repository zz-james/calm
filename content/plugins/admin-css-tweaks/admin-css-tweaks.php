<?php

/*
Plugin Name: CALM: Admin CSS Tweaks
Description: Tweaks to the WordPress admin CSS for the CALM site.
Author: Andy Wilkinson
Version: 1.0
Author URI: http://example.com
*/

function my_admin_head() {
        echo '<link rel="stylesheet" type="text/css" href="' .plugins_url('wp-admin.css', __FILE__). '">';
}

add_action('admin_head', 'my_admin_head');

?>