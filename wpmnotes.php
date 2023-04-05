<?php

/**
 * Plugin Name:       Wp Masters Custom Post Creator
 * Plugin URI:        https://example.com/plugins/wp-masters-cusom-post-creator/
 * Description:       Creates custom post with type of Note
 * Version:           0.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Ruslan Medoev
 * Author URI:        https://cv-portfolio-swart.vercel.app/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/wp-masters-cusom-post-creator/
 * Text Domain:       wpm-notes
 * Domain Path:       /languages
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2023 Ruslan Medoev, Inc.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WPM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WPM_PLUGIN_NAME', dirname( plugin_basename( __FILE__ ) ) );


if ( is_admin() ) {
	if ( ! function_exists( 'get_plugin_data' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	define( 'WPM_PLUGIN_VERSION', get_plugin_data( __FILE__ )['Version'] );
}

require_once WPM_PLUGIN_DIR . 'includes/class-wpmnotes-activate.php';
require_once WPM_PLUGIN_DIR . 'includes/class-wpmnotes.php';

function wpmnotes_activate() {
	Wpmnotes_Activate::activate();
}

function wpmnotes_deactivate() {
	Wpmnotes_Activate::deactivate();
}

$wpnotes = new Wpmnotes();

add_action( 'init', array( 'Wpmnotes_Activate', 'add_note_post_type' ) );
add_action( 'init', array( 'Wpmnotes_Activate', 'add_note_category' ) );
add_action( 'init', array( $wpnotes, 'validate_post' ) );

register_activation_hook( __FILE__, 'wpmnotes_activate' );
register_deactivation_hook( __FILE__, 'wpmnotes_deactivate' );
