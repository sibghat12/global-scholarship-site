<?php
/**
 * Template Name: Scholarship Category
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

get_header();  


?>


<?php 
$current_category = get_queried_object();
$category_name = $current_category->name; ?>

<section class="avada-page-titlebar-wrapper" style="margin-top:20px;margin-bottom: 40px;" >
    <div class="fusion-page-title-bar fusion-page-title-bar-breadcrumbs fusion-page-title-bar-center">
        <div class="fusion-page-title-row">
            <div class="fusion-page-title-wrapper">
                <div class="fusion-page-title-captions">
                <h1 class="" style="text-align: center;"> <?php echo $category_name; ?> </h1>
                 </div>
                 </div>
        </div>
    </div>
</section>


<?php

$category = get_queried_object(); // Get the current category object

$args = array(
    'post_type' => 'scholarship_post',
    'posts_per_page' => 3,
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => array(
        array(
            'taxonomy' => 'scholarship_category', // Your custom taxonomy
            'field'    => 'term_id',
            'terms'    => $category->term_id, // Use the current category ID
        ),
    ),
);

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<div class="row" >';
        
        while ($query->have_posts()) {
            $query->the_post();
            echo '<div class="col-md-4" style="padding-left:2% !important;padding-right:4% !important;">';
            echo '<div class="scholarship-item">';
            echo '<div class="featured-image">' . get_the_post_thumbnail() . '</div>';
            echo '<div class="more-scholarship-title-wrapper">';
            echo '<h2 class="scholarship-title more-scholarship-post-title"><a style="color:#333c4d !important;" href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a></h2>';
            echo '<div class="meta-scholarship-blog" style="width:30%;float:right;margin-top:8px;"><span style="float:left;">' . get_the_date() . '</span></div></div>';
             
            $excerpt = get_the_content();
            $excerpt = substr($excerpt, 0, 124);
            echo '<p class="more-scholarship-post-excerpt" >' . $excerpt . ' ....  
            <a href="' . esc_url(get_permalink()) . '" > Read more <i class="fa fa-arrow-right"></i> </a></p>';
            
            // Display scholarship categories associated with the current post
$taxonomy = 'scholarship_category';
$terms = get_the_terms(get_the_ID(), $taxonomy);
if ($terms && !is_wp_error($terms)) {
    echo '<div class="more-scholarship-post-categories">';
    echo '<ul class="category-list">';
    foreach ($terms as $term) {
        $term_link = get_term_link($term, $taxonomy);
        echo '<li><a href="' . esc_url($term_link) . '" class="scholarship_post_category_link" style="color:black !important;">' . esc_html($term->name) . '</a></li>';
    }
    echo '</ul>';
    echo '</div>';
}


            echo '</div>'; 
            echo '</div>'; 
           
        }

    wp_reset_postdata();
}

?>

<br>

<div class="clearfix"> </div>

<div class="recent-post-cta" style="margin-top:50px !important;">

    <div class="first-column">
    <div class="cta-text">
        <h2 class="heading-text">Search thousands of scholarships with GlobalScholarships.com!</h2>
        <p>Go through our scholarship database to find scholarships that best fits you! </p>
        <a href="<?php echo site_url() ?>/scholarship-search/" class="cta-button">Search for Scholarships! </a>
    </div>
   </div>


 <div class="second-column">
    <div class="cta-image">
    <img src="<?php echo site_url() ?>/wp-content/uploads/2023/10/categoryimage.png" alt="Description of Image">
    </div>
 </div>

</div>

<div class="clearfix"> </div>

<?php do_action( 'avada_after_content' ); ?>
<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
