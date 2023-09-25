<?php
/**
 * Template Name: Recent Posts 
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header();  ?>

<h1 class="recent-posts-heading"> Recent Posts  </h1>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 12,
    'paged' => $paged, // for pagination
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
    while($query->have_posts()): $query->the_post();
?>
    <div class="post-card">
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('medium'); ?>
        </a>
        <div class="text-wrapper">
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php 
            $content = strip_tags(get_the_content());
            $trimmed_content = substr($content, 0, 100);
            echo "<p style='line-height:28px !important;'>" . $trimmed_content . "...</p>"; 
            ?>
            <a href="<?php the_permalink(); ?>" class="read-more"> <span>
        Read More  </span> </a>
        </div>
    </div>
<?php
endwhile;

    echo '</div>';
    echo '</div>';

   echo '<div class="pagination-container">';
$big = 999999999;
echo paginate_links(array(
    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
    'format' => '?paged=%#%',
    'current' => max(1, get_query_var('paged')),
    'total' => $query->max_num_pages
));
echo '</div>';

    wp_reset_postdata();
endif;
?>



<div class="clearfix" style="margin-top:70px;"> </div>

<div class="recent-post-cta">

    <div class="first-column">

    <div class="cta-text">
        <h2 style="padding-left:0px;">Search thousands of scholarships with GlobalScholarships.com!</h2>
        <p>Go through our scholarship database to find scholarships that best fits you!
</p>
        <a href="<?php echo site_url() ?>/scholarship-search/" class="cta-button" style="color:white !important;">Search for Scholarships! </a>
    </div>

</div>


 <div class="second-column">
    <div class="cta-image">
        <img src="<?php echo site_url() ?>/wp-content/uploads/2023/09/Untitled_design__1_-removebg-1-1.png" alt="Description of Image">
    </div>
 </div>

</div>













<?php do_action( 'avada_after_content' ); ?>
<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */