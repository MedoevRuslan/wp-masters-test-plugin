<?php

/**
 * Class describes initial plugin activation
 */
class Wpmnotes_Activate {

	/**
	 * Static method activate plugin and initialize new custom post type 'Note'
	 */
	public static function activate() {
		if ( PHP_MAJOR_VERSION < 5.2 ) {
			die( esc_html_e( 'Please install php version >= 5.2 to activate this plugin' ) );
		}
		static::add_note_post_type();
		flush_rewrite_rules();
	}

	/**
	 * Adds new post type Note
	 *
	 * @return void
	 */
	public static function add_note_post_type() {
		register_post_type(
			'note',
			array(
				'label' => __( 'Notes', 'wpm-notes' ),
				'public' => true,
				'show_in_rest' => true,
				'supports' => array( 'title', 'editor', 'thumbnail' ),
				'has_archive' => true,
				'rewrite' => array( 'slug' => 'notes' ),
			)
		);
	}

	/**
	 * Method adds new category for Note and default terms
	 */
	public static function add_note_category() {
		$args = array(
			'label' => __( 'Note category', 'wpm-notes' ),
			'public' => true,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => 'note-category' ),
			'show_admin_column' => true,
			'show_in_rest' => true,
			'rest_base' => 'note_category',
		);

		register_taxonomy( 'note_category', 'note', $args );
		self::add_default_cat_terms();
	}

	/**
	 * Adds default terms to category
	 *
	 * @return void
	 */
	private static function add_default_cat_terms() {
		$terms = array(
			'Uncategorized',
			'Priority-1',
			'Priority-2',
			'Priority-3',
		);

		foreach ( $terms as $term ) {
			$term_exists = term_exists( $term, 'note_category' );

			if ( ! $term_exists ) {
				wp_insert_term( $term, 'note_category' );
			}
		}
	}

	/**
	 * Static method deactivate plugin
	 */
	public static function deactivate() {
		// Some logic that triggers when plugin is deactivated !
	}
}


