<?php
//function disallow_insert_term( $term, $taxonomy ) {
//
//	$user = wp_get_current_user();
//
//	if ( 'post_tag' === $taxonomy && in_array('administrator', $user->roles ) ) {
//
//		return new WP_Error(
//			'disallow_insert_term',
//			__('Your role does not have permission to add terms to this taxonomy')
//		);
//
//	}
//
//	return $term;
//}
//add_filter( 'pre_insert_term', 'disallow_insert_term', 10, 2 );

/**
 * Запрещаем создание новых тегов для всех, кроме админа.
 *
 * @param $term_id
 * @param $tt_id
 * @param $taxonomy
 *
 * @return void
 */
function disallow_insert_term ( $term_id, $tt_id, $taxonomy ) {
	if ( ! current_user_can( 'administrator' ) )  {
		if ( $taxonomy === 'post_tag' ) {
			wp_delete_term( $term_id, $taxonomy );
		}
	}
}
add_action( 'create_term', 'disallow_insert_term', 10, 3 );
