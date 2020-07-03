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
define( 'DB_NAME', 'tekdevops_wp22' );

/** MySQL database username */
define( 'DB_USER', 'tekdevops_wp22' );

/** MySQL database password */
define( 'DB_PASSWORD', '8]9Z2-tESp' );

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
define( 'AUTH_KEY',         'i6hvi9ve1xptievi8sj89uxy5hrpok0pjniwiinbtlzd2nuwcwgfoqhk5qjuuwtg' );
define( 'SECURE_AUTH_KEY',  'vizslukhpwqryt9h8smacfl4ubfsunshw6cajz592nz5rizp1iz4nnyun8qun3te' );
define( 'LOGGED_IN_KEY',    'ptypjht9eampxe2yplizj1eq2tj0cgcwtltxqkshr4lhmsibkmpvhqjtwfaedd7e' );
define( 'NONCE_KEY',        'mrwuugppm95qmlhezuhtiiueuvf8fbon0dz24dgxtosp63sozkzgxy2okn2uo32v' );
define( 'AUTH_SALT',        'fkbb9n67arxfhervhmuocxb0u74hyd9pmejt3fqap9w4qlmz0n7b4kpdaqwrxxho' );
define( 'SECURE_AUTH_SALT', 'mlngifwmrn9ahrhpmgare1sxs5yzywurzfl0jt1n8zajgh4muoqkkxlpzgyxfbbh' );
define( 'LOGGED_IN_SALT',   'pjobng8k9fnkioorcdqolfa4ghtn7fhh7xug7ofczhdgdg6cxkoceq0n6dykgcxg' );
define( 'NONCE_SALT',       'jtk8nk6usezunpqofrcqlfxpzgqbhixytmowhtkjbg5u2ql4y5eogw17xwgjjp4o' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp77_';

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
