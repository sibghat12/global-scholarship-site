<?php
/**
 * Template Name: Category Page 
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
$category_description = category_description();
if ( ! empty( $category_description ) ) {
    echo '<div class="category-description">' . $category_description . '</div>';
}
?>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 12,
    'paged' => $paged, // for pagination
    'cat' => get_queried_object_id(), // current category ID
    'meta_query' => array(
        array(
            'key' => '_thumbnail_id', 
        )
    )
);

$query = new WP_Query($args);

if($query->have_posts()): 
    echo '<div class="recent-wrapper">';
        echo '<div class="posts-grid">';
            while($query->have_posts()): $query->the_post(); ?>
                <div class="post-card">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium'); ?>
                    </a>
                    <div class="text-wrapper">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <?php 
                        $content = strip_tags(get_the_content());
                        $trimmed_content = substr($content, 0, 100);
                        echo "<p style='line-height:28px !important;'>" . $trimmed_content . "...</p>"; ?>
                    <a href="<?php the_permalink(); ?>" class="read-more-article"> 
                        <span>Read More </span> 
                    </a>
                    
                    </div>
                </div>
                <?php
            endwhile;

        echo '</div>';
     echo '</div>';
     $total_pages = $query->max_num_pages;
     $current_page = max(1, get_query_var('paged'));
    echo '<div class="pagination-container">';
        $big = 999999999;
        echo paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_text'    => __('« Previous'),
            'next_text'    => __('Next »'),
        ));
        
    echo '</div>';


    wp_reset_postdata();
endif;
?>



<div class="clearfix"> </div>

<div class="recent-post-cta">

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