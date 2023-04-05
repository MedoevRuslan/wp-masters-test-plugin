<?php

/**
 *  Exclude `Uncategorized` from terms to display only defined categories
 */

$uncategorized_cat = get_term_by( 'name', 'uncategorized', 'note_category' )->term_id;
$terms = get_terms(
	array(
		'taxonomy' => 'note_category',
		'exclude' => $uncategorized_cat,
		'hide_empty' => false,
	)
);

?>

<div class="wrap">

	<h1 class="note-header"><?php esc_attr_e( 'Add new Note', 'wpm-notes' ); ?></h1>

	<form class="note-form" method="post">
		<?php wp_nonce_field( 'create_custom_post', 'notes_nonce' ); ?>
		<input class="note-title" type="text" name="note_title"  placeholder="<?php esc_attr_e( 'Note title', 'wpm-notes' ); ?>"/><br />
		<?php
		wp_editor(
			'',
			'note_content',
			array(
				'editor_height' => 250,
			)
		);
		?>
		<div class="row-group">
			<label class="label-wrap">
				<span><?php esc_html_e( 'Publication Status', 'wpm-notes' ); ?></span>
				<select name="note_status" id="note_status">
					<option value="publish">
						<?php esc_html_e( 'Published', 'wpm-notes' ); ?>
					</option>
					<option value="draft">
						<?php esc_html_e( 'Draft', 'wpm-notes' ); ?>
					</option>
				</select>
			</label>
			<label class="label-wrap">
				<span><?php esc_html_e( 'Note category', 'wpm-notes' ); ?></span>
				<select name="note-category" id="note-category">
					<option value="<?php esc_attr_e( $uncategorized_cat ); ?>" selected><?php esc_html_e( 'Choose category' ); ?></option>
					<?php foreach ( $terms as $term ) : ?>
						<option value="<?php echo esc_attr( $term->term_id ); ?>"><?php echo esc_html( $term->name ); ?></option>
					<?php endforeach; ?>
				</select>
			</label>
			<?php submit_button( __( 'Save changes', 'wpm-notes' ) ); ?>
		</div>
	</form>

</div>
