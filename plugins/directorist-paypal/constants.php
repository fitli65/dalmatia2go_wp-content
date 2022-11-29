<?php
// Plugin version.
if (!defined('DT_PAYPAL_VERSION')) {
    define('DT_PAYPAL_VERSION', $version);
}
// Plugin Folder Path.
if (!defined('DT_PAYPAL_DIR')) {
    define('DT_PAYPAL_DIR', plugin_dir_path(DT_PAYPAL_FILE));
}
// Plugin Folder URL.
if (!defined('DT_PAYPAL_URL')) {
    define('DT_PAYPAL_URL', plugin_dir_url(DT_PAYPAL_FILE));
}
// Plugin Root File.
if (!defined('DT_PAYPAL_BASE')) {
    define('DT_PAYPAL_BASE', plugin_basename(DT_PAYPAL_FILE));
}
// Plugin Library Path
if (!defined('DT_PAYPAL_LIB_DIR')) {
    define('DT_PAYPAL_LIB_DIR', DT_PAYPAL_DIR . 'libs/');
}
// Plugin Language File Path
if (!defined('DT_PAYPAL_LANG_DIR')) {
    define('DT_PAYPAL_LANG_DIR', dirname(plugin_basename(DT_PAYPAL_FILE)) . '/languages');
}
// plugin author url
if (!defined('ATBDP_AUTHOR_URL')) {
    define('ATBDP_AUTHOR_URL', 'https://directorist.com');
}
// post id from download post type (edd)
if (!defined('ATBDP_PAYPAL_POST_ID')) {
    define('ATBDP_PAYPAL_POST_ID', 13702);
}