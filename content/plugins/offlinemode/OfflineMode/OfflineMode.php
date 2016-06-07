<?php
/*
Plugin Name: OfflineMode
Plugin URI: http://blog.zorex.info/?page_id=144
Description: Developed by zorex, this plugin enable admin to put up a splash page to show that the site is down for maintenance. Come with a timer to tell how long the site is down. User can customize their own splash screen or get a list of splash screen from <a href="http://blog.zorex.info/?p=142">here</a>.
Author: Zorex
Author URI: http://blog.zorex.info
Version: 1.0.0b
*/

/*  Copyright 2008  Zorex  (email : support@zorex.info)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class OfflineMode {
	
	
	# ------
	# Version info
	# ------
	
	var $version = '1.0.0b';
	
	
	# ------
	# Vars
	# ------
	
	var $err = false;
	var $msg = '';
	var $allSettings = array();
	
	
	# ----------------------------------------------------------------
	# Constructor
	# ----------------------------------------------------------------
	
	function OfflineMode() {
		
		# Display the splash if enabled
		add_action('send_headers', array('OfflineMode', 'displaySplash'));
		
		# Admin part below
		$data = array(	'OfflineMode_type' => '',
						'OfflineMode_enable' => '',
						'OfflineMode_startTime' => 0);
						
		add_option('OfflineModeSettings',$data,'OfflineMode Settings');
		
		add_action('admin_menu', array('OfflineMode', 'addSettingsPage'));
		
		add_action('admin_notices', array('OfflineMode', 'adminNoticeMsg'));
	}
	
	
	# ----------------------------------------------------------------
	# Get all the settings data
	# ----------------------------------------------------------------
	
	function getSettings() {
		global $offline;
		
		$offline->allSettings = get_option('OfflineModeSettings');
		#print_r($offline->allSettings);
	}
	
	
	# ----------------------------------------------------------------
	# Show the settings link for this plugin
	# ----------------------------------------------------------------
	
	function addSettingsPage() {
		if (function_exists('add_options_page')) {
			add_options_page('OfflineMode Settings', 'OfflineMode Settings', 8, basename(__FILE__), array('OfflineMode', 'optionPage'));
		}
	}
	
	
	# ----------------------------------------------------------------
	# Show the options of the settings
	# ----------------------------------------------------------------
	
	function optionPage() {
		global $offline;
		
		# User is authorized
		if( $offline->isAuthorized() ) {
			
			# Update the settings when the submit button is pressed
			$offline->updateSettings();
			
			$offline->getSettings();
			
			$form = array();
			
			# Fill the settings to the form
			if( $offline->allSettings['OfflineMode_enable'] ) {
				$form['OfflineMode_enable'] = ' checked="checked"';
			}
			
			$selection = $offline->getAvailableSplash($offline->allSettings['OfflineMode_type']);
			
			# Got msg to display?
			$offline->msgBox();
			
			
			
			# ---- Start HTML for settings page ----
		?>
<div class="wrap">
	<h2>OfflineMode Settings</h2>
	<p>This plugin will display a splash page to inform your user that your site is currently down while you are doing maintenance.</p>
	<form action="" method="post">
				
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Enable OfflineMode</th>
				<td>
					<input type="checkbox" id="OfflineMode_enable" name="OfflineMode_enable" value="1"<?php echo $form['OfflineMode_enable']; ?> />
					<label for="OfflineMode_enable">Turn your blog offline. User wont be able to see the content of your site.</label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Splash Page</th>
				<td>
					<select name="OfflineMode_type">
						<?php echo $selection; ?>
					</select>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" name="OfflineMode_submit" value="Update" class="button" />
		</p>
	</form>
</div>
		<?php
		}
	}
	
	
	# ----------------------------------------------------------------
	# Submit button pressed, update settings
	# ----------------------------------------------------------------
	
	function updateSettings() {
		global $offline;
		
		# We update when the submit button is pressed
		if( isset($_POST['OfflineMode_submit']) ) {
			
			$data = array(	'OfflineMode_type' => basename(base64_decode($_POST['OfflineMode_type'])),
							'OfflineMode_enable' => ((int) $_POST['OfflineMode_enable']),
							'OfflineMode_startTime' => time());
			
			update_option('OfflineModeSettings',$data);
			$offline->msg = 'Your settings have been saved.';
		}
	}
	
	
	# ----------------------------------------------------------------
	# Is user authorized to perform this action?
	# ----------------------------------------------------------------
	
	function isAuthorized() {
		global $user_level;
		if (function_exists("current_user_can")) {
			return current_user_can('activate_plugins');
		} else {
			return $user_level > 5;
		}
	}
	
	
	# ----------------------------------------------------------------
	# Get all the available splash user have installed
	# ----------------------------------------------------------------
	
	function getAvailableSplash($type) {
		global $offline;
		
		# init
		$selection = '';
		
		$dir = dirname(__FILE__) . '/SplashPages/';
		
		# Error reading the folder
		if( ($handle = @opendir($dir)) == false ) {
			$offline->err = true;
			$offline->msg = 'Error getting your splash pages. Make sure you have <code>' . $dir . '</code> is not missing.';
			return '<option value="0">---</option>';
		}
		
		# We start reading the dir lorr ;P
		while( false !== ($file = readdir($handle)) ) {
			
			$ext = substr($file, strrpos($file, '.') + 1, strlen($file));
			
			if( !is_dir($dir . $file) && strtolower($ext) == 'php' ) { # We don't want dir larr, just files
				
				if( $type == $file ) 
					$selection .= '<option value="' . base64_encode($file) . '" selected="selected">' . substr($file, 0, strrpos($file, '.')) . '</option>' . "\r\n";
				else 
					$selection .= '<option value="' . base64_encode($file) . '">' . substr($file, 0, strrpos($file, '.')) . '</option>' . "\r\n";
			}
		}
		closedir($handle);
		return $selection;
	}
	
	
	# ----------------------------------------------------------------
	# Display the msg box if we got msg to display
	# ----------------------------------------------------------------
	
	function msgBox() {
		global $offline;
		
		if( $offline->msg != NULL ) {
			# ---- Start of HTML for msg box ----
		?>
			<div id="message" class="updated fade"><p><?php echo $offline->msg; ?></p></div>
		<?php
		}
	}
	
	
	# ----------------------------------------------------------------
	# Display the notice box when OfflineMode is enabled
	# ----------------------------------------------------------------
	
	function adminNoticeMsg() {
		global $offline;
		
		$offline->getSettings();
		
		# User is authorized
		if( $offline->isAuthorized() && $offline->allSettings['OfflineMode_enable'] ) {
			# ---- Admin notice msg ----	
		?>
			<div class="error">
				<p>
				<strong>OfflineMode</strong> is currently enabled. Please remember to <a href="admin.php?page=<?php echo basename(__FILE__); ?>">disable</a> it once you are done.
				</p>
			</div>
		<?php
		}
	}
	
	
	# ----------------------------------------------------------------
	# Display the splash page if the its enabled
	# ----------------------------------------------------------------
	
	function displaySplash() {
		global $offline;
		
		$offline->getSettings();
		
		# Run the splash page lorr
		if( $offline->allSettings['OfflineMode_enable'] ) {
			
			$OfflineMode_startTime = $offline->allSettings['OfflineMode_startTime'];
			
			$dir = dirname(__FILE__) . '/SplashPages/';
			
			@include_once($dir . $offline->allSettings['OfflineMode_type']);
			
			# Bye bye, we don't display the rest
			exit();
		}
	}
	
	
}

# Run the plugin - OO rox ;D
$offline = new OfflineMode;
?>