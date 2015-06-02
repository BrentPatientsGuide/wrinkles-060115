<?php
# Database Configuration
define( 'DB_NAME', 'wp_wrinkles' );
define( 'DB_USER', 'wrinkles' );
define( 'DB_PASSWORD', '8HOaVGgxmuunSTiyR7pz' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         'ftFL$Z`eSVvs77^gY?>wqE*u}Hao<^_f2{.h4Y(c+.0m,v1z`%FQCyMx]46Zh^b ');
define('SECURE_AUTH_KEY',  'XH_5wve>M;,#rV9^|(d|Y.1%@]38#2,g@sl-|+U 6))GyT0mJhfGvE-_bo-E2YY~');
define('LOGGED_IN_KEY',    'BW5HJ{PuX*{R%XMPI+knn,3F6ai`I>I3%SI&n6sVJ*@8#W Ps-PdMtvLnlfs$?&_');
define('NONCE_KEY',        'OG[_/$^}7)$<|B^ocoI?qExt+3F]zY$HvMK;gaRW[yQR[;1@pApn:5ocAs:0u;c^');
define('AUTH_SALT',        'j1rg8z 0^?s5Wt$L>t]$XH4g8OM,7k:7K!%Ws*,;uAo{+!I}G;RPbK9Y[Tv?|]|L');
define('SECURE_AUTH_SALT', '`o%id58^>-WAVM7*;Ut-!Z`9rlGxZQZL(Z{d9?O6o6^mz&GjtnNx{kKhTp3F7onA');
define('LOGGED_IN_SALT',   's-9pJbbgr+-|l4/0`/F.$H&1c-^aAAbLT;&gwL<`=PJXr[jr8-71~]oj{U~%,{:h');
define('NONCE_SALT',       'ETaP|vo3nv>m+v`Y|NIZkLPEzC*+kc?i^,3Alzz.MxMqpBo2cy$O~J|1_hY|O?+C');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'wrinkles' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', '916804a5b6ed2d9465cc2c98b3490b05b7e122f9' );

define( 'WPE_FOOTER_HTML', "" );

define( 'WPE_CLUSTER_ID', '1497' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 22 );

define( 'WPE_LBMASTER_IP', '96.126.104.133' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'bc.wrinkles.wpengine.com', 1 => 'sm.wrinkles.wpengine.com', 2 => 'wrinkles.wpengine.com', 3 => 'www.body-contouring.com', 4 => 'www.hairremovaljournal.org', 5 => 'hair.wrinkles.wpengine.com', 6 => 'www.stretchmarks.org', 7 => 'www.wrinkles.org', 8 => 'treat.wrinkles.wpengine.com', );

$wpe_varnish_servers=array ( 0 => 'pod-1497', );

$wpe_special_ips=array ( 0 => '96.126.104.133', );

$wpe_ec_servers=array ( );

$wpe_largefs=array ( );

$wpe_netdna_domains=array ( 0 =>  array ( 'match' => 'www.hairremovaljournal.org', 'zone' => '1mxv5cu0rpz3o7mav1jhmzbf', 'enabled' => true, ), );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( 'default' =>  array ( 0 => 'unix:///tmp/memcached.sock', ), );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings




define( 'WP_ALLOW_MULTISITE', true );
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', true );
$base = '/';
define( 'DOMAIN_CURRENT_SITE', 'wrinkles.wpengine.com' );
define( 'PATH_CURRENT_SITE','/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );
define( 'SUNRISE', 'on' );


# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
