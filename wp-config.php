<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', 'C:\xampp\htdocs\ocdevwp-projet11\motaphoto3\wp-content\plugins\wp-super-cache/' );
define( 'DB_NAME', 'motaphoto3' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'j4;k-`Z|_)t3SZ BjalFV2r]Y )=a<Zr;PHN[vC.=;rMs.~/;9!lbQ(cMaw(4C7~' );
define( 'SECURE_AUTH_KEY',  'zQaWatt?v8RhL)BBvoYNxBd# JZ3@)GK8QD+*RF1[JS[yX8$>k`[vGoGk$T(f*RK' );
define( 'LOGGED_IN_KEY',    '*4yKo%ka3(VNO/MYP!@HYxg+U@8mv1.$I7w9Tut}W-svXvT{D: ZjAF)|Kpb<y,X' );
define( 'NONCE_KEY',        'YY}*}cl6u(16j-/<!<F[% `yxWb09EH.A;RaWGF4M)]C,QD+*4XAdQa#j5J$1mxJ' );
define( 'AUTH_SALT',        '/}MnkckkAL!E{y4%r7q]s*P4U)uLYmDYua_U:Ek+;Ml8bOzBi(NnHlr(iq8o]+R ' );
define( 'SECURE_AUTH_SALT', 'AWYz)zq&@tqw00YYEb-l>wZ}MeR}wfG~15NRm.lvs`]DC,$ZKB3BUH`ZCg?UZU9$' );
define( 'LOGGED_IN_SALT',   'h7DfyI(6nJ;e`m_zpZmqp1 aCXScH(n*g*d2<[scktl1nMcv&cn>]R7l>+hrx~)r' );
define( 'NONCE_SALT',       'LQgWIK[!4R_Gjc|~Prjyb5<~SrP[<^k#R`yxgDP<c?iO/5Un7j7e#3=:.GjY[;RZ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
