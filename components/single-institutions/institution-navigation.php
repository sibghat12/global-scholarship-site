<div class="gs-institution-navigation">
    <?php

    // Query for the previous post from the same country
    $previous_post = new WP_Query(array(
        'post_type' => 'institution',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'order' => 'DESC',
        'orderby' => 'ID',
        'meta_query' => array(
            array(
                'key' => 'location_country',
                'value' => $country_name,
                'compare' => '=',
            )
        ),
        'date_query' => array(
            array(
                'before' => get_the_date('Y-m-d H:i:s', $institution_id),
            )
        )
    ));
    
    
    // Query for the next post from the same country
    $next_post = new WP_Query(array(
        'post_type' => 'institution',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'order' => 'ASC',
        'orderby' => 'ID',
        'meta_query' => array(
            array(
                'key' => 'location_country',
                'value' => $country_name,
                'compare' => '=',
            )
        ),
        'date_query' => array(
            array(
                'after' => get_the_date('Y-m-d H:i:s', $institution_id),
            )
        )
    ));
    
    // Check if previous post exists
    if ($previous_post->have_posts()) :
        $previous_post->the_post();
    ?>
        <div class="previous-post">
            <a href="<?php the_permalink(); ?>">
                &lt; Previous
            </a>
        </div>
    <?php
    endif;
    
    // Reset post data
    wp_reset_postdata();
    
    // Check if both previous and next post exist
    if ($previous_post->have_posts() && $next_post->have_posts()) :
    ?>
        <div class="divider"></div>
    <?php
    endif;
    
    // Check if next post exists
    if ($next_post->have_posts()) :
        $next_post->the_post();
    ?>
        <div class="next-post">
            <a href="<?php the_permalink(); ?>">
                Next &gt;
            </a>
        </div>
    <?php
    endif;
    
    // Reset post data
    wp_reset_postdata();
    ?>
</div>