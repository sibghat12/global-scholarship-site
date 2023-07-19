<?php 

$home_page_id = get_the_ID();
$hero_section_title = get_field( 'hero_section_title', $home_page_id );
$hero_section_heading = get_field( 'hero_section_heading', $home_page_id );
$hero_section_text = get_field( 'hero_section_text', $home_page_id );
$hero_section_image = get_field( 'hero_section_image', $home_page_id );
$hero_section_button_title = get_field( 'hero_section_button_title', $home_page_id );
$hero_section_button = get_field( 'hero_section_button', $home_page_id );
$hero_section_image_id = $hero_section_image ?? $hero_section_image['ID'];


require get_stylesheet_directory() . '/components/partner-with-us/hero.php';

