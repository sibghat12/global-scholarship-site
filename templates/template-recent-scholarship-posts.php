<?php
/**
 * Template Name: Recent Scholarship Posts 
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header();  ?>

<h1 class="recent-posts-heading"> Recent Scholarship Posts  </h1>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array(
    'post_type' => 'scholarship_post',
    'posts_per_page' => 12,
    'paged' => $paged, // for pagination
    'meta_query' => array(
        array(
            'key' => '_thumbnail_id', 
        )
    )
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    // Initialize counter
    $counter = 0;
    
    while ($query->have_posts()) {
        // Start a new row after every 3 posts
        if ($counter % 3 == 0) {
            // Close the previous row div if it's not the first row
            if ($counter > 0) {
                echo '</div>'; // Close the previous row
            }
            echo '<div class="row">'; // Start a new row
        }
        
        $query->the_post();
        echo '<div class="col-md-4" style="padding-left:2% !important; padding-right:4% !important;">';
        echo '<div class="scholarship-item">';
        echo '<div class="featured-image">' . get_the_post_thumbnail() . '</div>';
        echo '<div class="more-scholarship-title-wrapper">';
        echo '<h2 class="scholarship-title more-scholarship-post-title"><a style="color:#333c4d !important;" href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a></h2>';
        echo '<div class="meta-scholarship-blog" style="width:30%;float:right;margin-top:8px;"><span style="float:left;">' . get_the_date() . '</span></div></div>';
         
        $excerpt = get_the_content();
        $excerpt = substr($excerpt, 0, 124);
        echo '<p class="more-scholarship-post-excerpt">' . $excerpt . ' ....  
        <a href="' . esc_url(get_permalink()) . '">Read more <i class="fa fa-arrow-right"></i></a></p>';
        
        // Display scholarship categories associated with the current post
        $taxonomy = 'scholarship_category';
        $terms = get_the_terms(get_the_ID(), $taxonomy);

        if ($terms && !is_wp_error($terms)) {
            echo '<div class="more-scholarship-post-categories">';
            echo '<ul class="category-list">';
            
            // Counter to keep track of categories
            $count = 0;
            
            foreach ($terms as $term) {
                $term_link = get_term_link($term, $taxonomy);
                echo '<li><a href="' . esc_url($term_link) . '" class="scholarship_post_category_link" style="color:black !important;">' . esc_html($term->name) . '</a></li>';
                
                // Increment the count
                $count++;
                
                // Break the loop if the count reaches 5
                if ($count >= 5) {
                    break;
                }
            }
            
            echo '</ul>';
            echo '</div>';
        }


        echo '</div>'; // Close scholarship-item
        echo '</div>'; // Close col-md-4

        // Increment counter
        $counter++;
    }

    // Close the last row div if any posts were output
    if ($counter > 0) {
        echo '</div>'; // Close the last row
    }

    wp_reset_postdata();
}
?>


<br>
<div class="clearfix recent-divider"> </div>

<div class="recent-post-cta" style="margin-top: 60px !important;">

    <div class="first-column">

    <div class="cta-text">
        <h2 class="heading-text">Search thousands of scholarships with GlobalScholarships.com!</h2>
        <p>Go through our scholarship database to find scholarships that best fits you!
</p>
        <a href="<?php echo site_url() ?>/scholarship-search/" class="cta-button" >Search for Scholarships! </a>
    </div>

</div>


 <div class="second-column">
    <div class="cta-image">
        <img src="<?php echo site_url() ?>/wp-content/uploads/2023/10/categoryimage.png" alt="Description of Image">
    </div>
 </div>

</div>













<?php do_action( 'avada_after_content' ); ?>
<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */