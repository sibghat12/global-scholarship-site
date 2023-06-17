<?php
/**
 * Template Name: Scholarship-Search
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

include get_stylesheet_directory() . "/functions/scholarships-functions.php";

?>

<?php get_header(); 

    $params = get_query_info();

    $subject = $params["subject"];
    $degrees = $params["degrees"];
    $location = $params["location"];
    $location_value = $params["location"];
    
    if($degrees=="Bachelors"){
        $degrees = "Bachelor's";
    }

    if($degrees=="Masters"){
        $degrees = "Master's";
    }

    $location = ucwords($location);
    $subject = ucwords($subject);


    if($location == "USA") {
        $location = "United States";
    }
    
    $loop = get_institutions_location($location);
    
    $institute_ids = $loop->get_posts();
    
    if(isset($subject) && $subject){
        if ($subject != "All Subjects"){
            $subject_query = 
            array(
                'relation' => 'OR',
                array(
                    'key'     => 'eligible_programs',
                    'value'   => $subject,
                    'compare' => 'LIKE',
                ),
                array(
                    'key'     => 'eligible_programs',
                    'value'   => "All Subjects",
                    'compare' => 'LIKE',
                ),
            );                
        } else {
        $subject_query = array('key' => 'eligible_programs', 'value' => $subject, 'compare' => 'LIKE');
        }
    }
    if(isset($degrees) && $degrees){
        $degree_query = array('key' => 'eligible_degrees', 'value' => $degrees, 'compare' => 'LIKE');
    }
    if(isset($location) && $location){
        $location_query  = array('key' => 'scholarship_institution', 'value' => $institute_ids, 'compare' => "IN");
    }
    
    $meta_query = array( 'relation' => 'AND');    
        
    if ($subject_query) { 
    $meta_query[] = $subject_query; 
    }
    if ($degree_query)  {
    $meta_query[] = $degree_query;
    }
    if ($location_query) { 
    $meta_query[] = $location_query; 
    }

   $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $ad_args = array(
        'post_type' => 'scholarships',
        'posts_per_page' => 10,
        'post_status' => 'publish',
         'paged' => $paged
    );
    
    if ($meta_query){
        $ad_args['meta_query'] = $meta_query;
    }

    

    $loop = new WP_Query($ad_args);

    

    $first = "Search Scholarship  ";
    $second = "in " . ucwords($location) . " ";
    $third = "for Students " . $location_string;

    if(isset($location) && $location){
        $text = $first . $second . $third;
    } else {
        $text = $first . $third;
    }

   $scholarship_details  = acf_get_fields('group_62ca6e3cc910c');
    $degrees_array = $scholarship_details[1]['choices'];
    $country_array = $scholarship_details[2]['choices'];
    $subject_array = $scholarship_details[3]['choices'];
    
    $location = $location_value;
    $location = str_replace(' ', '-', $location);

    $subject = strtolower($subject);
    $subject = str_replace(' ', '-', $subject);
     
?>  



<section id="content" class="small-text">
        <div id="openCourses">
            <div class="post-content">
                <h1 class="entry-title"><?php echo $text ?></h1>

<aside>            
<div class="course-filter"> 
    
    <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="POST" class="filter-wrapper">

    <input type="hidden" name="action" value="scholarship_form">
    <div class="filter-boxes-wrap">
        
         <div class="filter-title">
            Search for Scholarships:
        </div>        

        <div class="filter-box degree-filter">
        <select name="degree" >
            <option value="">All Degrees</option>
            <?php
            foreach ($degrees_array as $key => $degree_item) { ?>
            <option value="<?php echo $degree_item;?>" <?php echo $degree_item == $degrees ? "selected" : ""; ?> >   <?php echo $degree_item ?> </option>  
            <?php  } ?>
            </select>
        </div>


        <div class="filter-box subject-filter">
            <select name="subject" >
                 <option value="all-subjects">All Subjects</option>
            <?php
            
            foreach ($subject_array as $key => $subject_item) {
                
                $subject_value = strtolower($subject_item);
                $subject_value = str_replace(' ', '-', $subject_value);
                
                if($subject_item == "All Subjects")
                continue;

            ?>
            <option value="<?php echo $subject_value;?>" <?php echo $subject_value == $subject ? "selected" : ""; ?> >  <?php echo  $subject_item; ?>   </option> 
            <?php  } ?>
            </select>
        </div>
        

        <div class="filter-box country-filter">
             <select name="country" >
            <option value="">All Countries</option>
            <option value="USA" <?php echo $location == "USA" ? "selected" : ""; ?> >USA</option>
            <option value="south-korea" <?php echo $location == "south-korea" ? "selected" : ""; ?>>South Korea</option>
            </select>
        </div>


    </div>

    <div class="filter-btn">
    <button type="submit">Filter</button>
   </div>

    </form>
</div>
</aside>
    
            
            <div class="card-section">
                <?php


                if ($loop->have_posts() ){
                    while ($loop->have_posts() ) {
                        $loop->the_post();

                        $scholarship_id = $post->ID;
                        echo '<div class="col-sm-12 my-2 course-card">';
                        scholarship_card($scholarship_id);
                        echo '</div>'; 

                    } ?>
                   
                <center> <div class="clearfix"> </div>   <div class="pagination-div" style="margin-top: 50px !important;text-align: center;">
                    

                   <?php  /* $big = 999999999; // need an unlikely integer
                    echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format' => '?paged=%#%',
                    'current' => max( 1, get_query_var('paged') ),
                    'total' =>  $loop->max_num_pages
                     ) );   */?>
                    
                   <?php 
                    
                    $pagenum_link = html_entity_decode( get_pagenum_link() );
                    $url_parts    = explode( '?', $pagenum_link )[0];  
                    
                    echo paginate_links( array(
                    'base' => $url_parts . '%_%',
                    'format' => 'page/%#%', //for replacing the page number
                    'current' => max( 1, get_query_var('paged') ),
                    'total' =>  $loop->max_num_pages
                     ) );   ?>                    
                    
                    

                   </div> </center>
               </div>


               <?php  } ?>

                

            
                
                

    
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
    

    
</script>
            
<?php do_action( 'avada_after_content' ); ?>

<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */


