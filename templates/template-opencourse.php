<?php
/**
 * Template Name: Open Courses 
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); 

    $params = get_query_info();

    $subject = $params["subject"];
    //$location = $params["location"];
    $degrees = $params["degrees"];
    $country = $params["country"];

    $pro_ip_api_key = '2fNMZlFIbNC1Ii8';
    // Get Current Device Data
    $ip_api = file_get_contents('https://pro.ip-api.com/json/'.$_SERVER['REMOTE_ADDR'] . '?key='.$pro_ip_api_key);

    // Data Decoded
    $data = json_decode($ip_api);
 
    // Turn Object into Associative Array
    $data_array = get_object_vars($data);
   
    // Get Country Code to use to get other related content (Courses)
    if($data_array) {
        $country_code = $data_array['countryCode'];
    } else {
        // In case IP API is not working
        $country_code = $_SERVER['GEOIP_COUNTRY_CODE'];
    }


    // Location
    $location = $country_code;    

    //List of institutions in that country
    $institute_ids_country = get_institution_ids($country);

    if ($country == "europe"){
        $institute_ids_country = array_merge(get_institution_ids("germany"), get_institution_ids("united kingdom"));      
    }

    $location = code_to_country($location);

    if ($location == FALSE){
        $location_string = "around the World";
    } else {
        $location_string = "from " . $location; 
    }

    $active_institutions = get_active_institutions();

    $excluded = exclude_institutions ($location);

    $excluded_by_tier = exclude_institutions_by_tier($location);

    $excluded = array_merge($excluded, $excluded_by_tier);

    $ad_args = array(
        'post_type' => 'ads',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_key' => 'priority',
        'orderby' => "meta_value_num",
        'order' => "DESC",
        'meta_query' => array(
            'relation' => 'AND',
            array('key' => 'adsInstitution', 'value' => $active_institutions, 'compare' => 'IN'),
            array('key' => 'adsInstitution', 'value' => $excluded, 'compare' => 'NOT IN'),      
        ),
    );

    if(isset($subject) && $subject){
        $ad_args['meta_query'][] = array('key' => 'ads_subject', 'value' => $subject, 'compare' => 'LIKE');
    }

    if(isset($degrees) && $degrees){
        $ad_args['meta_query'][] = array('key' => 'degrees', 'value' => $degrees, 'compare' => 'LIKE');
    }

    if(isset($country) && $country){
        $ad_args['meta_query'][] = array('key' => 'adsInstitution', 'value' => $institute_ids_country, 'compare' => "IN");
    }

    $loop = new WP_Query($ad_args);

    $first = "Open " . ucwords($degrees) . " ". ucwords($subject) . " Courses ";
    $second = "in " . ucwords($country) . " ";
    $third = "for Students " . $location_string;

    if(isset($country) && $country){
        $text = $first . $second . $third;
    } else {
        $text = $first . $third;
    }
?>  

 
<div class="opencourse-title-div" style="max-width:1000px;margin:auto;" >
    <h1 style="font-size:32px; font-weight:700;text-align:center; color:black !important;padding-top:20px;padding-left:0px !important; padding-bottom: 10px; font-family: 'Roboto', Arial, Helvetica, sans-serif"> <?php  echo $text; ?></h1>
</div>


<div class="filter-toggle-btn" style=" font-size:18px;padding-top:10px;padding-bottom:10px;" > 
  <img src="<?php echo site_url(); ?>/wp-content/uploads/2023/04/filter-1.png"
 style="padding-right:0px;text-align: center;height: 22px;"> Filter     
 </div> 


<section id="content" class="small-text opencourse-template"   style="width:100% !important;">
		<div id="openCourses" >
			<div class="post-content" style="max-width:100%;">
    <div class="toggle-filter"  >           
 <center>
<aside style="width:60%;max-width:1000px;">            
<div class="course-filter"> 
    
    <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>"  style="margin-top:10px;width:100%;" method="POST" class="filter-wrapper">
    
    <input type="hidden" name="action" value="course_form">
    <div class="filter-boxes-wrap">
        
       <!--  <div class="filter-title">
            Search for Courses:
        </div>  -->       

        <div class="filter-box degree-filter">
            <select name="degree" >
            <option value="">Any Degree</option> 
            <option value="undergraduate" <?php echo $degrees == 'undergraduate' ? 'selected' : ''; ?>>Undergraduate</option> 
            <option value="masters" <?php echo $degrees == 'masters' ? 'selected' : ''; ?>>Master's</option> 
            <option value="mba" <?php echo $degrees == 'mba' ? 'selected' : ''; ?>>MBA</option> 

            </select>

        </div>


        <div class="filter-box subject-filter">
            <select name="subject" >
            <option value="">Any Subject</option>
            <option value="business" <?php echo $subject == 'business' ? 'selected' : ''; ?>>Business</option>
            <option value="computer-science" <?php echo $subject == 'computer science' ? 'selected' : ''; ?>>Computer Science</option>
            <option value="data-science" <?php echo $subject == 'data science' ? 'selected' : ''; ?>>Data Science</option>
            <option value="design" <?php echo $subject == 'design' ? 'selected' : ''; ?>>Design</option>
            <option value="marketing" <?php echo $subject == 'marketing' ? 'selected' : ''; ?>>Marketing</option>
            <option value="hospitality-and-tourism-management" <?php echo $subject == 'hospitality and tourism management' ? 'selected' : ''; ?>>Hospitality and Tourism Management</option>
            <option value="law" <?php echo $subject == 'law' ? 'selected' : ''; ?>>Law</option>                
            </select>

        </div>
        
        <div class="filter-box country-filter">
            <select name="country" >
            <option value="">Any Country</option>
            <option value="canada" <?php echo $country == 'canada' ? 'selected' : ''; ?>>Canada</option>
            <option value="germany" <?php echo $country == 'germany' ? 'selected' : ''; ?>>Germany</option>
            <option value="united-kingdom" <?php echo $country == 'united kingdom' ? 'selected' : ''; ?>>United Kingdom</option>
            <option value="europe" <?php echo $country == 'europe' ? 'selected' : ''; ?>>Europe</option>

            </select>

        </div>
        

         <div class="filter-btn" style="">
    <button  style="height: 47px;" type="submit">Filter</button>

    </div>

    </div>

   

    </form>
</div>
</aside>
</center>
</div>



            
            <div class="clearfix"> </div> 
            
            <div class="card-section-new" style="max-width:1000px;margin:auto;padding-top:45px;"> 
            
            
 

          
                <?php
                    


                if ($loop->have_posts() ){
                    while ($loop->have_posts() ) {
                        $loop->the_post();

                        $ad_id = $post->ID;
                      
                       show_ads_card_new($ad_id);
                         

                    }
                } else {
                    echo "<p class='white-background'><b>There were no courses matching your search of ". $text . ". Instead, we will show all the courses available for students " . $location_string . ". </b></p>";
                    

                    $all_ad_args = array(
                        'post_type' => 'ads',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'meta_key' => 'priority',
                        'orderby' => "meta_value_num",
                        'order' => "DESC",
                        'meta_query' => array(
                            'relation' => 'AND',
                            array('key' => 'adsInstitution', 'value' => $active_institutions, 'compare' => 'IN'),
                            array('key' => 'adsInstitution', 'value' => $excluded, 'compare' => 'NOT IN'),      
                        ),
                    );
                    
                    $new_loop = new WP_Query($all_ad_args);
                    

                    if ($new_loop->have_posts() ){
                        while ($new_loop->have_posts() ) {
                            $new_loop->the_post();

                            $ad_id = $post->ID;
                            echo '<div class="col-sm-12 my-2 course-card">';
                            //show_ads_card($ad_id);
                            echo '</div>'; 
                        }
                    }

                    
                }

                ?>

                <?php wp_reset_postdata(); ?>

            </div><!-- .card-section -->
               
                

    
	<?php wp_reset_postdata(); ?>
    
    
</section>
            
<script>
    
jQuery( document ).ready( function($){

    $(document).on('click', '.ad-read-more', function (e) {
        $(this).siblings(".line-clamp-3").removeClass('line-clamp-3');
        e.preventDefault();
        $(this).addClass("display-none-text");
        $(this).siblings(".ad-read-less").removeClass('display-none-text');        
    });

    $(document).on('click', '.ad-read-less', function (e) {
        $(this).siblings(".description").addClass('line-clamp-3');
        e.preventDefault();
        $(this).addClass("display-none-text");
        $(this).siblings(".ad-read-more").removeClass('display-none-text');        
    });
    

                          
                    
});    
    

  jQuery('.fusion-search-field input').attr('placeholder', 'Search for Courses');

 function adjustHeight() {
    console.log("dd");
        if (window.matchMedia("(min-width: 991px)").matches) {
            var height_col_md_4 = jQuery('.col-md-4').height();
            var height_col_md_8 = jQuery('.col-md-8').height();

            console.log(height_col_md_8);
            
            var max_height = Math.max(height_col_md_4, height_col_md_8);

            jQuery('.col-md-4').height(max_height);
            jQuery('.col-md-8').height(max_height);
        } else {
            // Optional: Reset to automatic height when viewport is less than 991px
            jQuery('.col-md-4').height('auto');
            jQuery('.col-md-8').height('auto');
        }
    }


  jQuery(window).on('load', function() {
    // Run on document ready
    
    // Update on window resize
    jQuery(window).resize(adjustHeight);
});

  

 jQuery(document).ready(function() {

       adjustHeight();

  var filterToggleBtn = jQuery('.filter-toggle-btn');
  var filterPanel = jQuery('.toggle-filter');
  filterToggleBtn.on('click', function() {
  filterPanel.toggle();
 });

});


jQuery(function() {
    var tooltips = jQuery('[title]').tooltip({
        position: {
            my: 'center bottom',
            at: 'center top-0',
        },
        tooltipClass: "custom-tooltip-styling",
        show: null,
        hide: { effect: "" },
        open: function(event, ui) {
            ui.tooltip.animate({ top: ui.tooltip.position().top - 4 }, "fast" );
        }
    });
});


document.querySelectorAll('.read-more').forEach((span) => {
  span.addEventListener('click', function(event) {
    event.preventDefault();
    event.stopPropagation();

    var short = this.parentElement;
    var full = short.nextElementSibling;

    jQuery(short).hide();
    jQuery(full).show();

    // If screen size is more than 991px
    if (window.innerWidth > 991) {



      // Select only the .col-md-8 element related to the clicked span
      var colMd8 = jQuery(this).closest('.col-md-8');
      
      // Select the .col-md-4 that immediately follows .col-md-8
      var colMd4 = colMd8.next('.col-md-4');

      var fullHeight = jQuery(full).height();

      // If the height of the full div is more than 100px
      if (fullHeight > 140) {
        console.log("150");
        colMd8.height('350');
        colMd4.height('350');
      } 

        else if (fullHeight > 100) {
            console.log("100");
        colMd8.height('300');
        colMd4.height('290');
      } 


      // If the height of the full div is more than 70px
      else if (fullHeight > 70) {
        console.log("70");
        colMd8.height('250');
        colMd4.height('250');
      } else {
        colMd8.height('200');
        colMd4.height('200');
      }
    jQuery('.funded-line').css('position' , 'absolute');
    jQuery('.funded-line').css('bottom' , '0px');
     

      // Add a border to the left side of the .col-md-4 element
      colMd4.css('border-left', '1px solid #77a6c9');

      jQuery('.annual-tuition-div').css('position' , 'absolute');
      jQuery('.annual-tuition-div').css('bottom' , '0px');
      jQuery('.annual-tuition-div').css('left' , '0px');


    }
  });
});




function readLess(){
    jQuery('#short').show();
    jQuery('#full').hide();
}


</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
            

<?php do_action( 'avada_after_content' ); ?>

<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
