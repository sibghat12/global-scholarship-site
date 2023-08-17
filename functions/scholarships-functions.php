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

function get_currency($country){
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

    );
    
    return $currency_list[$country];
}



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


// Convert to USD
function convert_to_usd($amount, $currency){
   $list = array(
    "KRW" => 0.00077,
    "CAD" => 0.78,
    "RMB" => 0.15,
    "GBP" => 1.21,
    "AUD" => 0.71, 
    "Euros" => 1.03,
    "NOK" => 0.10 ,
    "CHF" => 1.06 ,
    "USD" => 1,
    "NZD" => 0.63,
    "PLN" => 0.22,
    "INR" => 0.012,
    "Pesos" => 0.018,
    "Rand" => 0.055,
    "SGD" => 0.75,
    "Yen" => 0.0075,
    "RUB" =>  0.013,
    "CZK" => 0.045,
    "kr" => 0.096,
    "Danish Krone" => 0.14,
    "MXN" => 0.054,
    "UAH" => 0.027,
    "TRY" => 0.053,
    "TWD" => 0.033,
    "Rp" => 0.000066,
    "SAR" => 0.27,
    "MYR" => 0.23,
    );

    return (float)$amount * (float)$list[$currency];

}

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
   
  
            
    if (in_array($location_name, $locations)){
        
        $city_args = array(
            'post_type' => 'city',
            'meta_key' => $location_type,
            "meta_value" => $location_name,
 
         

            'posts_per_page' => -1,
            'no_found_rows' => true, 
            'update_post_meta_cache' => false, 
            'update_post_term_cache' => false,   
            'cache_results'          => false,
            'fields' => 'ids',
        );
        
        $the_query = new WP_Query($city_args);
        
        $my_posts = $the_query->get_posts();
        
        $post_ids = array();

        if( ! empty( $my_posts ) ){
            foreach ( $my_posts as $id ){
                
                array_push($post_ids, $id);
                
            }
            
            $institute_args = array(
                'post_type' => 'institution',
                'post_status' => 'publish',
                
            
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order'   => 'ASC',
                'no_found_rows' => true, 
                'update_post_meta_cache' => false, 
                'update_post_term_cache' => false,   
                'cache_results'          => false,
                'fields' => 'ids',                     
                'meta_query' => array(
                        array(
                            'key' => 'cities',
                            'value' => $post_ids,
                            'compare' => 'IN'
                        )
                    )
            );
            
            $loop = new WP_Query($institute_args);
            
            return $loop;            
            
            
        }
            

        }
   
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



function get_current_deadlines_institutions ($degree, $institution_id){ 

   $degree_name = $degree;
   $current_date = strtotime(date("F j, Y"));

   $institution_query = get_institution_by_id($institution_id);
   $deadline = array();
   $accept_year_application = array();

    while ($institution_query->have_posts() ) {
        $institution_query->the_post();
             
        if( have_rows('admission_deadlines') ) {

            //Push Deadline with according to degree
            while( have_rows('admission_deadlines') ) {
            the_row();
            $degree_value = get_sub_field('degree');
            if($degree_value == $degree_name ){
                $deadline_date = get_sub_field('deadline');
                $accept_year_value = get_sub_field('accepts_application_all_year_round');
                array_push($deadline, $deadline_date);
                array_push($accept_year_application , $accept_year_value );
                }
             }
              
        if(empty($deadline)){
        //Push Deadline without according to degree
            while( have_rows('admission_deadlines') ) {
            the_row();
            $degree_value = get_sub_field('degree');
            if(empty($degree_value)){
                $deadline_date = get_sub_field('deadline');
                $accept_year_value = get_sub_field('accepts_application_all_year_round');
                array_push($deadline, $deadline_date);
                array_push($accept_year_application , $accept_year_value );
                }
             }
        }

       
        }

        if(empty($deadline)) {
        $old_date = date_create("2000-03-15");
        $old_date = date_format($old_date,"F j, Y");
        return $old_date;
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



    foreach($accept_year_application as $item){
      if($item=="Yes"){
        $far_date = date_create("2050-03-15");
        $far_date = date_format($far_date,"F j,Y");
        return $far_date;
      }
    }

// If the below gets run, then there should be only one date (the 2010 deadline) or all the deadlines were past


    /*return the latest deadline here*/
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


// function save_scholarships_deadline_post_meta(){
// $args = array(
//         'post_type' => 'scholarships',
         
//          'no_found_rows' => true, 
//           'update_post_meta_cache' => false,
//           'update_post_term_cache' => false,
//           'cache_results'          => false,
//           'fields' => 'ids',

//         'posts_per_page' => -1,
//         'post_status' => 'publish',
//     );
    
//    $current_date = strtotime(date("F j, Y"));
//    $query = new WP_Query($args);
   
//    $master_degree = "Master's";
//    $bachelor_degree = "Bachelor's";
//    while ($query->have_posts() ) {
        
//         $query->the_post();
//         $scholarship_id = get_the_ID(); 
        
       
//         // Ignore that Scholarship that has Value Set 
//         // And Has Deadline Greator that current Time . (Mean Deadline Is In future so we continue to new scholarship)
//         // Else loop goes down to save meta. 

//         $check_master = strtotime(get_field('current_masters_scholarship_deadline'));
//         $check_bachelor = strtotime(get_field('current_bachelors_scholarship_deadline'));

//         //Code that skips udating deadlines if the check_bachelor's is latest then the current date.
        
//         if( isset($check_master) && isset($check_bachelor) ){
//             if($check_master > $current_date && $check_bachelor > $current_date){
//                 continue;
//             }
//         }


        

//         $institution = get_field("scholarship_institution");



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

//        else {
          
//           if($scholarship_deadline_date > $admission_deadline_date){
//            update_field('current_bachelors_scholarship_deadline', $scholarship_deadline , $scholarship_id);
//           }else {
//             update_field('current_bachelors_scholarship_deadline', $admission_deadline , $scholarship_id);
//           }

//          }

          

//        }

// }




function save_institution_deadline_post_meta(){

 $args = array(
        'post_type' => 'institution',
         
         'no_found_rows' => true, 
          'update_post_meta_cache' => false,
          'update_post_term_cache' => false,
          'cache_results'          => false,
          'fields' => 'ids',

        'posts_per_page' => -1,
        'post_status' => 'publish',
    );
    
   $query = new WP_Query($args);
   $master_degree = "Master's";
   $bachelor_degree = "Bachelor's";
   
   while ($query->have_posts() ) {


        
        $query->the_post();
        $institution_id = get_the_ID(); 

        
        // ..............................   Code to Work for the Master's. .........................

       $admission_deadline  = get_current_deadlines_institutions($master_degree , $institution_id );
        update_field('current_masters_admission_deadline', $admission_deadline , $institution_id);
         
        
        // ..............................   Code to Work for the Bachelors's. .........................

        $admission_deadline  = get_current_deadlines_institutions($bachelor_degree , $institution_id );
        update_field('current_bachelors_admission_deadline', $admission_deadline , $institution_id);

    }

}

   


function save_deadline_post_meta(){
    save_institution_deadline_post_meta();
    save_scholarships_deadline_post_meta();
}


//save_deadline_post_meta();

//add_action( 'init', 'save_deadline_post_meta' );



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
// add_action('init', 'save_scholarships_open_date_post_meta', 100);
// function save_scholarships_open_date_post_meta(){

// $args = array(
//         'post_type' => 'scholarships',
//         'post_status' => 'publish',
     
//      'no_found_rows' => true, 
//      'update_post_meta_cache' => false,
//      'update_post_term_cache' => false,
//      'cache_results'          => false,
//      'fields' => 'ids',


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


// }



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
    

    ?>



<script type="text/javascript">

    
    jQuery(document).ready(function($) {
    console.log("adas");
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



    
});


</script>
<?php 
  if (get_post_type() == 'scholarships') {

   include dirname(__FILE__) . "/countries_list.php"; 
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
 console.log(new_array);
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

   const exclude_regions_checkbox = document.getElementById('acf-field_64ca21f1da211-Africa');
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
    $output .= '<h2>' . esc_html($a['heading']) . '</h2>';
    $output .= '<hr>';
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
            $ibl = get_field("tuition_fee_international_lower" , $post->ID);
            $ibu = get_field("tuition_fee_upper_tuition_fee" , $post->ID );
            $iml = get_field("masters_tuition_fee_international_lower",  $post->ID);
            $imu = get_field("masters_tuition_fee_upper_tuition_fee",  $post->ID);


            $city = get_field('cities' , $post->ID);
            $city = get_post($city->ID);
            $country = get_post_meta($city->ID, 'country', TRUE);
            $current_currency = get_currency($country); 

        
             $ibl = roundNearestHundreth(convert_to_usd($ibl, $current_currency));
             $ibu = roundNearestHundreth(convert_to_usd($ibu, $current_currency));
             $imu = roundNearestHundreth(convert_to_usd($imu, $current_currency));
             $iml = roundNearestHundreth(convert_to_usd($iml, $current_currency)); 

             if (get_field("tuition_fee_international_lower" , $post->ID) == -1){
                $ibl = -1; 
            }
            
            if (get_field("tuition_fee_upper_tuition_fee", $post->ID) == -1){
                $ibu = -1; 
            }
            
            if (get_field("masters_tuition_fee_international_lower" , $post->ID) == -1){
                $iml = -1; 
            }
            
            if (get_field("masters_tuition_fee_upper_tuition_fee" , $post->ID) == -1){
                $imu = -1; 
            }
            
            
            //Checks if there are tuition information. This is used for titles
            if ($ibl == -1 && $ibu == -1 && $iml == -1 && $imu == -1){
                $is_tuition_information = false;
            } else {
                $is_tuition_information = true;
            }



       $scholarships_query = get_scholarships( $post->ID);
       $number_of_scholarships  = $scholarships_query->post_count;

            if ($number_of_scholarships > 0) {
                $title = $institution_title . " " . " Scholarships for International Students";            
            } elseif ($is_tuition_information) {
                $title = $institution_title . " " . " Tuition for International Students"; 
            } else {
                $title = $institution_title ." ". "Background Information ";     
            }

            $title = $title .' '. date("Y").' - '.date('Y', strtotime('+1 year'));
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

        if (isset($subject_value) && $subject_value) {
            if ($subject_value != "All Subjects") {
                $subject_query = array(
                    'relation' => 'OR',
                    array(
                        'key' => 'eligible_programs',
                        'value' => $subject_value,
                        'compare' => 'LIKE',
                    ),
                    array(
                        'key' => 'eligible_programs',
                        'value' => "All Subjects",
                        'compare' => 'LIKE',
                    ),
                );
            } else {
                $subject_query = array('type' => 'string', 'key' => 'eligible_programs', 'value' => $subject_value, 'compare' => 'IN');
            }
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

       if($scholarship_type_value=="Full Funding"){
        $scholarship_type_value = "Fully Funded";
       }
       if($scholarship_type_value=="Partial Funding"){
        $scholarship_type_value = "Partially Funded";
       }

        
            
             
          if ($scholarship_type_value) {
    if ($degree_value) {
        $text .= $found_posts . " " . $scholarship_type_value . " " . $degree_value . " Scholarships";
    } else {
        $text .= $found_posts . " " . $scholarship_type_value . " Scholarships";
    }
} else {
    if ($degree_value) {
        $text .= $found_posts . " " . $degree_value . " Scholarships";
    } else {
        $text .= $found_posts . " Scholarships";
    }
}

           if ($location_value) {
                $text .= " in " . $location_value;
            }
            if ($subject_value) {
                 if ($scholarship_type_value) {
    if ($degree_string) {
        $text .= $found_posts . " " . $scholarship_type_value . " " . $degree_value . " Scholarships";
    } else {
        $text .= $found_posts . " " . $scholarship_type_value . " Scholarships";
    }
} else {
    if ($degree_string) {
        $text .= $found_posts . " " . $degree_value . " Scholarships";
    } else {
        $text .= $found_posts . " Scholarships";
    }
}
        $text .= " for " . $subject_value;
            }

            $text .= " for International Students ";

            if($page) {
                $text .= "- Page " .$page . " of " . ceil($found_posts / 20);
               }

            return  $text;
       

        
    }






    return $title;
}

add_filter('rank_math/frontend/title', 'custom_rankmath_title');






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

    // echo "<pre>";
    // print_r($post_names);
    // exit;

    return array($post_ids, $post_names);
}



function update_generated_posts_field($institution_id, $post_names) {
    // Delete all existing rows in the repeater field
    delete_field('generated_posts', $institution_id);

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
        'posts_per_page' => -1,
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





function update_post_institutions() {
    global $wpdb;

    // Fetch all institution names 
    $institutions = $wpdb->get_results("SELECT ID, post_title, post_type FROM {$wpdb->posts} WHERE post_type = 'institution' AND post_status = 'publish'");

    // Fetch the first 100 published posts
    $post_data = $wpdb->get_results("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish' ORDER BY ID ASC");

    // Loop through the specific post
    foreach ($post_data as $post) {
        $post_id = $post->ID;
        $post_content = $post->post_content;

        $current_institutions = get_field('institutions', $post_id);
        if (!is_array($current_institutions)) {
            $current_institutions = array();
        }

        // Delete all existing rows in the institutions repeater field
        delete_field('institutions', $post_id);

        // Loop through all institutions
        foreach ($institutions as $institution) {
            $institution_id = $institution->ID;
            $institution_name = $institution->post_title;
            $institution_permalink = get_permalink($institution_id);

            if (preg_match('/[[:<:]]' . preg_quote($institution_name, '/') . '[[:>:]]/', $post_content)) {
                if (!empty($institution_name) && !empty($institution_permalink) && !in_array($institution_name, array_column($current_institutions, 'institution_title'))) {
                    $current_institutions[] = array(
                        'institution_title' => $institution_name,
                        'institution_link' => $institution_permalink
                    );
                }
            }
        }

        // Add a new row for each institution with non-empty title and link
        foreach ($current_institutions as $institution) {
            // Only add the row if the title and link are not empty
            if (!empty($institution['institution_title']) && !empty($institution['institution_link'])) {
                add_row('institutions', $institution, $post_id);
            }
        }
    }
}



//update_post_institutions();






function update_open_dates() {
    // Query all institution custom post types
    $args = [
        'post_type' => 'institution', // Replace 'institution' with your custom post type name
        'posts_per_page' => -1,
         'post_status' => 'publish'
    ];
    $query = new WP_Query($args);

    // Loop through all institution custom post types and update the open dates
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();

            if (have_rows('admission_deadlines', $post_id)) {
                $row_index = 1;
                while (have_rows('admission_deadlines', $post_id)) {
                    the_row();

                    // Get the admission deadlines data from the ACF repeater field row and than update it 
                    $deadline = get_sub_field('deadline');
                    $open_date = get_sub_field('open_date');

                    // Update the open dates if open_date is empty and deadline is not
                    if (empty($open_date) && !empty($deadline)) {
                        $deadline_date = DateTime::createFromFormat('F j, Y', $deadline);
                        $deadline_date->sub(new DateInterval("P3M")); // Subtract 3 months
                        $new_open_date = $deadline_date->format('F j, Y');

                        // Update the row with the new open_date
                        update_row('admission_deadlines', $row_index, [
                            'deadline' => $deadline,
                            'open_date' => $new_open_date
                        ], $post_id);
                    }
                    $row_index++;
                }
            }
        }
    }

    // Reset the post data
    wp_reset_postdata();
}

//add_action('init', 'update_open_dates');


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
//add_action('init', 'calculate_resulted_posts');


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


function calculate_resulted_institutions() {
    // Custom WP_Query for post type post
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'no_found_rows' => true, 
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results'          => false,
        'fields' => 'ids'
    );
    $query = new WP_Query($args);

    // Loop through all post type posts
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Get the current post ID
            $post_id = get_the_ID();

            // Get the institutions repeater field
            $institutions = get_field('institutions', $post_id);

            // Get the inputted_institutions repeater field
            $inputted_institutions = get_field('inputted_institutions', $post_id);

            // Check if both repeaters are arrays
            //if (is_array($institutions) && is_array($inputted_institutions)) {

                //new logic
                if (is_array($institutions)) {
                    // Calculate the resulted institutions after considering inputted institutions
                $resulted_institutions = array();

                foreach ($institutions as $institution) {
                    $institution_title = $institution['institution_title'];
                    $institution_link = $institution['institution_link'];

                    $is_in_inputted_institutions = false;

                    foreach ($inputted_institutions as $inputted_institution) {
                        $inputted_institution_id = $inputted_institution['institution_name'];
                        $inputted_institution_title = get_the_title($inputted_institution_id);
                        $inputted_institution_link = get_permalink($inputted_institution_id);

                        if ($institution_title === $inputted_institution_title) {
                            $is_in_inputted_institutions = true;
                            break;
                        }
                    }

                    if (!$is_in_inputted_institutions) {
                        $resulted_institutions[] = array(
                            'institution_name' => $institution_title,
                            'institution_link' => $institution_link
                        );
                    }
                }

                // Delete all rows from the resulted_institutions repeater before adding more
                $resulted_institutions_count = get_field('resulted_institutions', $post_id) ? count(get_field('resulted_institutions', $post_id)) : 0;
                for ($i = $resulted_institutions_count; $i >= 1; $i--) {
                    delete_row('resulted_institutions', $i, $post_id);
                }

                // Update the resulted_institutions repeater with the resulted institutions using add_row() function
                if (!empty($resulted_institutions)) {
                    foreach ($resulted_institutions as $resulted_institution) {
                        add_row('resulted_institutions', $resulted_institution, $post_id);
                    }
                }
            }
        }

        // Restore original post data
        wp_reset_postdata();
    }
}

// Call the function to perform the calculation
//add_action('init', 'calculate_resulted_institutions');



function update_number_of_resulted_institutions() {
    // Custom WP_Query for post type custom post type
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'no_found_rows' => true, 
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results'          => false,
        'fields' => 'ids'
    );
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
                update_field('number_of_resulted_institutions', 0 , $post_id);
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


// function crop_image($file_path) {
//     $image = wp_get_image_editor($file_path);
    
//     if ( ! is_wp_error($image)) {
//         $size = $image->get_size();
//         $width = $size['width'];
//         $height = $size['height'];

//         // Set the dimensions of the crop area (modify these as needed)
//         $crop_width = $width - 10;
//         $crop_height = $height - 10;

//         // Crop the image
//         $image->crop(0, 0, $width, $height, $crop_width, $crop_height);
//         $image->save($file_path);
//     }
// }

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