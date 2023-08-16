<?php
/**
 * This is used for institution custom post type
 *
 * @package Avada
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
    
}


?>

<?php get_header(); ?>

  <?php while ( have_posts() ) : ?>
       <?php the_post(); 

            $institution_title = get_the_title();

            $ibl = get_field("tuition_fee_international_lower");
            $ibu = get_field("tuition_fee_upper_tuition_fee");
            $iml = get_field("masters_tuition_fee_international_lower");
            $imu = get_field("masters_tuition_fee_upper_tuition_fee");

            $city = get_field('cities');
            $city = get_post($city->ID);
            $country = get_post_meta($city->ID, 'country', TRUE);
            $current_currency = get_currency($country);

             $ibl = roundNearestHundreth(convert_to_usd($ibl, $current_currency));
             $ibu = roundNearestHundreth(convert_to_usd($ibu, $current_currency));
             $imu = roundNearestHundreth(convert_to_usd($imu, $current_currency));
             $iml = roundNearestHundreth(convert_to_usd($iml, $current_currency));  


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



       $scholarships_query = get_scholarships( $post->ID);
       $number_of_scholarships  = $scholarships_query->post_count;

   

             if ($number_of_scholarships > 0) {
                $title_custom = $institution_title . " " . " Scholarships for International Students";            
            } elseif ($is_tuition_information) {
                $title_custom = $institution_title . " " . " Tuition for International Students"; 
            } else {
                $title_custom = $institution_title ." ". "Background Information ";     
            }

            $title_custom = $title_custom .' '. date("Y").' - '.date('Y', strtotime('+1 year'));

        ?>

<div class="avada-page-titlebar-wrapper customm" role="banner">
  <div class="fusion-page-title-bar fusion-page-title-bar-none fusion-page-title-bar-center">
    <div class="fusion-page-title-row">
      <div class="fusion-page-title-wrapper">
        <div class="fusion-page-title-captions"><h1 class="">   <?php echo $title_custom; ?> </h1> <div class="fusion-page-title-secondary">
                <div class="fusion-breadcrumbs"><span class="fusion-breadcrumb-item"><a href="https://stg-globalscholarshipsa-sibi.kinsta.cloud" class="fusion-breadcrumb-link"><span>Home</span></a></span><span class="fusion-breadcrumb-sep">/</span><span class="fusion-breadcrumb-item"><span class="breadcrumb-leaf">Fellowship and Relocation Grant</span></span></div>              </div>
                      
        </div>

        
      </div>
    </div>
  </div>
</div>



<div id="ezoic-pub-ad-placeholder-863"> </div>
<!-- End Ezoic - top_of_page - top_of_page -->
      
      <main id="main" class="clearfix width-100">
        <div class="fusion-row" style="max-width:100%;">




<section id="content">


 <div class="post-content">
           
           
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            
            
            
			<?php echo fusion_render_rich_snippets_for_pages();  ?>

			<?php avada_singular_featured_image(); ?>
            
          
            <?php 
            
            
                        
            $description = get_field("description"); 
            $tuition_fee = get_field('tuition_fee');

            // $ibl = $tuition_fee['international_lower'];
            // $ibu = $tuition_fee['upper_tuition_fee'];
            

            
            $ibl = get_field("tuition_fee_international_lower");
            $ibu = get_field("tuition_fee_upper_tuition_fee");


            $iml = get_field("masters_tuition_fee_international_lower");
            $imu = get_field("masters_tuition_fee_upper_tuition_fee"); 
            
            $admission_pages = get_field("admissions_pages");
            
            $admission_deadlines = get_field("admission_deadlines");
            
      
            $name = get_the_title();
            $type = get_field('type');
            $founded_year = get_field('founded_year');

            $enrollments = get_field('enrollment');
            $total_students = $enrollments['total'];
            $total_students_formatted = number_format(roundNearestHundreth($total_students));
            $international = $enrollments['international'];
                        
                        
            $average_ranking = round(get_post_meta(get_the_ID(), 'average_rankings', true));

            $city = get_field('cities');
            $city = get_post($city->ID);
            $city_name = get_the_title($city);
            $country = get_post_meta($city->ID, 'country', TRUE);

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
           
            

            

            
            //Round to the nearest hundredth

           $current_currency = get_currency($country);

       
           
                        
            $ibl = roundNearestHundreth(convert_to_usd($ibl, $current_currency));
             $ibu = roundNearestHundreth(convert_to_usd($ibu, $current_currency));
             $imu = roundNearestHundreth(convert_to_usd($imu, $current_currency));
             $iml = roundNearestHundreth(convert_to_usd($iml, $current_currency));
                         
                        
           //If the original $ibl was -1, change it back to -1
           //This is in place so that the rounding and such does not mess $ibl > 0 up

            
          if (get_field("tuition_fee_international_lower") == -1){
                $ibl = -1; 
            }
            
            if (get_field("tuition_fee_upper_tuition_fee") == -1){
                $ibu = -1; 
            }
            
            if (get_field("masters_tuition_fee_international_lower") == -1){
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
            

            
            //Checks if there is scholarship information. This is also used for titles
            
            
            if($number_of_scholarships > 0){
                $is_scholarship_information = true;
            } else {
                $is_scholarship_information = false;                
            }
            
            //Generate Title using the tuition and scholarship information
             $title_bread = $title;

            if ($is_scholarship_information){
                $title = $name . " Scholarships for International Students";            
            } else if ($is_tuition_information){
                $title = $name . " Tuition for International Students";
            } else {
                $title = $name . " Background Information ";           
            }
            
            
            
            //$current_currency is the currency of the institution's country. We use that for scholarship amount
            //We are using USD though for tuition fees
                        
            $currency = "USD";
            
           $lowercase = strtolower($country);
           $hyphenated = str_replace(' ', '-', $lowercase);

           $scholarships_category = array();
           while ($scholarships_query->have_posts() ) {
        $scholarships_query->the_post();
        $category = get_field('amount_category');
        array_push($scholarships_category, $category);
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

           $degrees_scholarships = array();
           while ($scholarships_query->have_posts() ) {
        $scholarships_query->the_post();

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

       $degrees_for_breadcrumb = array_values(array_unique($degrees_scholarships));
       sort($degrees_for_breadcrumb);
      $degrees_formatted_array = [];
          foreach($degrees_for_breadcrumb as $value) {
          $degrees_formatted_array[] = strtolower(str_replace("'", "", $value));
          }


            ?>
   

          <?php if ( $number_of_scholarships > 0 ) { ?>


            <div style=" margin-bottom:30px !important; display:none;" class="breadcrumbs" >
             <a  style="color:#55a8d7;"  href="<?php echo site_url(); ?>">  Home </a> <span style="color:black;padding-left:10px;padding-right:10px;"> > </span>
             <a  style="color:#55a8d7;" href="<?php echo site_url(); ?>/scholarship-search/<?php echo $hyphenated;  ?>"> <?php echo $country; ?> Scholarships  </a>  
             <span style="color:black;padding-left:10px;padding-right:10px;"> > </span> 
             <b><a   style="color:black;"  > <?php  echo $title; ?>  </a> </b>
               
            
              
                

           </div>
          <?php  } ?>



            <div class="custom-search">
                <?php echo do_shortcode('[courseFilter filter_word="Filter"]'); ?>
            </div>    
            
<!-- adngin-top_leaderboard-0   Ads do not delete-->
<div id="adngin-top_leaderboard-0"></div> 

			            <div class="post-content">

                    <p> <?php  echo $name; ?> is a <?php echo strtolower($type); ?> university in <?php echo $country; ?>. It was founded in 
                    <?php echo $founded_year; ?>  
                    <?php if($founded_year <=  1900) { ?>
                    and is considered one of the older universities in <?php echo $country; ?>, with a long history of providing high-quality education to students, as well as career opportunities to professionals in the academic field. 
                    <?php  } else { ?>
                    and has provided excellent education to students throughout the years.
                    <?php }?>
                    </p>

<!-- adngin-incontent_1-0 Ads do not delete-->
<div id="adngin-incontent_1-0" style="text-align: center;"></div>

                    <p>Nestled in the city of <?php echo $city_name ?>, students at <?php echo $name ?> are able to meet friendly locals, study in a safe city, and immerse in an interesting culture. 
                    </p>
                
<?php if ($country == "Canada") {?>
<p>Canada is also favored for offering quality education at affordable tuition fees. Universities here have a strong focus on research and are able to provide exciting opportunities to students specializing in various fields. The Canadian government even plays a part in supporting eligible Ph.D. students through scholarships.
</p>
                
<?php } else if ($country == "China"){?>
<p>Having one of the oldest civilizations, studying in China means learning about its long history and significant influence on other cultures. It is also well-known for its food, low cost of living, and numerous tourist spots, making it a haven for international students. By joining a university in China, you'll have the ideal chance to learn and master one of the most spoken languages in the world.    
</p>
<?php } else if ($country == "South Korea"){?>
<p>The country’s unique blend of tradition and modernity gives international students a remarkable study experience. Universities here are also known for upholding high standards of education, so their graduates are sought after in the global job market.
</p>                
<?php } else if ($country == "Australia"){?>
<p>Because of its excellent universities, great research opportunities, and exciting nature spots, Australia has become one of the most popular destinations for international students. Tuition fees are also lower here compared to other countries. Moreover, international students in Australia can work a few hours weekly to help with their expenses.
</p>                
<?php } else if ($country == "United Kingdom"){?>
<p>In addition, the UK is known for many advantages to international students. You can also study and work in the United Kingdom since international students are allowed to work up to 20 hours weekly, helping you earn some money to enjoy various activities and tourist hotspots here. Finally, with a degree in a UK university, you'll gain a solid foundation and a globally-competitive start on your career.
</p>                                
<?php } else if ($country == "Germany"){?>
<p>There are several English-taught programs offered in Germany. Degrees granted by universities in this country are globally recognized, so you have high employability anywhere in the world. Given this, it’s no surprise why there are over many international students in Germany.</p>                
<?php } else if ($country == "Poland"){?>
<p>As it’s one of the countries in the European Union, studying in Poland means you’ll have access to education on par with global standards. Besides the opportunity to explore its neighboring countries, Poland is also attractive to international students as there are universities here that offer tuition-free education.  
</p>                    
<?php } else if ($country == "Italy"){?>
<p>In addition, Italy is a popular tourist destination, offering a wide variety of experiences to international students. From its world-renowned cuisines to stunning countryside to historical sites, the country can provide you with education well beyond the classroom.  
</p>                   
<?php } else if ($country == "United States"){?>
<p>Universities in the United States are also attractive to international students due to their quality education. And as the country is known for its leading technology, research, and innovation, a degree from a US university will surely look attractive on your CV.  It's no wonder the country has many international students.   
</p>
<?php } else if ($country == "Switzerland"){?>
<p>Besides getting your degree in Switzerland, the country is also a popular training ground for language learners. You can choose to master any of its four official languages and be comfortable in doing so since the locals are also well-versed in English. If you'd rather spend your free time in silence, Switzerland is also a haven for nature lovers and outdoor adventurers. 
</p>                
<?php } else if ($country == "Netherlands"){?>
<p>The Netherlands is also well-known for having a top-level standard in education. Its colleges belong among the other universities that rank internationally. Tuition fees are subsidized by the government, but students may also work while studying to help with other finances. 
</p>                
<?php } else if ($country == "France"){?>
<p>Aside from that, inspiring architecture and art can be seen everywhere you look. French universities are well-known for having high academic standards and excellent research opportunities. Learning the French language during your stay in the country is also a valuable skill, as it is one of the most widely-spoken languages in the world. </p>                
<?php } else if ($country == "Norway"){?>
<p>When thinking of Norway, its admirable environment easily comes to mind. The nature in the country is such a sight to see, which will surely make the study experience more memorable. The universities offer quality education with no tuition, and there are scholarships for international students that can help with student life abroad.
</p>               
<?php } else if ($country == "Ireland"){?>
<p>Ireland is also an excellent place to gain your degree. Like its neighboring countries in Europe, the education standards here are globally competitive, and there are various employment opportunities once you graduate. 
</p> 
<?php } else if ($country == "Japan"){?>
<p>Besides those, Japan is a great place to acquire lifelong education outside the four corners of the lecture hall. You can easily step out of the university grounds and practice your Japanese communication skills. From Buddhist shrines to historical sites to theme cafes and restaurants, you'll never run out of things to explore. 
</p>                 
<?php } ?>
                
              
                
                <?php 
                    // Total Students Descriptions

                    if($total_students > 15000) { ?>
                    
                    <p> With <?php echo $total_students_formatted; ?> students enrolled, the <?php echo $name; ?> is a very large university offering a culturally diverse social atmosphere and allowing you to connect with people from all walks of life. </p>

                   <?php  } if($total_students < 15000 && $total_students > 5000)  { ?>
                         
                         <p>The <?php echo $name; ?> is a medium-sized university  with a total enrollment of <?php  echo $total_students_formatted; ?>. Here, you will find various clubs and organizations that you would be able to join. </p>

                    <?php } if($total_students < 5000) { ?>
                          
                          <p> With just <?php echo $total_students_formatted; ?> students, <?php echo $name; ?> is a smaller institution in <?php echo $country; ?>. Through enrolling in a smaller university, you will find a closer-knit community as well as more attention and care from your professors to make you successful. </p>

                    <?php } ?>



                    
                    <?php
                    // Total Students Description

                    if($average_ranking < 100) { ?>
                       
                       <p> 
                        <?php echo $name; ?> is an extremely prestigious university in <?php echo  $country; ?> having an average world ranking of 
                        <?php echo $average_ranking; ?> according to various ranking systems.  
                         As an international student, you can expect high quality courses <?php if($bachelor_courses){ echo "in " .   
                          $bachelor_courses_string . " as well as other programs for bachelors" ; } ?>. <?php if($master_courses){ echo "For Master’s, you’ll have excellent education in courses such as " . $master_courses_string; } ?>.</p>

                    <?php  } if($average_ranking > 100)  { ?>
                         
                        <p>Having an average world ranking of <?php echo $average_ranking; ?>, <?php echo $name; ?> is an excellent university in <?php echo $country; ?>. <?php if($bachelor_courses){ echo "For bachelor’s, you will find various programs such as " . $bachelor_courses_string . "."; } ?><?php if($master_courses){ echo " For Master’s, programs such as " . $master_courses_string . " are available." ; } ?></p>

                     <?php } ?>

                  

<?php  if ($number_of_scholarships == 1) { ?>
<p> 
Currently <?php echo $name; ?> offers 1 scholarship to international students. With the help of this scholarship, you can surely fulfill your dream of studying abroad without incurring high costs. In this article, we’ve discussed this scholarship and we also compiled some information, such as admission and important deadlines to help you with your application. So, let’s get started!

</p>
<?php } else { ?>

  <p> Scholarships, grants, and other forms of funding are offered by <?php echo $name; ?> to international students. With the help of these, you can surely fulfill your dream of studying abroad without incurring high costs. <?php if($number_of_scholarships > 0) { ?> In this article, you’ll find out which scholarships you can apply to at <?php echo $name; ?>.<?php } ?> <?php if( have_rows("admission_deadlines") && have_rows('admissions_pages')) { ?> We've also compiled some information, such as admission and important deadlines to help you on your application.<?php } ?> So, let’s get started!   </p>

<?php } ?>

<?php echo do_shortcode('[courseButton text="Find Available Courses Worldwide" link="/opencourses/"]'); ?>


<span id="ezoic-pub-video-placeholder-1"></span>

<?php include get_stylesheet_directory() . "/components/related/related-scholarships.php"; ?>

               <?php 
                wp_reset_postdata();
               if( have_rows('admissions_pages') ) {  ?>
                 <h2 id="admissions">  <?php echo $name; ?> Admissions</h2>
                  <?php   echo "<p>To apply to " . $name . ", make sure to complete the admission requirements and follow the application procedure. You can find more information on the following links:</p>";
                    echo '<ul>';
                    while ( have_rows('admissions_pages') ){
                    the_row();
                       
                        $degree = get_sub_field('degree_name');
                        $type = get_sub_field('type');
                        $link = get_sub_field('admissions_link');
                        echo '<li>';
                        echo "<a href='" . $link . "'>" . $type . " " . $degree . " Admissions Page </a>";
                        echo '</li>';                        
                                            
                    }

                  
                    echo '</ul>';
                }


                wp_reset_postdata();
            

            ?>     
                
               <?php 
               if( have_rows("admission_deadlines") ) { ?>

                 <h2 id="deadline">  <?php echo $name; ?> Application Deadlines</h2>
                  <?php   echo "<p>It is essential that you meet the application deadlines at " . $name . ". Here are the deadlines:</p>";
                    echo '<ul>';
                    while ( have_rows('admission_deadlines') ){
                    the_row();
                        
                        $degree = get_sub_field("degree");
                        if (!$degree){
                            $degree = "Bachelor's and Master's";
                        
                        }                        
                        
                        $deadline = get_sub_field("deadline");
                        
                        $label = get_sub_field("label");
                        
                        if ($label) {
                            $label_text = "(" . $label . ")";
                        } else {
                            $label_text = "";
                        }
                        

                        $open_date = get_sub_field("open_date");
                        $link = get_sub_field("deadline_link");
                        $application_all_year = get_sub_field("accepts_application_all_year_round");
                        
                        $varied_deadlines = get_sub_field("varied_deadline");
                        
                        if ($varied_deadlines == "Yes"){
                            $varied_text = "(Different " . $degree . " programs have different deadlines)";
                        } else {
                            $varied_text = "";
                        }
                        
                        
                        echo '<li>';
                        
                        if ($application_all_year == "Yes"){
                            echo "<a href='" . $link . "'>" . $degree . " Deadline</a>: Accepts Application All Year" ;
                        } else if ($application_all_year == "No"){
                                echo "<a href='" . $link . "'>" . $degree . " Deadline " . $label_text . "</a>: " . $deadline . " ". $varied_text;
                        }
                        echo '</li>';
                    }
                    echo '</ul>';
                }
            

            ?>                
                
                
                
       
                
                
        <?php 
        
        // Print out tuition fees if it is available

 
         if ($ibl > -1 && $iml > -1 ) {
    
         echo "<h2 id='tuition'>Tuition Fees at " . $name . " for International Students</h2>";
         
         if($ibl == 0 && $iml== 0 && $ibu == 0 && $iml == 0 ) {
          
          echo "<p>In this section, we will be discussing the tuition fees for international students at " . $name . "."; ?>
          <b> The tuition fee for both bachelor’s and master’s degrees is free. They don’t charge tuition fees to international students. </b> 


        <?php }  elseif ($ibl == 0 && $iml > 0 ) { 

              echo "<p>In this section, we will be discussing the tuition fees for international students at " . $name . "."; ?>
              The bachelor's tuition fees for international students at <?php echo $name ?> are free.             

            Master's tuition fee for international students at <?php echo $name ?> is <?php echo $iml != $imu ? number_format($iml) . " " . $currency . " to " . number_format($imu) . " " . $currency : number_format($iml) . " " . $currency; ?> per year. </p> 



        <?php }  elseif ($ibl > 0 && $iml == 0 ) { 
              
            echo "<p>In this section, we will be discussing the tuition fees for international students at " . $name . "."; ?>
            The bachelor's tuition fees for international students at <?php echo $name ?> is <?php echo $ibl != $ibu ? number_format($ibl) . " " . $currency . " to " . number_format($ibu) . " " . $currency: number_format($ibl) . " " . $currency; ?> per year.                

            Master's tuition fee for international students at <?php echo $name ?> are free. </p> 

        <?php } else {

            echo "<p>In this section, we will be discussing the tuition fees for international students at " . $name . "."; ?>
            The bachelor's tuition fees for international students at <?php echo $name ?> is <?php echo $ibl != $ibu ? number_format($ibl) . " " . $currency . " to " . number_format($ibu) . " " . $currency: number_format($ibl) . " " . $currency; ?> per year.             

            Master's tuition fee for international students at <?php echo $name ?> is <?php echo $iml != $imu ? number_format($iml) . " " . $currency . " to " . number_format($imu) . " " . $currency : number_format($iml) . " " . $currency; ?> per year. </p> 

        
        <?php } }




         else if ($ibl > -1 )  {   ?>
            
            

            <?php  if($ibl==0) { 

               echo "<h2>Tuition Fees at " . $name . " for International Students</h2>"; ?>

            <p>The bachelor's tuition fees for international students at <?php echo $name ?> are free.</p>

           <?php  } else { ?>

            <?php echo "<h2>Tuition Fees at " . $name . " for International Students</h2>"; ?>
            <p>The bachelor's tuition fees for international students at <?php echo $name ?> is <?php echo $ibl != $ibu ? 
             number_format($ibl) . " " . $currency . " to " . number_format($ibu) . " " . $currency: number_format($ibl) . " " . $currency; ?> per year.</p>


            
       <?php } } else if ($iml > -1 ) { 
            
           

                
             if($iml==0) {
              
              echo "<h2>Tuition Fees at " . $name . " for International Students</h2>"; ?>
                <p>Master's tuition fee for international students at <?php echo $name ?> is free. </p> 

             <?php } else {

             echo "<h2>Tuition Fees at " . $name . " for International Students</h2>"; ?>
            

        <p>Master's tuition fee for international students at <?php echo $name ?> is <?php echo $iml != $imu ? number_format($iml) . " " . $currency . " to " . number_format($imu) . " " . $currency : number_format($iml) . " " . $currency; ?> per year. </p> 
            

    <?php } } ?>
            
            
            

    <?php  if($ibu == 0 && $imu == 0  ){ ?>

    <p> <?php echo $name; ?> is one of the few universities in the world offering free tuition. This is one of the main reasons why 
        <?php echo $name;  ?> is a popular choice among international students.  </p>

    <?php } if($ibu == 0 && $imu > 0  ) { ?>
     <p> <?php echo $name; ?> is one of the few universities in the world offering free tuition for a bachelor's degree. This is one of the main reasons why 
        <?php echo $name;  ?> is a popular choice among international students. 
     However, only students at the bachelor’s level are granted this offer. Master’s students will still need to pay an amount for tuition.
     </p> 

   <?php } 

   if( $ibu > 0 && $imu == 0 ){?>  


     <p> <?php echo $name; ?> is one of the few universities in the world offering free tuition for a master's degree. This is one of the main reasons why 
        <?php echo $name;  ?> is a popular choice among international students. 
  However, only students at the master’s level are granted this offer. If you are an undergraduate, you will still need to pay an amount for tuition . </p>


   <?php  } if($ibu == 0 && $imu == 0 ) { ?>
 

 <?php  }

   ?>






    <p>When studying abroad, it is best to save as much money as you can. After all, there are other costs to consider besides tuition fees, such as accommodation, meals, transportation, and books.
    </p>

    <?php if($number_of_scholarships > 0) { ?>



    <p>The scholarships at <?php echo $name; ?> can help fund your study expenses. There are currently <?php echo $number_of_scholarships; ?> scholarships being offered to international students at the <?php echo $name; ?>, all with varying requirements, benefits, and application processes. We have compiled them in this list to help you find the scholarship that best fits you.
 </p>
            

    
    <h2 id="scholarships"> <?php echo $name; ?> Scholarships for International Students</h2>

    <?php 
            
    // If there is scholarships associated with this institution for Undgergraduate Program.
   
    if($undergraduate_list) { 

    
    echo  "<h3> Undergraduate Scholarships </h3>"; 
   
    $count = 1;
   
    while ($scholarships_query->have_posts() ) {
        $scholarships_query->the_post();
        $degrees = get_field('eligible_degrees');
        if (in_array("Bachelor's", $degrees)){
        $program = "undergraduate";
        require get_stylesheet_directory() .'/components/scholarship-component.php';
         $count = $count + 1;

        }
 }

wp_reset_postdata();
        
        

?>

    <?php if (count($undergraduate_list) > 1){ ?>
    <p> All the undergraduate scholarships available at <?php  echo $name; ?> are the following: </p>  
   
   <ul>
   <?php  foreach($undergraduate_list as $scholarship_id) { ?>
   <li> <a href="<?php echo get_permalink($scholarship_id); ?>">  <?php  echo get_the_title($scholarship_id); ?></a> </li> 
   <?php  } ?>
   </ul>
   <?php  } ?>


 <?php }  ?>



 
    <?php



            
    // If there is scholarships associated with this institution for Graduate Program.
  
    if($graduate_list) { 
    
        echo  "<h3> Graduate Scholarships </h3>"; 
        $count = 1; 
        while ($scholarships_query->have_posts() ) {
            $scholarships_query->the_post();

            $degrees = get_field('eligible_degrees');

            if(in_array("Master's", $degrees) || in_array("PhD", $degrees)){
                $program = "graduate";
                require get_stylesheet_directory() .'/components/scholarship-component.php';

                $count = $count + 1;

            }

        }

        wp_reset_postdata();

        ?>

        
         <?php if (count($graduate_list) > 1){ ?>

        <p> All the graduate scholarships available at  <?php  echo $name; ?> are the following: </p>   

        <ul>
        <?php  foreach($graduate_list as $scholarship_id) { ?>
       <li> <a href="<?php echo get_permalink($scholarship_id); ?>">  <?php  echo get_the_title($scholarship_id); ?></a> </li> 
       <?php  } ?>
       <?php  } ?>
            
       </ul>        
        
        
    <?php } ?> 




    



    <p> With these <?php echo $name; ?> scholarships for international students, you can finally study abroad financially worry-free. If you’re interested, make sure to also check out the <a href="/opencourses/">Open Courses for International Students</a>.    </p>  

    <?php } ?> 


           

             
                
	<?php fusion_link_pages(); ?>
    <?php 
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }
    ?>
         
	</div>
			
            <?php if ( ! post_password_required( $post->ID ) ) : ?>
				<?php do_action( 'avada_before_additional_page_content' ); ?>
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<?php $woo_thanks_page_id = get_option( 'woocommerce_thanks_page_id' ); ?>
					<?php $is_woo_thanks_page = ( ! get_option( 'woocommerce_thanks_page_id' ) ) ? false : is_page( get_option( 'woocommerce_thanks_page_id' ) ); ?>
					<?php if ( Avada()->settings->get( 'comments_pages' ) && ! is_cart() && ! is_checkout() && ! is_account_page() && ! $is_woo_thanks_page ) : ?>
						<?php comments_template(); ?>
					<?php endif; ?>
				<?php else : ?>
					<?php if ( Avada()->settings->get( 'comments_pages' ) ) : ?>
						<?php comments_template(); ?>
					<?php endif; ?>
				<?php endif; ?>
				<?php do_action( 'avada_after_additional_page_content' ); ?>
			<?php endif; // Password check. ?>
		</div>
	<?php endwhile; ?>
</section>

<script type="text/javascript">
    
    //Decoding apostrophe. 
    
     // var div = document.createElement('dive');
     // div.innerHTML = '<?php //echo $title ?>';
     // var title = div.firstChild.nodeValue;
   
     var breadcrumbs = jQuery('.breadcrumbs').html();
     jQuery('.fusion-page-title-captions').append(breadcrumbs);


    
   //jQuery('.fusion-page-title-captions h1').text(title);
    //document.title = title;
    
      // document.querySelectorAll('meta[property="og:title"]').forEach(function(el) {
      //     el.setAttribute("content", title);
      //  });   
   


</script>

<?php do_action( 'avada_after_content' ); ?>
<?php get_footer(); ?>
