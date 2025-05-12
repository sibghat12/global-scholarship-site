<?php
/**
 * Template Name: Show Published
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); 

//include get_stylesheet_directory() . "/functions/cities_functions.php";

?>  

<section id="content" class="small-text">
			<div class="post-content">

                
   <?php 
   $args = array(
    'post_type' => 'institution',
    'posts_per_page' => -1,
);

$the_query = new WP_Query($args);

$institutions = [];

while ($the_query->have_posts()) {
    $the_query->the_post();
    $id = get_the_ID();

    // Assuming 'cities' is the ACF field key for the city post object
    $city_post_id = get_field('cities', $id);

    if($city_post_id){
        // Fetch the country from the city post, adjust 'country' to your actual ACF field key in the city post type
        $country = get_field('country', $city_post_id);

        // Check if $country is a post object and fetch the title if so
        if (is_object($country)) {
            $country_name = get_the_title($country->ID);
        } else {
            // Adjust according to how your country data is structured
            $country_name = $country;
        }

        // Group institutions by country name
        $institutions[$country_name][] = [
            'id' => $id,
            'title' => get_the_title(),
        ];
    }
}

// Sort institutions by country name
ksort($institutions);

// Output institutions grouped by country
foreach ($institutions as $country => $insts) {
    echo "<h2>" . $country . "</h2><ul>";
    foreach ($insts as $inst) {
        $permalink = get_permalink($inst['id']);
        echo "<li><a href='" . esc_url($permalink) . "'>" . esc_html($inst['title']) . "</a></li>";
    }
    echo "</ul>";
}

    echo "</ul>";
         
        
                
                
                
                ?>
    </div>
                

    
	<?php wp_reset_postdata(); ?>
    
    
</section>
            
<?php do_action( 'avada_after_content' ); ?>

<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
