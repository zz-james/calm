<?php
/*
Plugin Name: Random Gallery



Author URI: http://www.greenwold.com/web-projects/#random-gallery


class dgplugins {
function random_gallery($attr)  { // $attr is the default name given by wp to an array consisting of the key/value pairs defined by the user in the shortcode
	sanitize_text_field($attr['ids']);
	if( !isset($attr['shownum']) || empty($attr['shownum']) || $attr['shownum'] < 1 || $attr['shownum'] > $count_in ) {
	// Create an array called $ids_out, which has a length equal to shownum and contains randomly selected values from $ids_in.
	for ($i = 1; $i < $attr['shownum']; $i++) {
	// Use the new ids list ($ids_out) to call the regular gallery shortcode.
add_shortcode('random-gallery',array('dgplugins','random_gallery'));