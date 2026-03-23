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
define( 'DB_NAME', 'wp_zhyvchik' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'MySQL-8.0' );

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
define( 'AUTH_KEY',         '?O3EB^Cne]jeH**O@CUsb!UhoO~(E|DMV>K_XV/Jpq5z-O=pyM;DWh8W4EfuQ51;' );
define( 'SECURE_AUTH_KEY',  '(hvR2u9>7h)~n<i)WR}ZcR8+LV-RF;g8W25qZq!q[cU8Jq VEE$B|0?jK30`|l4X' );
define( 'LOGGED_IN_KEY',    '6pF2?|}0tNJrj1B?-7eAAt+,o{|bh6J]!x/i&(<@r:al]lWnE~yV Ij{*b^a&7%&' );
define( 'NONCE_KEY',        '7klK+Z/?wWn[Ee/pm!jxg?p08RR^{Q9m@8V=9q9fSioAUr}I&Ml8j7`.r_Mglo`;' );
define( 'AUTH_SALT',        'k}j^ac3=JOV{L@Y k4u%,_*DtZQ0g1cq:NYH?$0kw#Z0YMP*H?,lM9^;N1FIXre|' );
define( 'SECURE_AUTH_SALT', ';boNHS(9k93Kh(cxyYw`37[:lbn&x#@u[GBvlS f/SuI&@X`XZwisjq t>1dsG/}' );
define( 'LOGGED_IN_SALT',   '%m3T(Tj6os[8-_V9#[Ky=|6cjR/.{Q5[gy @#7l555CPuT8MUQR9yq}c6MAxBidk' );
define( 'NONCE_SALT',       '6M(](p4G,Yn(pR<L%,{83]vmz>IUYvJmZV+[zC_:eE`I^|DmlQ[fl%LnoNK3@VlJ' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
