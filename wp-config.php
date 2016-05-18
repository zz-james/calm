<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
 
// Include local configuration
if (file_exists(dirname(__FILE__) . '/local-config.php')) {
	include(dirname(__FILE__) . '/local-config.php');
}

// Global DB config
if (!defined('DB_NAME')) {
	define('DB_NAME', 'savethem_cLam30ne');
}
if (!defined('DB_USER')) {
	define('DB_USER', 'james');
}
if (!defined('DB_PASSWORD')) {
	define('DB_PASSWORD', 'custom3r123');
}
if (!defined('DB_HOST')) {
	define('DB_HOST', 'localhost');
}

/** Database Charset to use in creating database tables. */
if (!defined('DB_CHARSET')) {
	define('DB_CHARSET', 'utf8');
}

/** The Database Collate type. Don't change this if in doubt. */
if (!defined('DB_COLLATE')) {
	define('DB_COLLATE', '');
}

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '^eb,QD1,TO0:f85fiLj}`N5N6k*>a^duF5V~Jj[-C/y:,-dy.6E/A}@g7x;:U!7L');
define('SECURE_AUTH_KEY',  'cpJkadI!8*qeod`yaG+FM9Y_<h&h7T,D+r^{jmMmtI<S-KPM%nv8%N%Nd,yda|<I');
define('LOGGED_IN_KEY',    '{<}n=Q@cJdUd]c&J[_!rFzfIR]{yz$(oM,A<&-Z}iZYLO:L]OVE?hrO<=2YJRFih');
define('NONCE_KEY',        '7 2K|V5xyp(,.r5hA|?HK2Dwr; U,iV|2[5TYEoM@,|O,|pUc+/YlO1^~}-z(/%c');
define('AUTH_SALT',        'Sv^iN+g=?`P{&grw7ZsZ>(zc*!.g<o%zzf$Qv+ReKWry9NP{k?<CR-eoW//nc4E6');
define('SECURE_AUTH_SALT', ']YE-{f3[+#GSWO-8&*$Z,1r7v`eozW;lm/^AY_OIfY]/L)DK1=263<  f~?Oea+v');
define('LOGGED_IN_SALT',   'aAHn`x. .},Up`2jzHi<{WA3FINhXH,8_wU)]7NY6x72W0szL-FfM q-1Vg|-xbS');
define('NONCE_SALT',       'agK+-@Z.4bdP9-F0JJ$Y?PB0Y^C+|, cG)3-IJ]oj(R8v;>`wj (_du%R~e ={a]');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = '0ziwukive4_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');


/**
 * Set custom paths
 *
 * These are required because wordpress is installed in a subdirectory.
 */
if (!defined('WP_SITEURL')) {
	define('WP_SITEURL', 'http://' . $_SERVER['SERVER_NAME'] . '/wordpress');
}
if (!defined('WP_HOME')) {
	define('WP_HOME',    'http://' . $_SERVER['SERVER_NAME'] . '');
}
if (!defined('WP_CONTENT_DIR')) {
	define('WP_CONTENT_DIR', dirname(__FILE__) . '/content');
}
if (!defined('WP_CONTENT_URL')) {
	define('WP_CONTENT_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/content');
}


/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
if (!defined('WP_DEBUG')) {
	define('WP_DEBUG', false);
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
