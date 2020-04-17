<?php
/**
 * Plugin Name: Mihdan: HTTP To HTTPS Via Htaccess
 */
add_filter(
	'mod_rewrite_rules',
	function ( $rules ) {

		$https = '';
		$https .= "# Редирект с HTTP на HTTPS.\n";
		$https .= "<IfModule mod_rewrite.c>\n";
		$https .= "RewriteEngine On\n";
		//$https .= "RewriteCond %{HTTPS} off\n";
		$https .= "RewriteCond %{HTTP:X-Forwarded-Proto} !https\n";
		$https .= "RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\n";
		$https .= "</IfModule>\n";

		return $https . $rules;
	}
);