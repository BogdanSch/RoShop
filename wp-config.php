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
define( 'DB_NAME', 'gbua_shop_wp_bs' );

/** Database username */
define( 'DB_USER', 'gbua_shop_wp_bs' );

/** Database password */
define( 'DB_PASSWORD', '465caz8334' );

/** Database hostname */
define( 'DB_HOST', 'mysql314.1gb.ua' );

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
define( 'AUTH_KEY',         '}kq%gOfK(8#s))*$`Ca;$zKg$63[[eIGDYCDh*C^Ra2Q:%1IG(/;u7eUPNk/gt7e' );
define( 'SECURE_AUTH_KEY',  'aWN/krwJ^^4SEGXDo1.?c0dL`foiKCbmIvul|qjXMFLf;T+CS2#@eBI!C%5&c9K8' );
define( 'LOGGED_IN_KEY',    ')1-^:*>+iL=+a`VeeDy@[-Iho`crv}AD)o@=G+Z{wDPqUd6`h/NnpN{qUsC4?eAR' );
define( 'NONCE_KEY',        'R>>H@q>uZGXk>BSuS^uO?UJr<X+iH!];aLt+MX6*~`b=bca%LL<]%@9Q;.a(-A)b' );
define( 'AUTH_SALT',        'Y/9AG2-Kb#m0rtmqmdlzvD5;_~+W86kN5X0{to/ac_2fDJl6^;HAkB(u05TJ,h[;' );
define( 'SECURE_AUTH_SALT', 'sILe/;G~~2:$>tG23)`gd@*?y*Bj7ix[#.n=tT-{ XSO<c,S,G:CdF=}Vn KT6D ' );
define( 'LOGGED_IN_SALT',   'LVXbp;6!^v`!F}0f#,L_$g|LC7/KD*//D|.v9Sh%*D%M wjuR^+UMc20[H(tA%M>' );
define( 'NONCE_SALT',       'N@|w_B4^yS}!G-DI6tl`!Lm<X50:mVvnC2Q4GeX8c&jPO3G^f4y,8|@tq(ISe%}W' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
