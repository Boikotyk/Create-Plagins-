<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'replacer_old' );

/** MySQL database username */
define( 'DB_USER', 'replacer_old' );

/** MySQL database password */
define( 'DB_PASSWORD', 'parasolka050' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'I9|X,QD{zteKW3dt-%0MrR-iIieJJO<[+Bu`nE-MM9/Oi@}@_*?XFhzRunGa^56S' );
define( 'SECURE_AUTH_KEY',  'e/GT|])s91Odtp,J359 dbO?M3/Q9H5I%:EEs2oZDk{iRR}2}G,<VQC`O7z@Yb}9' );
define( 'LOGGED_IN_KEY',    'W)#a@cD/mu|5!983~c@f{Zgu@N2gHXvC^7?IAaWUE1@AM++n<h?,4Y&e+p|D|xC]' );
define( 'NONCE_KEY',        '6QHNp&Gz7##0|8mz49RVpDIz+nNb8bxxP.i5dM6u~.Y>L}Q _R0PZhf`e#%q_nSy' );
define( 'AUTH_SALT',        '{;-qAl4&yEZws17(&r<H&PpOum239eu, ;]0Z*&D:v)<u76{++f`=0v<V4eRh @I' );
define( 'SECURE_AUTH_SALT', 'w$5%};@>T7:{iE&8Vi^xz3.F]<YB;UdDp{mhq*%qsBN9uv*-rWbe90^fwny3G304' );
define( 'LOGGED_IN_SALT',   '?.B >h=#[9JPJNkGaFl@$5<AQ,3r!s|Q|,D,QXX7Z1~pY_yOw69@/@l0IgbT&1r%' );
define( 'NONCE_SALT',       '_T?(~_<DN_QhErlE]Ux<YVYqS&F@$-X }:PO?/:44h;L[6Q*hXn)+W>xRW`D/.TI' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
