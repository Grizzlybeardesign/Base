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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'gbdtest_grizzlytheme');

/** MySQL database username */
define('DB_USER', 'gbdtest_grizzlyt');

/** MySQL database password */
define('DB_PASSWORD', '=n_anvA$sH5!');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'S98%U=|n;BJmgIc9=x-_A#?ko9IX8,e!1Yt_=:giRbc0Zj$mThd,dtEnycqb}~4L');
define('SECURE_AUTH_KEY',  'M9CW^4D {j0t$p<*^NiZu2[lgjHGcGoq$)gC%v;5J+e/(5M/kc]Xu~7EIbQ[!,V3');
define('LOGGED_IN_KEY',    '5t)dBQ=QdJIX27Q667xgoN?[*^Gp:bJ0#CQ!jc)ITeYj$?Un:Jh]h/*JOGCx2#}I');
define('NONCE_KEY',        'y+>s|!~xnA.QJU-.g9o-*NxGT. >/azr,7H|uJ4M{$)z3e5KTe=qpnanf]fK3@n<');
define('AUTH_SALT',        'HO6|vT|BqFo[]o4oI+q79$sj8#-,s7,YVfO0Sx75G_9ufVmNP.9xq//M:e~Ie8aN');
define('SECURE_AUTH_SALT', '/w0bOeE~]~1p@ wh+ER>LWHYKnJwf)NN`^iRNWE}gA_mY;PTWb]r%q[I^$Mr5<ox');
define('LOGGED_IN_SALT',   '>O~; vo|^{7M4Ox%5q hY5J07n kGG~}<pzgiL}-SmO7>68E?WC;Ov@?SJiET?l.');
define('NONCE_SALT',       '`q.,$Ed=!Wf^YWo5[Js=]TvNF9h~Qd~k=|CpGzq]5U;M8Nc#IwNn<^T@2bg$/>Yw');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
	error_reporting(-1);
		ini_set('display_errors', 1);
define('WP_DEBUG', true);
define('FS_METHOD', 'direct');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
