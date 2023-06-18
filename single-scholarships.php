<?php
/**
* This is used for Scholarship custom post type
*
* @package Avada
*/

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
   exit( 'Direct script access denied.' );
   
}

include dirname(__FILE__) . "/functions/countries_list.php"; 

$diffArray = [];
$newArray = [];

?>




<?php get_header(); ?>

<?php while ( have_posts() ) : ?>
       <?php the_post(); 

      $institution_id = get_post_meta($post->ID, 'scholarship_institution', true);
        if (!empty($institution_id)) {
            $institution_title = get_the_title($institution_id);
            $title_h1 =  get_the_title($post->ID) .' at '. $institution_title;
        }

        ?>

<div class="avada-page-titlebar-wrapper customm" role="banner">
  <div class="fusion-page-title-bar fusion-page-title-bar-none fusion-page-title-bar-center">
    <div class="fusion-page-title-row">
      <div class="fusion-page-title-wrapper">
        <div class="fusion-page-title-captions">

                                              <h1 class="">   <?php echo $title_h1; ?> </h1>

                      
                                    <div class="fusion-page-title-secondary">
                <div class="fusion-breadcrumbs"><span class="fusion-breadcrumb-item"><a href="https://stg-globalscholarshipsa-sibi.kinsta.cloud" class="fusion-breadcrumb-link"><span>Home</span></a></span><span class="fusion-breadcrumb-sep">/</span><span class="fusion-breadcrumb-item"><span class="breadcrumb-leaf">Fellowship and Relocation Grant</span></span></div>              </div>
                      
        </div>

        
      </div>
    </div>
  </div>
</div>

<div id="ezoic-pub-ad-placeholder-863"> </div>
<!-- End Ezoic - top_of_page - top_of_page -->
      
      <main id="main"  class="clearfix width-100">
        <div class="fusion-row" style="max-width:100%;">

        

<section   id="content" style="<?php esc_attr_e( apply_filters( 'awb_content_tag_style', '' ) ); ?>">


   <?php

     $scholarship_title = get_the_title(); ?>
       
       <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
           
           <?php echo fusion_render_rich_snippets_for_pages(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
           <?php avada_singular_featured_image(); ?>
           
        <?php  
       
           //Get Scholarship Custom Fields + Post Meta.

           $scholarship_type = get_field('amount_category');
           $scholarship_amount = get_field('amount_in_numbers');
           $scholarship_deadline = get_field('scholarship_deadline');
           $degrees = get_field('eligible_degrees');
           $degrees_text = convert_array_to_text($degrees);

           $number_of_recipients = get_field('number_of_recipients');
           $scholarship_duration = get_field('scholarship_duration');
           $programs = get_field('eligible_programs');
           
           $programs_text = convert_array_to_text($programs);

           
        
           if (in_array("All Subjects", $programs)){
            $programs_text = "All Subjects offered at " . get_the_title(get_field("scholarship_institution"));
           } else {
            $programs_text = convert_array_to_text($programs);
            }           
           


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
           
           
           <div class="post-content">
           
           <div style="padding-left:15px;" class="breadcrumbs">
             <a href="<?php echo site_url(); ?>/scholarship-search/<?php echo $hyphenated ?>"> <?php echo $country_name; ?> Scholarships  </a> /
              <a href="<?php echo get_permalink($institution->ID); ?>"> <?php echo $institution_name ." Scholarships";  ?> </a> /
              <a href="#"> <?php  echo $scholarship_title; ?> </a>
              <br>
               <?php 
                if (count($degrees) == 1){ ?>
                	
                   <a href="<?php echo site_url(); ?>/scholarship-search/<?php echo $degrees_formatted_array[0] ?>">
                   <?php  echo  $degrees[0] . " Scholarships  </a>" ?>
                  
                   <?php }

                  else if (count($degrees) == 2){ ?>
                     
                    <a href="<?php echo site_url(); ?>/scholarship-search/<?php echo $degrees_formatted_array[0] ?>">
                   <?php  echo  $degrees[0] . " Scholarships  </a>" ?>

                   /  <a href="<?php echo site_url(); ?>/scholarship-search/<?php echo $degrees_formatted_array[1] ?>">
                   <?php  echo  $degrees[1] . " Scholarships  </a>" ?>

                  
                  <?php } else if (count($degrees) == 3){  ?>

                 	   <a href="<?php echo site_url(); ?>/scholarship-search/<?php echo $degrees_formatted_array[0] ?>">
                     <?php  echo  $degrees[0] . " Scholarships  </a>" ?>

                   /  <a href="<?php echo site_url(); ?>/scholarship-search/<?php echo $degrees_formatted_array[1] ?>">
                   <?php  echo  $degrees[1] . " Scholarships  </a>" ?>


                    /  <a href="<?php echo site_url(); ?>/scholarship-search/<?php echo $degrees_formatted_array[2] ?>">
                   <?php  echo   $degrees[2] . " Scholarships  </a>" ?>
                
                <?php } 


                 ?>
                

           </div>

<!-- adngin-top_leaderboard-0   Ads do not delete-->
<div id="adngin-top_leaderboard-0"></div> 

             
           
                             
              <p> <?php if($founded_year > 1) { echo "Founded in " . $founded_year;} ?>,
                  <?php echo $institution_name; ?> is a
                  <?php echo strtolower($institution_type); ?> institution in
                  <?php echo $city_name . ", " . $country_name; ?>. <?php  echo $institution_name ?> is ranked by the <?php echo $ranking_array['name']; ?> Ranking as the top
                   <?php echo $ranking_array['value']; ?> institution in the world. Here, we will be looking at <?php echo $scholarship_title; ?>,
                  one of the <?php echo get_adjective_scholarship_amount($scholarship_type); ?> <?php  echo $institution_name; ?> scholarships for <?php echo $degrees_text; ?> international students.</p>

 <!-- adngin-incontent_1-0 Ads do not delete-->
<div id="adngin-incontent_1-0" style="text-align: center;"></div>
                 
              <h2> Scholarship Summary </h2>
              <ul>

                  <li>  Level of Study: <b><?php  echo $degrees_text; ?></b></li>
                  <li>  Host Institution:  <a href="<?php echo get_permalink($institution->ID); ?>"><b><?php  echo $institution_name; ?></b> </a></li>    
                  
                  <?php  if($scholarship_amount > 0 ){ ?>
                  
                                 <li>  
                  Scholarship Amount: <b><?php echo number_format($scholarship_amount); ?>  
                  <?php echo $currency; ?></b></li>    


                  <?php    }  ?>                  
                  
             <li>Scholarship Type: <b><?php echo $scholarship_type; ?> </b> </li>                   
                  
               <li>  Eligible Nationalities:   <b>
                  
                  <?php 
                     $countries = get_field('eligible_nationality');
                     $countries = explode(",",str_replace("\'","",implode(",",$countries)));
                     
                     $country_array_original = explode(",", str_replace( "'",   "",    implode(",", $country_array_original)));
                     

                      if($countries) {
                      $newArray = array_combine($countries, $countries);
                      }
                   
                    if($newArray) {
                      $diffArray = array_diff($country_array_original ,$newArray );
                    } 

                  if(count($diffArray) < 20 ) {
                      
                       if(in_array("All Nationalities", $countries )){
                        echo "All Nationalities";
                       } else  {
                        array_shift($diffArray);
                        echo "All Nationalities except " . convert_array_to_text($diffArray);
                      }

                  } else {

                        if(in_array("All Nationalities", $countries)) { 
                          echo "All Nationalities";
                          } else {
                       echo convert_array_to_text($countries);
                     }

                  }
                  
                  
                
                  
                   ?>

                     </b> </li>


               <?php if ($programs){?><li>  Eligible Subjects:   <b><?php  echo $programs_text; ?>       </b> </li><?php }?>
               <?php if($number_of_recipients > 0){ ?>
               <li> Number of Recipients:  <b> <?php  echo $number_of_recipients; ?>      </b>  </li>
               <?php }  else {
    
               echo "<li>Number of Recipients: <b>Not Specified</b> </li>";

                }?>
               
                   <li> Additional Scholarships Materials Required? <b><?php echo $separate_application; ?></b>  </li>
                  

                   <?php 
                  
                  
                       $bachelor_open_date = get_field('bachelor_open_date');
                       $master_open_date = get_field('master_open_date');


if ($institution_query->have_posts()) {

	               $bachelors_deadline = "";
                   $masters_deadline = "";
                   $bachelors_deadline_label = "";
                   $masters_deadline_label = "";
                   $bachelor_accpet_all_year = "";
                   $master_accept_all_year  ="";
                  
                   $has_found_bachelor= false;
                   $has_found_master = false;
                   $no_degree_selected = false;
                   $current_date_date = date('F j, Y');
                   $current_date = time();

    while ($institution_query->have_posts()) {
        $institution_query->the_post();

        if (have_rows('admission_deadlines')) {

            // Push Deadline according to the degree
            while (have_rows('admission_deadlines')) {
                the_row();

                $degree = get_sub_field('degree');

                if ($degree == "Bachelor's") {
                    $current_bachelors_deadline = get_sub_field("deadline");
                     $bachelor_accpet_all_year = get_sub_field("accepts_application_all_year_round");
                    if (empty($bachelors_deadline) ||
                        (strtotime($current_bachelors_deadline) > $current_date && (strtotime($current_bachelors_deadline) < strtotime($bachelors_deadline) || strtotime($bachelors_deadline) < $current_date)) ||
                        (strtotime($current_bachelors_deadline) < $current_date && strtotime($current_bachelors_deadline) > strtotime($bachelors_deadline))) {
                            $bachelors_deadline = $current_bachelors_deadline;
                          if($bachelors_deadline=="") {
                              if($bachelor_accpet_all_year=="Yes"){
                                $bachelors_deadline = "Accepts Application All Year";
                              }
                            }
                            $bachelors_deadline_label = get_sub_field("label");

                    }
                }

                if ($degree == "Master's") {
                    $current_masters_deadline = get_sub_field("deadline");
                    $master_accept_all_year = get_sub_field("accepts_application_all_year_round");
                    if (empty($masters_deadline) ||
                        (strtotime($current_masters_deadline) > $current_date && (strtotime($current_masters_deadline) < strtotime($masters_deadline) || strtotime($masters_deadline) < $current_date)) || $master_accept_all_year =="Yes" ||
                        (strtotime($current_masters_deadline) < $current_date && strtotime($current_masters_deadline) > strtotime($masters_deadline))) {
                            $masters_deadline = $current_masters_deadline;
                            if($masters_deadline=="") {
                              if($master_accept_all_year=="Yes"){
                                $masters_deadline = "Accepts Application All Year";
                              }
                            }
                            $masters_deadline_label = get_sub_field("label");
                    }
                }
            }

            if (empty($masters_deadline) || empty($bachelors_deadline)) {

                if (!$has_found_bachelor && !$has_found_master) {

                    while (have_rows('admission_deadlines')) {
                        the_row();
                        $current_deadline_without_degree = get_sub_field("deadline");

                        if (empty($deadline_without_degree) ||
                            (strtotime($current_deadline_without_degree) > $current_date && (strtotime($current_deadline_without_degree) < strtotime($deadline_without_degree) || strtotime($deadline_without_degree) < $current_date)) ||
                            (strtotime($current_deadline_without_degree) < $current_date && strtotime($current_deadline_without_degree) > strtotime($deadline_without_degree))) {
                                $deadline_without_degree = $current_deadline_without_degree;
                                $label_without_degree = get_sub_field("label");
                                $accept_all_year = get_sub_field("accepts_application_all_year_round");
                                $no_degree_selected = true;
                        }
                    }
                }
            }
        }
    }



    if (in_array("PhD", $degrees) && count($degrees) == 1) {
               // Do nothing
            } else {

            echo "</b>";
            if($bachelors_deadline || $masters_deadline || $accept_all_year || $master_accept_all_year ||  $deadline_without_degree ) {
            if($no_degree_selected) {
                
                if ($accept_all_year=="Yes") { 
                  echo '<li> Admission Deadline: ';
                echo "<b>";
                  echo " Currently Open"; 
                  echo "</b>"; } else {
            
             if($deadline_without_degree) {
             echo '<li> Admission Deadline: ';
                echo "<b>";
             echo  $deadline_without_degree;
             
              if ($bachelor_open_date == "Yes" || $master_open_date== "Yes") {
    echo "<i> (Currently Open)</i>";
} else {
    if (strtotime($deadline_without_degree) < strtotime($current_date_date)) {
        echo "<i> (Past Deadline)</i>";
    } 
}


            }

             }
           
           } else {
           
           echo '<li> Admission Deadline: ';

           if (in_array("Bachelor's", $degrees) && in_array("Master's", $degrees)) {
              

              if($masters_deadline === $bachelors_deadline) {
                 echo "<b>";  
            if($bachelor_accpet_all_year=="Yes"){ echo "Currently Open"; } else {
         
            echo  $bachelors_deadline;
           
            if ($bachelor_open_date == "Yes") {
    echo "<i>  (Currently Open)</i>";
} else {
    if (strtotime($bachelors_deadline) < strtotime($current_date_date)) {
        echo "<i> (Past Deadline)</i>";
    } 
}
              echo " </b>";
            }
           
              } else {

            // Both Bachelor's and Master's degrees are in the array
            echo " <ul style='padding-left:100px;font-weight:700;margin-top:0px;line-height:28px;font-size:17px;'>"; 
             


            if($bachelors_deadline) {
            echo "<li> Bachelor's: ";
            if ($bachelor_accpet_all_year=="Yes") { echo ": Currently Open";} else {
            echo  $bachelors_deadline;

             if ($bachelor_open_date == "Yes") {
    echo "<i>   (Currently Open)</i>";
} else {
    if (strtotime($bachelors_deadline) < strtotime($current_date_date)) {
        echo "<i>  (Past Deadline)</i>";
    } 
}




            }
            echo "</li>";
            }

            if($masters_deadline) {

            echo "<li> Master's: "; 
            if ($master_accept_all_year=="Yes") { echo "Accepts Application All Year"; } else {
            
             echo $masters_deadline;
               if ($master_open_date == "Yes") {
    echo "<i>  (Currently Open)</i>";
} else {
    if (strtotime($masters_deadline) < strtotime($current_date_date)) {
        echo "<i> (Past Deadline)</i>";
    } 
}
            }

             
            echo " </li>"; 
            }  


            echo "</ul>"; 
                
                }

            } elseif (in_array("Bachelor's", $degrees)) {
            // Only Bachelor's degree is in the array
            echo "<b>";  
            if($bachelor_accpet_all_year=="Yes"){ echo "Currently Open"; } else {
         
            echo  $bachelors_deadline;
           
            if ($bachelor_open_date == "Yes") {
    echo "<i>  (Currently Open)</i>";
} else {
    if (strtotime($bachelors_deadline) < strtotime($current_date_date)) {
        echo "<i> (Past Deadline)</i>";
    } 
}

            }
            echo " </b>";

            } elseif (in_array("Master's", $degrees)) {
              echo "<b>"; 
               if($master_accept_all_year=="Yes"){ echo "Currently Open"; } else {
            // Only Master's degree is in the array
          
            echo  $masters_deadline;
          
           if ($master_open_date == "Yes") {
    echo "<i>  (Currently Open)</i>";
} else {
    if (strtotime($masters_deadline) < strtotime($current_date_date)) {
        echo "<i> (Past Deadline)</i>";
    } 
}

           } 
            echo "</b>";
            }
          

            echo '</li>'; }
          }
            }




}



                  
      

            


         //Scholarship Deadline
           wp_reset_postdata();   
            if (have_rows("scholarship_deadlines")) {
                    
                   $bachelors_deadline = "";
                   $masters_deadline = "";
                   $bachelors_deadline_label = "";
                   $masters_deadline_label = "";
                   $bachelor_accpet_all_year = "";
                   $master_accept_all_year  ="";
                  
                   $has_found_bachelor= false;
                   $has_found_master = false;
                   $no_degree_selected = false;
                   $current_date_date = date('F j, Y');
                   $current_date = time();

                   $deadline_without_degree = "";

                       $bachelor_open_date = "";
                       $master_open_date = "";

    while (have_rows("scholarship_deadlines")) {
        the_row();

        $degree = get_sub_field('degree');

        if ($degree == "Bachelor's") {
            $current_bachelors_deadline = get_sub_field("deadline");

            if (empty($bachelors_deadline) ||
                (strtotime($current_bachelors_deadline) > $current_date && strtotime($current_bachelors_deadline) < strtotime($bachelors_deadline)) ||
                (strtotime($current_bachelors_deadline) < $current_date && strtotime($current_bachelors_deadline) > strtotime($bachelors_deadline))) {
                    $bachelors_deadline = $current_bachelors_deadline;
                    $bachelors_deadline_label = get_sub_field("label");
                    
                      $deadline_date_scholarship = get_sub_field('deadline');
                       $open_date_scholarship = get_sub_field('open_date');

                       // Convert deadline and open dates to Unix timestamps
$deadline_date_scholarship = strtotime($deadline_date_scholarship);
$open_date_scholarship = strtotime($open_date_scholarship);

// Check if open_date is less than the current date and deadline is greater than the current date
if ($open_date_scholarship < $current_date && $deadline_date_scholarship > $current_date) {
             
             $bachelor_open_date= "Yes";

            }
        }
      }

        if ($degree == "Master's") {
            $current_masters_deadline = get_sub_field("deadline");

            if (empty($masters_deadline) ||
                (strtotime($current_masters_deadline) > $current_date && strtotime($current_masters_deadline) < strtotime($masters_deadline)) ||
                (strtotime($current_masters_deadline) < $current_date && strtotime($current_masters_deadline) > strtotime($masters_deadline))) {
                    $masters_deadline = $current_masters_deadline;
                    $masters_deadline_label = get_sub_field("label");

                    $deadline_date_scholarship = get_sub_field('deadline');
                       $open_date_scholarship = get_sub_field('open_date');

                       // Convert deadline and open dates to Unix timestamps
$deadline_date_scholarship = strtotime($deadline_date_scholarship);
$open_date_scholarship = strtotime($open_date_scholarship);

// Check if open_date is less than the current date and deadline is greater than the current date
if ($open_date_scholarship < $current_date && $deadline_date_scholarship > $current_date) {
             
             $master_open_date= "Yes";

            }


            }
        }
    }

    if (empty($masters_deadline) || empty($bachelors_deadline)) {

        while (have_rows("scholarship_deadlines")) {
            the_row();

            $current_deadline_without_degree = get_sub_field("deadline");

            if (empty($deadline_without_degree) ||
                (strtotime($current_deadline_without_degree) > $current_date && strtotime($current_deadline_without_degree) < strtotime($deadline_without_degree)) ||
                (strtotime($current_deadline_without_degree) < $current_date && strtotime($current_deadline_without_degree) > strtotime($deadline_without_degree))) {
                    
                    $deadline_without_degree = $current_deadline_without_degree;
                    $label_without_degree = get_sub_field("label");

                    $deadline_date_scholarship = get_sub_field('deadline');
                       $open_date_scholarship = get_sub_field('open_date');

                       // Convert deadline and open dates to Unix timestamps
$deadline_date_scholarship = strtotime($deadline_date_scholarship);
$open_date_scholarship = strtotime($open_date_scholarship);



// Check if open_date is less than the current date and deadline is greater than the current date
if ($open_date_scholarship < $current_date && $deadline_date_scholarship > $current_date) {
             
             $bachelor_open_date= "Yes";
             $master_open_date="Yes";
            

            }

                    $no_degree_selected = true;
            }
        }
    }



  
   if (in_array("PhD", $degrees) && count($degrees) == 1) {
               // Do nothing
            } else {

            
          
            if($no_degree_selected) {
                
                if ($master_accept_all_year=="Yes" ||  $bachelor_accpet_all_year =="Yes") { 
                  echo '<li> </b> Scholarship Deadline: ';
                echo "<b>";
                  echo " Currently Open"; 
                  echo "</b>"; } else {
            
             if($deadline_without_degree) {
             echo '<li> </b> Scholarship Deadline: ';
                echo "<b>";
             echo  $deadline_without_degree;
             
             if ($bachelor_open_date == "Yes" || $master_open_date== "Yes") {
    echo "<i>  (Currently Open)</i>";
} else {
    if (strtotime($deadline_without_degree) < strtotime($current_date_date)) {
        echo "<i> (Past Deadline)</i>";
    } 
}


            } }
           
           } else {
           
           echo '<li> </b>Scholarship Deadline: ';

           if (in_array("Bachelor's", $degrees) && in_array("Master's", $degrees)) {

           if($masters_deadline === $bachelors_deadline) {
                 echo "<b>";  
            if($bachelor_accpet_all_year=="Yes"){ echo "Currently Open"; } else {
         
            echo  $bachelors_deadline;
           
            if ($bachelor_open_date == "Yes" || $master_open_date == "Yes") {
    echo "<i>  (Currently Open)</i>";
} else {
    if (strtotime($bachelors_deadline) < strtotime($current_date_date)) {
        echo "<i> (Past Deadline)</i>";
    } 
}
              echo " </b>";
            }
           
              } else {


               
            // Both Bachelor's and Master's degrees are in the array
            echo " <ul style='padding-left:100px;font-weight:700;margin-top:0px;line-height:28px;font-size:17px;'>"; 
            
            if($bachelors_deadline) {
            echo "<li> Bachelor's: ";
            if ($bachelor_accpet_all_year=="Yes") { echo ": Currently Open";} else {
            echo  $bachelors_deadline;
              

              if ($bachelor_open_date == "Yes") {
    echo "<i> (Currently Open)</i>";
} else {
    if (strtotime($bachelors_deadline) < strtotime($current_date_date)) {
        echo "<i> (Past Deadline)</i>";
    } 
}


            }
            echo "</li>";
            }

            if($masters_deadline) {

            echo "<li> Master's: "; 
            if ($master_accept_all_year=="Yes") { echo ": Currently Open";} else {
            
             echo $masters_deadline;
               if ($master_open_date == "Yes") {
    echo "<i>  (Currently Open)</i>";
} else {
    if (strtotime($masters_deadline) < strtotime($current_date_date)) {
        echo "<i> (Past Deadline)</i>";
    } 
}
            }

             
            echo " </li>"; 
            }  


            echo "</ul>"; 
                }

            } elseif (in_array("Bachelor's", $degrees)) {
            // Only Bachelor's degree is in the array
            echo "<b>";  
            if($bachelor_accpet_all_year=="Yes"){ echo "Currently Open"; } else {
         
            echo  $bachelors_deadline;
           if ($bachelor_open_date == "Yes") {
    echo "<i> (Currently Open)</i>";
} else {
    if (strtotime($bachelors_deadline) < strtotime($current_date_date)) {
        echo "<i> (Past Deadline)</i>";
    } 
}

            }
            echo " </b>";

            } elseif (in_array("Master's", $degrees)) {
              echo "<b>"; 
               if($master_accept_all_year=="Yes"){ echo "Currently Open"; } else {
            // Only Master's degree is in the array
          
            echo  $masters_deadline;
            
            if ($master_open_date == "Yes") {
    echo "<i> (Currently Open)</i>";
} else {
    if (strtotime($masters_deadline) < strtotime($current_date_date)) {
        echo "<i> (Past Deadline)</i>";
    } 
}

           } 
            echo "</b>";
            }
          

            echo '</li>'; }
          }
            


}





     
?>



              </ul></b>
                <?php   wp_reset_postdata();      ?>
              <h2>  <?php echo  $scholarship_title; ?> Coverage </h2>
              
              <?php if (sizeof($coverage) > 1){ ?>
               
              <p>  <?php echo  $scholarship_title; ?> covers  the following:</p>
               
              <ul>
              <?php
                                       
                  while (have_rows("scholarship_coverage")){
                  the_row();
                  
                  $value = get_sub_field("coverage");
                  ?>
              <li> <?php echo $value; ?></li>
              <?php } ?> </ul> <?php } else if (sizeof($coverage) == 1) { ?>
               
              <p>  <?php echo $scholarship_title; ?> covers <?php while (have_rows("scholarship_coverage")){
                  the_row();

                  $value = get_sub_field("coverage");
                  $value = trim($value);
                  $value = trim($value, ".");
                  echo $value . ".</p>";

                }} ?>
              
              <h2><?php echo $scholarship_title; ?> Eligibility Criteria</h2>
              <?php if ($eligibility_criteria){ ?>
              <p>To be eligible for <?php echo $scholarship_title; ?>, you will need to meet <b>BOTH</b> the eligibility criteria for <?php echo $scholarship_title; ?> <b>AND</b> the eligibility criteria for <?php echo $institution_name; ?> admissions.</p> 
               
             <h3>1. <?php echo $institution_name; ?> Eligibility Criteria</h3>

             <p>
                To be eligible for <?php echo $scholarship_title; ?>, you will need to meet the eligibility criteria for <?php echo $institution_name; ?>
 admissions first and also apply. Please see the <a href="<?php echo get_permalink($institution->ID) . "#admissions"; ?>"> <?php echo $institution_name; ?> Admissions Section</a> for admissions eligibility criteria information.

             </p>               

              <h3>2. <?php echo $scholarship_title; ?> Specific Eligibility Criteria</h3>
               
              <?php if (sizeof($eligibility_criteria) > 1){ ?>
               
              <p>In addition to meeting the admission requirements, you need to meet the following specific <?php echo $scholarship_title; ?> eligibility criteria. Applicants must be:</p>

              <ul>
              <?php  while (have_rows("eligibility_criteria")) { the_row(); ?>
              
              <?php 
                 
 $crite =  get_sub_field('criteria');

$new_str = preg_replace("/\*\*(.*?)\*\*/", "<b>$1</b>", $crite);

?>


              

              <li> <?php  echo $new_str; ?> </li>


              <?php } ?></ul>               


            <?php } else if (sizeof($eligibility_criteria) == 1){ ?>
               
              <p>In addition to meeting the admission requirements, you need to meet the following specific <?php echo $scholarship_title; ?> eligibility criteria. <b> Applicants must be <?php  while (have_rows("eligibility_criteria")) { the_row(); ?> 
              <?php  echo  get_sub_field('criteria');?>
              <?php } ?>. </b></p>
               
               
              <?php } ?>
               
               <p>Please see <a href="<?php echo ($creteria_page_link) ? $creteria_page_link : $scholarship_page_link;   ?>">  Eligibility Page </a> for specific details on eligibility criteria for <?php echo  $scholarship_title; ?>.</p>
               
           
              <?php } else { ?>
           
           <p>There are no specific eligibility criteria for <?php echo $scholarship_title; ?>. <b>You just need to be an incoming <?php echo $degrees_text; ?> international student who submit the admission application for <?php  echo $institution_name; ?></b>. <?php if($separate_application == "Yes") {?>In addition, you need to submit the separate application for scholarships.
               

                                     <?php } ?></p>

                          <?php } ?>


             
          
               
              <h2><?php echo $scholarship_title; ?> Application Procedure</h2>

              <?php if($separate_application == "No") {?>
               
               <p> There is NO separate application for <?php echo $scholarship_title; ?>. <b>All you need to do is submit your application for admissions at <?php  echo $institution_name; ?> to be eligible.</b> Please visit the official website found in <a href="<?php echo  get_permalink($institution->ID) . "#admissions"?>"> Admissions Section</a> to see the admissions requirements and admissions process.
                </p>

              <?php  } else { ?>
               <h3>1. <?php echo $institution_name; ?> Admissions Application Procedure</h3>
                          
             <p>The first step in applying for <?php echo $scholarship_title; ?> is to submit your admissions application for <?php echo $institution_name; ?>. Please visit the official website found in <a href="<?php echo  get_permalink($institution->ID) . "#admissions"; ?>">
                   <?php echo $institution_name; ?> Admissions Section </a> to see the admissions application process. </p>
               
               <h3>2. <?php echo $scholarship_title; ?> Specific Application Procedure</h3>
               
                  <p>There is a separate application that you need to submit for <?php echo $scholarship_title;  ?> in addition to <?php echo $institution_name; ?> admissions application. Please make sure to follow the instructions in the official <a href="<?php echo $scholarship_page_link; ?>"> <?php echo $scholarship_title; ?> Page</a>.</p>

              <?php } ?>

              <?php  if($additional_scholarship_requirements && $separate_application == "Yes") { ?>

               <p> When you are applying for <?php echo $scholarship_title; ?>, you need to submit the following documents and meet the following requirements in addition to requirements for admissions: </p>
               
              <ul>
              <?php  while (have_rows("additional_scholarship_requirements")) { the_row(); ?>
              <li > <?php  echo  get_sub_field('requirements');?> </li>
              <?php } ?></ul>                

              <p>Please see the <a href=" <?php echo ($additional_scholarship_requirements_link) ? $additional_scholarship_requirements_link : $scholarship_page_link; ?>"> <?php echo $scholarship_title; ?> Additional Requirements Page </a> for more information. </p>

            <?php } ?>


              <?php  if($application_procedure && $separate_application == "Yes") { ?>

              <p>To apply for <?php  echo $scholarship_title;  ?>, please follow these steps:</p>
               
                             <ol>
              <?php  while (have_rows("application_procedure")) { the_row(); ?>
              <li > <?php  echo  get_sub_field('steps');?> </li>
              <?php } ?></ol>
             
               


              <p>For more information, please see the <a href=" <?php echo ($scholarship_application_procedure_link) ? $scholarship_application_procedure_link : $scholarship_page_link; ?>"> <?php echo $scholarship_title; ?> Scholarship Application Procedure Page </a>. </p>
         <?php } ?>


              <h2>When to Apply for <?php echo $scholarship_title; ?></h2>
              <p>To see the <?php echo $institution_name; ?> admission deadline for <?php echo $degrees_text; ?>, please visit the
               <a href="<?php echo get_permalink($institution->ID) . "#admissions"; ?>"> <?php echo $institution_name; ?> Admissions Section</a>. 
               
                  <?php  if($separate_application == "Yes") { 
                  
                  if ($scholarship_deadlines){
                    echo "You will also need to apply separately for scholarships. Here are the scholarship application deadlines:</p>";
                    echo '<ul>';
                    while( have_rows("scholarship_deadlines")) {
                        the_row();
                        $degree = get_sub_field('degree');
                        
                        if (!$degree){
                            $degree = $degrees_text;
                        }                        
                                                
                        $open_date = get_sub_field('open_date');
                        $deadline = get_sub_field('deadline');
                        $label = get_sub_field("label");
                        
                        if ($label) {
                            $label_text = " (" . $label . ") ";
                        } else {
                            $label_text = "";
                        }
                        
                        echo '<li>';
                              echo $degree . " Scholarship Application Deadline" . $label_text . ": " . $deadline;
                        echo '</li>';
                    }
                    echo '</ul><p>';                  
                  }
                  
                  
                  ?>
                  
                  

                 Please see the <a href="<?php echo ($scholarship_deadline_link) ? $scholarship_deadline_link : $scholarship_page_link; ?>"> <?php echo $scholarship_title; ?> Deadline Page</a> for more information. </p>
               
              <?php } else { ?>

               There's no separate scholarship deadline since there is no separate application for <?php echo $scholarship_title; ?>. </p>
           
                         <?php } ?>


               <h2> <?php echo $scholarship_title; ?> Page </h2>
               <p>Find further information about this <?php echo get_adjective_scholarship_amount($scholarship_type); ?> scholarship at <?php echo $institution_name; ?> at
                   <a href="<?php echo $scholarship_page_link; ?>"> <?php echo $scholarship_title; ?> Page</a>.</p>
           
           <?php if ($number_of_scholarships > 1){ ?> 

                   <h2> Related Scholarships </h2>
           
               <p> Aside from <?php echo $scholarship_title; ?>, <?php echo $institution_name; ?> offers other scholarships and awards to international students at different levels. If you are interested, you can find more scholarships at <?php echo $institution_name; ?> at the <a href="<?php echo get_permalink($institution->ID); ?>"><?php echo $institution_name; ?> Scholarships Page</a>.</p>

     <?php        }?>
           
            </div>
            </div>

<?php endwhile; ?>



</section>

           
<?php 
if (get_field("exclude_nationality")){
    if (in_array("Exclude All Nationalities", get_field("exclude_nationality"))){
        delete_field("eligible_nationality");
        delete_field("exclude_nationality");    
        
    } else {
        $exclude = get_field("exclude_nationality");
        $scholarship_details  = acf_get_fields('group_62ca6e3cc910c');
        $country_array = array_values($scholarship_details[15]['choices']);
        $new_array = array_diff($country_array, $exclude);
        update_field("eligible_nationality", $new_array);
        delete_field("exclude_nationality");    
    }
}

if (get_field("include_regions")){


  $countries = get_field("eligible_nationality");
  
  // if (in_array("Africa", get_field("include_regions"))){
  //  // $countries = array_merge($countries, $africa);

  // }


  


  // if (in_array("Latin America", get_field("include_regions"))){
  //   $countries = array_merge($countries, $latinAmerica);
  // }

  // if (in_array("Caribbean", get_field("include_regions"))){
  //   $countries = array_merge($countries, $caribbean);
  // }

  // if (in_array("Southeast Asia", get_field("include_regions"))){
  //   $countries = array_merge($countries, $southeastAsia);
  // }

  // if (in_array("Pacific Island", get_field("include_regions"))){
  //   $countries = array_merge($countries, $pacific);
  // }

  // if (in_array("Asia", get_field("include_regions"))){
  //   $countries = array_merge($countries, $asia);
  // } 

  // if (in_array("Western Hemisphere", get_field("include_regions"))){
  //   $countries = array_merge($countries, $westernHemisphere);
  // }
  
  // if (in_array("Europe", get_field("include_regions"))){
  //   $countries = array_merge($countries, $Europe);
  // }   
  
  // if (in_array("European Union", get_field("include_regions"))){
  //   $countries = array_merge($countries, $EuropeanUnion);
  // }   
  
  // if (in_array("European Economic Area", get_field("include_regions"))){
  //   $countries = array_merge($countries, $EuropeanEconomicArea);
  // } 
  
  // if (in_array("Oceania", get_field("include_regions"))){
  //   $countries = array_merge($countries, $oceania_list);
  // }    

  // if (in_array("North America", get_field("include_regions"))){
  //   $countries = array_merge($countries, $northAmerica_list);
  // }    

  // if (in_array("Middle East", get_field("include_regions"))){
  //   $countries = array_merge($countries, $middleEast_list);
  // }   

  // if (in_array("Commonwealth", get_field("include_regions"))){
  //   $countries = array_merge($countries, $commonwealth_list);
  // }     
  

  // update_field("eligible_nationality", $countries);

  // delete_field("include_regions");    


}


function normalize_string($str) {
    // remove any diacritics from the string
    $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    // convert the string to lowercase
    $str = strtolower($str);
    // remove any extra whitespace from the string
    $str = trim($str);
    return $str;
}
?>


<script type="text/javascript">
    
    //Decoding apostrophe. 
    
    // var div = document.createElement('div');
    // div.innerHTML = '<?php //echo $title ?>';
    // var title = div.firstChild.nodeValue;

    
    
   //jQuery('.fusion-page-title-captions h1').text(title);
    
    //document.title = title;
    
    //    document.querySelectorAll('meta[property="og:title"]').forEach(function(el) {
    //       el.setAttribute("content", title);
    // });   
   
</script>



<?php do_action( 'avada_after_content' ); ?>
<?php get_footer(); ?>