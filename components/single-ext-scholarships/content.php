<?php

    // Scholarship Title from Post Title
    $scholarship_title = get_the_title(); 
    //Get Scholarship Custom Fields + Post Meta.

    // Scholarship Overview Wyswig
    $scholarship_overview_text = get_field('scholarship_overview');

    // Scholarship Disclaimer Wyswig
    $scholarship_disclaimer_text = get_field('disclaimer');

    
    $degrees = get_field('eligible_degrees');
    $degrees_text = convert_array_to_text($degrees);
    // This should be changed into Radio Button instead of checkbox since we only show one option
    $scholarship_host_country = get_field('host_country');
    
    $countries_field = get_field_object('field_6554776731838');
    $country_array_original = $countries_field['choices'];

    $scholarship_funded_by = get_field('funded_by');
    
    $scholarship_category = get_field('scholarship_category');
    $scholarship_type = get_field('scholarship_type');

    $scholarship_amount = get_field('amount_in_numbers');
    $scholarship_deadlines = get_field('scholarship_deadlines');
    
    $degrees = get_field('eligible_degrees');
    $degrees_text = convert_array_to_text($degrees);

    $number_of_recipients = get_field('number_of_recipients');
    $scholarship_duration = get_field('scholarship_duration');
    
    $nationalities_field = get_field_object('field_654dad4dd4ad4');

    $nationality_array_original = $nationalities_field['choices'];

    $eligible_nationalities = get_field('eligible_nationality');

    $programs = get_field('eligible_programs');

    $programs_field = get_field_object('field_654dad4dd4a9a');

    $programs_array_original = $programs_field['choices'];
    

    $eligible_institution_countries = get_field('eligible_institution_countries');

    $institution_countries_field = get_field_object('field_654db13f699f5');

    $institution_countries_array_original = $institution_countries_field['choices'];
    

    $coverage = get_field('scholarship_coverage');
    $eligibility_criteria = get_field('eligibility_criteria');
    
    echo '<pre>';
    print_r($eligibility_criteria);
    echo '</pre>';
    

    $application_procedure = get_field('application_procedure');

    echo '<pre>';
    print_r($application_procedure);
    echo '</pre>';
    
    $additional_scholarship_requirements = get_field('additional_scholarship_requirements');
    $helpful_links = get_field('helpful_links');

    $links = get_field('links');
    $creteria_page_link  = $links['eligible_criteria_link'];
    $scholarship_page_link = $links['scholarship_page_link'];
    $additional_scholarship_requirements_link = $links['additional_scholarship_requirements_link'];
    $scholarship_application_procedure_link = $links['scholarship_application_procedure_link'];
    $scholarship_deadline_link = $links['scholarship_deadline_link'];
    
    $scholarship_deadlines = get_field('scholarship_deadlines');
    
    // Institutions and Country's Institutions
    
    // Scholarship Eligible Institutions
    $scholarship_eligible_institutions = get_field('eligible_institutions');
    $eligible_institutions = [];
    
    foreach($scholarship_eligible_institutions as $institution) {

        // Loop of that Associated Institute to get Necessary custom fields

        $institution_query = get_institution_by_id($institution['institutions']->ID);
    
        while ($institution_query->have_posts() ) {
            $institution_query->the_post();
            $institution_name = get_the_title();

            array_push($eligible_institutions, $institution_name);

        }
        
        wp_reset_postdata();
        
    }

?>

    <section id="content" style="<?php esc_attr_e(apply_filters('awb_content_tag_style', '')); ?>">
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        
        <div class="post-content">
            
            <?php // GS External Scholarship Overview Box ?>
            <?php require get_stylesheet_directory() . '/components/single-ext-scholarships/scholarship-overview.php'; ?>

            
            <?php // GS External Scholarship Summary Box ?>
            <?php require get_stylesheet_directory() . '/components/single-ext-scholarships/scholarship-summary.php'; ?>


            <?php // GS External Scholarship Coverage ?>

            <?php require get_stylesheet_directory() . '/components/single-ext-scholarships/scholarship-coverage.php'; ?>
            <!-- Sibi Shortcode -->
            <aside><?php echo do_shortcode('[cta_post_shortcode title="Apply for 2024 Intake!" desc="Applications for 2024 Intake are open. Search through the degrees around the world!" link_url="/opencourses/" id="institution_opencourses_cta"]'); ?></aside>
           
            <?php // GS External Scholarship Eligibility Criteria ?>

            <?php require get_stylesheet_directory() . '/components/single-ext-scholarships/scholarship-eligibility-criteria.php'; ?>
           
            <?php // GS External Scholarship Application Process ?>

            <?php require get_stylesheet_directory() . '/components/single-ext-scholarships/scholarship-application-process.php'; ?>
            
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
