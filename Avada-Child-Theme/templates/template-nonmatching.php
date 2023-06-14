<?php
/**
 * Template Name: Non-Matching Filter
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

<div class="container" style="width:70%;">
<p style="margin-top:50px;margin-bottom:5px; font-size:24px;"> Number of scholarships: <b> <span id="cc"> </span> </b></p>
<hr>
<p style="font-size:15px;margin-bottom:60px;"> These are the below scholarships that has the number in the Permalink<br> And If some Url Has Different permalink and title. </p>

<?php

$count = 1;

// Get all scholarship posts
$scholarships = get_posts(array(
    'post_type' => 'scholarships', 
     'posts_per_page' => -1,
));

// Loop through each scholarship post
foreach ($scholarships as $scholarship) {
    // Get the post ID, title and permalink
    $post_id = $scholarship->ID;
    
    $post_title = $scholarship->post_title;
    $post_permalink = get_permalink($post_id);

    $post_title_for_display = $post_title;

    // Remove hyphen before any digit and remove all numbers from the permalink
    

    //$post_permalink = preg_replace(array('/-(?=\d)/', '/\d+/'), '', $post_permalink);
    
    // Remove the last hyphen if it is before the number and remove the number as well
      $post_permalink = preg_replace('/-\d+\/?$/', '', $post_permalink);
     

    // Get the last part of the permalink

    $last_part = basename($post_permalink);

    // Replace spaces with hyphens and convert to lowercase for comparison
    $last_part = strtolower(str_replace(' ', '-', $last_part));
    $post_title = strtolower(str_replace(' ', '-', $post_title));
     if (strpos($post_title, "'") !== false) {
   
    $post_title = str_replace("'", "", $post_title);
}

preg_match('/\(([^)]+)\)/', $post_title, $matches);

if (!empty($matches)) {
    $word_inside_parentheses = $matches[1];
    $lowercase_word = strtolower($word_inside_parentheses);
    $post_title = str_replace("(" . $word_inside_parentheses . ")", $lowercase_word, $post_title);
}




// if (preg_match('/[a-zA-Z]/', $post_title)) {
//     $post_title = preg_replace('/\d+th/', '', $post_title);
// }

if (strpos($post_title, '---') !== false) {
    $post_title = str_replace('---', '-', $post_title);
}


if (strpos($post_title, '--') !== false) {
    $post_title = str_replace('--', '-', $post_title);
}


if (strpos($post_title, '’') !== false) {
    $post_title = str_replace('’', '', $post_title);
}


if (strpos($post_title, 'é') !== false) {
    $post_title = str_replace('é', 'e', $post_title);
}

// if (strpos($post_title, '.') !== false) {
//     $post_title = str_replace('.', '', $post_title);
// }



if (strpos($post_title, '#') !== false) {
    $post_title = str_replace('#', '', $post_title);
}


if (strpos($post_title, ',') !== false) {
    $post_title = str_replace(',', '', $post_title);
}



if(strpos($post_title, ":") !== false) { // check if the string contains a colon
    $post_title = str_replace(":", "", $post_title); // remove the colon from the string
}

if (strpos($post_title, '---') !== false) {
    $post_title = str_replace('---', '-', $post_title);
}


if (strpos($post_title, '&') !== false) {
    $post_title = str_replace('&', '', $post_title);
}

if (strpos($post_title, 'amp;') !== false) {
    $post_title = str_replace('amp;', '', $post_title);
}

if (strpos($post_title, '%') !== false) {
    $post_title = str_replace('%', '', $post_title);
}


if (strpos($post_title, '+') !== false) {
    $post_title = str_replace('+', '', $post_title);
}

if (strpos($post_title, '.') !== false) {
    $post_title = str_replace('.', '-', $post_title);
}

if (strpos($post_title, '--') !== false) {
    $post_title = str_replace('--', '-', $post_title);
}


if (strpos($post_title, '-–-') !== false) {
    $post_title = str_replace('-–-', '-', $post_title);
}





    
    // Check if the permalink is a valid URL according to the title wording
    $valid_url = ($last_part === $post_title);

    // Output the post title and permalink if the URL is not valid
    if (!$valid_url) {
        echo "<div style='height:280px;margin-top:20px;margin-bottom:20px;background:#f7f7f7;padding:20px;'>";
        echo "<p style='font-size:27px;margin-top:10px;margin-bottom:10px'> S# : " .  $count. "</p>";
        echo "<hr style='width:100%;'>";
        
        echo '<p style="font-size:24px;margin-top:15px;margin-bottom:5px;">Post Title: <b>'. $post_title_for_display.' </b></p>';

       

        echo '<p style="margin-top:10px;margin-bottom:10px;font-size:22px;"> Post Peralink: <b> '. $last_part . ' </a> </b> </p>';
        echo  "<p><a style'font-size:18px;' href=" . get_permalink($post_id) .  "> Scholarship Link </a></p>";
        echo "</div>";

        $count++;
    }
}



?>
</div>

<script type="">
    

jQuery(document).ready(function() {
    // If you need to perform additional operations on the count
    // using jQuery, you can access it using the following code:
    jQuery('#cc').text(<?php echo $count-1; ?>);
    
    // Perform additional operations or updates to the #cc span if needed
});

</script>

<?php
 get_footer(); ?>

