<?php

    $institution_id = get_the_ID();
    $institution_title = get_the_title();

    $ibl = get_field("tuition_fee_international_lower");
    $ibu = get_field("tuition_fee_upper_tuition_fee");
    $iml = get_field("masters_tuition_fee_international_lower");
    $imu = get_field("masters_tuition_fee_upper_tuition_fee");
    
    $city = get_post(get_field('cities'));
    $city_name = get_the_title($city);
    // Check if city contains a comma (,)
    if (strpos($city_name, ',') !== false) {
        
        // Split the string by comma
        $parts = explode(',', $city_name);
    
        // Remove the word after the comma
        $city_name = trim($parts[0]);
    }
    
    $country_name = get_post_meta($city->ID, 'country', TRUE);
    $current_currency = get_currency($country_name);

    $current_currency = get_currency($country_name);


    // /currently-open-scholarships-canada/
    $currently_open_scholarships_country  =  strtolower($country_name);
    $currently_open_scholarships_country = str_replace(" ","-", $currently_open_scholarships_country);
    // Get Currently Open Scholarships in Link of the Country based on institution Location ( even it is city, state it will return the Country in which this city or state located )
    $currently_open_scholarships_by_country = site_url() . '/currently-open-scholarships-' .  $currently_open_scholarships_country . '/';

    $currencyUSD = 'USD';

    //  the convert from local currency to USD
    $iblUSD = ($ibl > 0) ? number_format(roundNearestHundreth(convert_to_usd($ibl, $current_currency))) : 0;
    $ibuUSD = ($ibu > 0) ? number_format(roundNearestHundreth(convert_to_usd($ibu, $current_currency))) : 0;
    $imuUSD = ($imu > 0) ? number_format(roundNearestHundreth(convert_to_usd($imu, $current_currency))) : 0;
    $imlUSD = ($iml > 0) ? number_format(roundNearestHundreth(convert_to_usd($iml, $current_currency))) : 0;  


    if (get_field("tuition_fee_international_lower") == -1){
        $ibl = -1; 
    }

    if (get_field("tuition_fee_upper_tuition_fee") == -1){
        $ibu = -1; 
    }

    if (get_field("masters_tuition_fee_international_lower" ) == -1){
        $iml = -1; 
    }

    if (get_field("masters_tuition_fee_upper_tuition_fee") == -1){
        $imu = -1; 
    }


    //Checks if there are tuition information. This is used for titles
    if ($ibl == -1 && $ibu == -1 && $iml == -1 && $imu == -1){
        $is_tuition_information = false;
    } else {
        $is_tuition_information = true;
    }


    $currency = get_currency($country_name);    
    $lowercase = strtolower($country_name);
    $hyphenated = str_replace(' ', '-', $lowercase);


    $scholarships_query = get_scholarships($post->ID);
    $number_of_scholarships  = $scholarships_query->post_count;

    if(empty($number_of_scholarships)) {
        $number_of_scholarships =  '0';
    } else {
        $number_of_scholarships = $number_of_scholarships;
    }
    
    

    $title = $institution_title . " " . " Scholarships for International Students";


                            
    $institution_type = get_field("type");
    $description = get_field("description"); 
    $tuition_fee = get_field('tuition_fee');

    // $ibl = $tuition_fee['international_lower'];
    // $ibu = $tuition_fee['upper_tuition_fee'];

    $admission_pages = get_field("admissions_pages");
    $application_video = get_field("application_video");
    $scholarship_video = get_field("scholarship_video");

    $admission_deadlines = get_field("admission_deadlines");


    $name = get_the_title();
    $type = get_field('type');
    $founded_year = get_field('founded_year');

    $enrollments = get_field('enrollment');
    $total_students = $enrollments['total'];
    $total_students_formatted = number_format(roundNearestHundreth($total_students));
    $international = $enrollments['international'];
                
                
    $average_ranking_value = get_post_meta(get_the_ID(), 'average_rankings', true);
    $average_ranking_value = round((int) $average_ranking_value);


    // Bachlerors Courses String
    $bachelor_courses = get_field('bachelors_courses');
    $bachelor_courses = $bachelor_courses['courses'];
    $bachelor_courses_string = get_formatted_courses($bachelor_courses);



    // Master's Courses String
    $master_courses = get_field('masters_courses');
    $master_courses = $master_courses['courses'];
    $master_courses_string = get_formatted_courses($master_courses);


    //get_scholarships gets all the scholarships custom post type that are associated with the institution name.
    //The function is in functions/scholarships-functions.php

    $scholarships_query = get_scholarships(get_the_ID());
    $number_of_scholarships  = $scholarships_query->post_count;

    $undergraduate_list = get_graduate_undergraduate_list($scholarships_query , "undergraduate");
    $graduate_list =      get_graduate_undergraduate_list($scholarships_query , "graduate");


    //Checks if there is scholarship information. This is also used for titles


    if($number_of_scholarships > 0){
        $is_scholarship_information = true;
    } else {
        $is_scholarship_information = false;                
    }

    //Generate Title using the tuition and scholarship information
    $title_bread = $title;

    // if ($is_scholarship_information){
    //     $title = $name . " Scholarships for International Students";            
    // } else if ($is_tuition_information){
    //     $title = $name . " Tuition for International Students";
    // } else {
    //     $title = $name . " Background Information ";           
    // }



    //$current_currency is the currency of the institution's country. We use that for scholarship amount
    //We are using USD though for tuition fees
                
    $lowercase = strtolower($country_name);
    $hyphenated = str_replace(' ', '-', $lowercase);
    $degrees_scholarships = array();
    $scholarships_category = array();

    while ($scholarships_query->have_posts() ) {
        $scholarships_query->the_post();
        $category = get_field('amount_category');
        array_push($scholarships_category, $category);
        
        $degrees = get_field('eligible_degrees');
        
        if (in_array("Bachelor's", $degrees)){
        array_push($degrees_scholarships, "Bachelor's");
        }

        if (in_array("Master's", $degrees)){
        array_push($degrees_scholarships, "Master's");
        }

        if (in_array("PhD", $degrees)){
        array_push($degrees_scholarships, "PhD");
        }
    }

    // Custom comparison function to sort funding types
    function compare_funding_types($a, $b) {
        $order = array("Partial Funding", "Full Tuition", "Full Funding");
        $a_index = array_search($a, $order);
        $b_index = array_search($b, $order);
        return $a_index - $b_index;
    }

    $category_for_breadcrumb = array_values(array_unique($scholarships_category));
    // Sort the array using the custom comparison function
    usort($category_for_breadcrumb, "compare_funding_types");
    $categories_formatted_array = [];

    foreach($category_for_breadcrumb as $value) {
        $categories_formatted_array[] = strtolower(str_replace(" ", "-", $value));
    }



    $degrees_for_breadcrumb = array_values(array_unique($degrees_scholarships));
    sort($degrees_for_breadcrumb);
    $degrees_formatted_array = [];
    foreach($degrees_for_breadcrumb as $value) {
        $degrees_formatted_array[] = strtolower(str_replace("'", "", $value));
    }

    $degrees_text = formatArrayToString($degrees_for_breadcrumb);

    
?>
    
    <main id="main">
        <div class="fusion-row">

            <section id="content" style="<?php esc_attr_e(apply_filters('awb_content_tag_style', '')); ?>">
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    
                    <div class="post-content">
                        
                        <?php // GS Institution Overview Box ?>
                        <?php require get_stylesheet_directory() . '/components/single-institutions/institution-overview.php'; ?>
                        
                        <?php // GS Institution Navigation Panel ?>
                        <?php require get_stylesheet_directory() . '/components/single-institutions/institution-navigation-panel.php'; ?>

                        <?php if (function_exists ('adinserter')) echo adinserter (7); ?>
                        
                        <?php // GS Institution Intro ?>
                        <?php require get_stylesheet_directory() . '/components/single-institutions/institution-intro.php'; ?>
                        
                        <?php if (function_exists ('adinserter')) echo adinserter (8); ?>

                        <?php // GS Institution Admissions ?>
                        <?php require get_stylesheet_directory() . '/components/single-institutions/institution-admissions.php'; ?>
                        <?php if (function_exists ('adinserter')) echo adinserter (9); ?>

                        <?php // GS Institution Deadlines ?>
                        <?php require get_stylesheet_directory() . '/components/single-institutions/institution-deadlines.php'; ?>
                        <?php if (function_exists ('adinserter')) echo adinserter (10); ?>

                        <?php // GS Institution Tuition Fees ?>
                        <?php require get_stylesheet_directory() . '/components/single-institutions/institution-tuition-fees.php'; ?>
                        <?php if (function_exists ('adinserter')) echo adinserter (10); ?>

                        <?php // GS Institution Scholarships ?>
                        <?php require get_stylesheet_directory() . '/components/single-institutions/institution-scholarships.php'; ?>

                        <?php // GS Institution Conclusion ?>
                        <?php require get_stylesheet_directory() . '/components/single-institutions/institution-conclusion.php'; ?>
                        <?php if (function_exists ('adinserter')) echo adinserter (10); ?>

                        <?php // GS Institution Share Media ?>
                        <?php require get_stylesheet_directory() . '/components/single-institutions/institution-social-media-share.php'; ?>
                        
                        <?php // GS Institution Navigation ?>
                        <?php require get_stylesheet_directory() . '/components/single-institutions/institution-navigation.php'; ?>

                        <?php 
                        if ( comments_open() || get_comments_number() ) {
                            comments_template();
                        }
                        ?>

                    </div>
  
                    <?php // GS Institution Newsletter ?>
                        <?php require get_stylesheet_directory() . '/components/single-institutions/newsletter.php'; ?>

                </div>
            </section>

        </div>
    </main>