<?php

    // Scholarship Title from Post Title
    $scholarship_title = get_the_title(); 
    //Get Scholarship Custom Fields + Post Meta.

    $scholarship_type = get_field('amount_category');
    $scholarship_amount = get_field('amount_in_numbers');
    $scholarship_deadline = get_field('scholarship_deadline');
    $degrees = get_field('eligible_degrees');
    $degrees_text = convert_array_to_text($degrees);

    $number_of_recipients = get_field('number_of_recipients');
    $scholarship_duration = get_field('scholarship_duration');


    $separate_application = get_field('separate_application');

    $scholarship_details  = acf_get_fields('group_62ca6e3cc910c');
    $country_array_original = $scholarship_details[13]['choices'];



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
    

    //Get Associated Institute Object
    $institution = get_field("scholarship_institution");
    
    $scholarships_query = get_scholarships($institution->ID);
    $number_of_scholarships  = $scholarships_query->post_count;
    
    // Loop of that Associated Institute to get Necessary custom fields
    $institution_query = get_institution_by_id($institution->ID);

    while ($institution_query->have_posts() ) {
        $institution_query->the_post();
        $institution_name = get_the_title();
        $founded_year = get_field('founded_year');
        $institution_type = get_field('type');
        
        

        $institution_description =  get_field('description');
        $rankings =  get_field('rankings');
        $ranking_array = get_ranking_with_name($rankings);
    }
    
    wp_reset_postdata();
    
    
    $city = get_post($institution->cities);
    $city_name = get_the_title($city);
    $country_name = get_post_meta($city->ID, 'country', TRUE);

    $currency = get_currency($country_name);
    
    if ($institution){
    
        $title = $scholarship_title . " at " . $institution_name;
    } else {
    
        $title = $scholarship_title;
    }
    
    
    $lowercase = strtolower($country_name);
    $hyphenated = str_replace(' ', '-', $lowercase);

    $degrees_formatted_array = [];
    foreach($degrees as $value) {
    $degrees_formatted_array[] = strtolower(str_replace("'", "", $value));
    }


?>
    
    <div id="ezoic-pub-ad-placeholder-863"> </div>

<main id="main" class="clearfix width-100">
    <div class="fusion-row" style="max-width:100%;">

    <section id="content" style="<?php esc_attr_e(apply_filters('awb_content_tag_style', '')); ?>">
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        
        <div class="post-content">
            
            <div id="adngin-top_leaderboard-0"></div>

            <?php // GS Scholarship Overview Box ?>
            <?php require get_stylesheet_directory() . '/components/single-scholarships/scholarship-overview.php'; ?>

            <?php // GS Scholarship Summary Box ?>
            <?php require get_stylesheet_directory() . '/components/single-scholarships/scholarship-summary.php'; ?>
            
            <?php // GS Scholarship Coverage ?>
            <?php require get_stylesheet_directory() . '/components/single-scholarships/scholarship-coverage.php'; ?>

            <?php // GS Scholarship Eligibility Criteria ?>
            <?php require get_stylesheet_directory() . '/components/single-scholarships/scholarship-eligibility-criteria.php'; ?>
            <?php // GS Scholarship Application Procedure ?>
            <?php require get_stylesheet_directory() . '/components/single-scholarships/scholarship-procedure.php'; ?>

            <?php // GS Scholarship Deadline ?>
            <?php require get_stylesheet_directory() . '/components/single-scholarships/scholarship-deadline.php'; ?>

            <?php // GS Scholarship Outro ?>
            <?php require get_stylesheet_directory() . '/components/single-scholarships/scholarship-outro.php'; ?>

        </div>

    </div>
    </section>

    </div>
</main>