<?php

require_once plugin_dir_path( __FILE__ ) . 'settings.php';
require_once plugin_dir_path( __FILE__ ) . 'cpt.php';

/*
* Creating Custom Newsletter Archive Page
*/

add_filter( 'template_include', 'newsletter_archive_template' );

function newsletter_archive_template( $template ) {
	if ( is_post_type_archive( 'sb-newsletter' ) ) {
		$theme_files     = array( 'archive-sb-newsletter.php', 'skinny-blocks-premium/archive-sb-newsletter.php' );
		$exists_in_theme = locate_template( $theme_files, false );
		if ( $exists_in_theme != '' ) {
			return $exists_in_theme;
		}
		return plugin_dir_path( __FILE__ ) . 'archive-sb-newsletter.php';
	}
	return $template;
}

/*
:: I am going to use this in case we decide to only change the post url ::

function append_query_string( $url, $post ) {
	if ( 'sb-newsletter' === get_post_type( $post ) ) {
		return "add_query_arg( $_GET, $url )";
	}
	return $url;
}
add_filter( 'post_type_link', 'append_query_string', 10, 2 );
*/
