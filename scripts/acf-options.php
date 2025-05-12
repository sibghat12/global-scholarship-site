<?php
if ( function_exists( 'acf_add_options_page' ) ) :

	acf_add_options_page(
		array(
			'page_title'      => 'Synchronization',
			'menu_title'      => 'Synchronization',
			'menu_slug'       => 'synchronization',
			'capability'      => 'edit_posts',
			'position'        => '',
			'parent_slug'     => '',
			'icon_url'        => '',
			'redirect'        => true,
			'post_id'         => 'options',
			'autoload'        => false,
			'update_button'   => 'Update',
			'updated_message' => 'Options Updated',
		)
	);

	    
    acf_add_options_sub_page(array(
        'page_title'     => 'Update Institutions Deadlines',
        'menu_title'    => 'Update Institutions Deadlines',
        'parent_slug'    => 'edit.php?post_type=institution',
        'capability'     => 'edit_posts',
    ));

endif;
