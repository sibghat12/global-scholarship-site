<?php



// function get_institution_id_by_title($title){
//    $page = get_page_by_title($title , OBJECT, "institution");
//    return $page->ID;
// }


// Gets scholarships by institution name
//include dirname(__FILE__) . "/countries_list.php"; 


function get_scholarships($institution_id){
     
   $args = array(
        'post_type' => 'scholarships',
        'posts_per_page' => -1,

         'no_found_rows' => true, 
         'update_post_meta_cache' => false,
         'update_post_term_cache' => false,
         'cache_results'          => false,
         'fields' => 'ids',

        'meta_key' => "scholarship_institution",
        'meta_value' => $institution_id,
        'post_status' => 'publish',
    );
    
    $query = new WP_Query($args);
   
    return $query;
 
}

// Gets scholarships by country
//include dirname(__FILE__) . "/countries_list.php"; 


function get_fully_funded_scholarships($institution_ids) {

    $args = array(
        'post_type' => 'scholarships',
        'posts_per_page' => -1,

        'no_found_rows' => true, 
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results' => false,
        'fields' => 'ids',

        'post_status' => 'publish',

        'meta_query' => array(
            array(
                'key' => 'amount_category',
                'value' => 'Full Funding',
                'compare' => '='
            ),
            array(
                'key' => 'scholarship_institution',
                'value' => $institution_ids,
                'compare' => '='
            )
        ),
    );

    $query = new WP_Query($args);

    return $query;
}

// Input :  Give field + type (Criteria or Coverage).
// OutPut : Return Html List of Creteria Or Coverage in unordered list.  

function get_scholarship_criteria_coverage($field_name , $type, $id){
    
    $text = "";
    
    if( have_rows($field_name, $id) ) { 
        $text = $text . "<ul>";
        while ( have_rows($field_name, $id) ){
            the_row();
             $crite =  get_sub_field($type);
             $new_str = preg_replace("/\*\*(.*?)\*\*/", "<b>$1</b>", $crite);

            $text = $text . '<li>' . $new_str . "</li>";                      

        }


        $text = $text . '</ul>';
    }    
    
    return $text;

}


// Input :  Give Loop of All scholarships against an Institute & Program Name  
// OutPut : Return html list of scholarships for given program . Either Undergraduate or Graduate.  

function get_graduate_undergraduate_list($query, $program){
   
    $scholarship_ids = get_scholarship_ids($query);
    $program_ids  = array(); 
    foreach($scholarship_ids as  $id){
    $degrees = get_field('eligible_degrees' , $id);
        if($program =="undergraduate") {
              if(in_array("Bachelor's", $degrees)){ 
              array_push($program_ids , $id);
                }
        }
        if($program =="graduate") {
               if(in_array("Master's", $degrees) || in_array("PhD", $degrees)){ 
               array_push($program_ids , $id);
                }
        }
    }
return $program_ids;

}


//Input = Scholarship Query Loop Give
//Output = Sholarship Ids Array

function get_scholarship_ids($query){
   
   $ids = array();
   while ($query->have_posts() ) {
        $query->the_post();
        $id = get_the_ID();
        array_push($ids , $id);
    };
    
    wp_reset_postdata();
    
    return $ids;
}



//Input = institution Id
//Output = Institution Object.
//Used in single-scholarships.php

function get_institution_by_id($id) {
   
    $args = array(
        'post_type' => 'institution',
        'posts_per_page' => -1,

          'no_found_rows' => true, 
          'update_post_meta_cache' => false,
          'update_post_term_cache' => false,
          'cache_results'          => false,
          'fields' => 'ids',

        'p' => $id,
    );

   $the_query = new WP_Query($args);
   return $the_query;
   
}


function get_institution_by_idd($id) {
   
    $args = array(
        'post_type' => 'institution',
        'include' => $id,
    );

   $posts = get_posts($args);
   return $posts;
   
}


function get_scholarship_by_id($id) {
   
    $args = array(
        'post_type' => 'scholarships',

          'no_found_rows' => true, 
          'update_post_meta_cache' => false,
          'update_post_term_cache' => false,
          'cache_results'          => false,
          'fields' => 'ids',

        'posts_per_page' => -1,
        'p' => $id,
    );

   $the_query = new WP_Query($args);
   return $the_query;
   
}


//Function that takes an array and outputs a text.
//Two items in array: output with “and”, Example: input: [“Bachelors”, “Masters”]. Output: Bachelors and Masters

function convert_array_to_text($array_list ){
    
    if(isset($array_list)){

        if (count($array_list) == 1) {
            return $array_list[0];
        }
            
        if (count($array_list) == 2) {
        return $array_list[0] . " and " . $array_list[1];
        }

        $format_text = implode(', ' ,  $array_list);
        
        $format_text = substr_replace($format_text, ', and', strrpos($format_text, ','), 1);
        
        return $format_text;

    } else {
        return "";
    }
}




//Get Currency Function

// function get_currency($country){
//     $currency_list = country_currency_list();
    
//     return $currency_list[$country];
// }



//Function that takes an array and outputs an array.
//Return : Ranking name and Value.

function get_ranking_with_name($rankings){
    $ranking_array = array();
    foreach ($rankings as $key => $value) {
      if($value > 0)  {

        $ranking_array['name'] = get_ranking_name_from_key($key);
        $ranking_array['value'] = $value;
        break;
      }  
    }
    return $ranking_array;
}

//Returns ranking name from key

function get_ranking_name_from_key($key){
    $ranking_list = array(
        "qs" => "QS",
        "the_ranking" => "Times Higher Education",
        "usnews" => "USNews",
        "edurank" => "EduRank",
        "4icu" => "UniRank", 
    );
    
   return $ranking_list[$key];
    
}

//Returns adjective for scholarship_type
//Used in single-scholarships text

function get_adjective_scholarship_amount($text){
    $text_list = array(
        "Full Funding" => "fully funded",
        "Full Tuition" => "full tuition",
        "Partial Funding" => "partially funded",
    );
    
   return $text_list[$text];
    
}





// Pass Courses array
// Output : Return Course string in such oder  : Course 1, Course 2 and Course 3.

function get_formatted_courses($courses) {
            
    $courses_text = ""; $format_courses_text = "";
    $counter = 0;

    if ($courses){

        if(sizeof($courses) > 3 ) {
            
        foreach ($courses as $courses_name) {
            if($counter==3){
                    break;
                }
            foreach($courses_name as  $val){
            $courses_text = $courses_text . $val . ", ";
            }
            $counter++;
        }
        $courses_text = rtrim($courses_text , ' ,');
        $format_courses_text = substr_replace($courses_text, ', and', strrpos($courses_text, ','), 1);
        }
    }

    return $format_courses_text;
        
}

// Pass Degrees array
// Output : Return degree string in such oder  : degree 1, degree 2 and degree 3.

function formatArrayToString($array) {
    $count = count($array);
    
    if ($count === 0) {
        return '';
    } elseif ($count === 1) {
        return $array[0];
    } elseif ($count === 2) {
        return $array[0] . ' and ' . $array[1];
    } else {
        $lastElement = array_pop($array);
        $string = implode(', ', $array);
        $string .= ', and ' . $lastElement;
        return $string;
    }
}


/* Deleted this because I would like the all the degrees to show now. 
  function get_formatted_eligible_courses($courses) {
               
               $counter =0;
               $courses_text = ""; $format_courses_text = "";
                foreach($courses  as  $val){
                    if($val =="Bachelor's")
                        continue;
                  $courses_text = $courses_text . $val . " , ";
                  $counter++;
                 }
               
               if($counter==1) {
               $format_courses_text = rtrim($courses_text , ' ,'); }
               else {
                 $courses_text = rtrim($courses_text , ' ,');
                $format_courses_text = substr_replace($courses_text, ' and', strrpos($courses_text, ','), 1); 
               }
               

             return $format_courses_text;
        
        }   
        
        
*/

// Pass Number 
// Format into a number like remove comma from the number display. 

function to_number($number){
      return (float) str_replace(',', '', $number);
}  




add_action('conditionally_fetch_and_store_currency_conversion_rates', 'conditionally_fetch_and_store_currency_conversion_rates');

function conditionally_fetch_and_store_currency_conversion_rates() {
    $last_update = get_option('currency_rates_last_update', 0);
    $current_time = current_time('timestamp');

    // Update rates if more than a month has passed since the last update
    if (($current_time - $last_update) > 30 * DAY_IN_SECONDS) {
        fetch_and_store_currency_conversion_rates();
        update_option('currency_rates_last_update', $current_time); // Update last update time
    }
}

function fetch_and_store_currency_conversion_rates() {
    $transient_key = 'currency_conversion_rates';
    $api_key = 'fxr_live_c26ae8c14971ba9e361e44017e494e33635f';  // Use your actual API key
    $api_url = "https://api.fxratesapi.com/latest?api_key={$api_key}&base=USD";

    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) {
        // Handle error appropriately
        return;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!empty($data) && isset($data['rates'])) {
        // Cache the rates for 30 days
        set_transient($transient_key, $data['rates'], 30 * DAY_IN_SECONDS);
    }
}

function convert_to_usd($amount, $currency) {
    // Attempt to use cached conversion rates
    $rates = get_transient('currency_conversion_rates');

    // Normalize the currency input
    $currencyMappings = [
        "KR" => "SEK",
        "RAND" => "ZAR",
        "DANISH KRONE" => "DKK",
        "PESOS" => "PHP",
        "RMB" => "CNY",
        "YEN" => "JPY",
        "EUROS" => "EUR",
    ];

    $currency = strtoupper($currency);
    if (array_key_exists($currency, $currencyMappings)) {
        $currency = $currencyMappings[$currency];
    }

    // Perform conversion if the rate is available
    if (isset($rates[$currency]) && $amount > 0) {
        return $amount / $rates[$currency];
    }

    // Return the original amount if conversion rate is not found
    return $amount;
}




// function convert_to_usd($amount, $currency){

// $list = array(
// "KRW" => 0.00074,
// "CAD" => 0.73,
// "RMB" => 0.14,
// "Yen" => 0.0067,
// "NZD" => 0.60,
// "GBP" => 1.22,
// "AUD" => 0.64,
// "Euros" => 1.06,
// "NOK" => 0.092,
// "CHF" => 1.10,
// "USD" => 1,
// "PLN" => 0.23,
// "INR" => 0.012,
// "Pesos" => 0.018,
// "Rand" => 0.052,
// "SGD" => 0.73,
// "RUB" => 0.0099,
// "CZK" => 0.043,
// "kr" => 0.091,
// "Danish Krone" => 0.14,
// "MXN" => 0.054,
// "Brazilian Real" => 0.19,
// "UAH" => 0.027,
// "TRY" => 0.036,
// "TWD" => 0.031,
// "Rp" => 0.000064,
// "RON" => 0.21,
// "BYN" => 0.30,
// "HUF" => 0.0027,
// "BAM" => 0.54,
// "ALL" =>0.01 ,
// "ISK" => 0.0073,
// "VND" => 0.000041,
// "THB" => 0.027,
// "LKR" => 0.0031,
// "PKR" => 0.0036,
// "NPR" => 0.0075,
// "QAR" => 0.27,
// "RSD" => 0.0090,
// "MYR" => 0.21,
// "SAR" => 0.27,
// "KHR" => 0.00024,
// "AED" =>  0.27,
// "ILS" =>  0.25,
// "CRC" =>  0.0019,
// "BGN"  => 0.54,
// "MDL"  => 0.055,
// "NGN"  => 0.0013,
 
//  );
  
//  if ($amount > 0){
//       return $amount * $list[$currency];
//    } else {
//       return $amount;
//    }
// }



function roundNearestHundreth($number){
    return (ceil( $number / 100 ) * 100);
}



//This function outputs all the institutions given a location name
//First, it checks if the location name is city, then state, then country, tne continent.
//If found, it returns the institutions in that location
//If not found, it returns an empty loop
//It is used for url like all-universities-location, where it takes location and checks for institutions in that location
//If the given location is a city, state, country, or continent, the it outputs the instituitons
//If not, it returns empty.
//Example: input: Korea, output: all the institutions in country korea
//Example: input: test, output: empty since there's no location named test
function get_institutions_location ($location_name){
    
    //Direct City Match
    
    
    $city_args = array(
        'post_type' => 'city',
        'title' => $location_name,
    );
    
    $the_query = new WP_Query($city_args);
  

  
    //Make an empty new query. If $the_query has posts (that is city with location is found), then assign $loop with institutions. 

    if ($the_query->have_posts()) {

        while ( $the_query->have_posts() ){
            $the_query->the_post();
            $the_post_id = get_the_id();
           
            $institute_args = array(
                'post_type' => 'institution',
                'post_status' => 'publish',
                'meta_key' => "cities",
               
              
               'fields' => 'ids',

                'posts_per_page' => -1,             
                "meta_value" => $the_post_id,
                               
                
            );                  
        };
                
        $loop = new WP_Query($institute_args); 

        

        //Return $loop if it has a direct match
        return $loop;
        
    };
    
   //This code doesn't run if city match is found
     
    
    
    $loop = get_cities_location($location_name, "state");
    
    if ($loop && $loop->have_posts()) {
    return $loop;
    } 

    $loop = get_cities_location($location_name, "country");
     
  
    //return if country has posts 
   if ($loop && $loop->have_posts()) {
        return $loop;
    };     
    
    $loop = get_cities_location($location_name, "continent");
    
    //return if continent has posts 
    if ($loop && $loop->have_posts()) {
        return $loop;
    };         
    
    
    return $loop;
};

//Input = Location name like state, country, continent
//Output list of all meta values with lowercased and hyphenated
//Example, input = "country", output ["canada", "united-kingdom", "korea", ...]
function get_location_values ($location_type){
    global $wpdb;
    
    $text = $wpdb->prepare("SELECT DISTINCT meta_value FROM wp_postmeta WHERE meta_key = %s", $location_type);
    
    $db_queries = $wpdb->get_results($text, ARRAY_A);
    
    $location = array();
    foreach ($db_queries as $db_query){
        array_push($location, $db_query["meta_value"]); 
    };
    
    return $location;
    
};


//This function is getting all the institutions given a location name and location type
//So if location_name is in location type, it will return all the institutions 
//Example1: Input(location-name:korea, location-type:country), output loop with all the institutions in Korea
//Example2: Input(location-name:korea, location-type:continent), don't output loop since korea is not in continent
//This function is used for get_institution_location
function get_cities_location($location_name, $location_type){
    
    $locations = get_location_values($location_type);

    
    $loop = new WP_Query();

    // Check if the provided location name is in the array of locations
    if (in_array($location_name, $locations)) {
        
        $city_args = array(
            'post_type' => 'city',
            'meta_key' => $location_type,
            'meta_value' => $location_name,
            'posts_per_page' => -1,
            'no_found_rows' => true, 
            'update_post_meta_cache' => false, 
            'update_post_term_cache' => false,   
            'cache_results' => false,
            'fields' => 'ids',
        );

        // Create a new WP_Query with the specified arguments for cities
        $the_query = new WP_Query($city_args);
        $my_posts = $the_query->get_posts();
        
        // Check if there are posts
        if (!empty($my_posts)) {
            $post_ids = array();
            foreach ($my_posts as $id) {
                array_push($post_ids, $id);
            }

            $institute_args = array(
                'post_type' => 'institution',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
                'no_found_rows' => true, 
                'update_post_meta_cache' => false, 
                'update_post_term_cache' => false,   
                'cache_results' => false,
                'fields' => 'ids',                     
                'meta_query' => array(
                    array(
                        'key' => 'cities',
                        'value' => $post_ids,
                        'compare' => 'IN'
                    )
                )
            );

            // Update $loop with the new WP_Query for institutions
            $loop = new WP_Query($institute_args);
        }
    }

    // Return the WP_Query object
    return $loop;
}



//Gets country, state values - Returns the text value, not the post id (there's no post id for state, country)
function get_country_state_values(){
    global $wpdb;
    
    $text = $wpdb->prepare("SELECT DISTINCT meta_value FROM wp_postmeta WHERE meta_key = 'state' OR meta_key = 'country'");
    
    $db_queries = $wpdb->get_results($text, ARRAY_A);
    
    $location = array();
    foreach ($db_queries as $db_query){
        array_push($location, $db_query["meta_value"]);    
    }
    
   return $location;     
    
}

//Get city post_ids with more than 1 count. Returns the post id, rather than the title of the post, different from get_country_state_values;

function get_city_values(){
    
    global $wpdb;

    
    $text = $wpdb->prepare("SELECT meta_value FROM wp_postmeta WHERE meta_key = 'cities' group by meta_value having Count(*) > 1");
    $db_queries = $wpdb->get_results($text, ARRAY_A);
    
    $location_id_array = array();

    foreach ($db_queries as $db_query){
        $post_id = $db_query["meta_value"];        
        array_push($location_id_array, $post_id);    
    }   
    
    return $location_id_array;
    
}



function scholarship_card( $scholarship_id ){
    
    $scholarship = get_post( $scholarship_id );
    $fields = get_fields( $scholarship );
    require get_stylesheet_directory() .'/components/scholarship-card.php';

};





// Here we register our "send_form" function to handle our AJAX request, do you remember the "superhypermega" hidden field? Yes, this is what it refers, the "send_form" action.

//add_action('wp_ajax_send_form', 'send_form'); // This is for authenticated users
//add_action('wp_ajax_nopriv_send_form', 'send_form'); // This is for unauthenticated users.
 
/**
 * In this function we will handle the form inputs and send our email.
 *
 * @return void
 */
 
// function send_form(){
 
//     // This is a secure process to validate if this request comes from a valid source.
//     check_ajax_referer( 'secure-nonce-name', 'security' );
 
//     /**
//      * First we make some validations, 
//      * I think you are able to put better validations and sanitizations. =)
//      */
     
    
//     echo 'Done!';
//     wp_die();
// }






//Commented by Sibi 5 September 

// function get_current_deadlines_institutions ($degree, $institution_id){ 

//    $degree_name = $degree;
//    $current_date = strtotime(date("F j, Y"));

//    $institution_query = get_institution_by_id($institution_id);
//    $deadline = array();
//    $accept_year_application = array();

//     while ($institution_query->have_posts() ) {
//         $institution_query->the_post();
             
//         if( have_rows('admission_deadlines') ) {

//             //Push Deadline with according to degree
//             while( have_rows('admission_deadlines') ) {
//             the_row();
//             $degree_value = get_sub_field('degree');
//             if($degree_value == $degree_name ){
//                 $deadline_date = get_sub_field('deadline');
//                 $accept_year_value = get_sub_field('accepts_application_all_year_round');
//                 array_push($deadline, $deadline_date);
//                 array_push($accept_year_application , $accept_year_value );
//                 }
//              }
              
//         if(empty($deadline)){
//         //Push Deadline without according to degree
//             while( have_rows('admission_deadlines') ) {
//             the_row();
//             $degree_value = get_sub_field('degree');
//             if(empty($degree_value)){
//                 $deadline_date = get_sub_field('deadline');
//                 $accept_year_value = get_sub_field('accepts_application_all_year_round');
//                 array_push($deadline, $deadline_date);
//                 array_push($accept_year_application , $accept_year_value );
//                 }
//              }
//         }

       
//         }

//         if(empty($deadline)) {
//         $old_date = date_create("2000-03-15");
//         $old_date = date_format($old_date,"F j, Y");
//         return $old_date;
//         }
//     }


//     //Sort the deadline array from oldest to latest
//     usort($deadline, "compareByTimeStamp");
//     $deadline = array_reverse($deadline);   
     
//     foreach($deadline as $date){
//          $date_to_time =  strtotime($date);
//         if($date_to_time > $current_date){
//             return $date;
//         }
//     }



//     foreach($accept_year_application as $item){
//       if($item=="Yes"){
//         $far_date = date_create("2050-03-15");
//         $far_date = date_format($far_date,"F j,Y");
//         return $far_date;
//       }
//     }

// // If the below gets run, then there should be only one date (the 2010 deadline) or all the deadlines were past


//     /*return the latest deadline here*/
//    $latest_date = end($deadline);
//    return $latest_date; 

// }


function get_current_deadlines_institutions($degree, $institution_id) {
    $degree_name = $degree;
    $current_date = strtotime(date("F j, Y"));

    $institution_query = get_institution_by_id($institution_id);
    $deadline = array();
    $accept_year_application = array();

    while ($institution_query->have_posts()) {
        $institution_query->the_post();

        if (have_rows('admission_deadlines')) {
            // Always start with checking all rows of 'admission_deadlines'
            while (have_rows('admission_deadlines')) {
                the_row();
                $degree_value = get_sub_field('degree');

                // Check if the degree value matches the specified degree OR the degree value is empty
                if ($degree_value == $degree_name || empty($degree_value)) {
                    $deadline_date = get_sub_field('deadline');

                    // Only push the deadline if it's not already in the array (to avoid duplicates)
                    if (!in_array($deadline_date, $deadline) && !empty($deadline_date)) {
                        array_push($deadline, $deadline_date);
                    }

                    $accept_year_value = get_sub_field('accepts_application_all_year_round');
                    if (!in_array($accept_year_value, $accept_year_application)) {
                        array_push($accept_year_application, $accept_year_value);
                    }
                }
            }
        }

        if (empty($deadline)) {
            $old_date = date_create("2000-03-15");
            $old_date = date_format($old_date, "F j, Y");
            return $old_date;
        }
    }

    // Sort the deadline array from oldest to latest
    usort($deadline, "compareByTimeStamp");
    $deadline = array_reverse($deadline);

    foreach ($deadline as $date) {
        $date_to_time = strtotime($date);
        if ($date_to_time > $current_date) {
            return $date;
        }
    }

    foreach ($accept_year_application as $item) {
        if ($item == "Yes") {
            $far_date = date_create("2050-03-15");
            $far_date = date_format($far_date, "F j,Y");
            return $far_date;
        }
    }

    // If the below gets run, then there should be only one date (the 2010 deadline) or all the deadlines were past
    $latest_date = end($deadline);
    return $latest_date;
}






//A function for sorting from farthest to oldest
function compareByTimeStamp($time1, $time2)
{
    if (strtotime($time1) < strtotime($time2))
        return 1;
    else if (strtotime($time1) > strtotime($time2)) 
        return -1;
    else
        return 0;
}


// Get Scholarship Deadlines
function get_scholarship_deadline($id, $degree){

  $deadline = array();
  $degree_name = $degree;
   $current_date = strtotime(date("F j, Y"));
    $scholarship_query = get_scholarship_by_id($id);
    while ($scholarship_query->have_posts() ) {
    
    $scholarship_query->the_post();

    if( have_rows('scholarship_deadlines') ) {

        //Push Deadline with according to degree
        while( have_rows('scholarship_deadlines') ) {
          the_row();
          $degree = get_sub_field('degree');
          
          if($degree == $degree_name){
             $deadline_date = get_sub_field('deadline');
             array_push($deadline, $deadline_date);
            }
        }

        
        if(empty($deadline)){
            //Push Deadline with according to degree
        while( have_rows('scholarship_deadlines') ) {
          the_row();
          $degree = get_sub_field('degree');
          
          if(empty($degree)){
             $deadline_date = get_sub_field('deadline');
             array_push($deadline, $deadline_date);
            }
        }

          }
    }


   //Sort the deadline array from oldest to latest

    usort($deadline, "compareByTimeStamp");
    $deadline = array_reverse($deadline);
  


     foreach($deadline as $date){
         $date_to_time =  strtotime($date);
        if($date_to_time > $current_date){
        return $date;
        }
    }

    //if Deadline is still empty give some random hardcoded deadline:
    if(empty($deadline)) {
        $far_date = date_create("2010-03-15");
        $far_date = date_format($far_date,"F j, Y");
        return $far_date;
    }

    /*return the latest deadline here*/
     $latest_date = end($deadline);
    
    return $latest_date;
    }

}


/**
 * Update Institutions Post Meta for Country and Continent using ACF cities and CPT city
 * 
 */
function save_scholarships_deadline_post_meta_ajax() {
  
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $batchSize = isset($_POST['batchSize']) ? intval($_POST['batchSize']) : 20;
    $postType = isset($_POST['postType']) ? sanitize_text_field($_POST['postType']) : 'scholarships';
    

    $scholarship_posts_count = wp_count_posts($postType);
    $scholarship_posts_count_published = $scholarship_posts_count->publish;


    
    $args = array(
      'post_type' => $postType,
      'posts_per_page' => $batchSize,
      'no_found_rows' => true, 
      'update_post_meta_cache' => false, 
      'update_post_term_cache' => false,   
      'cache_results' => false,
      'fields' => 'ids',
      'post_status' => 'publish',
      'offset' => $offset,
    );
    
    $query = new WP_Query($args);
    $master_degree = "Master's";
    $bachelor_degree = "Bachelor's";

    $myPosts = $query->get_posts();
    $current_date = strtotime(date("F j, Y"));
    
    foreach($myPosts as $scholarship_id) {

        
       
        // Ignore that Scholarship that has Value Set 
        // And Has Deadline Greator that current Time . (Mean Deadline Is In future so we continue to new scholarship)
        // Else loop goes down to save meta. 

        $check_master = strtotime(get_field('current_masters_scholarship_deadline', $scholarship_id));
        $check_bachelor = strtotime(get_field('current_bachelors_scholarship_deadline', $scholarship_id));

        //Code that skips udating deadlines if the check_bachelor's is latest then the current date.
        
        if( isset($check_master) && isset($check_bachelor) ){
            if($check_master > $current_date && $check_bachelor > $current_date){
                continue;
            }
        }


        

        $institution = get_field("scholarship_institution", $scholarship_id);



       // ..............................   Code to Work for the Master's. .........................
        $scholarship_deadline = get_scholarship_deadline($scholarship_id, $master_degree);
        $admission_deadline  = get_current_deadlines_institutions($master_degree , $institution->ID );
        
    
        $scholarship_deadline_date = strtotime($scholarship_deadline);     // 14 December 
        $admission_deadline_date = strtotime($admission_deadline);         // 1 December  
                  
           
        $scholarship_deadline = date("Y-m-d H:i:s" , $scholarship_deadline_date);
        $admission_deadline = date("Y-m-d H:i:s" , $admission_deadline_date);
       

         // echo "Scholarship deadline: " .$scholarship_deadline;
         // echo "<br>";
         // echo "Admission deadline: " . $admission_deadline;
         // echo "<br>";
         // echo "Current Date : " . date("F j, Y");
         
         

         
         // if both deadlines are latest than current date, save the oldest deadline

         if($scholarship_deadline_date > $current_date  && $admission_deadline_date > $current_date) {

            if($scholarship_deadline_date > $admission_deadline_date){
                update_field('current_masters_scholarship_deadline', $admission_deadline , $scholarship_id); 
            }else {
                 update_field('current_masters_scholarship_deadline', $scholarship_deadline , $scholarship_id); 
            }
       
       
        } 

         // if Scholar deadlines are older than current date And
       // if Admisison Deadlines are latest current Date . Save Older Date

       else if ($scholarship_deadline_date < $current_date  && $admission_deadline_date > $current_date) {
        
        $date_greator_2010 = date_create("2015-03-15");
        $date_greator_formated = date_format($date_greator_2010, "F j, Y");
        $date_greator_timestamp = strtotime($date_greator_formated);

       if($scholarship_deadline_date < $date_greator_timestamp  ) { 
          update_field('current_masters_scholarship_deadline', $admission_deadline , $scholarship_id);
        } else { 
        update_field('current_masters_scholarship_deadline', $scholarship_deadline , $scholarship_id);
        }

       } 




       // if Scholar deadlines are latest than current date And
       // if Admisison Deadlines are older current Date . Save Older Date
 
        else if($scholarship_deadline_date > $current_date  && $admission_deadline_date < $current_date) {
        update_field('current_masters_scholarship_deadline', $admission_deadline , $scholarship_id);
        }

       

        //When both scholarship deadline and admission deadline are older than the current date, save the latest deadline

       else {
          
          if($scholarship_deadline_date > $admission_deadline_date){
           update_field('current_masters_scholarship_deadline', $scholarship_deadline , $scholarship_id);
          }else {
            update_field('current_masters_scholarship_deadline', $admission_deadline , $scholarship_id);
          }

         }

         
         // ..............................   Code to Work for the Bachelors's. .........................

        $scholarship_deadline = get_scholarship_deadline($scholarship_id, $bachelor_degree);
        $admission_deadline  = get_current_deadlines_institutions($bachelor_degree , $institution->ID );

        
        $scholarship_deadline_date = strtotime($scholarship_deadline);
        $admission_deadline_date = strtotime($admission_deadline);

        /* Here, please check that scholarship_deadline and admission_deadline are > current date. 
        if both deadlines are older than current date, please save the scholarship_deadline (doesn't really matter which one you save since they are both old)
        if only one is > than the current date, then please save that deadline.
        if both are > than the current date, then save whichever is most closest to the current date */
        
        $scholarship_deadline = date("Y-m-d H:i:s" , $scholarship_deadline_date);
        $admission_deadline = date("Y-m-d H:i:s" , $admission_deadline_date);
       
    
        // if both deadlines are latest than current date, save the oldest deadline

        if($scholarship_deadline_date > $current_date  && $admission_deadline_date > $current_date) {

            if($scholarship_deadline_date > $admission_deadline_date){
                update_field('current_bachelors_scholarship_deadline', $admission_deadline , $scholarship_id); 
            }else {
                 update_field('current_bachelors_scholarship_deadline', $scholarship_deadline , $scholarship_id); 
            }
       
       
        } 


        // if Scholar deadlines are latest than current date And
       // if Admisison Deadlines are older current Date . Save Older Date

        else if($scholarship_deadline_date > $current_date  && $admission_deadline_date < $current_date) {
        update_field('current_bachelors_scholarship_deadline', $admission_deadline , $scholarship_id);
        }

       // if Scholar deadlines are older than current date And
       // if Admisison Deadlines are latest current Date . Save Older Date 

       else if ($scholarship_deadline_date < $current_date  && $admission_deadline_date > $current_date) {
        
        $date_greator_2010 = date_create("2015-03-15");
        $date_greator_formated = date_format($date_greator_2010, "F j, Y");
        $date_greator_timestamp = strtotime($date_greator_formated);

       if($scholarship_deadline_date < $date_greator_timestamp  ) { 
         update_field('current_bachelors_scholarship_deadline', $admission_deadline , $scholarship_id);
        } else { 
        update_field('current_bachelors_scholarship_deadline', $scholarship_deadline , $scholarship_id);
        }

      


       } 
       
       //When both scholarship deadline and admission deadline are older than the current date, save the latest deadline

       else {
          
          if($scholarship_deadline_date > $admission_deadline_date){
           update_field('current_bachelors_scholarship_deadline', $scholarship_deadline , $scholarship_id);
          }else {
            update_field('current_bachelors_scholarship_deadline', $admission_deadline , $scholarship_id);
          }

         }

          

       }
    
    $totalUpdated = $offset + count($myPosts);
    $totalPosts =  intval($scholarship_posts_count_published);

    $response = array(
      'totalUpdated' => $totalUpdated,
      'totalPosts' => $totalPosts,
    );
    
    wp_send_json($response);
    
  }
  add_action('wp_ajax_save_scholarships_deadline_post_meta', 'save_scholarships_deadline_post_meta_ajax');
  add_action('wp_ajax_nopriv_save_scholarships_deadline_post_meta', 'save_scholarships_deadline_post_meta_ajax');

//get_scholarship_deadline(48187, "Master's");


// function save_scholarships_deadline_post_meta() {


//     $args = array(
//         'post_type' => 'scholarships',
//         'no_found_rows' => true,
//         'update_post_meta_cache' => false,
//         'update_post_term_cache' => false,
//         'cache_results' => false,
//         'fields' => 'ids',
//         'posts_per_page' => -1,
//         'post_status' => 'publish',
//     );

//     $current_date = strtotime(date("F j, Y"));
//     $query = new WP_Query($args);
    
//     $master_degree = "Master's";
//     $bachelor_degree = "Bachelor's";

//     foreach ($query->posts as $scholarship_id) {
//         $check_master = strtotime(get_field('current_masters_scholarship_deadline', $scholarship_id));
//         $check_bachelor = strtotime(get_field('current_bachelors_scholarship_deadline', $scholarship_id));
       
     

//         // Ignore that Scholarship that has Value Set 
//         // And Has Deadline Greator that current Time . (Mean Deadline Is In future so we continue to new scholarship)
//         // Else loop goes down to save meta. 

        
//         //Code that skips udating deadlines if the check_bachelor's is latest then the current date.
        
//         // if( isset($check_master) && isset($check_bachelor) ){
//         //     if($check_master > $current_date && $check_bachelor > $current_date){
//         //         continue;
//         //     }
//         // }


        

//         $institution = get_field("scholarship_institution" , $scholarship_id);

    
//        // ..............................   Code to Work for the Master's. .........................
//         $scholarship_deadline = get_scholarship_deadline($scholarship_id, $master_degree);
//         $admission_deadline  = get_current_deadlines_institutions($master_degree , $institution->ID );
        
    
//         $scholarship_deadline_date = strtotime($scholarship_deadline);     // 14 December 
//         $admission_deadline_date = strtotime($admission_deadline);         // 1 December  
                  
           
//         $scholarship_deadline = date("Y-m-d H:i:s" , $scholarship_deadline_date);
//         $admission_deadline = date("Y-m-d H:i:s" , $admission_deadline_date);
       

//          // echo "Scholarship deadline: " .$scholarship_deadline;
//          // echo "<br>";
//          // echo "Admission deadline: " . $admission_deadline;
//          // echo "<br>";
//          // echo "Current Date : " . date("F j, Y");
         
         

         
//          // if both deadlines are latest than current date, save the oldest deadline

//          if($scholarship_deadline_date > $current_date  && $admission_deadline_date > $current_date) {

//             if($scholarship_deadline_date > $admission_deadline_date){
//                 update_field('current_masters_scholarship_deadline', $admission_deadline , $scholarship_id); 
//             }else {
//                  update_field('current_masters_scholarship_deadline', $scholarship_deadline , $scholarship_id); 
//             }
       
       
//         } 

//          // if Scholar deadlines are older than current date And
//        // if Admisison Deadlines are latest current Date . Save Older Date

//        else if ($scholarship_deadline_date < $current_date  && $admission_deadline_date > $current_date) {
        
//         $date_greator_2010 = date_create("2015-03-15");
//         $date_greator_formated = date_format($date_greator_2010, "F j, Y");
//         $date_greator_timestamp = strtotime($date_greator_formated);

//        if($scholarship_deadline_date < $date_greator_timestamp  ) { 
//           update_field('current_masters_scholarship_deadline', $admission_deadline , $scholarship_id);
//         } else { 
//         update_field('current_masters_scholarship_deadline', $scholarship_deadline , $scholarship_id);
//         }

//        } 




//        // if Scholar deadlines are latest than current date And
//        // if Admisison Deadlines are older current Date . Save Older Date
 
//         else if($scholarship_deadline_date > $current_date  && $admission_deadline_date < $current_date) {
//         update_field('current_masters_scholarship_deadline', $admission_deadline , $scholarship_id);
//         }

       

//         //When both scholarship deadline and admission deadline are older than the current date, save the latest deadline

//        else {
          
//           if($scholarship_deadline_date > $admission_deadline_date){
//            update_field('current_masters_scholarship_deadline', $scholarship_deadline , $scholarship_id);
//           }else {
//             update_field('current_masters_scholarship_deadline', $admission_deadline , $scholarship_id);
//           }

//          }

         
//          // ..............................   Code to Work for the Bachelors's. .........................

//         $scholarship_deadline = get_scholarship_deadline($scholarship_id, $bachelor_degree);
//         $admission_deadline  = get_current_deadlines_institutions($bachelor_degree , $institution->ID );

        
//         $scholarship_deadline_date = strtotime($scholarship_deadline);
//         $admission_deadline_date = strtotime($admission_deadline);

//         /* Here, please check that scholarship_deadline and admission_deadline are > current date. 
//         if both deadlines are older than current date, please save the scholarship_deadline (doesn't really matter which one you save since they are both old)
//         if only one is > than the current date, then please save that deadline.
//         if both are > than the current date, then save whichever is most closest to the current date */
        
//         $scholarship_deadline = date("Y-m-d H:i:s" , $scholarship_deadline_date);
//         $admission_deadline = date("Y-m-d H:i:s" , $admission_deadline_date);
       
    
//         // if both deadlines are latest than current date, save the oldest deadline

//         if($scholarship_deadline_date > $current_date  && $admission_deadline_date > $current_date) {

//             if($scholarship_deadline_date > $admission_deadline_date){
//                 update_field('current_bachelors_scholarship_deadline', $admission_deadline , $scholarship_id); 
//             }else {
//                  update_field('current_bachelors_scholarship_deadline', $scholarship_deadline , $scholarship_id); 
//             }
       
       
//         } 


//         // if Scholar deadlines are latest than current date And
//        // if Admisison Deadlines are older current Date . Save Older Date

//         else if($scholarship_deadline_date > $current_date  && $admission_deadline_date < $current_date) {
//         update_field('current_bachelors_scholarship_deadline', $admission_deadline , $scholarship_id);
//         }

//        // if Scholar deadlines are older than current date And
//        // if Admisison Deadlines are latest current Date . Save Older Date 

//        else if ($scholarship_deadline_date < $current_date  && $admission_deadline_date > $current_date) {
        
//         $date_greator_2010 = date_create("2015-03-15");
//         $date_greator_formated = date_format($date_greator_2010, "F j, Y");
//         $date_greator_timestamp = strtotime($date_greator_formated);

//        if($scholarship_deadline_date < $date_greator_timestamp  ) { 
//          update_field('current_bachelors_scholarship_deadline', $admission_deadline , $scholarship_id);
//         } else { 
//         update_field('current_bachelors_scholarship_deadline', $scholarship_deadline , $scholarship_id);
//         }

      


//        } 
       
//        //When both scholarship deadline and admission deadline are older than the current date, save the latest deadline
//         else {
//         if($scholarship_deadline_date > $admission_deadline_date){
//            update_field('current_bachelors_scholarship_deadline', $scholarship_deadline , $scholarship_id);
//           }else {
//             update_field('current_bachelors_scholarship_deadline', $admission_deadline , $scholarship_id);
//           }
//         }

          

//        }

// }


function save_scholarships_deadline_post_meta() {
    $batch_size = 05; // Fetch 100 posts at a time
    $paged = 1; // Start at the first page
    $current_date = strtotime(date("F j, Y"));
    $master_degree = "Master's";
    $bachelor_degree = "Bachelor's";

    do {
        $args = array(
            'post_type' => 'scholarships',
            'no_found_rows' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'cache_results' => false,
            'fields' => 'ids',
            'posts_per_page' => $batch_size,
            'paged' => $paged, // This enables the batching
            'post_status' => 'publish',
        );

        $query = new WP_Query($args);

        if (!$query->have_posts()) {
            break; // Exit the loop if there are no posts
        }

        foreach ($query->posts as $scholarship_id) {
            // Check and process Master's scholarship
            check_and_update_scholarship_deadline($scholarship_id, $master_degree, $current_date);
            
            // Check and process Bachelor's scholarship
            check_and_update_scholarship_deadline($scholarship_id, $bachelor_degree, $current_date);
        }
           wp_cache_flush(); // Clear the WordPress object cache
        $paged++; // Move on to the next batch

    } while (true); // Keep running until there are no posts left
}

function check_and_update_scholarship_deadline($scholarship_id, $degree, $current_date) {
    $institution = get_field("scholarship_institution", $scholarship_id);
    
    $scholarship_deadline_date = strtotime(get_scholarship_deadline($scholarship_id, $degree));
    $admission_deadline_date = strtotime(get_current_deadlines_institutions($degree, $institution->ID));

    // Mapping the degree type for field naming
    $degree_mapping = [
        "Master's" => 'masters',
        "Bachelor's" => 'bachelors'
    ];
     $degree_key = $degree_mapping[$degree] ?? '';

      
      

   
    // Determine the new deadline value
    $new_deadline = '';
    if ($scholarship_deadline_date > $current_date && $admission_deadline_date > $current_date) {
        $new_deadline = ($scholarship_deadline_date < $admission_deadline_date) ? $scholarship_deadline_date : $admission_deadline_date;
    } elseif ($scholarship_deadline_date > $current_date) {
        $new_deadline = $scholarship_deadline_date;
    } elseif ($admission_deadline_date > $current_date) {
        $date_greator_2010 = strtotime("2015-03-15");
        if ($scholarship_deadline_date >= $date_greator_2010) {
            $new_deadline = $scholarship_deadline_date;
        } else {
            $new_deadline = $admission_deadline_date;
        }
    } else {
        $new_deadline = ($scholarship_deadline_date > $admission_deadline_date) ? $scholarship_deadline_date : $admission_deadline_date;
    }

    // Only update if there's a valid deadline and degree key
    if ($new_deadline && $degree_key) {
        update_field('current_' . $degree_key . '_scholarship_deadline', date("Y-m-d H:i:s", $new_deadline), $scholarship_id);
    }
}




function save_institution_deadline_post_meta() {
    $posts_per_batch = 10;
    $paged = 1;

    while (true) { // Keep looping until all posts are processed.
        $args = array(
            'post_type' => 'institution',
            'posts_per_page' => $posts_per_batch,
            'post_status' => 'publish',
            'paged' => $paged,
            'fields' => 'ids'
        );

        $query = new WP_Query($args);

        if (!$query->have_posts()) {
            break; // Exit loop if there are no posts left to process.
        }

        $master_degree = "Master's";
        $bachelor_degree = "Bachelor's";

        foreach ($query->posts as $institution_id) {
            // Logic for the Master's Deadline
            $admission_deadline_master = get_current_deadlines_institutions($master_degree, $institution_id);
            update_field('current_masters_admission_deadline', $admission_deadline_master, $institution_id);

            // Logic for the Bachelor's Deadline
            $admission_deadline_bachelor = get_current_deadlines_institutions($bachelor_degree, $institution_id);
            update_field('current_bachelors_admission_deadline', $admission_deadline_bachelor, $institution_id);
        }

        $paged++; // Move to the next batch.
    }
}

function save_deadline_post_meta(){
    save_institution_deadline_post_meta();
    save_scholarships_deadline_post_meta();
}



//add_action( 'init', 'save_deadline_post_meta' );
add_action('save_deadline_post_meta', 'save_deadline_post_meta');






function get_cities_of_published_institute() {
global $wpdb;

$query = "
    SELECT DISTINCT pm_country.meta_value as country_name
    FROM {$wpdb->posts} p_institution
    INNER JOIN {$wpdb->postmeta} pm_city ON pm_city.post_id = p_institution.ID AND pm_city.meta_key = 'cities'
    INNER JOIN {$wpdb->posts} p_city ON p_city.ID = pm_city.meta_value
    INNER JOIN {$wpdb->postmeta} pm_country ON pm_country.post_id = p_city.ID AND pm_country.meta_key = 'country'
    WHERE p_institution.post_type = 'institution'
    AND p_institution.post_status = 'publish'
    AND p_city.post_type = 'city'
    AND p_city.post_status = 'publish'
";

$country_list = $wpdb->get_col($query);

return $country_list;


}



function save_scholarships_open_date_post_meta() {

    // Get the current offset
    $offset = 0;
    $batchSize = 20;
    $postType = 'scholarships';
    $master_degree = "Master's";
    $bachelor_degree = "Bachelor's";

    $scholarship_posts_count = wp_count_posts($postType);
    $scholarship_posts_count_published = $scholarship_posts_count->publish;
     
    
    // Create a while loop that will continue to run until all posts have been processed
    while ( $offset <  intval($scholarship_posts_count_published) ) {
  
      // Get the scholarships that need to be processed
      $args = array(
        'post_type' => $postType,
        'post_status' => 'publish',
        'posts_per_page' => $batchSize,
        'offset' => $offset,
        'no_found_rows' => true, 
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results'          => false,
        'fields' => 'ids',
      );
  
      $query = new WP_Query($args);

      $scholarship_posts = $query->get_posts();


      // If there are no more scholarships to process, break out of the loop
      if ($query->have_posts() == false) {
        break;
      }
  
      // Loop through the scholarships and update the open date meta
      foreach ($scholarship_posts as $scholarship_id) {
    
        // Get the current date
        $current_date = strtotime(date("F j, Y"));
  
        // Get the current master deadline
        $current_master_deadline = get_field('current_masters_scholarship_deadline', $scholarship_id);
        $current_bachelor_deadline = get_field('current_bachelors_scholarship_deadline', $scholarship_id);
  
        // Get the institution ID
        $institution = get_field("scholarship_institution", $scholarship_id);
        $institution_id = $institution->ID;
  
        // If the master deadline is in the past, set the open date to "No"
        if (!empty($current_master_deadline) && strtotime($current_master_deadline) < $current_date) {
          update_field('master_open_date', 'No', $scholarship_id);
        } else {
          get_open_dates($master_degree, $institution_id, $scholarship_id);
        }
  
        // If the bachelor deadline is in the past, set the open date to "No"
        if (!empty($current_bachelor_deadline) && strtotime($current_bachelor_deadline) < $current_date) {
          update_field('bachelor_open_date', 'No', $scholarship_id);
        } else {
          get_open_dates($bachelor_degree, $institution_id, $scholarship_id);
        }
      }
  
      // Increment the offset
      $offset += $batchSize;
    }
    
}


//add_action('init', 'save_scholarships_open_date_post_meta', 100);
add_action('save_scholarships_open_date_post_meta', 'save_scholarships_open_date_post_meta');



// function save_scholarships_open_date_post_meta(){

// $args = array(
//         'post_type' => 'scholarships',
//         'post_status' => 'publish',
     
//      // 'no_found_rows' => true, 
//      // 'update_post_meta_cache' => false,
//      // 'update_post_term_cache' => false,
//      // 'cache_results'          => false,
//      // 'fields' => 'ids',


//         'post_per_page' => -1,
//      );
    
   
//    $query = new WP_Query($args);
   
//     $current_date = strtotime(date("F j, Y"));

//    $master_degree = "Master's";
//    $bachelor_degree = "Bachelor's";
//    while ( $query->have_posts() ) {
        
//         $query->the_post();
//         $scholarship_id = get_the_ID();

//         $current_master_deadline = get_field('current_masters_scholarship_deadline');
//         $current_bachelor_deadline = get_field('current_bachelors_scholarship_deadline');

//         $institution = get_field("scholarship_institution");
//         $institution_id = $institution->ID;
         
       
//                if (!empty($current_master_deadline) && strtotime($current_master_deadline) < $current_date) {
//             update_field('master_open_date', 'No', $scholarship_id);
//         } else {
//             get_open_dates($master_degree, $institution_id, $scholarship_id);
//         }

//         if (!empty($current_bachelor_deadline) && strtotime($current_bachelor_deadline) < $current_date) {
//                 update_field('bachelor_open_date', 'No', $scholarship_id);
//             } else {
//                 get_open_dates($bachelor_degree, $institution_id, $scholarship_id);
//             }
              

//       //  get_open_dates($bachelor_degree , $institution_id , $scholarship_id);
//        // get_open_dates($master_degree , $institution_id , $scholarship_id);
//          //get_open_dates($master_degree , $institution_id , 50499);
//     }
//  }



function get_open_dates($degree, $institute_id, $scholarship_id) {

    

    $degree_name = $degree;
    $currentDate = strtotime(date("F j, Y"));
    $posts = get_institution_by_idd($institute_id);
    $deadline = array();
    $check = false;

    foreach ($posts as $post) {
        setup_postdata($post);

        if (have_rows('admission_deadlines', $post->ID)) {
            while (have_rows('admission_deadlines', $post->ID)) {
                the_row();

                $degree_value = get_sub_field('degree');
                $endDate = get_sub_field('deadline');
                $startDate = get_sub_field('open_date');
                $startDate = strtotime($startDate);
                $endDate = strtotime($endDate);

                if ($startDate == 230) {
                    $startDate = null;
                }

                if ($endDate == 230) {
                    $endDate = null;
                }

                if ($degree_value) {
                    if ($degree_value == $degree_name) {
                        // Check if the current date is between the start date and the end date
                        if (!is_null($startDate) && !is_null($endDate) && $currentDate >= $startDate && $currentDate <= $endDate) {
                            if ($degree_name == "Bachelor's") {
                                update_field('bachelor_open_date', 'Yes', $scholarship_id);
                                $check = true;
                            }

                            if ($degree_name == "Master's") {
                                update_field('master_open_date', 'Yes', $scholarship_id);
                                $check = true;
                            }
                        }
                    }
                } else {
                    // Check if the current date is between the start date and the end date
                    if (!is_null($startDate) && !is_null($endDate) && $currentDate >= $startDate && $currentDate <= $endDate) {
                        update_field('bachelor_open_date', 'Yes', $scholarship_id);
                        update_field('master_open_date', 'Yes', $scholarship_id);
                        $check = true;
                    }
                }
            }
        }
    }

    if (!$check) {
        if ($degree_name == "Bachelor's") {
            update_field('bachelor_open_date', 'No', $scholarship_id);
        }

        if ($degree_name == "Master's") {
            update_field('master_open_date', 'No', $scholarship_id);
        }
    } else {
        // Other logic (if needed)
    }

    // Reset the post data
    wp_reset_postdata();
}


//save_scholarships_open_date_post_meta();


function check_opening_soon($institute_id) {
   

    $currentDate = strtotime(date("F j, Y"));
    $posts = get_institution_by_idd($institute_id);
  
    
    $bachelor_opeing_soon = "";
    $master_opeing_soon = "";
  
    $opeing_soon_array = array();
        
    foreach ($posts as $post) {
    setup_postdata($post);

    if (have_rows('admission_deadlines', $post->ID)) {

        while (have_rows('admission_deadlines', $post->ID)) {
            the_row();

            $degree_value = get_sub_field('degree');

            if ($degree_value == "Bachelor's") {
                $endDate = get_sub_field('deadline');
                $startDate = get_sub_field('open_date');

                $startDate = strtotime($startDate);
                $endDate = strtotime($endDate);

                if (!empty($startDate)) {

                    if ($startDate < $currentDate && $endDate > $currentDate) {
                         
                        $bachelor_opeing_soon = "Yes";
                        array_push($$opeing_soon_array, array("bachelor" => $bachelor_opeing_soon));
                        break;

                    }
                }

            } 
        }


          while (have_rows('admission_deadlines', $post->ID)) {
            
            the_row();

            $degree_value = get_sub_field('degree');

            if ($degree_value == "Master's") {
                $endDate = get_sub_field('deadline');
                $startDate = get_sub_field('open_date');

                $startDate = strtotime($startDate);
                $endDate = strtotime($endDate);

                if (!empty($startDate)) {

                    if ($startDate < $currentDate && $endDate > $currentDate) {
                         
                        $master_opeing_soon = "Yes";
                        array_push($$opeing_soon_array, array("master" => $master_opeing_soon));
                        
                        break;

                    }
                }

            } 
        }

  
// function get_cities_of_published_institute(){
     
//     $city_ids = array();

//      $args = array(
//      'post_type' => 'institution',
//      'no_found_rows' => true, 
//      'update_post_meta_cache' => false,
//      'update_post_term_cache' => false,
//      'cache_results'          => false,
//      'fields' => 'ids',
//      'posts_per_page' => -1,
//      'post_status' => 'publish', 
//      );

//     $loop = new WP_Query($args);
//     while ($loop->have_posts() ) {
//         $loop->the_post();
//         $city = get_field("cities"); 
//         array_push($city_ids , $city->ID);
//     }
      
  

//     $args_cities = array(
//     'post_type' => 'city',
//     'posts_per_page' => -1,
//     'orderby' => 'post__in',
//     'order'     => 'ASC', 
//     'post__in' => $city_ids
//    );


//    $country_list = array();

//    $loop_cities = new WP_Query( $args_cities );
//    while ($loop_cities->have_posts() ) {
//         $loop_cities->the_post();
//         $country_name = get_field("country"); 
//         array_push($country_list , $country_name);
//     }
//     $country_list = array_unique($country_list);
//     return $country_list;

// }

        

  //       if(empty($opeing_soon_array)) {
        
  //       if (have_rows('admission_deadlines', $post->ID)) {
        
  //        while (have_rows('admission_deadlines', $post->ID)) {
           
  //           the_row();

  //               $endDate = get_sub_field('deadline');
  //               $startDate = get_sub_field('open_date');

  //               $startDate = strtotime($startDate);
  //               $endDate = strtotime($endDate);

  //               if (!empty($startDate)) {

  //                   if ($startDate < $currentDate && $endDate > $currentDate) {

  //                       $bachelor_opeing_soon = "Yes";
  //                       $master_opeing_soon = "Yes";
  //                       array_push($$opeing_soon_array, array("master" => $master_opeing_soon));
  //                       array_push($$opeing_soon_array, array("bachelor" => $bachelor_opeing_soon));
  //                       break;

  //                   }
  //               }
  //       }
  //   }
  // }





}


}
 

    
    return $opeing_soon_array;
}





function add_custom_js() {
      include dirname(__FILE__) . "/countries_list.php"; 
?>



<script type="text/javascript">




   
        jQuery(document).ready(function () {
           
            jQuery('input').on('click', function () {
                var link = jQuery(this).val();
                var urlRegex = /^(ftp|http|https):\/\/[^ "]+$/;
                if (urlRegex.test(link)) {
                   window.open(link, '_blank');
                } 
            });

        });

    
document.addEventListener("DOMContentLoaded", function() {
    // Find and process input fields inside the first ACF group
    var inputFields1 = document.querySelectorAll('.acf-field-6547a10d15d4c .acf-field-6547a10d15d4f input[type="text"]');
    if (inputFields1) {
        inputFields1.forEach(function(inputField) {
            if (inputField.value === 'Yes') {
                inputField.style.color = 'white';
                inputField.style.backgroundColor = 'green';
            }
        });
    }

    // Find and process input fields inside the second ACF group
    var inputFields2 = document.querySelectorAll('.acf-field-644be0dedadac .acf-field-653a09b95e443 input[type="text"]');
    if (inputFields2) {
        inputFields2.forEach(function(inputField) {
            if (inputField.value === 'Yes') {
                inputField.style.color = 'white';
                inputField.style.backgroundColor = 'green';
            }
        });
    }
});



    jQuery(document).ready(function($) {


    
    // Run Tool Ajax Call

    var PostInputt = jQuery('.inside').find('#acf-field_653f97c2da5db');
    PostInputt.prop('readonly', true); // Set the field as readonly

     jQuery('#runtool').on('click', function(event) {
        event.preventDefault();
        var customPostID = jQuery(this).closest('.inside').find('#acf-field_653f97c2da5db').val();
        console.log('Custom Post IDa:', customPostID);
       var link = "<?php echo  admin_url("admin-ajax.php"); ?>";

       $.ajax({
        type: 'POST',
        url: link, 
        data: {
            action: 'run_interlinking_tool',
            customPostID: customPostID
        },
        success: function(response) {
            console.log('AJAX request successful.');
           location.reload();
        },
        error: function(error) {
            console.error('Error in AJAX request:', error);
        }
    });
    
    });

    
    // Generate Posts for Posts Ajax Call

     jQuery('#generate_posts_for_keywords').on('click', function(event) {
        event.preventDefault();
        var customPostID = jQuery(this).closest('.inside').find('#acf-field_653f97c2da5db').val();
        console.log('Custom Post IDa:', customPostID);
    
        var link = "<?php echo  admin_url("admin-ajax.php"); ?>";

        $.ajax({
        type: 'POST',
        url: link, 
        data: {
            action: 'generate_posts', 
            customPostID: customPostID
        },
        success: function(response) {
        console.log('AJAX request successful.');
        location.reload();
        },
        error: function(error) {
        console.error('Error in AJAX request:', error);
        }
    });
   });
       


    // Remove All Entries for Keywords
        jQuery('#remove-keyword-entries').on('click', function(event) {
        event.preventDefault();
        var customPostID = jQuery(this).closest('.inside').find('#acf-field_653f97c2da5db').val();
        console.log('Custom Post IDa:', customPostID);
      
        var link = "<?php echo  admin_url("admin-ajax.php"); ?>";

        $.ajax({
        type: 'POST',
        url: link, 
        data: {
            action: 'remove_keyword_entries', // Replace with your actual PHP function name
            customPostID: customPostID
        },
        success: function(response) {
            console.log('AJAX request successful.');
            location.reload();
        },
        error: function(error) {
        console.error('Error in AJAX request:', error);
        }
        });

    });



    // Calculate  Institutions

     jQuery('#calculateinstitutions').on('click', function(event) {
        event.preventDefault();
        var customPostID = jQuery(this).closest('.inside').find('#acf-field_653f97c2da5db').val();
        console.log('Custom Post IDa:', customPostID);
    
        var link = "<?php echo  admin_url("admin-ajax.php"); ?>";

        $.ajax({
        type: 'POST',
        url: link, 
        data: {
            action: 'calculate_institutions', // Replace with your actual PHP function name
            customPostID: customPostID
        },
        success: function(response) {
            console.log('AJAX request successful.');
            location.reload();
        },
        error: function(error) {
        console.error('Error in AJAX request:', error);
        }
    });

    });


     jQuery('#calculate_posts').on('click', function(event) {
        event.preventDefault();
        var customPostID = jQuery(this).closest('.inside').find('#acf-field_653f97c2da5db').val();
        console.log('Custom Post IDa:', customPostID);
       
        var link = "<?php echo  admin_url("admin-ajax.php"); ?>";

        $.ajax({
        type: 'POST',
        url: link, 
        data: {
            action: 'calculate_posts', 
            customPostID: customPostID
        },
        success: function(response) {
        console.log('AJAX request successful.');
        location.reload();
        },
        error: function(error) {
        console.error('Error in AJAX request:', error);
        }
    });

    });

      
      $('.acf-field-6547d5451742f .acf-field-true-false input[type="checkbox"]').on('change', function() {
        var isChecked = $(this).is(':checked');
        var row = $(this).closest('.acf-row');
        var rowId = row.data('id'); // Get the row ID
        var post_id = $('input[name="post_ID"]').val(); // Assuming the post ID is available in a hidden input field
      
        // Send an AJAX request
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'update_posts_inputted',
                post_id: post_id,
                row_index: rowId.replace('row-', ''), 
                inputted_value: isChecked ? 1 : 0
            },
            success: function(response) {
                console.log('Value updated successfully.');
            },
            error: function(error) {
                console.error('Error updating value: ', error);
            }
        });
    });


 

       $('.acf-field-645a82d7c1805 .acf-field-true-false input[type="checkbox"]').on('change', function() {
        var isChecked = $(this).is(':checked');
        var row = $(this).closest('.acf-row');
        var rowId = row.data('id'); // Get the row ID
        var post_id = $('input[name="post_ID"]').val(); 
       
        // Send an AJAX request
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'update_inputted_value',
                post_id: post_id,
                row_index: rowId.replace('row-', ''), // Remove the 'row-' prefix
                inputted_value: isChecked ? 1 : 0
            },
            success: function(response) {
                console.log('Value updated successfully.');
            },
            error: function(error) {
                console.error('Error updating value: ', error);
            }
        });
    });


   $('.acf-field-64575f5db8196 input[type="url"]').on('focus', function() {
        var url = $(this).val();
        console.log("adas");
        if (url) {
            //window.open(url, '_blank');
            navigator.clipboard.writeText(url);
        }
    });

     $('.acf-field-64575fb1b819b input[type="url"]').on('focus', function() {
        var url = $(this).val();
        console.log("adas");
        if (url) {
            //window.open(url, '_blank');
            navigator.clipboard.writeText(url);        }
    });

 $('.acf-field-644be0dedadac input[type="url"]').on('focus', function() {
        var url = $(this).val();
        console.log("adas");
        if (url) {
            //window.open(url, '_blank');
            navigator.clipboard.writeText(url);        }
    });

 $('.acf-field-645a82d7c1805 input[type="url"]').on('focus', function() {
        var url = $(this).val();
        console.log("adas");
        if (url) {
            //window.open(url, '_blank');
            navigator.clipboard.writeText(url);        }
    });



// Include Regions

const include_regions_related_posts = document.getElementById('acf-field_65246f98a2abe-All-Countries');
const include_regions_related_posts_ul = include_regions_related_posts.closest('ul');
include_regions_related_posts_ul.classList.add('include_region_related_class');
    
// Exclude Regions

const exclude_regions_checkbox_related_posts = document.getElementById('acf-field_65246fc1a2abf-All-Countries');
const regons_related_posts_ul = exclude_regions_checkbox_related_posts.closest('ul');
regons_related_posts_ul.classList.add('exclude_related_posts_regions_class');

// Excluded Countries

const exclude_countries_related_posts = document.getElementById('acf-field_65246ff2a2ac0-Afghanistan');
const exclude_countries_related_posts_ul = exclude_countries_related_posts.closest('ul');
exclude_countries_related_posts_ul.classList.add('exclude_countries_related_class');


$("#acf-field_65246fc1a2abf-All-Countries").change(function() {
if($(this).is(":checked")) {
      $(".exclude_related_posts_regions_class li input").not($(this)).prop("checked", false);
    }else {
   $(".exclude_related_posts_regions_class li input").not("#acf-field_65246fc1a2abf-All-Countries").change(function() {
    if($(this).is(":checked")) {
      $("#acf-field_65246fc1a2abf-All-Countries").prop("checked", false);
     }
    });
}
});

    

$(document).on('change', '.include_region_related_class li input', function () {
    const checkedValues = $('.include_region_related_class li input:checked').map(function () {
        return this.value;
    }).get();

    $('.exclude_related_posts_regions_class li input').prop('checked', false);

    $('.exclude_related_posts_regions_class li input').each(function () {
        if (!checkedValues.includes($(this).val())) {
            $(this).prop('checked', true);
        }
    });
    check_excluded_countries();
});

$(".exclude_related_posts_regions_class li input").change(function () {
    const checkedValues = $('.exclude_related_posts_regions_class li input:checked').map(function () {
        return this.value;
    }).get();

    $('.include_region_related_class li input').prop('checked', false);

    $('.include_region_related_class li input').each(function () {
        if (!checkedValues.includes($(this).val())) {
            $(this).prop('checked', true);
        }
    });
});




$(".exclude_related_posts_regions_class li input").change(function() {

  if ($(this).is(":checked")) {

    console.log($(this).val());

    if ($(this).val() === "All Countries") {
      $(".exclude_countries_related_class li input").prop("checked", true);
    } else {
      $(".exclude_countries_related_class li input").prop("checked", false);
      let exclude_related_posts_selected_array = $('.exclude_related_posts_regions_class li input[type=checkbox]:checked').map(function() {
        return this.value;
      }).get();

      var new_array = [];

      // loop through each region
      for (var i = 0; i < exclude_related_posts_selected_array.length; i++) {

        // if the region is "Africa", add all the African countries to the new array
      if (exclude_related_posts_selected_array[i] == "Africa") {
       new_array = new_array.concat(<?php echo json_encode($africa); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Asia") {
        new_array = new_array.concat(<?php echo json_encode($asia); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Caribbean") {
        new_array = new_array.concat(<?php echo json_encode($caribbean); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Commonwealth") {
        new_array = new_array.concat(<?php echo json_encode($commonwealth_list); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Europe") {
        new_array = new_array.concat(<?php echo json_encode($Europe); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "European Economic Area") {
        new_array = new_array.concat(<?php echo json_encode($EuropeanEconomicArea); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "European Union") {
        new_array = new_array.concat(<?php echo json_encode($EuropeanUnion); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Latin America") {
        new_array = new_array.concat(<?php echo json_encode($latinAmerica); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Middle East") {
        new_array = new_array.concat(<?php echo json_encode($middleEast_list); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "North America") {
        new_array = new_array.concat(<?php echo json_encode($northAmerica_list); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Oceania") {
        new_array = new_array.concat(<?php echo json_encode($oceania_list); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Pacific Island") {
        new_array = new_array.concat(<?php echo json_encode($pacific); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Southeast Asia") {
        new_array = new_array.concat(<?php echo json_encode($southeastAsia); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Western Hemisphere") {
        new_array = new_array.concat(<?php echo json_encode($westernHemisphere); ?>);
      } 
      if (exclude_related_posts_selected_array[i] == "South Asia") {
        new_array = new_array.concat(<?php echo json_encode($southAsia_list); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "East Asia") {
        new_array = new_array.concat(<?php echo json_encode($eastAsia_list); ?>);
      }

      }

      // remove duplicates from the new array
      new_array = Array.from(new Set(new_array));
      console.log(new_array);

      $('.exclude_countries_related_class li input[type="checkbox"]').each(function() {
        const checkboxValue = $(this).val();
        if (new_array.includes(checkboxValue)) {
          $(this).prop('checked', true);
        }
      });
    }

  } else {

    const uncheckedRegion = $(this).val();
    const countriesToUncheck = getRegionCountries(uncheckedRegion); // Ensure getRegionCountries function is defined
    $('.exclude_countries_related_class li input[type="checkbox"]').each(function() {
      const checkboxValue = $(this).val();
      if (countriesToUncheck.includes(checkboxValue)) {
        $(this).prop('checked', false);
      }
    });

    if (uncheckedRegion === "All Countries") {
      $(".exclude_countries_related_class li input").prop("checked", false);
    }
  }



});



    
});


function check_excluded_countries() {

    

    let exclude_related_posts_selected_array = jQuery('.exclude_related_posts_regions_class li input[type=checkbox]:checked').map(function() {
        return this.value;
      }).get();
      
      jQuery(".exclude_countries_related_class li input").prop("checked", false);
      console.log(exclude_related_posts_selected_array);

      var new_array = [];

      // loop through each region
      for (var i = 0; i < exclude_related_posts_selected_array.length; i++) {

        // if the region is "Africa", add all the African countries to the new array
      if (exclude_related_posts_selected_array[i] == "Africa") {
       new_array = new_array.concat(<?php echo json_encode($africa); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Asia") {
        new_array = new_array.concat(<?php echo json_encode($asia); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Caribbean") {
        new_array = new_array.concat(<?php echo json_encode($caribbean); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Commonwealth") {
        new_array = new_array.concat(<?php echo json_encode($commonwealth_list); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Europe") {
        new_array = new_array.concat(<?php echo json_encode($Europe); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "European Economic Area") {
        new_array = new_array.concat(<?php echo json_encode($EuropeanEconomicArea); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "European Union") {
        new_array = new_array.concat(<?php echo json_encode($EuropeanUnion); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Latin America") {
        new_array = new_array.concat(<?php echo json_encode($latinAmerica); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Middle East") {
        new_array = new_array.concat(<?php echo json_encode($middleEast_list); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "North America") {
        new_array = new_array.concat(<?php echo json_encode($northAmerica_list); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Oceania") {
        new_array = new_array.concat(<?php echo json_encode($oceania_list); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Pacific Island") {
        new_array = new_array.concat(<?php echo json_encode($pacific); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Southeast Asia") {
        new_array = new_array.concat(<?php echo json_encode($southeastAsia); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "Western Hemisphere") {
        new_array = new_array.concat(<?php echo json_encode($westernHemisphere); ?>);
      } 
      if (exclude_related_posts_selected_array[i] == "South Asia") {
        new_array = new_array.concat(<?php echo json_encode($southAsia_list); ?>);
      }
      if (exclude_related_posts_selected_array[i] == "East Asia") {
        new_array = new_array.concat(<?php echo json_encode($eastAsia_list); ?>);
      }

      }

      // remove duplicates from the new array
      new_array = Array.from(new Set(new_array));
      

      jQuery('.exclude_countries_related_class li input[type="checkbox"]').each(function() {
        const checkboxValue = jQuery(this).val();
        if (new_array.includes(checkboxValue)) {
          jQuery(this).prop('checked', true);
        }
      });


    
}

</script>

<?php 
  if (get_post_type() == 'scholarships') {

   
?>
    

<script type="text/javascript">
jQuery(document).ready(function($) {
// get the checkbox element by its ID

const checkbox = document.getElementById('acf-field_62ca6ed806bc6-All-Nationalities');
const ul = checkbox.closest('ul');
// add a custom class to the ul element
ul.classList.add('my-custom-class');
    
  // Listen for changes on the "All Nationalities" checkbox
  $("#acf-field_62ca6ed806bc6-All-Nationalities").change(function() {
    


    if($(this).is(":checked")) {
      // If the "All Nationalities" checkbox is checked,
      // uncheck all other nationality checkboxes
      
      $(".my-custom-class li input").not($(this)).prop("checked", false);
    }
  });

  // // Listen for changes on the other nationality checkboxes
  $(".my-custom-class li input").not("#acf-field_62ca6ed806bc6-All-Nationalities").change(function() {
    if($(this).is(":checked")) {
      // If any other nationality checkbox is checked,
      // uncheck the "All Nationalities" checkbox
      $("#acf-field_62ca6ed806bc6-All-Nationalities").prop("checked", false);
    }
  });

// get the checkbox element by its ID
const checkbox_subject = document.getElementById('acf-field_633c2fdaca399-All-Subjects');
const ull = checkbox_subject.closest('ul');
// add a custom class to the ul element
ull.classList.add('my-custom-class-subject');


   // Listen for changes on the "All Nationalities" checkbox
  $("#acf-field_633c2fdaca399-All-Subjects").change(function() {
    if($(this).is(":checked")) {
      // If the "All Subjects" checkbox is checked,
      // uncheck all other subject checkboxes
      $(".my-custom-class-subject li input").not($(this)).prop("checked", false);
    }
  });

  // // Listen for changes on the other nationality checkboxes
  $(".my-custom-class-subject li input").not("#acf-field_633c2fdaca399-All-Subjects").change(function() {
    if($(this).is(":checked")) {
      // If any other subject checkbox is checked,
      // uncheck the "All Subjects" checkbox
      $("#acf-field_633c2fdaca399-All-Subjects").prop("checked", false);
    }
  });


// get the checkbox element by its ID
const checkbox_exclude_nationalites = document.getElementById('acf-field_633f0ce569a44-Exclude-All-Nationalities');
const ul_exclude_nationalities = checkbox_exclude_nationalites.closest('ul');
// add a custom class to the ul element
ul_exclude_nationalities.classList.add('exclude_nationalities');


   // Listen for changes on the "All Exclude Nationalites" checkbox
  $("#acf-field_633f0ce569a44-Exclude-All-Nationalities").change(function() {
    if($(this).is(":checked")) {
      // If the "All Exclude Nationalities" checkbox is checked,
      // uncheck all other nationalites checkboxes
      $(".exclude_nationalities li input").not($(this)).prop("checked", false);
      $(".my-custom-class li input ").prop("checked", false);
    }
  });

  // // Listen for changes on the other nationality checkboxes
  $(".exclude_nationalities li input").not("#acf-field_633f0ce569a44-Exclude-All-Nationalities").change(function() {
    if($(this).is(":checked")) {
      // If any other subject checkbox is checked,
      // uncheck the "All Subjects" checkbox
      $("#acf-field_633f0ce569a44-Exclude-All-Nationalities").prop("checked", false);
      


    let values = $('.exclude_nationalities li input[type=checkbox]:checked').map(function() {
      return this.value;
    }).get();
    

     $('.my-custom-class li input[type="checkbox"]').each(function() {
      const checkboxValue = $(this).val();
     if (values.includes(checkboxValue)) {
    $(this).prop('checked', false);
    }else {
    $(this).prop('checked', true);
    }
     });

  $("#acf-field_62ca6ed806bc6-All-Nationalities").prop("checked", false);
  }

  });

        // get the checkbox element by its ID
        const regions_checkbox = document.getElementById('acf-field_6372189f1e3d8-Africa');
        const regons_ul = regions_checkbox.closest('ul');
        // add a custom class to the ul element
        regons_ul.classList.add('include_regions_class');

     $(".include_regions_class li input").change(function() {
      if($(this).is(":checked")) {
        $("#acf-field_62ca6ed806bc6-All-Nationalities").prop("checked", false);
        let regions_selected_array = $('.include_regions_class li input[type=checkbox]:checked').map(function() {
          return this.value;
          }).get();

         var new_array = [];

     // loop through each region
     for (var i = 0; i < regions_selected_array.length; i++) {
  
     // if the region is "Africa", add all the African countries to the new array
      if (regions_selected_array[i] == "Africa") {
       new_array = new_array.concat(<?php echo json_encode($africa); ?>);
      }
      if (regions_selected_array[i] == "Asia") {
        new_array = new_array.concat(<?php echo json_encode($asia); ?>);
      }
      if (regions_selected_array[i] == "Caribbean") {
        new_array = new_array.concat(<?php echo json_encode($caribbean); ?>);
      }
      if (regions_selected_array[i] == "Commonwealth") {
        new_array = new_array.concat(<?php echo json_encode($commonwealth_list); ?>);
      }
      if (regions_selected_array[i] == "Europe") {
        new_array = new_array.concat(<?php echo json_encode($Europe); ?>);
      }
      if (regions_selected_array[i] == "European Economic Area") {
        new_array = new_array.concat(<?php echo json_encode($EuropeanEconomicArea); ?>);
      }
      if (regions_selected_array[i] == "European Union") {
        new_array = new_array.concat(<?php echo json_encode($EuropeanUnion); ?>);
      }
      if (regions_selected_array[i] == "Latin America") {
        new_array = new_array.concat(<?php echo json_encode($latinAmerica); ?>);
      }
      if (regions_selected_array[i] == "Middle East") {
        new_array = new_array.concat(<?php echo json_encode($middleEast_list); ?>);
      }
      if (regions_selected_array[i] == "North America") {
        new_array = new_array.concat(<?php echo json_encode($northAmerica_list); ?>);
      }
      if (regions_selected_array[i] == "Oceania") {
        new_array = new_array.concat(<?php echo json_encode($oceania_list); ?>);
      }
      if (regions_selected_array[i] == "Pacific Island") {
        new_array = new_array.concat(<?php echo json_encode($pacific); ?>);
      }
      if (regions_selected_array[i] == "Southeast Asia") {
        new_array = new_array.concat(<?php echo json_encode($southeastAsia); ?>);
      }
      if (regions_selected_array[i] == "Western Hemisphere") {
        new_array = new_array.concat(<?php echo json_encode($westernHemisphere); ?>);
      } 
      if (regions_selected_array[i] == "South Asia") {
        new_array = new_array.concat(<?php echo json_encode($southAsia_list); ?>);
      }
      if (regions_selected_array[i] == "East Asia") {
        new_array = new_array.concat(<?php echo json_encode($eastAsia_list); ?>);
      }
}

// remove duplicates from the new array
new_array = Array.from(new Set(new_array));

    $('.my-custom-class li input[type="checkbox"]').each(function() {
      const checkboxValue = $(this).val();
     if (new_array.includes(checkboxValue)) {
    $(this).prop('checked', true);
    }
     });


      } else {

    const uncheckedRegion = $(this).val();
    const countriesToUncheck = getRegionCountries(uncheckedRegion);
    $('.my-custom-class li input[type="checkbox"]').each(function() {
      const checkboxValue = $(this).val();
      if (countriesToUncheck.includes(checkboxValue)) {
        $(this).prop('checked', false);
      }
    });
}

  });


   //Exclude Regions Logic Here 

   //First we add a class to the closet ul

   //const exclude_regions_checkbox = document.getElementById('acf-field_64ca21f1da211-Africa');
  
   const exclude_regions_checkbox = document.getElementById('acf-field_64cb9496f11d3-Africa');
        const exclude_regons_ul = exclude_regions_checkbox.closest('ul');
        // add a custom class to the ul element
        exclude_regons_ul.classList.add('exclude_regions_class');


$(".exclude_regions_class li input").change(function() {
    if($(this).is(":checked")) {
        // Initially, check all countries
        $('.my-custom-class li input[type="checkbox"]').prop('checked', true);
          $("#acf-field_62ca6ed806bc6-All-Nationalities").prop("checked", false);
        // Get countries that belong to the checked region
        const excludedRegion = $(this).val();
        const countriesToExclude = getRegionCountries(excludedRegion);

        // Uncheck those countries
        $('.my-custom-class li input[type="checkbox"]').each(function() {
            const checkboxValue = $(this).val();
            if (countriesToExclude.includes(checkboxValue)) {
                $(this).prop('checked', false);
            }
        });

        // Now, for the include regions checkboxes
        let excludedRegions = $('.exclude_regions_class li input[type=checkbox]:checked').map(function() {
          return this.value;
        }).get();

        $(".include_regions_class li input").each(function() {
            if (excludedRegions.includes($(this).val())) {
                $(this).prop('checked', false);  // uncheck the region in include regions
            } else {
                $(this).prop('checked', true);   // check other regions
            }
        });

    } else {
        // If the region is unchecked, we assume you want to revert to checking those countries again
        const includedRegion = $(this).val();
        const countriesToInclude = getRegionCountries(includedRegion);

        $('.my-custom-class li input[type="checkbox"]').each(function() {
            const checkboxValue = $(this).val();
            if (countriesToInclude.includes(checkboxValue)) {
                $(this).prop('checked', true);
            }
        });

        // Also, since the region is unchecked in exclude regions, we should check it in include regions
        $(".include_regions_class li input[value='" + includedRegion + "']").prop('checked', true);
    }
});




});





    </script>
    <?php
  }
?>

<script>

function getRegionCountries(region) {
  switch (region) {
    case "Africa":
      return <?php echo json_encode($africa); ?>;
    case "Asia":
      return <?php echo json_encode($asia); ?>;
    case "Caribbean":
      return <?php echo json_encode($caribbean); ?>;
    case "Commonwealth":
      return <?php echo json_encode($commonwealth_list); ?>;
    case "Europe":
      return <?php echo json_encode($Europe); ?>;
    case "European Economic Area":
      return <?php echo json_encode($EuropeanEconomicArea); ?>;
    case "European Union":
      return <?php echo json_encode($EuropeanUnion); ?>;
    case "Latin America":
      return <?php echo json_encode($latinAmerica); ?>;
    case "Middle East":
      return <?php echo json_encode($middleEast_list); ?>;
    case "North America":
      return <?php echo json_encode($northAmerica_list); ?>;
    case "Oceania":
      return <?php echo json_encode($oceania_list); ?>;
    case "Pacific Island":
      return <?php echo json_encode($pacific); ?>;
    case "Southeast Asia":
      return <?php echo json_encode($southeastAsia); ?>;
    case "Western Hemisphere":
      return <?php echo json_encode($westernHemisphere); ?>;
      case "South Asia":
      return <?php echo json_encode($southAsia_list); ?>;
      case "East Asia":
      return <?php echo json_encode($eastAsia_list); ?>;
    default:
      return [];
  }
}



    </script>
<?php


}
add_action('admin_head', 'add_custom_js');




// // Add Role for new user scholarship_editor
// function add_scholarship_user_role() {
//     $the_scholarship_editor_capabilities = get_role('editor')->capabilities;
//     add_role('scholarship_editor', 'Scholarship Editor', $the_scholarship_editor_capabilities);
// }
// add_action('init', 'add_scholarship_user_role');

// function add_scholarship_caps_to_scholarship_editor() {
//     // gets the scholarship_editor role
//     $scholarship_editor = get_role('scholarship_editor');

//     // Remove default post and page capabilities
//     $scholarship_editor->remove_cap('edit_post');
//     $scholarship_editor->remove_cap('edit_posts');
//     $scholarship_editor->remove_cap('edit_other_posts');
//     $scholarship_editor->remove_cap('publish_posts');
//     $scholarship_editor->remove_cap('read_private_posts');
//     $scholarship_editor->remove_cap('delete_post');

//     $scholarship_editor->remove_cap('edit_page');
//     $scholarship_editor->remove_cap('edit_pages');
//     $scholarship_editor->remove_cap('edit_other_pages');
//     $scholarship_editor->remove_cap('publish_pages');
//     $scholarship_editor->remove_cap('read_private_pages');
//     $scholarship_editor->remove_cap('delete_page');
    
//     // Add capabilities for scholarships
//     $scholarship_editor->add_cap('edit_scholarships');
//     $scholarship_editor->add_cap('edit_others_scholarships');
//     $scholarship_editor->add_cap('publish_scholarships');
//     $scholarship_editor->add_cap('edit_published_scholarships');
//     $scholarship_editor->add_cap('read_scholarships');
//     $scholarship_editor->add_cap('delete_scholarships');
//     $scholarship_editor->add_cap('delete_others_scholarships');
//     $scholarship_editor->add_cap('delete_published_scholarships');

//     // Add capabilities for institutions
//     $scholarship_editor->add_cap( 'edit_institutions' ); 
//     $scholarship_editor->add_cap( 'edit_others_institutions' );
//     $scholarship_editor->add_cap( 'publish_institutions' );
//     $scholarship_editor->add_cap( 'edit_published_institutions' );
//     $scholarship_editor->add_cap( 'read_institutions' );
//     $scholarship_editor->add_cap( 'delete_institutions' );
//     $scholarship_editor->add_cap( 'delete_others_institutions' );
//     $scholarship_editor->add_cap( 'delete_published_institutions' );

//     // Add custom capabilities related to scholarships, institutions, and cities
//     // Add the necessary capabilities here based on your custom post types for scholarships, institutions, and cities
// }
// add_action('init', 'add_scholarship_caps_to_scholarship_editor');

// function toc_shortcode($atts, $content = null) {
//   $a = shortcode_atts( array(
//     'heading' => 'Table of Contents',
//   ), $atts );

//   // Split the content into steps
//   $matches = array();
//   preg_match_all('/<a href="([^"]+)">([^<]+)<\/a>/i', $content, $matches, PREG_SET_ORDER);

//   // Group steps by column
//   $columns = array(array(), array());
//   $step_count = count($matches);
//   $steps_per_column = ceil($step_count / 2);
//   $left_steps = min($steps_per_column, $step_count);
//   for ($i = 0; $i < $left_steps; $i++) {
//     $columns[0][] = $matches[$i];
//   }
//   $right_steps = $step_count - $left_steps;
//   for ($i = 0; $i < $right_steps; $i++) {
//     $columns[1][] = $matches[$left_steps + $i];
//   }

//   // Generate the HTML for the table of contents
//   $output = '<div class="table-of-contents">';
//   $output .= '<h2>' . esc_html($a['heading']) . '</h2>';
//   $output .= '<div class="columns">';
//   $output .= '<div class="column">';
//   $output .= '<ol>';
//   foreach ($columns[0] as $item) {
//     $output .= '<li>';
//     $output .= '<a href="' . $item[1] . '">' . $item[2] . '</a>';
//     $output .= '</li>';
//   }
//   $output .= '</ol>';
//   $output .= '</div>';
//   $output .= '<div class="column">';
//   $output .= '<ol start="' . ($left_steps + 1) . '">';
//   foreach ($columns[1] as $item) {
//     $output .= '<li>';
//     $output .= '<a href="' . $item[1] . '">' . $item[2] . '</a>';
//     $output .= '</li>';
//   }
//   $output .= '</ol>';
//   $output .= '</div>';
//   $output .= '</div>';
//   $output .= '</div>';

//   return $output;
// }




function newt_toc_shortcode($atts, $content = null) {
    $a = shortcode_atts(array(
        'heading' => 'Table of Contents',
    ), $atts);
    $content = do_shortcode($content);
    $matches = array();
    preg_match_all('/<a href="([^"]+)"(?: substep)?>([^<]+)<\/a>/is', $content, $matches, PREG_SET_ORDER);

   $output = '<div class="new-table-of-contents">';
 $output .= '<h2>' . esc_html($a['heading']) . ' <span class="toc-icon" > <img src="' . site_url() . '/wp-content/uploads/2024/01/list.png">  <svg style="padding-left:2px;fill: black;color:black" class="arrow-unsorted-368013" xmlns="http://www.w3.org/2000/svg" width="17px" height="17px" viewBox="0 0 24 24" version="1.2" baseProfile="tiny"><path d="M18.2 9.3l-6.2-6.3-6.2 6.3c-.2.2-.3.4-.3.7s.1.5.3.7c.2.2.4.3.7.3h11c.3 0 .5-.1.7-.3.2-.2.3-.5.3-.7s-.1-.5-.3-.7zM5.8 14.7l6.2 6.3 6.2-6.3c.2-.2.3-.5.3-.7s-.1-.5-.3-.7c-.2-.2-.4-.3-.7-.3h-11c-.3 0-.5.1-.7.3-.2.2-.3.5-.3.7s.1.5.3.7z"></path></svg> </span> </h2>';

   
   
   
    $output .= '<div class="toc-wrapper" style="padding-top:20px;">';
    $output .= '<hr style="width:96%;margin:auto;">';
    $output .= '<div class="toc-columns">';
    
    $step_count = 0;
    $steps = array();

    // Group steps and substeps together
    foreach ($matches as $item) {
        if (strpos($item[0], ' substep') === false) {
            $step_count++;
            $steps[] = array(
                'title' => $item[2],
                'link' => $item[1],
                'substeps' => array(),
            );
        } else {
            $last_step = end($steps);
            $last_step['substeps'][] = array(
                'title' => $item[2],
                'link' => $item[1],
            );
            array_pop($steps);
            $steps[] = $last_step;
        }
    }

    $half_steps = ceil($step_count / 2);
    $current_step = 0;

    for ($i = 0; $i < 2; $i++) {
        $output .= '<ol class="toc-column">';
        while (!empty($steps) && ($i == 1 || $current_step < $half_steps)) {
            $step = array_shift($steps);
            $current_step++;

            if ($i == 0 || $current_step > $half_steps) {
                $output .= '<li><a href="' . $step['link'] . '">' . $step['title'] . '</a>';
                if (!empty($step['substeps'])) {
                    $output .= '<ul class="sub-steps">';
                    foreach ($step['substeps'] as $substep) {
                        $output .= '<li><a href="' . $substep['link'] . '">' . $substep['title'] . '</a></li>';
                    }
                    $output .= '</ul>';
                }
                $output .= '</li>';
            }
        }
        $output .= '</ol>';
    }
    $output .= '</div>'; // Close .toc-columns
    $output .= '</div>';
    $output .= '</div>'; // Close .new-table-of-contents
    return $output;
}
add_shortcode('toc', 'newt_toc_shortcode');


function wise_shortcode( $atts, $content = null ) {
  return '<div class="wise">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'wise', 'wise_shortcode' );



function custom_rankmath_title($title) {
   $current_url = $_SERVER['REQUEST_URI'];
    global $post;
    if ($post->post_type == 'scholarships') {
        $institution_id = get_post_meta($post->ID, 'scholarship_institution', true);
        if (!empty($institution_id)) {
            $institution_title = get_the_title($institution_id);
            $title = get_the_title($post->ID) . " at " . $institution_title;
        } else {
            $title = get_the_title($post->ID);
        }

        $title  =  $title .' '. date("Y").' - '.date('Y', strtotime('+1 year'));
    } elseif ($post->post_type == 'institution') {
        $institution_title = get_the_title( $post->ID );


        $title = $institution_title ." " . " Scholarships for International Students" .' '. date("Y").' - '.date('Y', strtotime('+1 year'));
    }

    

    elseif (strpos($current_url, 'scholarship-search') !== false) {

        // remove the trailing slash if it exists
        $current_url = rtrim($current_url, '/');
        $url_parts = explode('/', $current_url);
        // we use array_slice to get rid of the first three parts
        $url_parts = array_slice($url_parts, 2);

        $degree_label_array = ['masters', 'bachelors', 'phd'];
        $currently_open_label_array = ['open', 'one-month', 'two-month', 'three-month', 'four-month', 'five-month', 'six-month', 'twelve-month'];
        $scholarship_type_array = ['full-funding', 'full-tuition', 'partial-funding'];
        $scholarship_details = acf_get_fields('group_62ca6e3cc910c');

       $scholarship_details  = acf_get_fields('group_62ca6e3cc910c');
       // Get fields by name.
       $published_countries = array_column($scholarship_details, null, 'name')['published_countries'];
       $contry_array = $published_countries['choices'];

$nationalites_array = array_column($scholarship_details, null, 'name')['eligible_nationality'];
$nationalites_array = $nationalites_array['choices'];

  foreach ($nationalites_array as $key => $national_value) {
            $national_value = strtolower($national_value);
            $national_value = str_replace(' ', '-', $national_value);
            $nationalites_array[$key] = $national_value;
        }



        $location_array = array();
        foreach ($contry_array as $value) {
            $location_array[$value] = $value;
        }

        foreach ($location_array as $key => $location_value) {
            $location_value = strtolower($location_value);
            $location_value = str_replace(' ', '-', $location_value);
            $location_array[$key] = $location_value;
        }
         
        

      
        




        $location_value = '';
        $location_matches_array = array_intersect($location_array, $url_parts);
        if (!empty($location_matches_array)) {
            $location_value = reset($location_matches_array);
        } else {
            // Handle the case when $url_parts is empty
            $location_value = ''; // Replace 'default-value' with the desired value
        }

        $location_value = str_replace('-', ' ', $location_value);
        $location_value = ucwords(strtolower($location_value));

        $subject_array = $scholarship_details[12]['choices'];
        foreach ($subject_array as $key => $subject_value) {
            $subject_value = strtolower($subject_value);
            $subject_value = str_replace(' ', '-', $subject_value);
            $subject_array[$key] = $subject_value;
        }
       
         
// Initialize the variable to false
$nationality = false;

// Loop through the array
foreach ($url_parts as &$part) {
    if (strpos($part, 'nationality-') === 0) {
        $nationality = true; // Set the variable to true if "nationality-" is found
        $part = str_replace('nationality-', '', $part); // Remove the "nationality-" prefix
    }
}
unset($part);  // Unset the reference to prevent unintended side-effects
$nationality_value = "";


if ($nationality) {
   $nationality_matches_array = array_intersect($nationalites_array, $url_parts);
        if (!empty($nationality_matches_array)) {
            $nationality_value = reset($nationality_matches_array);
        } else {
            $nationality_value = '';
        }

        $nationality_value = str_replace('-', ' ', $nationality_value);
        $nationality_value = ucwords(strtolower($nationality_value));
} 
      


        

 
        $subject_matches_array = array_intersect($subject_array, $url_parts);
        if (!empty($subject_matches_array)) {
            $subject_value = reset($subject_matches_array);
        } else {
            $subject_value = '';
        }

        $subject_value = str_replace('-', ' ', $subject_value);
        $subject_value = ucwords(strtolower($subject_value));

        $degree_values_match = array_intersect($degree_label_array, $url_parts);
        if (!empty($degree_values_match)) {
            $degree_value = reset($degree_values_match);
            if ($degree_value == "masters") {
                $degree_value = "Master's";
            } elseif ($degree_value == "bachelors") {
                $degree_value = "Bachelor's";
            } elseif ($degree_value == "phd") {
                $degree_value = "PhD";
            }
        } else {
            // Handle the case when $url_parts is empty
            $degree_value = ''; // Replace 'default-value' with the desired value
        }

        $scholarship_type_values_match = array_intersect($scholarship_type_array, $url_parts);
        if (!empty($scholarship_type_values_match)) {
            $scholarship_type_value = reset($scholarship_type_values_match);
        } else {
            // Handle the case when $url_parts is empty
            $scholarship_type_value = ''; // Replace 'default-value' with the desired value
        }

        $scholarship_type_value = str_replace('-', ' ', $scholarship_type_value);
        $scholarship_type_value = ucwords(strtolower($scholarship_type_value));

        $application_matches_array = array_intersect($currently_open_label_array, $url_parts);
        if (!empty($application_matches_array)) {
            $application_value = reset($application_matches_array);
        } else {
            $application_value = '';
        }

        $current_date = date("Y-m-d H:i:s");

        $next_due_date = '';


        if ($application_value == "open") {
            $next_due_date = date('Y-m-d H:i:s', strtotime("+3820 days"));
        }

        if ($application_value == "one-month") {
            $next_due_date = date('Y-m-d H:i:s', strtotime("+30 days"));
        }

        if ($application_value == "two-month") {
            $next_due_date = date('Y-m-d H:i:s', strtotime("+60 days"));
        }

        if ($application_value == "three-month") {
            $next_due_date = date('Y-m-d H:i:s', strtotime("+90 days"));
        }

        if ($application_value == "four-month") {
            $next_due_date = date('Y-m-d H:i:s', strtotime("+120 days"));
        }

        if ($application_value == "five-month") {
            $next_due_date = date('Y-m-d H:i:s', strtotime("+150 days"));
        }

        if ($application_value == "six-month") {
            $next_due_date = date('Y-m-d H:i:s',  strtotime("+180 days"));
        }

        if ($application_value == "twelve-month") {
            $next_due_date = date('Y-m-d H:i:s',  strtotime("+364 days"));
        }

        if(isset($subject_value) && $subject_value){
    
        $subject_query = array('type' => 'string' , 'key' => 'eligible_programs', 'value' => $subject_value, 'compare' => 'LIKE');
        }


        if(isset($nationality_value) && $nationality_value){
    
        $nationality_query = array('type' => 'string' , 'key' => 'eligible_nationality', 
            'value' => $nationality_value, 'compare' => 'LIKE');
        }  

        if (isset($degree_value) && $degree_value) {
            $degree_query = array('key' => 'eligible_degrees',  'value' => $degree_value,  'compare' => 'LIKE');
        }

        if (isset($scholarship_type_value) && $scholarship_type_value) {
            $type_query = array('key' => 'amount_category', 'value' => $scholarship_type_value, 'compare' => "LIKE");
        }

        if (isset($application_value) && $application_value) {
            if ($degree_value == "Master's") {
                if ($application_value == "open") {
                    $application_query = array(
                        'relation' => 'AND',
                        array('key' => 'current_masters_scholarship_deadline', 'compare' => '<=', 'value' => $next_due_date, 'type' => 'date'),
                        array('key' => 'current_masters_scholarship_deadline', 'compare' => '>=', 'value' => $current_date, 'type' => 'date'),
                        array('key' => 'master_open_date', 'value' => 'Yes', 'compare' => "LIKE"),
                    );
                } else {
                    $application_query = array(
                        'relation' => 'AND',
                        array('key' => 'current_masters_scholarship_deadline', 'compare' => '<=', 'value' => $next_due_date, 'type' => 'date'),
                        array('key' => 'current_masters_scholarship_deadline', 'compare' => '>=', 'value' => $current_date, 'type' => 'date'),
                    );
                }
            }

            if ($degree_value == "Bachelor's") {
                if ($application_value == "open") {
                    $application_query = array(
                        'relation' => 'AND',
                        array('key' => 'current_bachelors_scholarship_deadline', 'compare' => '<=', 'value' => $next_due_date, 'type' => 'date'),
                        array('key' => 'current_bachelors_scholarship_deadline', 'compare' => '>=', 'value' => $current_date, 'type' => 'date'),
                        array('key' => 'bachelor_open_date', 'value' => 'Yes', 'compare' => "LIKE"),
                    );
                } else {
                    $application_query = array(
                        'relation' => 'AND',
                        array('key' => 'current_bachelors_scholarship_deadline', 'compare' => '<=', 'value' => $next_due_date, 'type' => 'date'),
                        array('key' => 'current_bachelors_scholarship_deadline', 'compare' => '>=', 'value' => $current_date, 'type' => 'date'),
                    );
                }
            }
        }

        if (!empty($location_value)) {
            $loop_institute = get_institutions_location($location_value);
            $institute_ids = $loop_institute->get_posts();
        }

        if (isset($location_value) && $location_value) {
            $location_query  = array('key' => 'scholarship_institution', 'value' => $institute_ids, 'compare' => "IN");
        }

        $meta_query = array('relation' => 'AND');

        if ($subject_query) {
            $meta_query[] = $subject_query;
        }

        if ($degree_query) {
            $meta_query[] = $degree_query;
        }

        if ($location_query) {
            $meta_query[] = $location_query;
        }

        if ($type_query) {
            $meta_query[] = $type_query;
        }

          if ($nationality_query) {
            $meta_query[] = $nationality_query;
        }

        if ($application_query) {
            $meta_query[] = $application_query;
        }

        $ad_args = array(
             'post_type' => 'scholarships',
        'post_status' => 'publish',
     
     
     'update_post_meta_cache' => false,
     'update_post_term_cache' => false,
     'cache_results'          => false,
     'fields' => 'ids',


      
        );

        if ($meta_query) {
            $ad_args['meta_query'] = $meta_query;
        }

        $loop = new WP_Query($ad_args);

        // Save the found_posts value
        $found_posts = $loop->found_posts;

        $page = '';

      foreach ($url_parts as $part) {
       if (is_numeric($part)) {
        $page = $part;

        break; // Stop the loop if an integer value is found
    }
   }

       $text = "";

if ($scholarship_type_value == "Full Funding") {
    $scholarship_type_value = "Fully Funded";
}

if ($scholarship_type_value == "Partial Funding") {
    $scholarship_type_value = "Partially Funded";
}

// Initial scholarship phrase construction
$scholarship_phrase = $found_posts;

if ($scholarship_type_value) {
    $scholarship_phrase .= " " . $scholarship_type_value;
}

if ($degree_value) {
    $scholarship_phrase .= " " . $degree_value;
}

$scholarship_phrase .= " Scholarships";

$text .= $scholarship_phrase;

// Add location if present
if ($location_value) {
    $text .= " in " . $location_value;
}

// Add subject if present
if ($subject_value) {
    $text .= " for " . $subject_value;
}
if($nationality_value){
$text .= " for ". $nationality_value . " Students";
}else {
   $text .= " for International Students "; 
}

// Add pagination details if present
if ($page) {
    $text .= "- Page " . $page . " of " . ceil($found_posts / 20);
}

return $text;

       

        
    }






    return $title;
}

add_filter('rank_math/frontend/title', 'custom_rankmath_title');



function generate_scholarship_text($current_url) {
    
        // remove the trailing slash if it exists
        $current_url = rtrim($current_url, '/');
        $url_parts = explode('/', $current_url);
        // we use array_slice to get rid of the first three parts
        $url_parts = array_slice($url_parts, 2);

        $degree_label_array = ['masters', 'bachelors', 'phd'];
        $currently_open_label_array = ['open', 'one-month', 'two-month', 'three-month', 'four-month', 'five-month', 'six-month', 'twelve-month'];
        $scholarship_type_array = ['full-funding', 'full-tuition', 'partial-funding'];
        $scholarship_details = acf_get_fields('group_62ca6e3cc910c');

       $scholarship_details  = acf_get_fields('group_62ca6e3cc910c');
       // Get fields by name.
       $published_countries = array_column($scholarship_details, null, 'name')['published_countries'];
       $contry_array = $published_countries['choices'];

$nationalites_array = array_column($scholarship_details, null, 'name')['eligible_nationality'];
$nationalites_array = $nationalites_array['choices'];

  foreach ($nationalites_array as $key => $national_value) {
            $national_value = strtolower($national_value);
            $national_value = str_replace(' ', '-', $national_value);
            $nationalites_array[$key] = $national_value;
        }



        $location_array = array();
        foreach ($contry_array as $value) {
            $location_array[$value] = $value;
        }

        foreach ($location_array as $key => $location_value) {
            $location_value = strtolower($location_value);
            $location_value = str_replace(' ', '-', $location_value);
            $location_array[$key] = $location_value;
        }
         
        

      
        




        $location_value = '';
        $location_matches_array = array_intersect($location_array, $url_parts);
        if (!empty($location_matches_array)) {
            $location_value = reset($location_matches_array);
        } else {
            // Handle the case when $url_parts is empty
            $location_value = ''; // Replace 'default-value' with the desired value
        }

        $location_value = str_replace('-', ' ', $location_value);
        $location_value = ucwords(strtolower($location_value));

        $subject_array = $scholarship_details[12]['choices'];
        

         
        $subject_array = array_column($scholarship_details, null, 'name')['eligible_programs'];
        $subject_array = $subject_array['choices'];

        

        foreach ($subject_array as $key => $subject_value) {
            $subject_value = strtolower($subject_value);
            $subject_value = str_replace(' ', '-', $subject_value);
            $subject_array[$key] = $subject_value;
        }
       
         
// Initialize the variable to false
$nationality = false;

// Loop through the array
foreach ($url_parts as &$part) {
    if (strpos($part, 'nationality-') === 0) {
        $nationality = true; // Set the variable to true if "nationality-" is found
        $part = str_replace('nationality-', '', $part); // Remove the "nationality-" prefix
    }
}
unset($part);  // Unset the reference to prevent unintended side-effects
$nationality_value = "";


if ($nationality) {
   $nationality_matches_array = array_intersect($nationalites_array, $url_parts);
        if (!empty($nationality_matches_array)) {
            $nationality_value = reset($nationality_matches_array);
        } else {
            $nationality_value = '';
        }

        $nationality_value = str_replace('-', ' ', $nationality_value);
        $nationality_value = ucwords(strtolower($nationality_value));
} 
      


        

 
        $subject_matches_array = array_intersect($subject_array, $url_parts);
        if (!empty($subject_matches_array)) {
            $subject_value = reset($subject_matches_array);
        } else {
            $subject_value = '';
        }

        $subject_value = str_replace('-', ' ', $subject_value);
        $subject_value = ucwords(strtolower($subject_value));

        $degree_values_match = array_intersect($degree_label_array, $url_parts);
        if (!empty($degree_values_match)) {
            $degree_value = reset($degree_values_match);
            if ($degree_value == "masters") {
                $degree_value = "Master's";
            } elseif ($degree_value == "bachelors") {
                $degree_value = "Bachelor's";
            } elseif ($degree_value == "phd") {
                $degree_value = "PhD";
            }
        } else {
            // Handle the case when $url_parts is empty
            $degree_value = ''; // Replace 'default-value' with the desired value
        }

        $scholarship_type_values_match = array_intersect($scholarship_type_array, $url_parts);
        if (!empty($scholarship_type_values_match)) {
            $scholarship_type_value = reset($scholarship_type_values_match);
        } else {
            // Handle the case when $url_parts is empty
            $scholarship_type_value = ''; // Replace 'default-value' with the desired value
        }

        $scholarship_type_value = str_replace('-', ' ', $scholarship_type_value);
        $scholarship_type_value = ucwords(strtolower($scholarship_type_value));

        $application_matches_array = array_intersect($currently_open_label_array, $url_parts);
        if (!empty($application_matches_array)) {
            $application_value = reset($application_matches_array);
        } else {
            $application_value = '';
        }

        $current_date = date("Y-m-d H:i:s");

        $next_due_date = '';


        if ($application_value == "open") {
            $next_due_date = date('Y-m-d H:i:s', strtotime("+3820 days"));
        }

        if ($application_value == "one-month") {
            $next_due_date = date('Y-m-d H:i:s', strtotime("+30 days"));
        }

        if ($application_value == "two-month") {
            $next_due_date = date('Y-m-d H:i:s', strtotime("+60 days"));
        }

        if ($application_value == "three-month") {
            $next_due_date = date('Y-m-d H:i:s', strtotime("+90 days"));
        }

        if ($application_value == "four-month") {
            $next_due_date = date('Y-m-d H:i:s', strtotime("+120 days"));
        }

        if ($application_value == "five-month") {
            $next_due_date = date('Y-m-d H:i:s', strtotime("+150 days"));
        }

        if ($application_value == "six-month") {
            $next_due_date = date('Y-m-d H:i:s',  strtotime("+180 days"));
        }

        if ($application_value == "twelve-month") {
            $next_due_date = date('Y-m-d H:i:s',  strtotime("+364 days"));
        }

        if(isset($subject_value) && $subject_value){
    
        $subject_query = array('type' => 'string' , 'key' => 'eligible_programs', 'value' => $subject_value, 'compare' => 'LIKE');
        }


        if(isset($nationality_value) && $nationality_value){
    
        $nationality_query = array('type' => 'string' , 'key' => 'eligible_nationality', 
            'value' => $nationality_value, 'compare' => 'LIKE');
        }  

        if (isset($degree_value) && $degree_value) {
            $degree_query = array('key' => 'eligible_degrees',  'value' => $degree_value,  'compare' => 'LIKE');
        }

        if (isset($scholarship_type_value) && $scholarship_type_value) {
            $type_query = array('key' => 'amount_category', 'value' => $scholarship_type_value, 'compare' => "LIKE");
        }

        if (isset($application_value) && $application_value) {
            if ($degree_value == "Master's") {
                if ($application_value == "open") {
                    $application_query = array(
                        'relation' => 'AND',
                        array('key' => 'current_masters_scholarship_deadline', 'compare' => '<=', 'value' => $next_due_date, 'type' => 'date'),
                        array('key' => 'current_masters_scholarship_deadline', 'compare' => '>=', 'value' => $current_date, 'type' => 'date'),
                        array('key' => 'master_open_date', 'value' => 'Yes', 'compare' => "LIKE"),
                    );
                } else {
                    $application_query = array(
                        'relation' => 'AND',
                        array('key' => 'current_masters_scholarship_deadline', 'compare' => '<=', 'value' => $next_due_date, 'type' => 'date'),
                        array('key' => 'current_masters_scholarship_deadline', 'compare' => '>=', 'value' => $current_date, 'type' => 'date'),
                    );
                }
            }

            if ($degree_value == "Bachelor's") {
                if ($application_value == "open") {
                    $application_query = array(
                        'relation' => 'AND',
                        array('key' => 'current_bachelors_scholarship_deadline', 'compare' => '<=', 'value' => $next_due_date, 'type' => 'date'),
                        array('key' => 'current_bachelors_scholarship_deadline', 'compare' => '>=', 'value' => $current_date, 'type' => 'date'),
                        array('key' => 'bachelor_open_date', 'value' => 'Yes', 'compare' => "LIKE"),
                    );
                } else {
                    $application_query = array(
                        'relation' => 'AND',
                        array('key' => 'current_bachelors_scholarship_deadline', 'compare' => '<=', 'value' => $next_due_date, 'type' => 'date'),
                        array('key' => 'current_bachelors_scholarship_deadline', 'compare' => '>=', 'value' => $current_date, 'type' => 'date'),
                    );
                }
            }
        }

        if (!empty($location_value)) {
            $loop_institute = get_institutions_location($location_value);
            $institute_ids = $loop_institute->get_posts();
        }

        if (isset($location_value) && $location_value) {
            $location_query  = array('key' => 'scholarship_institution', 'value' => $institute_ids, 'compare' => "IN");
        }

        $meta_query = array('relation' => 'AND');

        if ($subject_query) {
            $meta_query[] = $subject_query;
        }

        if ($degree_query) {
            $meta_query[] = $degree_query;
        }

        if ($location_query) {
            $meta_query[] = $location_query;
        }

        if ($type_query) {
            $meta_query[] = $type_query;
        }

          if ($nationality_query) {
            $meta_query[] = $nationality_query;
        }

        if ($application_query) {
            $meta_query[] = $application_query;
        }

        $ad_args = array(
             'post_type' => 'scholarships',
        'post_status' => 'publish',
     
     
     'update_post_meta_cache' => false,
     'update_post_term_cache' => false,
     'cache_results'          => false,
     'fields' => 'ids',


      
        );

        
        if ($meta_query) {
            $ad_args['meta_query'] = $meta_query;
        }

        $loop = new WP_Query($ad_args);

        // Save the found_posts value
        $found_posts = $loop->found_posts;

        $page = '';

foreach ($url_parts as $part) {
    if (is_numeric($part)) {
        $page = $part;

        break; // Stop the loop if an integer value is found
    }
   }
          
        
$text = "";

$found_posts_orignal = $found_posts;

// Determine the prefix based on empty_url
if ($empty_url) {
    $text .= "Find All";
} else {
    $text .= "Find";
}

// Adjust scholarship type values
if ($scholarship_type_value == "Full Funding") {
    $scholarship_type_value = "Fully Funded";
}
if ($scholarship_type_value == "Partial Funding") {
    $scholarship_type_value = "Partially Funded";
}

// Construct the main scholarship phrase, ensuring we don't repeat information
$main_phrase = "";
if (!$empty_url) {
    $main_phrase .= " " . $found_posts;
}
if ($scholarship_type_value) {
    $main_phrase .= " " . $scholarship_type_value;
}
if ($degree_value) {
    $main_phrase .= " " . $degree_value;
}
$main_phrase .= " Scholarships";

// Append main scholarship phrase to text
$text .= " " . $main_phrase;

// Add location if present
if ($location_value) {
    $text .= " in " . $location_value;
}

// Add subject if present
if ($subject_value) {
    $text .= " for " . $subject_value;
}


if($nationality_value){
$text .= " for " . $nationality_value . " Students.";  
}else {
  $text .= " for International Students.";  
}


// Add pagination details if present
if ($page) {
    $text .= " - Page " . $page . " of " . ceil($found_posts / 20) . ".";
}

// Append total scholarships information
$text .= " Check All " . $found_posts_orignal . " Scholarships.";

return $text;



}






function custom_rankmath_description($description) {
    $current_url = $_SERVER["REQUEST_URI"];
    
    if (strpos($current_url, 'scholarship-search') !== false) {
    return   generate_scholarship_text($current_url);
    }

   
}
add_filter('rank_math/frontend/description', 'custom_rankmath_description');

function get_published_scholarships_count() {
   $args = array(
    'post_type' => 'scholarships',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
    'cache_results' => false,
    'fields' => 'ids',
);

$scholarships_query = new WP_Query($args);

// Get the count from the query.
$count = $scholarships_query->found_posts;

return $count;
}



function find_posts_containing_institution($institution_name) {
    
    global $wpdb;

    $query = $wpdb->prepare("
        SELECT ID, post_title
        FROM {$wpdb->posts}
        WHERE post_type = 'post'
        AND post_status = 'publish'
        AND post_content REGEXP %s
    ", '[[:<:]]' . $wpdb->esc_like($institution_name) . '[[:>:]]');

    $results = $wpdb->get_results($query);

    $post_ids = wp_list_pluck($results, 'ID');
    $post_names = wp_list_pluck($results, 'post_title');

    return array($post_ids, $post_names);
}



function update_generated_posts_field($institution_id, $post_names) {
   
    //delete_field('generated_posts', $institution_id);

    // Add a new row for each post name
    foreach ($post_names as $post_name) {
        // Get the post ID based on the post name
        $post_id = get_page_by_title($post_name, OBJECT, 'post')->ID;

        // Get the post URL
        $post_url = get_permalink($post_id);

        // Create a clickable link for the post name
        $post_link = '<a href="' . $post_url . '">' . $post_name . '</a>';

        // Add the new row to the repeater field with the post_title sub-field
        add_row('generated_posts', array('post_name' => $post_url, 'post_title' => $post_name), $institution_id);
    }
}




function update_generated_posts() {
    
    $args = array(
        'post_type' => 'institution',
        'post_status' => 'publish',
        'posts_per_page' => 100,
        'no_found_rows' => true, 
         'update_post_meta_cache' => false,
         'update_post_term_cache' => false,
         'cache_results'          => false,
         'fields' => 'ids',
     );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            
            $query->the_post();
            $institution_id = get_the_ID();
            $institution_name = get_the_title();

           
            list($post_ids, $post_names) = find_posts_containing_institution($institution_name);
            update_generated_posts_field($institution_id, $post_names);
        }
    }

    wp_reset_postdata();
}


//update_generated_posts();





function update_post_institutions($specific_post_id = null) {
    global $wpdb;

    // Fetch all institution names 
    $institutions = $wpdb->get_results("SELECT ID, post_title, post_type, post_name FROM {$wpdb->posts} WHERE post_type = 'institution' AND post_status = 'publish'");

    // Fetch the first 100 published posts
    if ($specific_post_id !== null) {
        $post_data = $wpdb->get_results($wpdb->prepare("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish' AND ID = %d", $specific_post_id));
    } else {
        $post_data = $wpdb->get_results("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish' ORDER BY ID ASC");
    } 

    // Loop through the specific post
    foreach ($post_data as $post) {
        $post_id = $post->ID;
        $post_content = $post->post_content;

        $current_institutions = get_field('generated_institutions', $post_id);

        // Remove duplicate institutions
        $existing_titles = array();
        $unique_institutions = array();
        foreach ($current_institutions as $inst) {
            if (!in_array($inst['institution_title'], $existing_titles)) {
                $existing_titles[] = $inst['institution_title'];
                $unique_institutions[] = $inst;
            }
        }

        $current_institutions = $unique_institutions;

        if (!is_array($current_institutions)) {
            $current_institutions = array();
        }

        $existing_institutions = array_column($current_institutions, 'institution_title');
        
        // Loop through all institutions
        foreach ($institutions as $institution) {
            
            $institution_id = $institution->ID;
            $institution_name = $institution->post_title;
            $institution_slug = $institution->post_name;
            $institution_permalink = get_permalink($institution_id);

            if (strpos($institution_permalink, '?p=') !== false) {
            $base_url = get_site_url(); // Retrieves the base URL of your WordPress site
            $institution_permalink = trailingslashit($base_url) . 'institutions/' . $institution_slug . '/'; // Constructs the full SEO-friendly URL
            }

            
            if (preg_match('/[[:<:]]' . preg_quote($institution_name, '/') . '[[:>:]]/', $post_content)) {

                if (!empty($institution_name) && !in_array($institution_name, $existing_institutions)) {
                    $current_institutions[] = array(
                        'institution_title' => $institution_name,
                        'institution_link' => $institution_permalink,
                        'inputted' => 'No'
                    );
                } elseif (in_array($institution_name, $existing_institutions)) {
                    foreach ($current_institutions as &$inst) {
                        
            
              if(site_url() == "https://globalscholarships.com") {
              $inst['institution_link'] = str_replace('https://env-globalscholarshipsa-sibi.kinsta.cloud', 'https://globalscholarships.com', $inst['institution_link']);
                  }

              
                  
                     
                if (strpos($inst['institution_link'], '?p=') !== false) {
                          $url_id = url_to_postid($inst['institution_link']);
                          
                         if ($url_id) {
                        $existing_institutue = get_post($url_id); // Retrieve the post object
                        $existing_institution_slug = $existing_institutue->post_name; // Extract the post slug
                        $base_url = get_site_url(); // Retrieve the base URL of your WordPress site
                        $institution_permalink = trailingslashit($base_url) . 'institutions/' .$existing_institution_slug . '/'; 
                        $inst['institution_link'] = $institution_permalink;

                        
                       }
                    }

                       

                        if ($inst['institution_title'] === $institution_name && $inst['inputted'] === 'Yes') {
                            break; // Skip adding the institution if it already exists and is marked as 'Yes'
                        } elseif ($inst['institution_title'] === $institution_name && $inst['inputted'] === 'No') {
                            $inst['inputted'] = 'No'; // Set the 'inputted' value to 'No' if the institution already exists but is not marked as 'Yes'
                        }
                    }
                }
            }
        }

        // Update the 'generated_institutions' field with the modified array
        update_field('generated_institutions', $current_institutions, $post_id);
    }
}


function generate_posts_by_keywords($specific_post_id = null) {
    
    global $wpdb;

    // Fetch all keywords from the specific post
    $keywords = array();
    if ($specific_post_id !== null) {
        $keywords_repeater = get_field('keywords', $specific_post_id);
        if ($keywords_repeater) {
            foreach ($keywords_repeater as $keyword_item) {
                // Ensure the keyword is not empty
                if (!empty($keyword_item['keyword'])) {
                    $keywords[] = $keyword_item['keyword'];
                }
            }
        }
    }

    // If no keywords are present, exit the function
    if (empty($keywords)) {
        return; // No keywords specified, do nothing
    }

    // Get the limit for the number of posts to generate
    $posts_limit = get_field('number_of_posts_to_generate', $specific_post_id);
    if (empty($posts_limit) || !is_numeric($posts_limit)) {
        $posts_limit = 100; // Set to a high number if not specified or invalid
    }

    // Fetch the first 100 published posts
    $post_data = $wpdb->get_results("SELECT ID, post_content, post_title FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish' ORDER BY ID DESC ");

    // Fetch the current generated posts
    $current_generated_posts = get_field('generated_posts_for_posts', $specific_post_id);
    if (!is_array($current_generated_posts)) {
        $current_generated_posts = array();
    }

    // Remove duplicate rows based on the 'post_name' field
    $current_generated_posts = array_map("unserialize", array_unique(array_map("serialize", $current_generated_posts)));
    $current_generated_posts = array_values($current_generated_posts);
    
    $generated_count = count($current_generated_posts); // Count already generated posts

    foreach ($post_data as $post) {
        if ($generated_count >= $posts_limit) {
            break; // Stop if the limit is reached
        }

        $post_id = $post->ID;
        $post_content = $post->post_content;
        $post_exists = false;

        // Loop through all keywords and check if they exist in the post content
        foreach ($keywords as $keyword) {
            if (preg_match('/\b' . preg_quote($keyword, '/') . '\b/i', $post_content)) {
                
                foreach ($current_generated_posts as $generated_post) {
                    if ($generated_post['post_name'] === $post->post_title) {
                        $post_exists = true;
                        if ($generated_post['inputted'] === 'Yes') {
                            break; // Skip adding the post if it already exists and is marked as 'Yes'
                        }
                    }
                }
                
                // Add the post if it doesn't exist already and increment counter
                if (!$post_exists) {
                    $current_generated_posts[] = array(
                        'post_name' => $post->post_title,
                        'post_link' => get_permalink($post_id),
                        'inputted' => 'No'
                    );
                    $generated_count++;
                }
                
                // Break the keyword loop if the post exists
                if ($post_exists) {
                    break;
                }
            }
        }
    }

    // Update the ACF field 'generated_posts_for_posts' after the loop
    update_field('generated_posts_for_posts', $current_generated_posts, $specific_post_id);
}





function generate_posts_by_keywords_for_all_posts() {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => -1, // Retrieve all posts
        'post_status'    => 'publish',
        'fields'         => 'ids', // Return only post IDs
    );

    $query = new WP_Query($args);

    $post_ids = $query->posts;

    foreach ($post_ids as $specific_post_id) {
        generate_posts_by_keywords($specific_post_id);
        add_generated_posts_to_resulted_posts($specific_post_id);
    }
}

add_action('generate_posts_by_keywords_for_all_posts', 'generate_posts_by_keywords_for_all_posts');




function calculate_posts_for_all_posts() {
    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => -1,  // -1 to retrieve all posts
        'fields'         => 'ids',  // Retrieve only post IDs
    );

    $post_ids = get_posts($args);

    foreach ($post_ids as $specific_post_id) {
        
        make_generated_posts_to_inputted($specific_post_id);
        add_generated_posts_to_resulted_posts($specific_post_id); 
        count_resulted_posts($specific_post_id);
    }
}

add_action('calculate_posts_for_all_posts' , 'calculate_posts_for_all_posts');



function update_open_dates() {
    $batch_size = 10; // Fetch 100 posts at a time
    $paged = 1; // Start at the first page

    do {
        $args = array(
            'post_type' => 'institution',
            'no_found_rows' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'cache_results' => false,
            'fields' => 'ids',
            'posts_per_page' => $batch_size,
            'paged' => $paged, // This enables the batching
            'post_status' => 'publish',
        );

        $query = new WP_Query($args);

        if (!$query->have_posts()) {
            break; // Exit the loop if there are no posts
        }

        foreach ($query->posts as $post_id) {
            if (have_rows('admission_deadlines', $post_id)) {
                $row_index = 1;
                while (have_rows('admission_deadlines', $post_id)) {
                    the_row();

                    $deadline = get_sub_field('deadline');
                    $open_date = get_sub_field('open_date');

                    if (empty($open_date) && !empty($deadline)) {
                        $deadline_date = DateTime::createFromFormat('F j, Y', $deadline);
                        $deadline_date->sub(new DateInterval("P3M")); // Subtract 3 months
                        $new_open_date = $deadline_date->format('F j, Y');

                        update_row('admission_deadlines', $row_index, [
                            'deadline' => $deadline,
                            'open_date' => $new_open_date
                        ], $post_id);
                    }
                    $row_index++;
                }
            }
        }

        wp_cache_flush(); // Clear the WordPress object cache
        $paged++; // Move on to the next batch

    } while (true); // Keep running until there are no posts left
}


add_action('update_open_dates', 'update_open_dates');




function update_open_dates_scholarships() {
    $batch_size = 10; // Fetch 100 posts at a time
    $paged = 1; // Start at the first page

    do {
        $args = array(
            'post_type' => 'scholarships',
            'no_found_rows' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'cache_results' => false,
            'fields' => 'ids',
            'posts_per_page' => $batch_size,
            'paged' => $paged, // This enables the batching
            'post_status' => 'publish',
        );

        $query = new WP_Query($args);

        if (!$query->have_posts()) {
            break; // Exit the loop if there are no posts
        }

        foreach ($query->posts as $post_id) {
            if (have_rows('scholarship_deadlines', $post_id)) {
                $row_index = 1;
                while (have_rows('scholarship_deadlines', $post_id)) {
                    the_row();

                    $deadline = get_sub_field('deadline');
                    $open_date = get_sub_field('open_date');

                    if (empty($open_date) && !empty($deadline)) {
                        $deadline_date = DateTime::createFromFormat('F j, Y', $deadline);
                        $deadline_date->sub(new DateInterval("P3M")); // Subtract 3 months
                        $new_open_date = $deadline_date->format('F j, Y');

                        update_row('scholarship_deadlines', $row_index, [
                            'deadline' => $deadline,
                            'open_date' => $new_open_date
                        ], $post_id);
                    }
                    $row_index++;
                }
            }
        }

        wp_cache_flush(); // Clear the WordPress object cache
        $paged++; // Move on to the next batch

    } while (true); // Keep running until there are no posts left
}


add_action('update_open_dates_scholarships', 'update_open_dates_scholarships');


function calculate_resulted_posts() {
    // Custom WP_Query for institution custom post type
    $args = array(
        'post_type' => 'institution',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'no_found_rows' => true, 
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results'          => false,
        'fields' => 'ids'
    );
    $query = new WP_Query($args);

    // Loop through all institution posts
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Get the current post ID
            $post_id = get_the_ID();

            // Get the generated_posts and inputted_posts repeaters
            $generated_posts = get_field('generated_posts', $post_id);
            $inputted_posts = get_field('inputted_posts', $post_id);

            // Check if both repeaters are arrays
            //if (is_array($generated_posts) && is_array($inputted_posts)) {

            //new logic    
            if (is_array($generated_posts)) {
    
                // Calculate the remaining posts from generated_posts after considering inputted_posts
                $remaining_posts = array();

                foreach ($generated_posts as $generated_post) {
                    $generated_post_url = $generated_post['post_name'];
                    $generated_post_title = get_the_title(url_to_postid($generated_post_url));

                    $is_in_inputted_posts = false;

                    foreach ($inputted_posts as $inputted_post) {
                        $inputted_post_id = $inputted_post['post_name'];
                        $inputted_post_title = get_the_title($inputted_post_id);

                        if ($generated_post_title === $inputted_post_title) {
                            $is_in_inputted_posts = true;
                            break;
                        }
                    }

                    if (!$is_in_inputted_posts) {
                        $remaining_posts[] = array(
                            'post_name' => $generated_post_url,
                            'post_title' => $generated_post_title
                        );
                    }
                }

                // Delete all rows from the resulted_posts repeater before adding more
                $resulted_posts_count = get_field('resulted_posts', $post_id) ? count(get_field('resulted_posts', $post_id)) : 0;
                for ($i = $resulted_posts_count; $i >= 1; $i--) {
                    delete_row('resulted_posts', $i, $post_id);
                }

                // Update the resulted_posts repeater with the remaining posts using add_row() function
                if (!empty($remaining_posts)) {
                    foreach ($remaining_posts as $remaining_post) {
                        add_row('resulted_posts', $remaining_post, $post_id);
                    }
                }
            }
        }

        // Restore original post data
        wp_reset_postdata();
    }
}

// Call the function to perform the calculation
//add_action('calculate_resulted_posts', 'calculate_resulted_posts');


// Call the function to perform the calculation
//add_action('init', 'calculate_resulted_posts');



function update_number_of_resulted_posts() {
    // Custom WP_Query for institution custom post type
    $args = array(
        'post_type' => 'institution',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'no_found_rows' => true, 
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results'          => false,
        'fields' => 'ids'
    );
    $query = new WP_Query($args);

    // Loop through all institution posts
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Get the current post ID
            $post_id = get_the_ID();

            // Get the resulted_posts repeater field
            $resulted_posts = get_field('resulted_posts', $post_id);

            // Update the number_of_resulted_posts field with the number of rows in the resulted_posts field
            if (is_array($resulted_posts)) {
                update_field('number_of_resulted_posts', count($resulted_posts), $post_id);
            } else {
                update_field('number_of_resulted_posts', 0, $post_id);
            }
        }

        // Restore original post data
        wp_reset_postdata();
    }
}

// Call the function to update the number_of_resulted_posts field
//add_action('init', 'update_number_of_resulted_posts');


function update_all_post_institutions() {
    
    global $wpdb;
    // Fetch all institution names 
    $institutions = $wpdb->get_results("SELECT ID, post_title, post_type, post_name FROM {$wpdb->posts} WHERE post_type = 'institution' AND post_status = 'publish'");
    
    $posts_per_batch = 5;
    $paged = 1;

    while (true) {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $posts_per_batch,
        'post_status' => 'publish',
        'paged' => $paged,
        'fields' => 'ids'
    );

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        break; // Exit loop if there are no posts left to process.
    }

    $post_data = $query->posts;

    foreach ($post_data as $post_id) {
        
        $post_content = get_post_field('post_content', $post_id);
        $current_institutions = get_field('generated_institutions', $post_id);
        
        // Remove duplicate institutions
        $existing_titles = array();
        $unique_institutions = array();
        foreach ($current_institutions as $inst) {
            if (!in_array($inst['institution_title'], $existing_titles)) {
                $existing_titles[] = $inst['institution_title'];
                $unique_institutions[] = $inst;
            }
        }
        $current_institutions = $unique_institutions;
        
        if (!is_array($current_institutions)) {
            $current_institutions = array();
        }
        
        $existing_institutions = array_column($current_institutions, 'institution_title');
        
        // Loop through all institutions
        foreach ($institutions as $institution) {
             
            $institution_id = $institution->ID;
            $institution_name = $institution->post_title;
            $institution_slug = $institution->post_name;
            $institution_permalink = get_permalink($institution_id);

             if (strpos($institution_permalink, '?p=') !== false) {
            $base_url = get_site_url(); // Retrieves the base URL of your WordPress site
            $institution_permalink = trailingslashit($base_url) . 'institutions/' . $institution_slug . '/'; // Constructs the full SEO-friendly URL
             }
  
    
            if (preg_match('/[[:<:]]' . preg_quote($institution_name, '/') . '[[:>:]]/', $post_content)) {
                if (!empty($institution_name) && !in_array($institution_name, $existing_institutions)) {
                    $current_institutions[] = array(
                        'institution_title' => $institution_name,
                        'institution_link' => $institution_permalink,
                        'inputted' => 'No'
                    );
                } elseif (in_array($institution_name, $existing_institutions)) {
                    foreach ($current_institutions as &$inst) {
                        
              if(site_url() == "https://globalscholarships.com") {
              $inst['institution_link'] = str_replace('https://env-globalscholarshipsa-sibi.kinsta.cloud', 'https://globalscholarships.com', $inst['institution_link']);
                  }
                    
                if (strpos($inst['institution_link'], '?p=') !== false) {
                          $url_id = url_to_postid($inst['institution_link']);
                          
                         if ($url_id) {
                        $existing_institutue = get_post($url_id); // Retrieve the post object
                        $existing_institution_slug = $existing_institutue->post_name; // Extract the post slug
                        $base_url = get_site_url(); // Retrieve the base URL of your WordPress site
                        $institution_permalink = trailingslashit($base_url) . 'institutions/' .$existing_institution_slug . '/'; 
                        $inst['institution_link'] = $institution_permalink;

                        
                       }
                    }

                        if ($inst['institution_title'] === $institution_name && $inst['inputted'] === 'Yes') {
                            break; // Skip adding the institution if it already exists and is marked as 'Yes'
                        } elseif ($inst['institution_title'] === $institution_name && $inst['inputted'] === 'No') {
                            $inst['inputted'] = 'No'; // Set the 'inputted' value to 'No' if the institution already exists but is not marked as 'Yes'
                        }
                    }
                }
            }
        }
         
     update_field('generated_institutions', $current_institutions, $post_id);

    
    update_generated_institutions_new_inputted_field($post_id);


    // Add Generated Institutions to the Institutions Posts    

    delete_field('resulted_institutions', $post_id);
    $generated_institutions = get_field('generated_institutions', $post_id);
    if ($generated_institutions) {
        foreach ($generated_institutions as $generated_institution) {
            if ($generated_institution['inputted'] === 'No') {
                $new_row = array(
                    'institution_name' => $generated_institution['institution_title'],
                    'institution_link' => $generated_institution['institution_link'],
                    'inputted' => ''
                );
                add_row('resulted_institutions', $new_row, $post_id);
            }
        }
    }

    // Count Resultant Institutions

    $resulted_posts = get_field('resulted_institutions', $post_id);
    if (is_array($resulted_posts) && !empty($resulted_posts)) {
        $resulted_posts_count = count($resulted_posts);
        update_field('number_of_resulted_institutions', $resulted_posts_count, $post_id);
     } else {
        // If there are no posts, set the count to 0
        update_field('number_of_resulted_institutions', 0, $post_id);
    }
}

$paged++; 

}

}

// Work as Run Tool Button
add_action('update_all_post_institutions', 'update_all_post_institutions');
//add_action('init', 'update_all_post_institutions');

function calculate_resulted_institutions() {
    $posts_per_batch = 100;
    $paged = 1;

    while (true) {
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $posts_per_batch,
            'post_status' => 'publish',
            'no_found_rows' => true, 
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'cache_results' => false,
            'orderby' => 'ID',
            'order' => 'DESC',
            'paged' => $paged,
            'fields' => 'ids'
        );

        $query = new WP_Query($args);

        // Loop through all post type posts in the batch
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $post_id = get_the_ID();

                $resulted_institutions = get_field('resulted_institutions', $post_id);
                $generated_institutions = get_field('generated_institutions', $post_id);

                if ($resulted_institutions && $generated_institutions) {
                    foreach ($resulted_institutions as $resulted_institution) {
                        if ($resulted_institution['inputted']) {
                            $institution_name = $resulted_institution['institution_name'];
                            foreach ($generated_institutions as &$generated_institution) {
                                if ($generated_institution['institution_title'] === $institution_name) {
                                    $generated_institution['inputted'] = 'Yes';
                                }
                            }
                        }
                    }
                    update_field('generated_institutions', $generated_institutions, $post_id);
                }

                // Update the Generated No to the Resultant
                delete_field('resulted_institutions', $post_id);
                $generated_institutions = get_field('generated_institutions', $post_id);
                if ($generated_institutions) {
                    foreach ($generated_institutions as $generated_institution) {
                        if ($generated_institution['inputted'] === 'No') {
                            $new_row = array(
                                'institution_name' => $generated_institution['institution_title'],
                                'institution_link' => $generated_institution['institution_link'],
                                'inputted' => ''
                            );
                            add_row('resulted_institutions', $new_row, $post_id);
                        }
                    }
                }

                // Count the Resultant
                $resulted_posts = get_field('resulted_institutions', $post_id);

                if (is_array($resulted_posts) && !empty($resulted_posts)) {
                    $resulted_posts_count = count($resulted_posts);
                    update_field('number_of_resulted_institutions', $resulted_posts_count, $post_id);
                } else {
                    // If there are no posts, set the count to 0
                    update_field('number_of_resulted_institutions', 0, $post_id);
                }
            }

            // Restore original post data
            wp_reset_postdata();
        } else {
            break; // Exit the loop if there are no more posts
        }

        $paged++; // Move to the next batch
    }
}



// Work as Calculate Institutions For All Posts
add_action('calculate_resulted_institutions', 'calculate_resulted_institutions');
//add_action('init', 'calculate_resulted_institutions');




function update_number_of_resulted_institutions($specific_post_id = null) {
    // Custom WP_Query for post type custom post type
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results' => false,
        'fields' => 'ids'
    );

    if ($specific_post_id) {
        $args['p'] = $specific_post_id; // Include the specific post ID if provided
    }

    $query = new WP_Query($args);

    // Loop through all post type posts
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Get the current post ID
            $post_id = get_the_ID();

            // Get the resulted_institutions repeater field
            $resulted_institutions = get_field('resulted_institutions', $post_id);

            // Update the number_of_resulted_institutions field with the number of rows in the resulted_institutions field
            if (!empty($resulted_institutions)) {
                update_field('number_of_resulted_institutions', count($resulted_institutions), $post_id);
            } else {
                update_field('number_of_resulted_institutions', 0, $post_id);
            }
        }

        // Restore original post data
        wp_reset_postdata();
    }
}


// Call the function to update the number_of_resulted_institutions field
//add_action('init', 'update_number_of_resulted_institutions');


function format_city_name($city_name) {
$split_city = explode(",", $city_name);
             if (count($split_city) > 1) {
             $second_part = $split_city[1];
               if (strlen(trim($second_part)) == 2) {
                $city_name = $split_city[0];
                }
             }
return $city_name;
}


function update_scholarship_weights() {
    $args = array(
        'post_type' => 'scholarships',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'fields' => 'ids', // Only get post ID's
    );

    $scholarship_posts = get_posts($args);

    foreach ($scholarship_posts as $post_id) {
        $weight = 0;

       // Get eligible degrees field
$eligible_degrees = get_field('eligible_degrees', $post_id);

// Check if 'eligible_degrees' is an array before checking for specific degrees
if (is_array($eligible_degrees)) {

    // Check if currently open
    $bachelor_open = in_array("Bachelor's", $eligible_degrees) && get_field('bachelor_open_date', $post_id) == "Yes";
    $master_open = in_array("Master's", $eligible_degrees) && get_field('master_open_date', $post_id) == "Yes";

    if ($bachelor_open || $master_open) {
        $weight += 100;
    }
}

        // Check for amount category
        $amount_category = get_field('amount_category', $post_id);
        switch ($amount_category) {
            case 'Full Funding':
                $weight += 100;
                break;
            case 'Full Tuition':
                $weight += 50;
                break;
            case 'Partial Funding':
                $weight -= 100;
                break;
        }

        // Update the weight field
        update_field('scholarship_weights', $weight, $post_id);
    }
}

add_action('update_scholarship_weights', 'update_scholarship_weights');


function update_scholarship_country() {
    $args = array(
        'post_type' => 'scholarships',
        'posts_per_page' => -1,
        'fields' => 'ids', // This will return an array of post IDs
    );

    $scholarship_ids = get_posts($args);

    foreach ($scholarship_ids as $scholarship_id) {
        $institution_id = get_field('scholarship_institution', $scholarship_id);
        $city_id = get_field('cities', $institution_id);
        $country_name = get_field('country', $city_id);

        // Update the 'institution_country' field with the country name
        update_field('institution_country', $country_name, $scholarship_id);
    }
}
//add_action('init', 'update_scholarship_country');
add_action('update_scholarship_country', 'update_scholarship_country');

function process_scholarship($scholarship_id, $allowed_countries) {
   
    $institution_id = get_field('scholarship_institution', $scholarship_id);
    $institution_name = get_the_title($institution_id);
    $country_name = get_field('institution_country', $scholarship_id);
    $scholarship_type = get_field('amount_category', $scholarship_id);
    $eligible_degrees = get_field('eligible_degrees', $scholarship_id);

    if (!is_array($eligible_degrees)) {
        return null;
    }

    $deadlines = array();
    if (in_array("Bachelor's", $eligible_degrees) && get_field('bachelor_open_date', $scholarship_id) === "Yes") {
        $deadlines[] = array(
            'degree' => "Bachelor's",
            'deadline' => date('F j, Y', strtotime(get_field('current_bachelors_scholarship_deadline', $scholarship_id))),
        );
    }
    
    if (in_array("Master's", $eligible_degrees) && get_field('master_open_date', $scholarship_id) === "Yes") {
        $deadlines[] = array(
            'degree' => "Master's",
            'deadline' => date('F j, Y', strtotime(get_field('current_masters_scholarship_deadline', $scholarship_id))),
        );
    }

    if (empty($deadlines)) {
        return null;
    }

    return array(
        'institution_name' => $institution_name,
        'institution_permalink' => get_permalink($institution_id),
        'scholarship' => array(
            'scholarship_title' => get_the_title($scholarship_id),
            'scholarship_permalink' => get_permalink($scholarship_id),
            'coverages' => get_field('scholarship_coverage', $scholarship_id),
            'eligible_degrees' => $eligible_degrees,
            'deadlines' => $deadlines,
            'scholarship_type' => $scholarship_type,
            'country' => $country_name,
        )
    );
}

function get_scholarships_info($scholarships_ids, $allowed_countries) {
    $institution_scholarships = array();
    $institution_count = 0;

    foreach ($scholarships_ids as $scholarship_id) {
        $processed_scholarship = process_scholarship($scholarship_id, $allowed_countries);
        if ($processed_scholarship === null) {
            continue;
        }

        $institution_name = $processed_scholarship['institution_name'];
        $country_name = $processed_scholarship['scholarship']['country'];

        if (!isset($institution_scholarships[$country_name])) {
            $institution_scholarships[$country_name] = array();
        }

        if (!isset($institution_scholarships[$country_name][$institution_name])) {
            $institution_scholarships[$country_name][$institution_name] = array(
                'institution_permalink' => $processed_scholarship['institution_permalink'],
                'scholarships' => array()
            );
            $institution_count++;
        }

        $institution_scholarships[$country_name][$institution_name]['scholarships'][] = $processed_scholarship['scholarship'];
    }

    return $institution_scholarships;
}

function get_scholarships_by_weight($institution_ids) {

    $args = array(
        'post_type' => 'scholarships',
        'posts_per_page' => -1,

        'no_found_rows' => true, 
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results' => false,
        'fields' => 'ids',

        'post_status' => 'publish',

        'meta_query' => array(
            array(
                'key' => 'scholarship_weights',
            ),
            array(
                'key' => 'scholarship_institution',
                'value' => $institution_ids,
                'compare' => '='
            )
        ),
        'orderby' => array(
            'scholarship_weights' => 'DESC'
        ),
    );

    $query = new WP_Query($args);

    return $query;
}

function get_best_scholarships_country($country, $posts_num) {

    $args = array(
        'post_type' => 'scholarships',
        'posts_per_page' => $posts_num,
        'no_found_rows' => true, 
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results' => false,
        'fields' => 'ids',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'scholarship_weights',
                'compare' => 'EXISTS',
            ),
            array(
                'key' => 'institution_country',
                'value' => $country,
            )
        ),
        'orderby' => array(
            'scholarship_weights' => 'DESC'
        ),
    );

    $query = new WP_Query($args);

    return $query;
}




function get_all_scholarships() {
    $args = array(
        'post_type' => 'scholarships', // Assuming 'scholarship' is your custom post type.
        'posts_per_page' => -1,       // Fetch all scholarships.
        'post_status' => 'publish',   // Only fetch published scholarships.
        'fields' => 'ids'             // Only return IDs.
    );

    $scholarship_ids = get_posts($args);
    $scholarships_array = array();

    foreach ($scholarship_ids as $id) {
        $title = get_the_title($id);
        $scholarships_array[$id] = $title;
    }

    return $scholarships_array;
}

/**
 * 
 * Update Deadlines for Institutions based on Conditions Looping through all posts and change deadlines that matches the conditions 
 * 
 */
function gs_update_deadlines() {
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $batchSize = isset($_POST['batchSize']) ? intval($_POST['batchSize']) : 20;
    $postType = isset($_POST['postType']) ? sanitize_text_field($_POST['postType']) : 'institution';
    $postStatus = isset($_POST['postStatus']) ? sanitize_text_field($_POST['postStatus']) : array('publish', 'draft');
    $openingDate = isset($_POST['openingDate']) ? sanitize_text_field($_POST['openingDate']) : '';
    $deadlineDate = isset($_POST['deadlineDate']) ? sanitize_text_field($_POST['deadlineDate']) : '';
    $institutionCountry = isset($_POST['institutionCountry']) ? sanitize_text_field($_POST['institutionCountry']) : '';
    $institutionDegree = isset($_POST['institutionDegree']) ? sanitize_text_field($_POST['institutionDegree']) : '';
    $newOpeningDate = isset($_POST['newOpeningDate']) ? sanitize_text_field($_POST['newOpeningDate']) : '';
    $newDeadlineDate = isset($_POST['newDeadlineDate']) ? sanitize_text_field($_POST['newDeadlineDate']) : '';

    if(!empty($postStatus) && is_string($postStatus)) {
        $postStatus = array($postStatus);
    }
    $institution_posts_count = get_all_posts_count([$postType], $postStatus);
    // $institution_posts_count_published = $institution_posts_count->publish;

    $institutionDegree = stripslashes_from_strings_only($institutionDegree);

    $args = array(
        'post_type' => $postType,
        'posts_per_page' => $batchSize,
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results' => false,
        'fields' => 'ids',
        'post_status' => $postStatus,
        'offset' => $offset
    );

    $query = new WP_Query($args);
    $deadlinesPosts = $query->get_posts();
    $theInstitutionConditions = array();
    $institutionUpdatedData = array();

    if (isset($deadlinesPosts) && !empty($deadlinesPosts)) {
        $institutionsUpdated = array();

        foreach ($deadlinesPosts as $institution_id) {
            // Get admissions Repeater for Institution
            $admission_deadlines = get_field('admission_deadlines', $institution_id);
            $city_id = get_field('cities', $institution_id);
            $country = get_field('country', $city_id);

            if ($admission_deadlines) {
                foreach ($admission_deadlines as $index => $admission_row) {
                    $shouldUpdate = true;

                    // Check if the conditions are provided
                    if (!empty($openingDate) && $admission_row['open_date'] !== $openingDate) {
                        $shouldUpdate = false;
                    }

                    if (!empty($deadlineDate) && $admission_row['deadline'] !== $deadlineDate) {
                        $shouldUpdate = false;
                    }

                    if (!empty($institutionCountry) && $country !== $institutionCountry) {
                        $shouldUpdate = false;
                    }

                    if (!empty($institutionDegree) && $admission_row['degree'] !== $institutionDegree) {
                        $shouldUpdate = false;
                    }

                    // Update the opening date if the conditions are met
                    if ($shouldUpdate) {
                        if (!empty($newOpeningDate)) {
                            $admission_deadlines[$index]['open_date'] = $newOpeningDate;
                        }

                        if (!empty($newDeadlineDate)) {
                            $admission_deadlines[$index]['deadline'] = $newDeadlineDate;
                        }
                    }
                }
                
                // Get the original value of the custom field
                $oldAdmissionDeadlines = get_field('admission_deadlines', $institution_id, true);

                // Update the admission deadlines repeater field
                update_field('admission_deadlines', $admission_deadlines, $institution_id);

                
                // Compare the original value to the new value
                if ($oldAdmissionDeadlines !== $admission_deadlines) {
                    // The custom field has been changed
                    $institutionsUpdated = array(); // Create a new empty array for each institution
                    $institutionsUpdated[] = $institution_id;


                    $institutionsUpdated['id'] = $institution_id; // Get the institution title
                    $institutionsUpdated['permalink'] = get_permalink($institution_id); // Get the institution permalink
                    $institutionsUpdated['title'] = get_the_title($institution_id); // Get the institution title
                    
                    if (!empty($institution_id)) {
                        $institutionsUpdated['country'] = get_field('location_country', $institution_id); // Get the institution country
                    } else {
                        $institutionsUpdated['country'] = '';
                    }
        
                    $institutionUpdatedData[] = $institutionsUpdated; // Add the institution array to the $institutionData array
                }

            }

            $theInstitutionConditions[$institution_id]['open_date'] = wp_list_pluck($admission_deadlines, 'open_date');
            $theInstitutionConditions[$institution_id]['deadline'] = wp_list_pluck($admission_deadlines, 'deadline');
            $theInstitutionConditions[$institution_id]['degree'] = wp_list_pluck($admission_deadlines, 'degree');
            $theInstitutionConditions[$institution_id]['country'] = $country;
        }
    }

    $totalUpdated = $offset + count($deadlinesPosts);
    $totalPosts = intval($institution_posts_count);

    $response = array(
        'totalUpdated' => $totalUpdated,
        'totalPosts' => $totalPosts,
        'institutionConditions' => $theInstitutionConditions,
        'institutionsUpdated' => $institutionUpdatedData,
    );

    wp_send_json($response);
}
add_action('wp_ajax_nopriv_update_deadlines', 'gs_update_deadlines');
add_action('wp_ajax_update_deadlines', 'gs_update_deadlines');


function get_all_posts_count(array $postType, array $postStatus) {
    $args = array(
      'post_status' => $postStatus,
      'post_type' => $postType,
    );
  
    $query = new WP_Query($args);
    $count = $query->found_posts;
  
    return $count;
}

function get_gs_institutions_preview() {
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $batchSize = isset($_POST['batchSize']) ? intval($_POST['batchSize']) : 20;
    $postType = isset($_POST['postType']) ? sanitize_text_field($_POST['postType']) : 'institution';
    $postStatus = isset($_POST['postStatus']) ? sanitize_text_field($_POST['postStatus']) : array('publish', 'draft');
    $openingDate = isset($_POST['openingDate']) ? sanitize_text_field($_POST['openingDate']) : '';
    $deadlineDate = isset($_POST['deadlineDate']) ? sanitize_text_field($_POST['deadlineDate']) : '';
    $institutionCountry = isset($_POST['institutionCountry']) ? sanitize_text_field($_POST['institutionCountry']) : '';
    $institutionDegree = isset($_POST['institutionDegree']) ? sanitize_text_field($_POST['institutionDegree']) : '';
    $newOpeningDate = isset($_POST['newOpeningDate']) ? sanitize_text_field($_POST['newOpeningDate']) : '';
    $newDeadlineDate = isset($_POST['newDeadlineDate']) ? sanitize_text_field($_POST['newDeadlineDate']) : '';
    
    if (!empty($postStatus) && is_string($postStatus)) {
        $postStatus = array($postStatus);
    }
    
    $institutionDegree = stripslashes_from_strings_only($institutionDegree);
    
    $args = array(
        'post_type' => $postType,
        'post_status' => $postStatus,
        'posts_per_page' => -1,
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results' => false,
        'fields' => 'ids',
    );
    
    $preview_query = new WP_Query($args);
    $preview_posts = $preview_query->get_posts();
    $institutionData = array();
    $match_found = false;
    $the_unique_institutions = [];

    if (isset($preview_posts) && !empty($preview_posts) && is_array($preview_posts)) {
        foreach ($preview_posts as $id) {
            $repeater_rows = get_field('admission_deadlines', $id); // Get repeater field data
            
            if (!empty($repeater_rows) && is_array($repeater_rows)) {
                
                foreach ($repeater_rows as $row) {
                    $country = get_field('location_country', $id); // Get the institution country
                    // if ($row['degree'] == $institutionDegree && $row['open_date'] == $openingDate && $row['deadline'] == $deadlineDate && ($institutionCountry === '' || $country == $institutionCountry) ) 
                    if (
                        ($institutionDegree === '' || $row['degree'] == $institutionDegree) &&
                        ($openingDate === '' || $row['open_date'] == $openingDate) &&
                        ($deadlineDate === '' || $row['deadline'] == $deadlineDate) &&
                        ($institutionCountry === '' || $country == $institutionCountry)
                    )
                    {
                        $match_found = true;
                        $institution = array(); // Create a new empty array for each institution

                        $institution['id'] = $id; // Get the institution title
                        $institution['permalink'] = get_permalink($id); // Get the institution permalink
                        $institution['title'] = get_the_title($id); // Get the institution title
                        
                        if (!empty($id)) {
                            $institution['country'] = get_field('location_country', $id); // Get the institution country
                        } else {
                            $institution['country'] = '';
                        }

                        $institutionData[] = $institution;

                        $unique_ids = array_column($institutionData, 'id');
                        $institutionData = array_intersect_key($institutionData, array_unique($unique_ids));
                    }
                }

            }
        }
    }
    
    $response = array(
        'institutionsData' => $institutionData ?? $institutionData,
    );
    
    wp_send_json($response, 200);
}

add_action('wp_ajax_nopriv_institutions_preview', 'get_gs_institutions_preview');
add_action('wp_ajax_institutions_preview', 'get_gs_institutions_preview');


// function get_gs_institutions_preview() {

//     $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
//     $batchSize = isset($_POST['batchSize']) ? intval($_POST['batchSize']) : 20;
//     $postType = isset($_POST['postType']) ? sanitize_text_field($_POST['postType']) : 'institution';
//     $postStatus = isset($_POST['postStatus']) ? sanitize_text_field($_POST['postStatus']) : array('publish', 'draft');
//     $openingDate = isset($_POST['openingDate']) ? sanitize_text_field($_POST['openingDate']) : '';
//     $deadlineDate = isset($_POST['deadlineDate']) ? sanitize_text_field($_POST['deadlineDate']) : '';
//     $institutionCountry = isset($_POST['institutionCountry']) ? sanitize_text_field($_POST['institutionCountry']) : '';
//     $institutionDegree = isset($_POST['institutionDegree']) ? sanitize_text_field($_POST['institutionDegree']) : '';
//     $newOpeningDate = isset($_POST['newOpeningDate']) ? sanitize_text_field($_POST['newOpeningDate']) : '';
//     $newDeadlineDate = isset($_POST['newDeadlineDate']) ? sanitize_text_field($_POST['newDeadlineDate']) : '';
//     if(!empty($postStatus) && is_string($postStatus)) {
//         $postStatus = array($postStatus);
//     }
//     $institution_posts_count = get_all_posts_count([$postType], $postStatus);

//     $institutionDegree = stripslashes_from_strings_only($institutionDegree);


//     $meta_query = array();

//     // Check if the opening date is set and not empty.
//     if (isset($openingDate) && !empty($openingDate)) {
//         $meta_query[] = array(
//             'key' => 'admission_deadlines_$_open_date',
//             'compare' => '=',
//             'value' => $openingDate,
//         );
//     }

//     // Check if the deadline date is set and not empty.
//     if (isset($deadlineDate) && !empty($deadlineDate)) {
//         $meta_query[] = array(
//             'key' => 'admission_deadlines_$_deadline',
//             'compare' => '=',
//             'value' => $deadlineDate,
//         );
//     }

//     // Check if the institution degree is set and not empty.
//     if (isset($institutionDegree) && !empty($institutionDegree)) {
//         $meta_query[] = array(
//             'key' => 'admission_deadlines_$_degree',
//             'compare' => '=',
//             'value' => $institutionDegree,
//         );
//     }

//     // Check if the institution country is set and not empty.
//     if (isset($institutionCountry) && !empty($institutionCountry)) {
//         $meta_query[] = array(
//             'key' => 'location_country',
//             'compare' => '=',
//             'value' => $institutionCountry,
//         );
//     }

//     $meta_query['relation'] = 'AND';
    
//     $args = array(
//         'post_type' => $postType,
//         'post_status' => $postStatus,
//         'posts_per_page' => $batchSize,
//         'no_found_rows' => true,
//         'update_post_meta_cache' => false,
//         'update_post_term_cache' => false,
//         'cache_results' => false,
//         'fields' => 'ids',
//         'offset' => $offset,
//         'meta_query' => $meta_query,
//     );
    
//     $preview_query = new WP_Query($args);
    
//     $preview_posts = $preview_query->get_posts();

//     $institutionData = []; 



//     if(isset($preview_posts) && !empty($preview_posts) && is_array($preview_posts)) {
//         foreach ($preview_posts as $key => $id) {
//             $institution = array(); // Create a new empty array for each institution

//             $institution['id'] = $id; // Get the institution title
//             $institution['permalink'] = get_permalink($id); // Get the institution permalink
//             $institution['title'] = get_the_title($id); // Get the institution title
            
//             if (!empty($id)) {
//                 $institution['country'] = get_field('location_country', $id); // Get the institution country
//             } else {
//                 $institution['country'] = '';
//             }

//             $institutionData[] = $institution; // Add the institution array to the $institutionData array
//         }
//     }

//     $response = array(
//         'institutionsPreview' => $preview_posts,
//         'institutionsData' =>  $institutionData,
//     );

//     wp_send_json($response, 200);
// }

// add_action('wp_ajax_nopriv_institutions_preview', 'get_gs_institutions_preview');
// add_action('wp_ajax_institutions_preview', 'get_gs_institutions_preview');

function create_table_for_gs_deadlines_data() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'gs_deadlines_data';

    $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    deadlinesUpdatedDegree TEXT NOT NULL,
    deadlinesUpdatedCountry TEXT NOT NULL,
    openingDateUpdate TEXT NOT NULL,
    deadlineDateUpdate TEXT NOT NULL,
    openingDateUpdated TEXT NOT NULL,
    deadlineDateUpdated TEXT NOT NULL,
    updateDeadlinesDate TEXT NOT NULL,
    updatedInstitutionsIds LONGTEXT NOT NULL,
    date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    PRIMARY KEY  (id)
    );";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

add_action('init', 'create_table_for_gs_deadlines_data');


function get_gs_institutions_updated_data() {

    global $wpdb;
    $table_name = $wpdb->prefix . 'gs_deadlines_data';
    
    $gsDeadlinesData = array();
   
    // Degree
    $gsDeadlinesData['deadlinesUpdatedDegree'] =  (isset($_POST['deadlinesUpdatedDegree'])) ? sanitize_text_field($_POST['deadlinesUpdatedDegree']) : '';

    // Country
    $gsDeadlinesData['deadlinesUpdatedCountry'] =  (isset($_POST['deadlinesUpdatedCountry'])) ? sanitize_text_field($_POST['deadlinesUpdatedCountry']) : '';

    // Past Opening Date
    $gsDeadlinesData['openingDeadlineDateUpdate'] =  (isset($_POST['openingDeadlineDateUpdate'])) ? sanitize_text_field($_POST['openingDeadlineDateUpdate']) : '';
    // Past Deadline Date

    $gsDeadlinesData['deadlineDeadlineDateUpdate'] =  (isset($_POST['deadlineDeadlineDateUpdate'])) ? sanitize_text_field($_POST['deadlineDeadlineDateUpdate']) : '';
    // New Opening Date

    $gsDeadlinesData['openingDeadlineDateUpdated'] =  (isset($_POST['openingDeadlineDateUpdated'])) ? sanitize_text_field($_POST['openingDeadlineDateUpdated']) : '';

    // New Deadline Date

    $gsDeadlinesData['deadlineDeadlineDateUpdated'] =  (isset($_POST['deadlineDeadlineDateUpdated'])) ? sanitize_text_field($_POST['deadlineDeadlineDateUpdated']) : '';

    // Date of the Process
    $gsDeadlinesData['updateDeadlinesDate'] =  (isset($_POST['updateDeadlinesDate'])) ? sanitize_text_field($_POST['updateDeadlinesDate']) : '';

    // Institutions Ids with dates changed
    $gsDeadlinesData['updatedInstitutionsIds'] =  isset($_POST['updatedInstitutionsIds']) ? (array) $_POST['updatedInstitutionsIds'] : array();

    // Database logged Date
    $gsDeadlinesData['date'] = isset($_POST['date']) ? $_POST['date'] : '';


    $response = array();
    if(!empty($gsDeadlinesData['updatedInstitutionsIds'])) {
        $updatedInstitutionsIds = json_encode($gsDeadlinesData['updatedInstitutionsIds']);
        $wpdb->insert(
            $table_name,
            array(
            'deadlinesUpdatedDegree' => $gsDeadlinesData['deadlinesUpdatedDegree'],
            'deadlinesUpdatedCountry' => $gsDeadlinesData['deadlinesUpdatedCountry'],
            'openingDateUpdate' => $gsDeadlinesData['openingDeadlineDateUpdate'],
            'deadlineDateUpdate' => $gsDeadlinesData['deadlineDeadlineDateUpdate'],
            'openingDateUpdated' => $gsDeadlinesData['openingDeadlineDateUpdated'],
            'deadlineDateUpdated' => $gsDeadlinesData['deadlineDeadlineDateUpdated'],
            'updateDeadlinesDate' => $gsDeadlinesData['updateDeadlinesDate'],
            'updatedInstitutionsIds' => $updatedInstitutionsIds,
            'date' => $gsDeadlinesData['date']
            )
        );   
        $response = array(
            'data' => $gsDeadlinesData,
            'success' => 'data entered into the database',
        );
    } else {
        $response = array(
            'data' => [],
            'success' => 'It is empty, no institutions exist for this update, so we are going to skip it!',
        ); 
    }

    wp_send_json($response, 200);

}

add_action('wp_ajax_nopriv_update_deadlines_data', 'get_gs_institutions_updated_data');
add_action('wp_ajax_update_deadlines_data', 'get_gs_institutions_updated_data');

// Get all Institutions that are not connected to scholarships
function get_institutions_without_scholarships() {
    // Custom WP_Query for scholarships custom post type
    $scholarships_args = array(
        'post_type' => 'scholarships',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results' => false,
        'fields' => 'ids'
    );
    $scholarships_query = new WP_Query($scholarships_args);

    $scholarships = $scholarships_query->get_posts();

    $institutions_args = array(
        'post_type' => 'institution',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results' => false,
        'fields' => 'ids'
    );
    $institutions_query = new WP_Query($institutions_args);

    $institutions = $institutions_query->get_posts();

    $institutions_with_scholarships = [];

    foreach ($scholarships as $scholarship) {
        $scholarship_institution = get_field('scholarship_institution', $scholarship);
        if ($scholarship_institution) {
            $institutions_with_scholarships[] = $scholarship_institution->ID;
        }
    }

    $unique_institutions = array_unique($institutions_with_scholarships);

    $result = array_diff($institutions, $unique_institutions);

    return $result;
}

function institutions_without_scholarships_list( $atts ){

    $result = get_institutions_without_scholarships();
    echo "<ol>";
        foreach($result as $key => $institution) {
            ?>
            <li>
                <a  href="<?php echo get_permalink($institution); ?>"> <?php echo get_the_title($institution); ?></a>
            </li>
            <?php
        }
    echo "</ol>";
}
add_shortcode( 'institutions-without-scholarships', 'institutions_without_scholarships_list' );

function country_currency_list() {

       $currency_list = array(
       "South Korea" => "KRW",
       "Canada" => "CAD",
       "China" => "RMB",
       "Japan" => "Yen",
       "New Zealand" => "NZD",
       "United Kingdom" => "GBP",
       "Australia" => "AUD",
       "Germany" => "Euros",
       "Greece" => "Euros",
       "Norway" => "NOK",
       "Switzerland" => "CHF",
       "United States" => "USD",
       "Netherlands" => "Euros",
       "France" => "Euros",
       "Poland" => "PLN",
       "Italy" => "Euros",
       "Ireland" => "Euros",
       "India" => "INR",
       "Philippines" => "Pesos",
       "South Africa" => "Rand",
       "Spain" => "Euros",
       "Portugal" => "Euros",
       "Singapore" => "SGD",
       "Russia" => "RUB",
       "Czech Republic" => "CZK",
       "Austria" => "Euros",
       "Sweden" => "kr",
       "Finland" => "Euros",
       "Denmark" => "Danish Krone",
       "Mexico" => "MXN",
       "Brazil" => "Brazilian Real",
       "Ukraine" => "UAH",
       "Turkey" => "TRY",
       "Taiwan" => "TWD",
       "Indonesia" => "Rp",
       "Belgium" => "Euros",
       "Croatia" => "Euros",
       "Romania" => "RON",
       "Belarus" => "BYN",
       "Hungary" => "HUF",
       "Bosnia and Herzegovina" => "BAM",
       "Albania" => "ALL",
       "Kosovo" => "Euros",
       "Estonia" => "Euros",
       "Iceland" => "ISK",
       "Slovenia" => "Euros",
       "Vietnam" => "VND",
       "Thailand" => "THB",
       "Sri Lanka" => "LKR",
       "Pakistan" => "PKR",
       "Nepal" => "NPR",
       "Qatar" => "QAR",
       "Serbia" => "RSD",
       "Malaysia" => "MYR",
       "Saudi Arabia" => "SAR",
       "Cambodia" => "KHR",
       "United Arab Emirates" => "AED",
       "Israel" => "ILS",
       "Costa Rica" => "CRC",
       "Andora" => "Euros",
       "Bulgaria" => "BGN",
       "Cyprus" => "Euros",
       "Liechtenstein" => "CHF",
       "Lithuania" => "Euros",
       "Luxembourg" => "Euros",
       "Malta" => "Euros",
       "Moldova" => "MDL",
       "Monaco" => "Euros",
       "Montenegro" => "Euros",
       "San Marino" => "Euros",
       "Slovakia" => "Euros",
       "Vatican City" => "Euros",
       "Nigeria" => "NGN",

    );

    return $currency_list;
 }


 function get_currency($country){
    $currency_list = country_currency_list();

    if(array_key_exists($country, $currency_list)){
        return $currency_list[$country];
    } else {
        return "USD";
    }
}

function has_usd_currency($country){
    $currency_list = country_currency_list();

    $currency = $currency_list[$country] ?? null; // Get the currency for the given country

    return ($currency === "USD"); // Check if the currency is USD
}


function update_generated_institutions_new_inputted_field($specific_post_id = null) {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results' => false,
        'fields' => 'ids'
    );

    if ($specific_post_id) {
        $args['p'] = $specific_post_id; // Include the specific post ID if provided
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $post_id = get_the_ID();

            $generated_institutions = get_field('generated_institutions', $post_id);
            $inputted_institutions = get_field('inputted_institutions', $post_id);

            if (is_array($generated_institutions) && is_array($inputted_institutions)) {
                foreach ($generated_institutions as &$generated_institution) {
                    $generated_institution['inputted'] = 'No'; // Initialize 'inputted' as 'No'

                    $generated_name = $generated_institution['institution_title'];

                    foreach ($inputted_institutions as $inputted_institution) {
                        $inputted_name = $inputted_institution['institution_name'];
                        $inputted_name = get_the_title($inputted_name);

                        if ($inputted_name === $generated_name) {
                            $generated_institution['inputted'] = 'Yes';
                            break;
                        }
                    }
                }

                // Update the 'generated_institutions' field
                update_field('generated_institutions', $generated_institutions, $post_id);
            }
        }

        wp_reset_postdata();
    }
}



// Call the function to update the institutions
// update_generated_institutions_new_inputted_field();

function update_custom_post_id_field_for_all_posts() {
    $args = array(
        'post_type' => 'post', 
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'fields' => 'ids'
    );

    $post_ids = get_posts($args);

    foreach ($post_ids as $post_id) {
        update_field('custom_post_id', $post_id, $post_id); 
    }
}


//add_action('init', 'update_custom_post_id_field_for_all_posts');


function update_custom_post_id_field_on_publish($post_id) {
    // Check if this is just a revision or autosave
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return;
    }

    $post_type = get_post_type($post_id);

    // Replace 'your_custom_post_type' with the name of your custom post type
    if ($post_type === 'post') {
        $custom_post_id = get_field('custom_post_id', $post_id);

        // Update the custom field only if it's empty
        if (empty($custom_post_id)) {
            update_field('custom_post_id', $post_id, $post_id);
        }
    }
}
add_action('save_post', 'update_custom_post_id_field_on_publish');



function process_resulted_institutions($specific_post_id) {
    $post_id = $specific_post_id;
    $resulted_institutions = get_field('resulted_institutions', $post_id);
    $generated_institutions = get_field('generated_institutions', $post_id);

    if ($resulted_institutions && $generated_institutions) {
        foreach ($resulted_institutions as $resulted_institution) {
            if ($resulted_institution['inputted']) {
                $institution_name = $resulted_institution['institution_name'];
                foreach ($generated_institutions as &$generated_institution) {
                    if ($generated_institution['institution_title'] === $institution_name) {
                        $generated_institution['inputted'] = 'Yes';
                    }
                }
            }
        }
      update_field('generated_institutions', $generated_institutions, $post_id);
    }
    
    if ($resulted_institutions) {
    while (have_rows('resulted_institutions', $post_id)) {
        the_row();
        delete_row('resulted_institutions', 0, $post_id);
    }
   }

}


function make_generated_posts_to_inputted($specific_post_id) {
    $post_id = $specific_post_id;
    $resulted_institutions = get_field('resultant_posts_for_posts', $post_id);
    $generated_institutions = get_field('generated_posts_for_posts', $post_id);

     
   if ($resulted_institutions && $generated_institutions) {
    foreach ($resulted_institutions as $resulted_institution) {
        if ($resulted_institution['inputted']) {
            
            $institution_name = $resulted_institution['post_name'];
            foreach ($generated_institutions as &$inner_generated_institution) {
                if ($inner_generated_institution['post_name'] === $institution_name) {
                    $inner_generated_institution['inputted'] = 'Yes';
                }
            }
        }
    }

    // Reindex the array using the unique identifier
    $generated_institutions = array_values($generated_institutions);

    // Optionally, update the entire repeater field after all changes are made
    update_field('generated_posts_for_posts', $generated_institutions, $post_id);
}

    
      
}


// Function: 
// Count Resultant Posts and Update in the Field

function count_resulted_posts($specific_post_id) {
    $resulted_posts = get_field('resultant_posts_for_posts', $specific_post_id);

    if (is_array($resulted_posts) && !empty($resulted_posts)) {
        $resulted_posts_count = count($resulted_posts);
        update_field('count_resulted_posts', $resulted_posts_count, $specific_post_id);
        
    } else {
        // If there are no posts, set the count to 0
        update_field('count_resulted_posts', 0, $specific_post_id);
       
    }
}


function count_resulted_institutions($specific_post_id) {
    $resulted_posts = get_field('resulted_institutions', $specific_post_id);

    if (is_array($resulted_posts) && !empty($resulted_posts)) {
        $resulted_posts_count = count($resulted_posts);
        update_field('number_of_resulted_institutions', $resulted_posts_count, $specific_post_id);
       
    } else {
        // If there are no posts, set the count to 0
        update_field('number_of_resulted_institutions', 0, $specific_post_id);
        
    }
}


// Function: 
// Add Generated Institutions to the Resultant Institutions
function add_generated_to_resulted($post_id) {
    delete_field('resulted_institutions', $post_id);
    $generated_institutions = get_field('generated_institutions', $post_id);
    if ($generated_institutions) {
        foreach ($generated_institutions as $generated_institution) {
            if ($generated_institution['inputted'] === 'No') {
                $new_row = array(
                    'institution_name' => $generated_institution['institution_title'],
                    'institution_link' => $generated_institution['institution_link'],
                    'inputted' => ''
                );
                add_row('resulted_institutions', $new_row, $post_id);
            }
        }
    }
}


// Function: 
// Add Generated Posts to the Resultant Posts

function add_generated_posts_to_resulted_posts($post_id) {
   
    delete_field('resultant_posts_for_posts', $post_id);
    $generated_institutions = get_field('generated_posts_for_posts', $post_id);

    if ($generated_institutions) {
        $resultant_posts = array(); // Initialize an array to store resultant posts

        foreach ($generated_institutions as $generated_institution) {
            if ($generated_institution['inputted'] == 'No') {
                $resultant_posts[] = array(
                    'post_name' => $generated_institution['post_name'],
                    'post_link' => $generated_institution['post_link'],
                    'inputted'  => ''
                );
            }
        }

        if (!empty($resultant_posts)) {
            // Update the 'resultant_posts_for_posts' field with the array of resultant posts
            update_field('resultant_posts_for_posts', $resultant_posts, $post_id);
             
        }
    }


}


function add_generated_to_inputted($post_id) {
    $generated_institutions = get_field('generated_institutions', $post_id);
    if ($generated_institutions) {
        // Clear the inputted_institutions field before adding new rows
        update_field('inputted_institutions', array(), $post_id);

        $inputted_institutions = array();

        foreach ($generated_institutions as $generated_institution) {
            if ($generated_institution['inputted'] === 'Yes') {
                $institution_title = $generated_institution['institution_title'];
                $institution_id = get_page_by_title($institution_title, OBJECT, 'institution')->ID;

                if ($institution_id) {
                    $new_row = array(
                        'institution_name' => $institution_id,
                        'inputted' => 'Yes'
                    );
                    $inputted_institutions[] = $new_row;
                }
            }
        }

        update_field('inputted_institutions', $inputted_institutions, $post_id);
    }
}



// Button: Run Tool

add_action('wp_ajax_run_interlinking_tool', 'run_interlinking_tool');
add_action('wp_ajax_nopriv_run_interlinking_tool', 'run_interlinking_tool');

function run_interlinking_tool() {
    
    if (isset($_POST['customPostID'])) {
        
        $custom_post_id = $_POST['customPostID'];
        update_post_institutions($custom_post_id);
        //update_generated_institutions_new_inputted_field($custom_post_id);
        add_generated_to_resulted($custom_post_id);
        count_resulted_institutions($custom_post_id);

        
    }
    wp_die(); // Always use wp_die() at the end
}


// Button: Remvoe Keyword Entries
add_action('wp_ajax_remove_keyword_entries', 'remove_keyword_entries');
add_action('wp_ajax_nopriv_remove_keyword_entries', 'remove_keyword_entries');

function remove_keyword_entries() {
    if (isset($_POST['customPostID'])) {
        $custom_post_id = $_POST['customPostID'];
        delete_field('generated_posts_for_posts', $custom_post_id);
        delete_field('resultant_posts_for_posts', $custom_post_id);
        update_field('count_resulted_posts', 0, $custom_post_id);
    }
    wp_die(); 
}

add_action('wp_ajax_calculate_institutions', 'calculate_institutions');
add_action('wp_ajax_nopriv_calculate_institutions', 'calculate_institutions');

function calculate_institutions() {
    
    if (isset($_POST['customPostID'])) {
        
        $custom_post_id = $_POST['customPostID'];
        
        process_resulted_institutions($custom_post_id);
        add_generated_to_resulted($custom_post_id);
        count_resulted_institutions($custom_post_id);
        //add_generated_to_inputted($custom_post_id);
    }
    
    wp_die(); // Always use wp_die() at the end
}


// Check Mark : Resultant Institututions 

add_action('wp_ajax_update_inputted_value', 'update_inputted_value');
add_action('wp_ajax_nopriv_update_inputted_value', 'update_inputted_value');

function update_inputted_value() {
    $post_id = $_POST['post_id'];
    $row_index = $_POST['row_index'];
    $inputted_value = $_POST['inputted_value'];

    // Extract the numeric value from the row index
    $index = intval(filter_var($row_index, FILTER_SANITIZE_NUMBER_INT));
   
    // Get the current 'resulted_institutions' data
    $resulted_institutions = get_field('resulted_institutions', $post_id);

    // Update the specific 'inputted' value in the 'resulted_institutions' data
    if (is_array($resulted_institutions) && isset($resulted_institutions[$index])) {
        $resulted_institutions[$index]['inputted'] = $inputted_value;
        update_field('resulted_institutions', $resulted_institutions, $post_id);
    }
    
    wp_die();
}


// Button: Update Generated Posts 

add_action('wp_ajax_generate_posts', 'generate_posts');
add_action('wp_ajax_generate_posts', 'generate_posts');

function generate_posts() {
    if (isset($_POST['customPostID'])) {
        $custom_post_id = $_POST['customPostID'];
         generate_posts_by_keywords($custom_post_id); 
        add_generated_posts_to_resulted_posts($custom_post_id);
        

    }
    wp_die(); 
}




// Button : Calculate Posts

add_action('wp_ajax_calculate_posts', 'calculate_posts');
add_action('wp_ajax_nopriv_calculate_posts', 'calculate_posts');

function calculate_posts() {
    if (isset($_POST['customPostID'])) {
        $custom_post_id = $_POST['customPostID'];
            make_generated_posts_to_inputted($custom_post_id);
            add_generated_posts_to_resulted_posts($custom_post_id);
            count_resulted_posts($custom_post_id);
        
    }
    wp_die(); 
}



// Check Mark from the Resultant Posts for Posts Clicked

add_action('wp_ajax_update_posts_inputted', 'update_posts_inputted');
add_action('wp_ajax_nopriv_update_posts_inputted', 'update_posts_inputted');

function update_posts_inputted() {
    $post_id = $_POST['post_id'];
    $row_index = $_POST['row_index'];
    $inputted_value = $_POST['inputted_value'];

    // Extract the numeric value from the row index
    $index = intval(filter_var($row_index, FILTER_SANITIZE_NUMBER_INT));
   
    $resulted_institutions = get_field('resultant_posts_for_posts', $post_id);

    // Update the specific 'inputted' value in the 'resulted_institutions' data
    if (is_array($resulted_institutions) && isset($resulted_institutions[$index])) {
        $resulted_institutions[$index]['inputted'] = $inputted_value;
        update_field('resultant_posts_for_posts', $resulted_institutions, $post_id);
    }
    
}




// Shortcode for get Scholarship Counts

function scholarship_count_shortcode() {
    $scholarship_count = wp_count_posts('scholarships')->publish;
    return $scholarship_count;
}
add_shortcode('scholarship_count', 'scholarship_count_shortcode');


// Shortcode for get Institutions Counts

function institution_count_shortcode() {
    $institution_count = wp_count_posts('institution')->publish;
    return $institution_count;
}
add_shortcode('institution_count', 'institution_count_shortcode');


// Shortcode Get Current Year
function current_year_shortcode() {
    $current_year = date('Y');
    return $current_year;
}
add_shortcode('current_year', 'current_year_shortcode');


// Shortcode get Current Year
function current_month_shortcode() {
    $current_month = date('F');
    return $current_month;
}
add_shortcode('current_month', 'current_month_shortcode');


function convert_country_to_nationality($country_name) {
    $nationalities = array(
        'Australia' => 'Australian',
        'Austria' => 'Austrian',
        'Belgium' => 'Belgian',
        'Canada' => 'Canadian',
        'China' => 'Chinese',
        'Denmark' => 'Danish',
        'Estonia' => 'Estonian',
        'Finland' => 'Finnish',
        'France' => 'French',
        'Germany' => 'German',
        'Hong Kong' => 'Hong Kong',
        'Hungary' => 'Hungarian',
        'Iceland' => 'Icelandic',
        'India' => 'Indian',
        'Ireland' => 'Irish',
        'Israel' => 'Israeli',
        'Italy' => 'Italian',
        'Japan' => 'Japanese',
        'Malaysia' => 'Malaysian',
        'Mexico' => 'Mexican',
        'Netherlands' => 'Dutch',
        'New Zealand' => 'New Zealand',
        'Norway' => 'Norwegian',
        'Philippines' => 'Filipino',
        'Poland' => 'Polish',
        'Portugal' => 'Portuguese',
        'Qatar' => 'Qatari',
        'Russia' => 'Russian',
        'Saudi Arabia' => 'Saudi Arabian',
        'Singapore' => 'Singaporean',
        'South Africa' => 'South African',
        'South Korea' => 'South Korean',
        'Spain' => 'Spanish',
        'Sweden' => 'Swedish',
        'Switzerland' => 'Swiss',
        'Taiwan' => 'Taiwanese',
        'Turkey' => 'Turkish',
        'United Kingdom' => 'British',
        'United States' => 'American'
    );

    if (array_key_exists($country_name, $nationalities)) {
        return $nationalities[$country_name];
    } else {
        return $country_name;
    }
}


// Function to generate the countries list text
function generate_countries_institutions_text($countries) {
    $texts = [];

    foreach ($countries as $country) {
        $nationality = convert_country_to_nationality($country);

        if ($nationality) {
            $texts[] = $nationality;
        }
    }

    $count = count($texts);
    if ($count === 1) {
        return $texts[0] . ' Institutions';
    } elseif ($count === 2) {
        return implode(' and ', $texts) . ' Institutions';
    } elseif ($count > 2) {
        $lastText = array_pop($texts);
        return implode(', ', $texts) . ", and " . $lastText . ' Institutions';
    } else {
        return "";
    }
}
