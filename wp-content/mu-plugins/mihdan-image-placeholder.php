<?php
/**
 * Plugin Name: Mihdan: Image Placeholder
 */

namespace Mihdan_Image_Placeholder;

$images = array(
	// Обычные
	'https://placeimg.com/640/480/animals',
	'https://placeimg.com/640/480/arch',
	'https://placeimg.com/640/480/nature',
	'https://placeimg.com/640/480/people',
	'https://placeimg.com/640/480/tech',
	'https://placeimg.com/640/480/any',

	// Черно-белые
	'https://placeimg.com/640/480/animals/grayscale',
	'https://placeimg.com/640/480/arch/grayscale',
	'https://placeimg.com/640/480/nature/grayscale',
	'https://placeimg.com/640/480/people/grayscale',
	'https://placeimg.com/640/480/tech/grayscale',
	'https://placeimg.com/640/480/any/grayscale',

	// Sepia
	'https://placeimg.com/640/480/animals/sepia',
	'https://placeimg.com/640/480/arch/sepia',
	'https://placeimg.com/640/480/nature/sepia',
	'https://placeimg.com/640/480/people/sepia',
	'https://placeimg.com/640/480/tech/sepia',
	'https://placeimg.com/640/480/any/sepia',
);

/**
 * Проверяем все ссылки на картинки и ставим
 * заглушку в случае их отсутствия
 *
 * @param $image
 *
 * @return mixed
 */
function set_placeholder( $image ) {

	global $images;

	// Переводим абсолютный URL в относительный путь по серверу.
	$path = $_SERVER['DOCUMENT_ROOT'] . wp_make_link_relative( $image[0] );

	// Если по пути нет файла - подсовываем заглушку.
	if ( ! file_exists( $path ) ) {

		// Выбираем случайный плейсхолдер из массива.
		$image[0] = $images[ array_rand( $images ) ];
	}

	return $image;
}
add_filter( 'wp_get_attachment_image_src', __NAMESPACE__ . '\set_placeholder' );

// eof;
