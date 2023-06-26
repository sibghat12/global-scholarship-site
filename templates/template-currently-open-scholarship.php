
<?php
/**
 * Template Name: Currently Open Scholarships
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

// Get the header
get_header(); 

// Get the values from the ACF fields
$country = get_field('country');
$intro = get_field('intro');
$conclusion = get_field('conclusion');

$allowed_countries = ['United States', 'United Kingdom', 'Canada', 'Australia', 'South Korea'];
if ($country !== 'All') {
    $allowed_countries = [$country];
}

?>

<h1 style="font-size:36px;padding-bottom:20px;text-align:center;"> Currently Open Scholarship </h1>

<?php echo $intro; ?>

<?php

// Check if the data is already in the cache.
$institution_scholarships = get_transient('scholarships_data');

if ($institution_scholarships === false) {
    // The data is not in the cache, process the list.

    // Define the number of scholarships to process in one iteration.
    $posts_per_page = 100;

    // Calculate the total number of pages.
    $total_posts = wp_count_posts('scholarships')->publish;
    $total_pages = ceil($total_posts / $posts_per_page);

    $institution_scholarships = array();

    // Process the scholarships in batches.
    for ($page = 0; $page < $total_pages; $page++) {
        // Get a batch of scholarships.
        $scholarships = get_posts(array(
            'post_type' => 'scholarships',
            'post_status' => 'publish',
            'fields' => 'ids',
            'posts_per_page' => $posts_per_page,
            'paged' => $page + 1, // 'paged' parameter is 1-indexed.
        ));

        // Process each scholarship in the batch.
        foreach ($scholarships as $scholarship_id) {
            // Load all post meta data into cache.
            $scholarship_fields = get_post_custom($scholarship_id);

            // Get the institution's fields
            $institution_id = $scholarship_fields['scholarship_institution'][0];
            print_r($institution_id);
            exit;
            $institution_fields = get_post_custom($institution_id);
            $institution_name = get_the_title($institution_id);

            // Check if the institution's country is allowed
            //$country = $institution_fields['country'][0];
            if (!in_array($country, $allowed_countries)) {
                continue;
            }

            // Process the deadlines
            $scholarship_deadlines = maybe_unserialize($scholarship_fields['scholarship_deadlines'][0]);
            $admission_deadlines = maybe_unserialize($institution_fields['admission_deadlines'][0]);
            $eligible_degrees = maybe_unserialize($scholarship_fields['eligible_degrees'][0]);
            $future_deadlines = array();

            foreach ($scholarship_deadlines as $deadline) {
                if (strtotime($deadline['deadline']) > time() && in_array($deadline['degree'], $eligible_degrees)) {
                    $future_deadlines[] = $deadline;
                }
            }

            if (empty($future_deadlines)) {
                foreach ($admission_deadlines as $deadline) {
                    if (strtotime($deadline['deadline']) > time() && in_array($deadline['degree'], $eligible_degrees)) {
                        $future_deadlines[] = $deadline;
                    }
                }
            }

            if (empty($future_deadlines)) {
                continue;
            }

            // Build the scholarship list for each institution and country
            if (!isset($institution_scholarships[$country])) {
                $institution_scholarships[$country] = array();
            }
            if (!isset($institution_scholarships[$country][$institution_name])) {
                $institution_scholarships[$country][$institution_name] = array(
                    'institution_permalink' => get_permalink($institution_id),
                    'scholarships' => array()
                );
            }
            $institution_scholarships[$country][$institution_name]['scholarships'][] = array(
                'scholarship_title' => get_the_title($scholarship_id),
                'scholarship_permalink' => get_permalink($scholarship_id),
                'coverages' => maybe_unserialize($scholarship_fields['scholarship_coverage'][0]),
                'eligible_degrees' => $eligible_degrees,
                'deadlines' => $future_deadlines
            );
        }
    }

    // Set a transient cache for the results.
    set_transient('scholarships_data', $institution_scholarships, HOUR_IN_SECONDS);
}



foreach ($institution_scholarships as $country_name => $country_institutions) {
     if (in_array($country_name, $allowed_countries)) {
    echo '<center><h2 style="margin-top:60px;margin-bottom:30px;">Currently Open Scholarships in ' . $country_name . '</h2></center>';
    echo '<table id="example"  style="border-collapse: collapse; border: 1px solid black;" >';
    echo '<thead><tr><th> Institution Name</th><th>Scholarship</th><th>Coverages</th><th>Eligible Degrees</th><th>Scholarship Deadlines </tr></thead>';

    $count = 0;
 echo '<tbody>';
    foreach ($country_institutions as $institution_name => $institution) {
        if ($count >= 10) {
            break;
        }

        $scholarships = $institution['scholarships'];
        $scholarship_count = count($scholarships);
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
        $displayed_degrees = array();
        foreach ($scholarships[0]['deadlines'] as $deadline) {
            if (in_array($deadline['degree'], $scholarships[0]['eligible_degrees']) && !in_array($deadline['degree'], $displayed_degrees) && $deadline['degree'] !== 'PhD') {
                echo  '<b>' . $deadline['degree']. ":</b> " .$deadline['deadline'] . '<br>';
                $displayed_degrees[] = $deadline['degree'];
            }
        }
        echo '</td>';
        echo '</tr>';

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
            $displayed_degrees = array();
            foreach ($scholarships[$i]['deadlines'] as $deadline) {
                if (in_array($deadline['degree'], $scholarships[$i]['eligible_degrees']) && !in_array($deadline['degree'], $displayed_degrees) && $deadline['degree'] !== 'PhD') {
                    echo  '<b>' . $deadline['degree']. ":</b> " .$deadline['deadline'] . '<br>';
                    $displayed_degrees[] = $deadline['degree'];
                }
            }
            echo '</td>';
            echo '</tr>';
        }

        $count++;
    }
    echo '</tbody>';
    echo '</table>';
}
}

?>




<div style="margin-top:50px;">
<?php echo $conclusion; ?>
</div>




<?php get_footer(); ?>
