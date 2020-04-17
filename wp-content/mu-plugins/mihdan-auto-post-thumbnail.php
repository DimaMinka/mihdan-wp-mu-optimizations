<?php
/**
 * Plugin Name: Auto Post Thumbnail
 * Author: mikhail@kobzarev.com
 */
namespace Mihdan\Auto_Post_Thumbnail;

/**
 * Возвращает ID медиафайла по переданному URL.
 *
 * @param  string $url Ссылка на файл в любом формате, вплоть до image.jpg или просто name_image
 * @return int    $attachment_id  ID медифайла
 * ver 1.0
 */
function attachment_url_to_post_id( $url = null ){
	global $wpdb;

	if( ! $url )
		return false;

	$name = basename( $url ); // имя файла

	// удалим размер миниатюры (-80x80) из URL.
	$name = preg_replace('~-[0-9]+x[0-9]+(?=\..{2,6})~', '', $name );
	// Избавляемся от расширения, так как в базе имена файлов без расширения
	$name = preg_replace('~\.[^.]+$~', '', $name );

	// очистим чтобы привести к стандартному виду.
	$name = sanitize_title( sanitize_file_name( $name ) );

	// Запрос в базу по полю post_name и post_type. Поля индексируемые, а значит поиск по ним очень быстрый.
	$wild = '%';
	$attachment_id = $wpdb->get_var(
		$wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name LIKE %s AND post_type = 'attachment'", $wild . $wpdb->esc_like( $name  ) . $wild )
	);

	return intval( $attachment_id );
}

function set_post_thumbnail( $post_id, \WP_Post $post ) {
	if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
		return;
	}

	if ( has_post_thumbnail( $post_id ) ) {
		return;
	}

	$attachments = get_attached_media( 'image', $post_id );

	// Если есть загруженные для поста фотки,
	// береём первую и делаем обложкой.
	if ( $attachments ) {
		$keys = array_reverse( $attachments );
		\set_post_thumbnail( $post_id, $keys[0]->ID );

		return;
	};

	// Если в содержимом записи есть фотки,
	// берем первую, получаем по адресу ID вложения
	// (так надо когда фотка есть в медиатеке, но не загружена для текущего поста)
	// Делаем её обложкой.
	$document = new \DOMDocument( '1.0', 'UTF-8' );
	$html     = mb_convert_encoding( $post->post_content, 'HTML-ENTITIES', 'UTF-8' );
	$document->loadHTML( $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
	$xpath    = new \DOMXPath( $document );
	$images   = $xpath->query( '//img[@src]' );
	$count    = count( $images );

	if ( $count ) {
		/** @var \DOMElement $image */
		$image = $images[0];
		$src   = $image->getAttribute( 'src' );
		$attachment_id = attachment_url_to_post_id( $src );

		if ( $attachment_id ) {
			\set_post_thumbnail( $post_id, $attachment_id );

			return;
		}
	}
}

add_action( 'save_post', __NAMESPACE__ . '\set_post_thumbnail', 10, 2 );

// eol.