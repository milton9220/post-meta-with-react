<?php

namespace Milton\App\Controllers;

// Do not allow directly accessing this file.


use Milton\App\Traits\SingletonTrait;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

class AssetsControllers {
	use SingletonTrait;

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Ajax URL
	 *
	 * @var string
	 */
	private $ajaxurl;
	/**
	 * Styles.
	 *
	 * @var array
	 */
	private $styles = [];

	/**
	 * Scripts.
	 *
	 * @var array
	 */
	private $scripts = [];


	/**
	 * Class Constructor
	 */
	public function __construct() {
		$this->version = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? time() : PMWR_VERSION;
		/**
		 * Admin scripts.
		 */
		add_action( 'admin_enqueue_scripts', [ $this, 'backend_assets' ], 99 );

	}

	/**
	 * Registers Admin scripts.
	 *
	 * @return void
	 */
	public function backend_assets( $screen ) {
		$scripts = [
			[
				'handle' => 'pmwr-admin-js',
				'src'    => pmwr()->get_assets_uri( 'admin/js/post-meta-admin.js' ),
				'deps'   => [],
				'footer' => true,
			],
		];

		// Register public scripts.
		foreach ( $scripts as $script ) {
			wp_register_script( $script['handle'], $script['src'], $script['deps'], $this->version, $script['footer'] );
		}

		$styles = [
			[
				'handle' => 'pmwr-admin-css',
				'src'    => pmwr()->get_assets_uri( 'admin/css/post-meta-admin.css' ),
			],
		];

		// Register public styles.
		foreach ( $styles as $style ) {
			wp_register_style( $style['handle'], $style['src'], [], $this->version );
		}

        if ('edit.php' == $screen || 'post.php' == $screen || 'post-new.php' == $screen){
            wp_enqueue_style( 'pmwr-admin-css' );

            wp_enqueue_script( 'pmwr-admin-js' );
            $post_id = get_the_ID();
            $meta_fields = get_post_meta($post_id);
            $repeater_field= get_post_meta($post_id, '_repeater_field', true);
            $repeater_field = maybe_unserialize($repeater_field);
            wp_localize_script(
                'pmwr-admin-js',
                'pmwrParams',
                [
                    'ajaxUrl'         => esc_url( admin_url( 'admin-ajax.php' ) ),
                    'adminUrl'        => esc_url( admin_url() ),
                    'restApiUrl'      => esc_url_raw( rest_url() ),
                    'rest_nonce'      => wp_create_nonce( 'wp_rest' ),
                    pmwr()->nonceId => wp_create_nonce( pmwr()->nonceText ),
                    'plugin_file_url' => pmwr()->plugin_url(),
                    'metaFields' => [
                        'simple_field_one' => isset($meta_fields['_simple_field_one']) ? $meta_fields['_simple_field_one'][0] : '',
                        'simple_field_two' => isset($meta_fields['_simple_field_two']) ? $meta_fields['_simple_field_two'][0] : '',
                        'repeater_fields' =>  $repeater_field
                    ],
                ]
            );
        }

	}
}