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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'balibungalowrentv2_loc');

/** Database username */
define('DB_USER', 'root');

/** Database password */
define('DB_PASSWORD', 'root');

/** Database hostname */
define('DB_HOST', '127.0.0.1:3308');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY', 'I:1J,zR7lR<3mqB~$v]Lc{g #(|yeviLhlc8a bW??l^fNsSx(FT,M8THx$5Up{^');
define('SECURE_AUTH_KEY', 'k-7f`J;(:^M;IRJO:)]95xA,N7Wv:!m;T574qOHoUA%95k+x36_nRX<6+4;lSj>d');
define('LOGGED_IN_KEY', 'AE>p8wgt1Dti?F.NCF`qS j#eD%YBrfIlIj(Bp=|/qhN|?QQ%>S!6,)?l=e+Zh7(');
define('NONCE_KEY', 'N5A6xMb[F B[l[X`$>pfb.$faeYH>K,mj`6x+2S#(-j(K6&_.`jGZUG;D af+q~0');
define('AUTH_SALT', 't%m],1,}oafz`F<WRh8:RwPHF<McXdUwYO@F:i*O2EBn{+ 4I+363<{fZ|c4s&==');
define('SECURE_AUTH_SALT', ':E;Dv[8A?M[>G4Yk O.r| ,}i/jNeR$m}j=7%_FL8`)JG*_jP&8A$4|u/1{jEW,W');
define('LOGGED_IN_SALT', '&(B!CYoEWOf9w kuby&wJEj pPSD=0H4u*re!fPd4y*>eTqRhp^Qbx=0J)U{SMPL');
define('NONCE_SALT', 'Qq1Xa]F40EfHGd[$H;lj6#P+{NjsUN|{b/{D[fwrwVR(o ^uV0w%Defc)2jH!)1X');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'bbr_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
$isDev = false;
@ini_set('log_errors', $isDev ? 'On' : 'Off');
@ini_set('display_errors', 'Off');
define('WP_DEBUG', $isDev ? true : false);
define('WP_DEBUG_LOG', $isDev ? true : false);
define('WP_DEBUG_DISPLAY', false);

/** Define WP environment **/
define('WP_ENVIRONMENT_TYPE', $isDev ? 'development' : 'production');

/** Prevent editing by Admin -> Appearance -> Editor **/
define('DISALLOW_FILE_EDIT', true);

/** Prevent WP Schedule System **/
define('DISABLE_WP_CRON', false);

/** Prevent concatenate scripts in the admin **/
define('CONCATENATE_SCRIPTS', false);

/** Disable auto-update **/
define('AUTOMATIC_UPDATER_DISABLED', true);
define('WP_AUTO_UPDATE_CORE', false);

/** Set default theme **/
define('WP_DEFAULT_THEME', 'salient-child');

/** Set memory limits */
define('WP_MEMORY_LIMIT', '512M');
define('WP_MAX_MEMORY_LIMIT', '512M');

/** Set maximal number of post revisions to keep */
define('WP_POST_REVISIONS', 50);

/* Add any custom values between this line and the "stop editing" line. */


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
