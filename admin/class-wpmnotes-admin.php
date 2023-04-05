<?php

/**
 * Class describes methods to add plugin's button to admin menu render page with applied styles
 */
class Wpmnotes_Admin {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_page' ) );
	}

	/**
	 *  Plugin button to admin menu page
	 */
	public function add_admin_page() {
		$hook_suffix = add_menu_page(
			__( 'WPM Notes', 'wpm-notes' ),
			__( 'WPM Notes', 'wpm-notes' ),
			'manage_options',
			'wpm-posts',
			array( $this, 'render_page' ),
			'dashicons-admin-appearance'
		);

		// Connect styles and scripts to this page !
		add_action( "admin_print_scripts-{$hook_suffix}", array( $this, 'admin_scripts' ) );
	}

	public function render_page() {
		require_once WPM_PLUGIN_DIR . 'templates/admin/new-note.php';
	}

	public function admin_scripts() {
			wp_enqueue_style( 'wpm-admin', WPM_PLUGIN_URL . 'admin/css/wpm-admin.css', array(), WPM_PLUGIN_VERSION );
			wp_enqueue_script( 'wpm-admin', WPM_PLUGIN_URL . '/admin/js/wpm-admin.js', array(), WPM_PLUGIN_VERSION, true );
	}
}
