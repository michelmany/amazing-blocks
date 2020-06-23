<?php

if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_sub_page(
		array(
			'page_title'  => 'Newsletter Settings',
			'menu_title'  => 'Settings',
			'parent_slug' => 'edit.php?post_type=sb-newsletter',
		)
	);
}
