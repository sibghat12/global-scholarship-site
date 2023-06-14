<?php
/**
 * Template Name: Currently Open Scholarhsip
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>



	<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    th, td {
        padding: 8px;
        text-align: left;
        border: 2px solid gray !important;
    }
    
    th {
        background-color: #f2f2f2;
    }
    
    h2 {
        margin-top: 20px;
    }

    hr {
        background: gray;
    }

    td:nth-child(3) {
    width: 20%; /* You can adjust this value to fit your needs */
}

 td:nth-child(5) {
    width: 20%; /* You can adjust this value to fit your needs */
}

td:nth-child(1) {
    width: 20%; /* You can adjust this value to fit your needs */
}

td:nth-child(2) {
    width: 20%; /* You can adjust this value to fit your needs */
}

td:nth-child(3) {
    width: 20%; /* You can adjust this value to fit your needs */
}

li {
	font-size:15px !important;
	line-height: 18px !important;
}

</style>

<?php get_header(); ?>


<h1 style="font-size:36px;padding-bottom:20px;text-align:center;"> Currently Open Scholarship </h1>

<p> Thousands of universities and colleges around the globe offer scholarships to students from all over the world. These scholarships can help you cover the costs of tuition, room and board, books, and even travel expenses. </p>

<p> We know that looking and applying for a scholarship is not an easy task. To help you, we compiled the currently open scholarships in the USA, United Kingdom, South Korea, Canada, and Australia.  </p>

<p style="margin-bottom:60px;"> At Global Scholarships, we aim to provide the most updated scholarships for international students! Make sure to take note of the deadlines and read the scholarship pages to get to know more about eligibility, requirements, and more! </p>

<?php

$scholarships = get_posts(array(
    'post_type' => 'scholarships',
    'post_status' => 'publish',
    'posts_per_page' => -1, // Retrieve all posts
));

// Step 2: Loop through each scholarship post
$institution_scholarships = array();
foreach ($scholarships as $scholarship) {
    // Step 3: Get institution ID or scholarship_institution custom field value
    $institution_id = get_field('scholarship_institution', $scholarship->ID);

    // Step 4: Retrieve institution post
    $institution = get_post($institution_id);

    // Step 5: Extract institution name
    $institution_name = $institution->post_title;

    // Step 7: Extract country name
    $cities_id = get_field('cities', $institution_id);

    // Step 4: Retrieve cities post
    $cities = get_post($cities_id);

    $country = get_field('country', $cities_id);

    // Step 8: Group institutions by country name
    if (!isset($institution_scholarships[$country])) {
        $institution_scholarships[$country] = array();
    }

    if (!isset($institution_scholarships[$country][$institution_name])) {
        $institution_scholarships[$country][$institution_name] = array(
            'institution_permalink' => get_permalink($institution->ID), // Get the permalink of the institution
            'scholarships' => array()
        );
    }

    // Retrieve scholarship_deadlines repeater field values
    $deadlines = get_field('scholarship_deadlines', $scholarship->ID);

    // Check if scholarship_deadlines is empty or no records found
    if (empty($deadlines)) {
        // Retrieve admission_deadlines repeater field values from institution
        $deadlines = get_field('admission_deadlines', $institution_id);
    }

    $eligible_degrees = get_field('eligible_degrees', $scholarship->ID); // Get the eligible degrees for the scholarship

    $institution_scholarships[$country][$institution_name]['scholarships'][] = array(
        'scholarship_title' => $scholarship->post_title,
        'scholarship_permalink' => get_permalink($scholarship->ID), // Get the permalink of the scholarship
        'coverages' => get_field('scholarship_coverage', $scholarship->ID),
        'eligible_degrees' => $eligible_degrees,
        'deadlines' => $deadlines
    );
}

// Step 9 and 10: Create the table
foreach ($institution_scholarships as $country_name => $country_institutions) {
    echo '<center><h2 style="margin-top:60px;margin-bottom:30px;">Currently Open Scholarships in ' . $country_name . '</h2></center>';
    echo '<table style="border-collapse: collapse; border: 1px solid black;" >';
    echo '<tr><th>Institution Name</th><th>Scholarship</th><th>Coverages</th><th>Eligible Degrees</th><th>Scholarship Deadlines</th></tr>';

    $count = 0; // Keep track of the number of institutions

    foreach ($country_institutions as $institution_name => $institution) {
        if ($count >= 10) {
            break; // Limit reached, exit the loop
        }

        $scholarships = $institution['scholarships'];
        $scholarship_count = count($scholarships);

        // Display institution name in the first row only
        echo '<tr style="border: 1px solid black;" >';
        echo '<td rowspan="' . $scholarship_count . '"><a href="' . $institution['institution_permalink'] . '">' . $institution_name . '</a></td>';
        echo '<td><a href="' . $scholarships[0]['scholarship_permalink'] . '">' . $scholarships[0]['scholarship_title'] . '</a></td>';
        echo '<td>';
        foreach ($scholarships[0]['coverages'] as $coverage) {
           echo '<li>' . $coverage['coverage'] . '</li>';
        }
        echo '</td>';
        echo '<td>';
        foreach ($scholarships[0]['eligible_degrees'] as $degree) {
            
                echo $degree . '<br>';
         
        }
        echo '</td>';
        echo '<td>';
        $displayed_degrees = array(); // Keep track of displayed degrees
        foreach ($scholarships[0]['deadlines'] as $deadline) {
            if (in_array($deadline['degree'], $scholarships[0]['eligible_degrees']) && !in_array($deadline['degree'], $displayed_degrees) && $deadline['degree'] !== 'PhD') { // Exclude PhD degree
                 echo  '<b>' . $deadline['degree']. ":</b> " .$deadline['deadline'] . '<br>';
                $displayed_degrees[] = $deadline['degree']; // Add displayed degree to the array
            }
        }
        echo '</td>';
        echo '</tr>';

        // Display remaining scholarships in subsequent rows
        for ($i = 1; $i < $scholarship_count; $i++) {
            echo '<tr>';
            echo '<td><a href="' . $scholarships[$i]['scholarship_permalink'] . '">' . $scholarships[$i]['scholarship_title'] . '</a></td>';
            echo '<td>';
            foreach ($scholarships[$i]['coverages'] as $coverage) {
                echo '<li>' . $coverage['coverage'] . '</li>';
            }
            echo '</td>';
            echo '<td>';
            foreach ($scholarships[$i]['eligible_degrees'] as $degree) {
               
                    echo $degree . '<br>';
              
            }
            echo '</td>';
            echo '<td>';
            $displayed_degrees = array(); // Keep track of displayed degrees
            foreach ($scholarships[$i]['deadlines'] as $deadline) {
                if (in_array($deadline['degree'], $scholarships[$i]['eligible_degrees']) && !in_array($deadline['degree'], $displayed_degrees) && $deadline['degree'] !== 'PhD') { // Exclude PhD degree
                   echo  '<b>' . $deadline['degree']. ":</b> " .$deadline['deadline'] . '<br>';
                    $displayed_degrees[] = $deadline['degree']; // Add displayed degree to the array
                }
            }
            echo '</td>';
            echo '</tr>';
        }

        $count++; // Increment the institution count
    }

    echo '</table>';
}

?>



<p style="margin-top:60px;">We hope that these currently open scholarships will help you, as you search for ways to support your studies! We also have a newsletter where we send these scholarships every Monday. If you want to get these notifications, please subscribe to our  <a href="">email list. </a> </p>

<p style="margin-bottom:0px;">Please do get the currently open scholarships, and once the deadline expired, it should be removed automatically, then be replaced with a new one.
 </p>

 <p style="margin-bottom:0px;">Also, if possible, please rioritize putting the full tuition and full funding. If there are no other full tuition and fully funded scholarships, insert partial. Thank you!

 </p>





<?php get_footer(); ?>