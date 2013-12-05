<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'pramod123');

/** MySQL database username */
define('DB_USER', 'pramod123');

/** MySQL database password */
define('DB_PASSWORD', 'werder124');

/** MySQL hostname */
define('DB_HOST', 'mysql.alexcreativeconsulting.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'H$mF#|Gt^NEpsEu@ Lor>.f|><vb|ve8_. ]62Qb2nUoV{(m)+83P%BtvQW&50MV');
define('SECURE_AUTH_KEY',  '.-|u/|,Yq9:TezW^OJ_%O&-!?{^o{t`.+j3.X|x%k,/zl5PsjY{DMTPPv+g+/`Zk');
define('LOGGED_IN_KEY',    '*gP`,OpDppz{_KU~c,b||2-8=Bl!nJAa{kF>u56AwGN-Td-@;;vAY]t(!OG|k+~S');
define('NONCE_KEY',        '+ejcf&{}ua&TQ0+|_^/lw p!.@g,JDjdxi63pGRq$;Coi4#z|,<G9&-q7q9p;DOe');
define('AUTH_SALT',        'XH+@wy0MjEzMo+Py H)zf<62KyC2Q}%lsAxm$=sE6f^p(Q(Gh;<f4|6yEci~>^f2');
define('SECURE_AUTH_SALT', 'v5+YA)sXKw<}^Ho/.H:[m]XG2r_sRrklc2j8>>gJqt:_II.o|iA=$!Rm7B^/9HOz');
define('LOGGED_IN_SALT',   '5=>--CD{i2e6q=|hks,XX8(8UGOFT7VlGy^!o{/S>RFLXKAjkm@&R;f?k|`K|[WP');
define('NONCE_SALT',       '+q]K%SvON07rqqTdANX=At(S%W1 C43Ok$/@|=gNVU_&}h|wa#![{g~D7k}b>I+/');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_tmp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

//** Added by Bikram
define('WPLANG', '');
define('ADMIN_COOKIE_PATH', '/');
define('COOKIE_DOMAIN', '');
define('COOKIEPATH', '');
define('SITECOOKIEPATH', '');
