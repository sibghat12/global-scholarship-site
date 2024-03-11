<?php
/**
* This is used for Scholarship Posts custom post type
*
* @package Avada
*/

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
   exit( 'Direct script access denied.' );
   
}
?>

<?php get_header(); 

 $featured_image_url = get_the_post_thumbnail_url( get_the_ID() );

?>

<section class="scholarship-post-main">

<div style="margin-top:20px;" >
<a class="blog-breadcrumb" href="/" style="color:#767676 !important;"> Home </a> >  <a style="color:#767676 !important;" class="blog-breadcrumb" href="/recent-scholarship-posts/" > Scholarship Recipients </a>  >  
<a  style="color:#77a6c9 !important" href="" class="blog-breadcrumb active-breadcrumb">  <?php echo get_the_title(); ?> Scholarship Journey </a>
</div>

   <div class="row" style="padding-top:40px;">
   <div class="col-md-8 col-sm-12" style="padding-right:5%;">
   <h1 style="padding-left:0px;font-family: 'Roboto', Arial, Helvetica, sans-serif;font-size:51px;font-weight:600;line-height: 62px;"> Hi, I'm <span style="color:#5590bc !important;"> <?php echo get_the_title(); ?> </span> <br>
This is the story of my <br><span style="color:#5590bc !important;">Scholarship Journey. </span>  </h1>


  <div class="brief_intro_text">
   <?php echo get_field('brief_intro'); ?>
  </div>
    

    </div>
   <div class="col-md-4 col-sm-12" style="float:right;"> 

    <div class="image-container">
        <img src="<?php echo $featured_image_url; ?>" alt="Your Image">
    </div>
    <div class="image-container1">
    </div>

   </div>
   </div>

  <div class="clearfix"></div>

   <div class="row the-journey" style="padding-top:20px;width:80%;margin:auto;">
   
   <h2 style="font-size:48px;margin-bottom:0px;line-height:60px;font-family: 'Roboto', Arial, Helvetica, sans-serif; padding-left:0px;  display: block;"> The <br> Journey</h2>
  <hr style="width:25%;float:left;margin-top:0px; border: 2px solid #77a6c9;">

  <div class="clearfix"></div>

  <div class="the_journey_text">
   <?php echo wpautop(get_the_content()); ?>
  </div>
    
      


<div class="clearfix"> </div>

<div class="scholarship_categories">


<?php
$taxonomy = 'scholarship_category'; // Replace with your custom taxonomy slug
$terms = get_the_terms( get_the_ID(), $taxonomy );

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
    foreach ( $terms as $term ) {
        $term_link = get_term_link( $term, $taxonomy );
        ?>
        <a href="<?php echo esc_url( $term_link ); ?>" class="scholarship_post_category_link" style="color:black !important;"><?php echo esc_html( $term->name ); ?></a>
        <?php
    }
}
?>




  
</div>


</section>


<section class="cta_submit">
 <center> <p style="margin-top:0px !important;margin-bottom:0px !important;padding-bottom:0px !important;padding-top:0px !important;font-size:32px !important;line-height: 42px !important;">Want to <b>submit</b> your <br>
<b>scholarship journey? </b> </p>
<hr style="width:18%;margin:auto; border: 2px solid #77a6c9;margin-top:20px;margin-bottom:15px;">
<p style="margin-top:0px !important; padding-top:0px !important;font-size:20px !important;padding-bottom:0px !important;margin-bottom:0px;">Contact us at</p>
<a style="padding-top:15px;font-size:18px !important;color:#6f7171 !important" href="mailto:admin@globalscholarships.com"> admin@globalscholarships.com </a> </center>
</section>

<div class="clearfix"> </div>

<section class="scholarship-post-main read-more-scholarship-post" style="margin-top:70px;margin-bottom:-20px;">
  <h2 style="padding-top:20px;padding-bottom:30px;font-size:32px !important;color:black;text-align:center;font-family: 'Roboto', Arial, Helvetica, sans-serif;"> More Scholarship Recipients </h2> 
  <div class="clearfix"> </div>
 <?php
echo do_shortcode('[latest_scholarships]');
?>

<?php 
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }
        ?>


</section>


<!-- <script type="text/javascript">
    jQuery(document).ready(function ($) {
    const $commentsAuthors = $('.comments-container').find('.comment-author');
    
    $commentsAuthors.each(function (index, author) {
        const $authorElement = $(author);
        const authorHTML = $authorElement.html();
        const modifiedHTMLwithoutAT = authorHTML.replace(' at ', '');

        $authorElement.html(modifiedHTMLwithoutAT);
    });
});
</script> -->

<?php 
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
