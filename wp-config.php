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
define( 'DB_NAME', 'job' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'hB,DV>o2^o5y#Li<pg J$no{`N[Y?Z|bN, DtB((0hz.}RM+Ha%Z1MlL)hsntsZ:' );
define( 'SECURE_AUTH_KEY',  'yBmEdvn::LUSTJ`bDjEKItH~{]R9eM}AI>A&B07l305kHN3&O+=!$Fvx;6(:&Qh4' );
define( 'LOGGED_IN_KEY',    '@|bv>r^Wry^mVM!LH]tO]2&h}eY2;U?I-A>g{1-W.uPL!Y:vb@_ X}YqAk@2)?T(' );
define( 'NONCE_KEY',        'Mld+(&OuU&<^ ?yz/GPa0yB@1GnNPdf_QHbq8wZDM=X}$;WP?n)UTa$Q!n|M &:E' );
define( 'AUTH_SALT',        'nid.B7Rz^3F;#lqB4RQWGbv[>/*F~PmL:F~l{=Ud,`8mWgzjo+$m*htA*oO_4}Wh' );
define( 'SECURE_AUTH_SALT', '=u(6a!qH9!6aPsThYRw/Z98z%rK&Qcl)eD>#pns3r;vOt00(m~Xj_AT4isMtsWTZ' );
define( 'LOGGED_IN_SALT',   'rkl*Aq#v0f& HRI^xza)y9t~b3xX6@wvnRBab).b.mTK^wE!xK+0]dEW{49wFT[X' );
define( 'NONCE_SALT',       '7YX;ox&/&Lrvg)DlADPLk+W228qU9.@X.>s2^rcnTnP({&.$>UfnL7M1sMv=xJMV' );

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
