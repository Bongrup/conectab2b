<?php

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL
define( 'WP_CACHE', true ); // Added by WP Rocket

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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'db4mcyhotdouns' );

/** Database username */
define( 'DB_USER', 'urn60utjbdhet' );

/** Database password */
define( 'DB_PASSWORD', 'gcpwmgig1cki' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define( 'AUTH_KEY',          'P=Y!t1Ml.Ms#}n;3*FWh0F2+Z<q^DU-<f_Q$i( j=+cQqqA#4Qm%FJX%LMl}-b57' );
define( 'SECURE_AUTH_KEY',   'dTd;1Ch.rTo>pR{g%%uW*.Nmk}e<d:L[I*b7yT+,M&E*^KA13wxw52m[(qY=u]K%' );
define( 'LOGGED_IN_KEY',     'c#yybI)_<2t@,@U!)FSA*Xd*RbyO(j-ae<=|D5eabhqty4mNmpBjOSGK&4KO^8<T' );
define( 'NONCE_KEY',         'mbaE~NOK_H?=)+E!%j.wKoOKL+L%7`GNH4!?1iOt]`X#CLI#DfqVUW_n26eHm[rp' );
define( 'AUTH_SALT',         'hiA?1H<uWC|GP1F!;9;*,m4~dYP@{!1YACHd[8sxsykI|pe:+~_ZuF4/Spo!K#/g' );
define( 'SECURE_AUTH_SALT',  'h8;^9;~u w<]>qg?kU[v_>]@cU]4`YmielWsx+XL5WW]u1QHr7CE^V&zH7vHl22)' );
define( 'LOGGED_IN_SALT',    'kS6nz%uva(stvu:!QyVpDn:qCHJ:8(B|8`}DTZ)~nzD%{gV|z=bK|FpV9Vcs=~f7' );
define( 'NONCE_SALT',        '%6d|26&^gFkU!7CKFG4JK4Jqg8=P,dBxOy63If!$^]EZbF~3MO<1<~EvT]^,h(Ym' );
define( 'WP_CACHE_KEY_SALT', ':W3Lmu2675[dby0W{UMj0)oL}{<l@)XlbZD%[kf)`oeGnfV_.O?_U>?6%[;RUdgc' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'tep_';

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
define( 'WP_POST_REVISIONS', false );


/* Add any custom values between this line and the "stop editing" line. */



define( 'WC_TS_EASY_INTEGRATION_ENCRYPTION_KEY', '4d67f01d09c7a1d70b51c85364a7e1138e25426d7df0b31b23c1258b0150f7dc' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
@include_once('/var/lib/sec/wp-settings-pre.php'); // Added by SiteGround WordPress management system
require_once ABSPATH . 'wp-settings.php';
@include_once('/var/lib/sec/wp-settings.php'); // Added by SiteGround WordPress management system
