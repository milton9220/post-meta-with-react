<?php

namespace Milton\App\Controllers\Admin\PostMeta;



use Milton\App\Traits\SingletonTrait;

if ( ! defined( 'ABSPATH' ) ) {
    exit( 'This script cannot be accessed directly.' );
}
class AddPostMeta{
    use SingletonTrait;
    private $nonce_action = 'metabox_nonce';
    private $nonce_name = 'metabox_nonce_secret';
    public function __construct() {
        add_action('add_meta_boxes', [$this, 'add_custom_meta_box'],10);
        add_action('save_post', [$this, 'save_custom_meta']);
        add_filter('use_block_editor_for_post_type', function ($use_block_editor, $post_type) {
            if (in_array($post_type, ['page', 'post'])) {
                return false; // Disable Gutenberg for these post types
            }
            return $use_block_editor;
        }, 10, 2);
    }

    public function add_custom_meta_box($post) {
        add_meta_box(
            'custom_meta_box_id',
            'Custom Meta Box',
            [$this, 'render_meta_box'],
            ['page','post'],
            'normal',
            'low'
        );
    }
    public function render_meta_box($post) {

        wp_nonce_field($this->nonce_action, $this->nonce_name);

        echo '<div id="post-meta-react-container"></div>';
    }
    public function save_custom_meta($post_id) {

        // Verify nonce
        if (!isset($_POST[$this->nonce_name]) || !wp_verify_nonce($_POST[$this->nonce_name], $this->nonce_action)) {
            return;
        }
        // Check user capabilities
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Sanitize and save simple fields
        if (isset($_POST['simple_field_one'])) {
            update_post_meta($post_id, '_simple_field_one', sanitize_text_field($_POST['simple_field_one']));
        }

        if (isset($_POST['simple_field_two'])) {
            update_post_meta($post_id, '_simple_field_two', sanitize_text_field($_POST['simple_field_two']));
        }
        // Sanitize and save repeater data
        if (isset($_POST['repeater_data']) && is_array($_POST['repeater_data'])) {
            $repeater_data = $_POST['repeater_data']; // Directly use the array from $_POST
            $sanitized_data = array_map(function ($item) {
                return [
                    'field_one' => sanitize_text_field($item['field_one']),
                    'field_two' => sanitize_text_field($item['field_two']),
                ];
            }, $repeater_data);

            // Save the sanitized data as serialized in post meta
            update_post_meta($post_id, '_repeater_field', $sanitized_data);
        }


    }

}