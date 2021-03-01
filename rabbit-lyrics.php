<?php
/**
 * Plugin Name:     Rabbit Lyrics
 * Description:     JavaScript audio and timed lyrics synchronizer.
 * Version:         0.1.0
 * Author:          Guo Yunhe
 * License:         AGPL-3.0-or-later
 * License URI:     https://www.gnu.org/licenses/agpl-3.0.html
 * Text Domain:     rabbit-lyrics
 *
 * @package         rabbit-lyrics
 */

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function rabbit_lyrics_init() {
	$dir = __DIR__;

	// Eidtor scripts and styles

	$editor_script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $editor_script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "rabbit-lyrics" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$editor_script_asset = require( $editor_script_asset_path );
	wp_register_script(
		'rabbit-lyrics-editor',
		plugins_url( $index_js, __FILE__ ),
		$editor_script_asset['dependencies'],
		$editor_script_asset['version']
	);
	wp_set_script_translations( 'rabbit-lyrics-editor', 'rabbit-lyrics' );

	$editor_style = 'build/index.css';
	wp_register_style(
		'rabbit-lyrics-editor',
		plugins_url( $editor_style, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_style" )
	);

	// Page scripts and styles

	$script_asset_path = "$dir/build/script.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "rabbit-lyrics" block first.'
		);
	}
	$index_js     = 'build/script.js';
	$script_asset = require( $script_asset_path );
	wp_register_script(
		'rabbit-lyrics',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version']
	);

	$style = 'build/style-index.css';
	wp_register_style(
		'rabbit-lyrics',
		plugins_url( $style, __FILE__ ),
		array(),
		filemtime( "$dir/$style" )
	);

	// Theme styles

	$theme = wp_get_theme();
	if ( $theme->exists() ) {
		$theme_id = $theme->get( 'TextDomain' );
		if ( in_array($theme_id, ['twentytwenty', 'twentytwentyone']) ) {
			$theme_style = "themes/$theme_id.css";
			wp_register_style(
				"rabbit-lyrics-theme",
				plugins_url( $theme_style, __FILE__ ),
				array(),
				filemtime( "$dir/$theme_style" )
			);
			wp_enqueue_style( 'rabbit-lyrics-theme' );
		}
	}

	register_block_type(
		'rabbit-lyrics/lyrics',
		array(
			'editor_script' => 'rabbit-lyrics-editor',
			'editor_style'  => 'rabbit-lyrics-editor',
			'script'        => 'rabbit-lyrics',
			'style'         => 'rabbit-lyrics',
		)
	);
}
add_action( 'init', 'rabbit_lyrics_init' );
