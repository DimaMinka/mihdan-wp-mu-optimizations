<?php
/**
 * @link https://amp-wp.org/documentation/how-the-plugin-works/classic-templates/
 */

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'amp', array(
			'paired'              => true,
			//'templates_supported' => 'all',
		) );
	}
);

add_action(
	'amp_post_template_css',
	function ( $amp_template ) {
		// only CSS here please...
		?>
		header.amp-wp-header {
			background: #000;
		}
		header.amp-wp-header .amp-site-title {
			background-image: url( 'https://news-front.info/wp-content/themes/newsfront/img/logo-footer.png' );
			background-repeat: no-repeat;
			background-size: contain;
			display: inline-block;
			height: 28px;
			width: 94px;
			margin: 0 auto;
			text-indent: -9999px;
		}
		<?php
	}
);

add_filter(
	'amp_query_var',
	function ( $amp_endpoint ) {
		return 'amp';
	}
);

add_filter(
	'amp_post_article_header_meta',
	function ( $meta ) {
		foreach ( array_keys( $meta, 'meta-author', true ) as $key ) {
			unset( $meta[ $key ] );
		}

		return $meta;
	}
);

add_filter(
	'gettext',
	function ( $translation, $text, $domain ) {

		if ( 'amp' === $domain ) {
			switch ( $text ) {
				case 'Exit Reader Mode' : {
					$translation = 'Полная версия';
					break;
				}
			}
		}

		return $translation;
	},
	10,
	3
);

/**
 * Вертаем взад meta:description на АМР страницах.
 */
add_action(
	'amp_post_template_head',
	function ( $amp_template ) {
		if ( ! class_exists( 'WPSEO_Frontend' ) ) {
			return;
		}
		$wpseo = WPSEO_Frontend::get_instance();
		?>
		<meta name="description" content="<?php echo esc_html( $wpseo->metadesc( false ) ); ?>" />
		<?php
	}
);

// eol.
