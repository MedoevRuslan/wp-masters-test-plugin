<?php

/**
 * Main class of WPM-Notes plugin
 */
class Wpmnotes {

	/**
	 * Class constructor init all hooks and main dependencies
	 */
	public function __construct() {
		$this->load_dependencies();
		$this->init_hooks();
		$this->define_admin_hooks();
	}

	/**
	 * Load admin dependencies
	 *
	 * @return void
	 */
	private function load_dependencies() {
		require_once WPM_PLUGIN_DIR . 'admin/class-wpmnotes-admin.php';
	}

	/**
	 * Initializing hooks
	 *
	 * @return void
	 */
	private function init_hooks() {
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
	}

	/**
	 * Load text domain for translations
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'wpm-notes', false, WPM_PLUGIN_NAME . '/languages/' );
	}

	/**
	 * Creates new Wpmnotes_Admin object and invoke all admin hooks
	 */
	private function define_admin_hooks() {
		new Wpmnotes_Admin();
	}

	/**
	 * Method validates post method to add new Note post to database
	 */
	public function validate_post() {

		if ( ! isset( $_POST['notes_nonce'] ) || ! wp_verify_nonce( $_POST['notes_nonce'], 'create_custom_post' ) ) {
				return;
		}

			wp_insert_post(
				array(
					'post_type' => 'note',
					'post_title' => sanitize_text_field( $_POST['note_title'] ),
					'post_content' => $_POST['note_content'],
					'post_status' => $_POST['note_status'],
					'tax_input' => array(
						'note_category' => array( $_POST['note-category'] ),
					),
				)
			);
	}
}


