<?php
/**
 * Plugin Name: Mihdan: WP Rocket Deep Settings
 * Description: Глубокая настройка плагина WP Rocket
 * Author: Mikhail Kobzarev
 * Author URI: https://www.kobzarev.com/
 * Version: 1.0
 */

/**
 * Включить кеширование результатов поиска
 */
add_filter( 'rocket_cache_search', '__return_true' );

//add_filter('rocket_htaccess_charset', '__return_false');
//add_filter('rocket_htaccess_etag', '__return_false');
//add_filter('rocket_htaccess_web_fonts_access', '__return_false');
//add_filter('rocket_htaccess_files_match', '__return_false');
//add_filter('rocket_htaccess_mod_expires', '__return_false');
//add_filter('rocket_htaccess_mod_deflate', '__return_false');
//add_filter('rocket_htaccess_mod_rewrite', '__return_false');
//add_filter( 'do_rocket_generate_caching_files', '__return_false' );
//add_filter( 'do_run_rocket_bot', '__return_false');
//add_filter( 'rocket_minify_filename_length', '');
//add_filter( 'rocket_minify_excluded_external_js', '');

// Дебаг минификации скриптов и стлей
//add_filter( 'rocket_minify_debug', '__return_true');

/**
 * Запретим ракете чистить кеш при любом чихе
 */
remove_action( 'switch_theme', 'rocket_clean_domain' );        // When user change theme
remove_action( 'user_register', 'rocket_clean_domain' );        // When a user is added
remove_action( 'profile_update', 'rocket_clean_domain' );        // When a user is updated
remove_action( 'deleted_user', 'rocket_clean_domain' );        // When a user is deleted
remove_action( 'wp_update_nav_menu', 'rocket_clean_domain' );        // When a custom menu is update
//remove_action( 'permalink_structure_changed', 'rocket_clean_domain' ); 	// When permalink structure is update
remove_action( 'create_term', 'rocket_clean_domain' );        // When a term is created
remove_action( 'edited_terms', 'rocket_clean_domain' );        // When a term is updated
remove_action( 'delete_term', 'rocket_clean_domain' );        // When a term is deleted
remove_action( 'customize_save', 'rocket_clean_domain' );        // When customizer is saved
remove_action( 'wp_trash_post', 'rocket_clean_post' );
//remove_action( 'delete_post', 'rocket_clean_post' );
//remove_action( 'clean_post_cache', 'rocket_clean_post' );
remove_action( 'wp_update_comment_count', 'rocket_clean_post' ); 