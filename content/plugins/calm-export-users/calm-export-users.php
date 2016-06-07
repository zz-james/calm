<?php
/**
 * @package calm_export_user_data
 * @version 1.0
 */
/*
Plugin Name: Export User Data CSV
Plugin URI: 
Description: This plugin allows you to export user data.
Author: Andy Wilkinson
Version: 1.0
Author URI: http://www.errorstudio.co.uk
*/

add_action('admin_menu', 'calm_export_user_data_menu');
add_action('init','calm_export_user_data_send_file');

function calm_export_user_data_menu () {
	//Page title, menu title, the capability required, url link to the plugin page, options function which generates content
	add_management_page('Export User Data Options', 'Export User Data', 'manage_options', 'calm_export_user_data_page_name', 'calm_export_user_data_options');
	//add_options_page('Custom Plugin Page', 'Custom Plugin Menu', 'manage_options', 'plugin', 'plugin_options_page');


}

function calm_export_user_data_send_file() {
	global $wpdb;
	if (isset($_POST['send_csv'])) {
		check_admin_referer('calm-export-users-dump_users');
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		//munge the tablenames to include the appropriately configured prefix
		$tables = array(
			"users" => $wpdb->prefix."users",
			"usermeta" => $wpdb->prefix."usermeta",
			"cimy_uef_data" => $wpdb->prefix."cimy_uef_data"
		);

		// generate the query
		$query = <<<END
			SELECT $tables[users].user_email, $tables[users].user_registered, $tables[users].user_login,
			(select meta_value from $tables[usermeta] where meta_key = 'first_name' and user_id = $tables[users].id) as first_name,
			(select meta_value from $tables[usermeta] where meta_key = 'last_name' and user_id = $tables[users].id) as last_name,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 2 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as age,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 3 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as gender,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 4 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as ethnicity,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 5 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as postcode,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 6 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as facebook_profile,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 7 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as twitter_name,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 8 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as interest_in_calm,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 15 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as i_support_calm_because,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 11 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as experience_of_suicide,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 1 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as can_we_contact_you_about_it,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 13 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as your_manifesto,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 14 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as your_manifesto_ok,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 16 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as involved_volunteer,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 17 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as involved_writeforus,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 18 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as involved_workinoffice,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 19 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as involved_missions,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 26 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as involved_other,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 20 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as interests_sports,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 21 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as interests_comedy,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 22 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as interests_arts,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 23 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as interests_music,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 24 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as interests_fashion,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 25 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as interests_literature,
			(select VALUE from $tables[cimy_uef_data] where $tables[cimy_uef_data].FIELD_ID = 27 and $tables[cimy_uef_data].USER_ID = $tables[users].id) as ok_to_email
			FROM $tables[users] ORDER BY $tables[users].user_login
END;
	
		//$result is an array of objects, each representing a line in the results
		$result = $wpdb->get_results($query);
	
		//we need a CSV header line, so we get the first result object's keys
		//(i.e. field names) and return them as an array
		$header = array_keys(get_object_vars($result[0]));
		//start building the CSV output by flattening the array into a string
		//with commas and double quotes in between each element (and a newline at the end)
		$csv = '"'.implode('","',$header).'"'."\n";
		//now we just iterate through the entire $result, getting each object in turn
		//and splitting that into an array, which we then implode to a CSV string
		foreach($result as $data) {
			$output = Array();
			//iterate through each element in the data (i.e. field => value pair)
			//and stick the value into the output array
			foreach(get_object_vars($data) as $k => $v) {
				$output[] = $v;
			}
			//flatten the array and concat to the CSV string (with a newline)
			//we're enclosing each field with double quotes and removing
			//any double quotes we find in the text.
			$csv .= '"'.implode('","',str_replace('"','',$output)).'"'."\n";
		}

		//we chuck out a couple of headers and then write the CSV string
		$filename = date("d-m-Y-H-i-s")."_calm_users.csv";
		header("Content-Type: text/csv");
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		echo $csv;
		die(); //TODO - this is a mess; there must be a better way to stop execution
	}
}


function calm_export_user_data_options () {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
		
	?>

		<div class="wrap">

		<h2>Export User Data</h2>

		<p>Click the button to download a CSV of the user data.</p>

	<form method="post" action="tools.php?page=calm_export_user_data_page_name">
	<?php
	if ( function_exists('wp_nonce_field') )
		wp_nonce_field('calm-export-users-dump_users');
	?>

		<input type="hidden" name="send_csv" value="yes" />
		
	    <p class="submit">
	    	<input type="submit" class="button-primary" value="Save User Data CSV" />
	    </p>

	</form>
	</div>
	<?php 
}

add_action('admin_init', 'plugin_admin_init');

function plugin_admin_init() {

	register_setting( 'calm_export_user_data_options_unique_identifier', 'calm_export_user_data_options', 'calm_export_user_data_options_validate' );

}

?>
