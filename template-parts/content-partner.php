<?php 

$partner_with_us_page_id = get_the_ID();
// Hero Section
$hero_section_title = get_field( 'hero_section_title', $partner_with_us_page_id );
$hero_section_heading = get_field( 'hero_section_heading', $partner_with_us_page_id );
$hero_section_text = get_field( 'hero_section_text', $partner_with_us_page_id );
$hero_section_image = get_field( 'hero_section_image', $partner_with_us_page_id );
$hero_section_button_title = get_field( 'hero_section_button_title', $partner_with_us_page_id );
$hero_section_button = get_field( 'hero_section_button', $partner_with_us_page_id );
$hero_section_image_id = $hero_section_image['ID'];

$partner_with_us_sections = get_field('partner_with_us_sections', $partner_with_us_page_id);

// Why Us Section
$why_us_section = $partner_with_us_sections['why_us_section'];
$why_us_box_heading = $why_us_section['why_us_box_heading'];
$why_us_box_text = $why_us_section['why_us_box_text'];
$why_us_boxes = $why_us_section['why_us_answers_boxes'];

// Promote Section
$promote_section = $partner_with_us_sections['promote_section'];
$promote_box = $promote_section['promote_box'];

// Get Started Section

$get_started_section =  $partner_with_us_sections['get_started_section'];
$get_started_image = wp_get_attachment_image($get_started_section['get_started_image'], 'full');
$get_started_heading = $get_started_section['get_started_heading'];
$get_started_description = $get_started_section['get_started_description'];
$get_started_link = $get_started_section['get_started_link']; // absolute not the whole link

// Our Partners Section

$our_partners_section =  $partner_with_us_sections['our_partners_section'];
$our_partners_heading =  $our_partners_section['our_partner_heading'];
$our_partner_description =  $our_partners_section['our_partner_description'];
$our_partners_images =  $our_partners_section['our_partners_images'];

// Testimonials Section

$testimonials_section = $partner_with_us_sections['testimonials_section'];
$testimonials_heading = $testimonials_section['testimonials_heading'];
$testimonials_text = $testimonials_section['testimonials_text'];
$testimonials = $testimonials_section['testimonials'];

// echo '<pre>';
// print_r($testimonials_heading);
// echo '</pre>';


// GS Hero Section Partner With Us

require get_stylesheet_directory() . '/components/partner-with-us/hero.php';

// GS Why Us Section Partner With Us

require get_stylesheet_directory() . '/components/partner-with-us/why-us.php';

// GS What Promote Partner With Us

require get_stylesheet_directory() . '/components/partner-with-us/promote.php';

// GS Get Started Partner With Us

require get_stylesheet_directory() . '/components/partner-with-us/get-started.php';

// GS Our Partners Partner With Us

require get_stylesheet_directory() . '/components/partner-with-us/our-partners.php';

// GS Testimonials Partner With Us (commented out once we have enough testimonials)

require get_stylesheet_directory() . '/components/partner-with-us/testimonials.php';

// GS Pricing Partner With Us

require get_stylesheet_directory() . '/components/partner-with-us/pricing.php';

// GS Partner Form Partner With Us

require get_stylesheet_directory() . '/components/partner-with-us/partner-form.php';

// GS Partner Contact Partner With Us

require get_stylesheet_directory() . '/components/partner-with-us/partner-contact.php';

