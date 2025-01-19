<?php

define('VITE_DEV_SERVER', 'http://localhost:5173');
define('VITE_THEME_DIR', 'wp-content/themes/wp-vite-theme');
define('VITE_ASSETS_DIR', VITE_THEME_DIR . '/resources');
define('VITE_CLIENT_PATH', VITE_DEV_SERVER . '/' . VITE_THEME_DIR . '/@vite/client');
define('VITE_SCRIPTS_PATH', VITE_DEV_SERVER . '/' . VITE_ASSETS_DIR . '/scripts/scripts.js');
define('VITE_STYLES_PATH', VITE_DEV_SERVER . '/' . VITE_ASSETS_DIR . '/styles/styles.css');
define('VITE_MANIFEST_PATH', get_template_directory() . '/dist/.vite/manifest.json');

define('THEME_ASSETS_DIR', get_template_directory_uri() . '/dist');