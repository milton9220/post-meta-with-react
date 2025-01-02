<?php
namespace Milton\App;
use Milton\App\Controllers\Admin\PostMeta\AddPostMeta;
use Milton\App\Controllers\AssetsControllers;
use Milton\App\Traits\SingletonTrait;

/**
 * Main initialization class.
 *
 */

// Do not allow directly accessing this file.


if ( ! defined( 'ABSPATH' ) ) {
    exit( 'This script cannot be accessed directly.' );
}



final class PostMetaWithReact{
    /**
     * Singleton
     */
    use SingletonTrait;
    /**
     * Nonce id
     *
     * @var string
     */
    public $nonceId = 'pmwr_wpnonce';
    /**
     * Nonce Text
     *
     * @var string
     */
    public $nonceText = 'pmwr_nonce';

    /**
     * Post Type.
     *
     * @var string
     */
    public $current_theme;

    /**
     * Class Constructor
     */
    private function __construct() {
        $this->current_theme = wp_get_theme()->get( 'TextDomain' );
        add_action( 'init', [ $this, 'language' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ], 100 );
    }
    public function language() {
        load_plugin_textdomain( 'post-meta-with-react', false, PMWR_ABSPATH . '/languages/' );
    }
    /**
     * Init
     *
     * @return void
     */
    public function init() {
        do_action( 'pmwr/before_loaded' );


        AssetsControllers::instance();
        AddPostMeta::instance();

        do_action( 'pmwr/after_loaded' );
    }
    /**
     * Assets url generate with given assets file
     *
     * @param string $file File.
     *
     * @return string
     */
    public function get_assets_uri( $file ) {
        $file = ltrim( $file, '/' );
        return trailingslashit( PMWR_URL . '/assets' ) . $file;
    }

    /**
     * Get the template path.
     *
     * @return string
     */
    public function get_template_path() {
        return apply_filters( 'pmwr_template_path', 'post-meta-with-react/' );
    }
    /**
     * et the plugin templates path.
     *
     * @return string
     */
    public function get_plugin_template_path() {
        return $this->plugin_path() . '/templates/';
    }

    /**
     * Get the plugin path.
     *
     * @return string
     */
    public function plugin_path() {
        return untrailingslashit( plugin_dir_path( PMWR_FILE ) );
    }
	/**
     * Get the plugin path.
     *
     * @return string
     */
    public function plugin_url() {
        return untrailingslashit( PMWR_URL );
    }
}


