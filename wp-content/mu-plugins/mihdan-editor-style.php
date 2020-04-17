<?php
/**
 * Plugin Name: Mihdan: Editor Style
 */
add_action(
	'after_setup_theme',
	function() {
		add_editor_style( plugin_dir_url( __FILE__ ) . 'css/editor.css?' . filemtime( plugin_dir_path( __FILE__ ) . 'css/editor.css' ) );
	}
);

add_action(
	'wp_enqueue_scripts',
	function() {
		wp_enqueue_style( 'editor', plugin_dir_url( __FILE__ ) . 'css/editor.css', [], filemtime( plugin_dir_path( __FILE__ ) . 'css/editor.css' ) );
	}
);

/**
 * Добавить кнопку на панель TinyMCE.
 */
add_filter(
	'mce_buttons_2',
	function( $buttons ) {
		$buttons[] = 'styleselect';

		return $buttons;
	}
);

add_filter(
	'tiny_mce_before_init',
	function( $init_array ) {

		$style_formats = array(
			array(
				'title' => 'Blockquote',
				'block' => 'blockquote',
				'classes' => 'mihdan-blockquote',
				'wrapper' => true,
			),
			array(
				'title' => 'Warning',
				'block' => 'blockquote',
				'classes' => 'mihdan-blockquote mihdan-blockquote--warning',
				'wrapper' => true,
			),
			array(
				'title' => 'Question',
				'block' => 'blockquote',
				'classes' => 'mihdan-blockquote mihdan-blockquote--question',
				'wrapper' => true,
			),
			array(
				'title' => 'Danger',
				'block' => 'blockquote',
				'classes' => 'mihdan-blockquote mihdan-blockquote--danger',
				'wrapper' => true,
			),
			array(
				'title' => 'Check',
				'block' => 'blockquote',
				'classes' => 'mihdan-blockquote mihdan-blockquote--check',
				'wrapper' => true,
			),
			array(
				'title' => 'Info',
				'block' => 'blockquote',
				'classes' => 'mihdan-blockquote mihdan-blockquote--info',
				'wrapper' => true,
			),
			array(
				'title' => 'Thumbs Up',
				'block' => 'blockquote',
				'classes' => 'mihdan-blockquote mihdan-blockquote--thumbs-up',
				'wrapper' => true,
			),
			array(
				'title' => 'Thumbs Down',
				'block' => 'blockquote',
				'classes' => 'mihdan-blockquote mihdan-blockquote--thumbs-down',
				'wrapper' => true,
			),
		);

		$init_array['style_formats'] = json_encode( $style_formats );

		return $init_array;
	}
);