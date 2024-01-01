<?php

    // Scholarship Title from Post Title
    $scholarship_title = get_the_title(); 
    //Get Scholarship Custom Fields + Post Meta.

    // Scholarship Overview Wyswig
    $scholarship_overview_text = get_field('scholarship_overview');

    // Scholarship Disclaimer Wyswig
    $scholarship_disclaimer_text = get_field('disclaimer');

    // Scholarship Eligible Institutions
    $scholarship_eligible_institutions = get_field('eligible_institutions');
    
    $degrees = get_field('eligible_degrees');
    $degrees_text = convert_array_to_text($degrees);

    $scholarship_host_countries = get_field('host_country');
    
    $countries_field = get_field_object('field_6554776731838');
    $country_array_original = $countries_field['choices'];

    // echo '<pre>';
    // print_r($country_array_original);
    // echo '</pre>';
    

     
    $scholarship_type = get_field('amount_category');
    $scholarship_amount = get_field('amount_in_numbers');
    $scholarship_deadline = get_field('scholarship_deadline');
    $degrees = get_field('eligible_degrees');
    $degrees_text = convert_array_to_text($degrees);

    $number_of_recipients = get_field('number_of_recipients');
    $scholarship_duration = get_field('scholarship_duration');


    $separate_application = get_field('separate_application');

    $countries_field = get_field_object('field_62ca6ed806bc6');

    $country_array_original = $countries_field['choices'];


    $countries = get_field('eligible_nationality');
    

    $countries = convert_array_to_text($countries);
    $coverage = get_field('scholarship_coverage');
    $eligibility_criteria = get_field('eligibility_criteria');
    
    

    $application_procedure = get_field('application_procedure');
    $additional_scholarship_requirements = get_field('additional_scholarship_requirements');
    $helpful_links = get_field('helpful_links');

    $links = get_field('links');
    $creteria_page_link  = $links['eligible_criteria_link'];
    $scholarship_page_link = $links['scholarship_page_link'];
    $additional_scholarship_requirements_link = $links['additional_scholarship_requirements_link'];
    $scholarship_application_procedure_link = $links['scholarship_application_procedure_link'];
    $scholarship_deadline_link = $links['scholarship_deadline_link'];
    
    $scholarship_deadlines = get_field('scholarship_deadlines');
    

    // echo '<pre>';
    // print_r($scholarship_eligible_institutions);
    // echo '</pre>';
    $eligible_institutions = [];
    
    foreach($scholarship_eligible_institutions as $institution) {

        // Loop of that Associated Institute to get Necessary custom fields

        $institution_query = get_institution_by_id($institution['institutions']->ID);
    
        while ($institution_query->have_posts() ) {
            $institution_query->the_post();
            $institution_name = get_the_title();

            array_push($eligible_institutions, $institution_name);

            
            // $founded_year = get_field('founded_year');
            // $institution_type = get_field('type');
            
            
    
            // $institution_description =  get_field('description');
            // $rankings =  get_field('rankings');
            // $ranking_array = get_ranking_with_name($rankings);
        }
        
        wp_reset_postdata();
        
    }


?>
    
<main id="main">
    <div class="fusion-row">

    <section id="content" style="<?php esc_attr_e(apply_filters('awb_content_tag_style', '')); ?>">
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        
        <div class="post-content">
            
            <?php // GS External Scholarship Overview Box ?>
            <?php require get_stylesheet_directory() . '/components/single-ext-scholarships/scholarship-overview.php'; ?>

            
            <?php // GS External Scholarship Summary Box ?>
            <?php require get_stylesheet_directory() . '/components/single-ext-scholarships/scholarship-summary.php'; ?>



            <?php 
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
            ?>

        </div>
        <?php // GS Scholarships Newsletter ?>
            <?php require get_stylesheet_directory() . '/components/single-ext-scholarships/newsletter.php'; ?>

    </div>
    </section>

    </div>
</main>