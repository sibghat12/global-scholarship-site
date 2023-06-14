<?php 

get_header();
?> 

<div id="primary" class="content-single content-area">
<main id="main" class="site-main" role="main">
    
<?php
while ( have_posts() ) : the_post();
    
    //If current blog id is main blog, we get the content from before
    
    if (get_current_blog_id() == 1){
        get_template_part( 'template-parts/content', 'adschool' );
    }
    
    
    donovan_post_navigation();

    do_action( 'donovan_after_posts' );

    donovan_related_posts();

    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
    comments_template();
    endif;

endwhile; // End of the loop.
?>

    
    
         

</main><!-- #main -->
</div><!-- #primary -->
<?php
get_sidebar();
get_footer();
?>