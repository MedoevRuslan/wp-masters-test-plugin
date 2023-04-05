<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

// Cleaning installed plugin fields in database !
$wpdb->query(
	"DELETE a, b, c
    FROM `wp_posts` a 
    LEFT JOIN `wp_term_relationships` b 
        ON (a.ID = b.object_id)
    LEFT JOIN `wp_postmeta` c 
        ON (a.ID = c.post_id)
    WHERE a.post_type = 'note'"
);

$wpdb->query(
	"DELETE a, b 
    FROM `wp_term_taxonomy` a
    LEFT JOIN `wp_terms` b 
        ON (a.term_id = b.term_id)
    WHERE a.taxonomy = 'note_category'"
);
