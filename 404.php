<?php
/**
 * The template used for 404 pages.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header();  ?>


<?php 

$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if (strpos($current_url, '/scholarship-search-not-found/') !== false) {

   
    $parsed_url = parse_url($current_url);
    $path = $parsed_url['path'];
    
    $search_query = basename($path);

    // Send a 404 header
    header("HTTP/1.1 404 Not Found");

    include(get_stylesheet_directory() . '/templates/template-filters.php');
   
 
    // Echo out the jQuery script
    echo "<script>
    jQuery(document).ready(function($) {
        $('body').addClass('page-template-template-filters');
    });
    </script>";
  


   
}  else { ?>
        
         <h1 class="err404-header">  Page Not Found! </h1> 
         <p class="err404-para">Oh no, we couldn’t find that awesome page that you are looking for! Good news though, there are still tons of helpful information at Global Scholarships. Search below to find the information that you need!</p>



<?php  } 

?>









<?php get_footer(); ?>
