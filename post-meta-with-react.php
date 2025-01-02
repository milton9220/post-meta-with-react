<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Post Meta With React
 * Plugin URI:
 * Description:
 * Version:           1.0.0
 * Author:
 * Author URI:
 * Text Domain:       post-meta-with-react
 * Domain Path:       /languages
 */

// Do not allow directly accessing this file.
use Milton\App\PostMetaWithReact;

if ( ! defined( 'ABSPATH' ) ) {
    exit( 'This script cannot be accessed directly.' );
}


define( 'PMWR_VERSION', '1.0.0' );

define( 'PMWR_FILE', __FILE__ );

define( 'PMWR_BASENAME', plugin_basename( __FILE__ ) );

define( 'PMWR_URL', plugins_url( '', PMWR_FILE ) );

define( 'PMWR_ABSPATH', dirname( PMWR_FILE ) );

define( 'PMWR_PATH', plugin_dir_path( __FILE__ ) );

require_once PMWR_PATH . 'vendor/autoload.php';

function pmwr() {
    static $cached_instance;
    if ( null !== $cached_instance ) {
        return $cached_instance;
    }
    $cached_instance = PostMetaWithReact::instance();
    return $cached_instance;
}

pmwr();
