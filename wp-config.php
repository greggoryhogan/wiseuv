<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wiseuvor_wp' );

/** Database username */
define( 'DB_USER', 'wiseuvor_wpu' );

/** Database password */
define( 'DB_PASSWORD', 'y^zNI]f0H6%E' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'I{J-5CM^$7@+&a+-%+>lZ>VpccJ_LZ|EC|ulh$dT|SFm;O&<wTWtv9S{;3r2:d4C');
define('SECURE_AUTH_KEY',  ':K->j`D`9?|qx:xeC:AzM9sBTd96A46JK!&S7nemn!$X+e0GS17@XRpU^wGX?-|s');
define('LOGGED_IN_KEY',    'EU^HnLidr#M$K4#.#}}xzpUWqw&mkW)1sFFl:UD%0Tgf1CtJ*&yt+g5*M]tcefP8');
define('NONCE_KEY',        '@?0o?;>T<)c]75R+*kG2Gl/2I_Gw*@a?rNPV=C2/}|0Up$A+:}&M%-)|9D5Pj^2(');
define('AUTH_SALT',        'Wsw]4)MwCZa|-$VNY0G!gt)^8]v~_FKx4CQJ+]MQ7Sn2BHX2m,]$5lqL]m|6ZE6;');
define('SECURE_AUTH_SALT', 'jW4DwpOt~mF:N>  74$?gjp&z:3QE!0jHHd{,MNXxwLJiTzoR+VhCef)SdGgHW55');
define('LOGGED_IN_SALT',   '2c{:dY+Zt(sEa{Z!JMci/+D|!kH}wK/fjhfP)iu-|:qUPB?Dn8A[N/RD>KFi|8z+');
define('NONCE_SALT',       '!_zglCPp|a;wqK|ody?ej/cMB3 R3ED{;F/{,v*zv%<[[gSe>VlLT.IDE:ffjWHZ');
	

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wuv_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
