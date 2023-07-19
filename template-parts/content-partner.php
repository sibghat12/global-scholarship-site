<?php 

$partner_with_us_page_id = get_the_ID();
$hero_section_title = get_field( 'hero_section_title', $partner_with_us_page_id );
$hero_section_heading = get_field( 'hero_section_heading', $partner_with_us_page_id );
$hero_section_text = get_field( 'hero_section_text', $partner_with_us_page_id );
$hero_section_image = get_field( 'hero_section_image', $partner_with_us_page_id );
$hero_section_button_title = get_field( 'hero_section_button_title', $partner_with_us_page_id );
$hero_section_button = get_field( 'hero_section_button', $partner_with_us_page_id );
$hero_section_image_id = $hero_section_image['ID'];

// GS Hero Section Partner With Us

require get_stylesheet_directory() . '/components/partner-with-us/hero.php';

