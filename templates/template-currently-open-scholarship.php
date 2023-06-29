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
       
        text-align: left;
        border: 2px solid gray !important;
    }
    
    th {
        padding-left:px !important;
        background-color: #f2f2f2;
    }
    
    h2 {
        margin-top: 20px;
    }

    hr {
        background: gray;
    }

   





li {
    font-size:15px !important;
    line-height: 18px !important;
}

#example_length {
    margin-bottom:20px;
}
#example {
    margin-bottom:50px;
}
.dataTables_info {
    font-size:20px;
}
.dataTables_paginate a {
    font-size:18px !important;
}

.scholarships-table {
    border:none !important;
        border-left: none !important;
        border-right: none !important;
    }
    .scholarships-table td ,.scholarships-table th {
         border-left: none !important;
         border-top:none !important;
         padding-left:10px !important;
         padding-bottom:20px !important;
         padding-top:10px !important;
        border-bottom: 2px solid gray !important;
        width:25% !important;

    }

  .scholarships-table tr:last-child td {
    border-bottom: none !important;
}

.scholarships-table tr:last-child {
    border-bottom: none !important;
}
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"/>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<?php get_header();

// Get the values from the ACF fields
$country = get_field('country');
$intro = get_field('intro');
$conclusion = get_field('conclusion');
?>

<h1 style="font-size:36px;padding-bottom:20px;text-align:center;"> <?php single_post_title(); ?> </h1>
<div style="margin-bottom:60px;">
<?php echo $intro; ?>
</div>
<?php 


wp_reset_postdata();
// Get all institution IDs

$allowed_countries = ['United States', 'United Kingdom', 'Canada', 'Australia', 'South Korea'];

if ($country === 'All') {
    $countries_to_display = $allowed_countries;
} else {
    $countries_to_display = [$country];
}


    $institution_ids = get_posts(array(
        'post_type' => 'institution',
        'post_status' => 'publish',
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results' => false,
        'fields' => 'ids',
        'posts_per_page' => -1, // Retrieve all institutions
    ));

    // Initialize an array to hold the IDs of institutions in the specified country
    $filtered_institution_ids = array();

    // Loop over the institutions
    foreach ($institution_ids as $institution_id) {
        // Get the city ID associated with this institution
        $cities_id = get_field('cities', $institution_id);

        // Get the country associated with this city
        $institution_country = get_field('country', $cities_id);

        // If the country matches, add the institution ID to the filtered list
        if ($institution_country === $country) {
            $filtered_institution_ids[] = $institution_id;
        }
    }

    $institution_ids = $filtered_institution_ids;

    // Then, when getting scholarships, add a meta query to only include scholarships related to these institutions
    $scholarships_ids = get_posts(array(
        'post_type' => 'scholarships',
        'post_status' => 'publish',
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results' => false,
        'fields' => 'ids',
        'posts_per_page' => -1, // Retrieve all posts
        'meta_query' => array(
            array(
                'key' => 'scholarship_institution', // Assuming 'scholarship_institution' is the key of the 
                'value' => $institution_ids,
                'compare' => 'IN',
            )
        )
    ));

$institution_scholarships = array();
$institution_count = 0;

foreach ($scholarships_ids as $scholarship_id) {
    if ($institution_count >= 20) break; // Stop loop if institution count is 20

    $institution_id = get_field('scholarship_institution', $scholarship_id);
    $institution = get_post($institution_id);
    $institution_name = $institution->post_title;
   
    $city_id = get_field('cities', $institution_id);
    $city = get_post($city_id);
    $country_name = get_field('country', $city);
    
    if (!in_array($country_name, $allowed_countries)) {
        continue;
    }


    $scholarship_type = get_field('amount_category', $scholarship_id);

    $scholarship_deadlines = get_field('scholarship_deadlines', $scholarship_id);
    $admission_deadlines = get_field('admission_deadlines', $institution_id);
    $eligible_degrees = get_field('eligible_degrees', $scholarship_id);
    $future_deadlines = array();

    if (is_array($scholarship_deadlines)) {
        foreach ($scholarship_deadlines as $deadline) {
            if (strtotime($deadline['deadline']) > time() && in_array($deadline['degree'], $eligible_degrees)) {
                $future_deadlines[] = $deadline;
            }
        }
    }

    if (empty($future_deadlines) && is_array($admission_deadlines)) {
        foreach ($admission_deadlines as $deadline) {
            if (strtotime($deadline['deadline']) > time() && in_array($deadline['degree'], $eligible_degrees)) {
                $future_deadlines[] = $deadline;
            }
        }
    }

    if (empty($future_deadlines)) {
        continue;
    }

    if (!isset($institution_scholarships[$country_name])) {
        $institution_scholarships[$country_name] = array();
    }



    // Check if institution is already in the list, if not increase the count
    if (!isset($institution_scholarships[$country_name][$institution_name])) {
        $institution_scholarships[$country_name][$institution_name] = array(
            'institution_permalink' => get_permalink($institution->ID),
            'scholarships' => array()
        );
        $institution_count++; 
    }

    $institution_scholarships[$country_name][$institution_name]['scholarships'][] = array(
        'scholarship_title' => get_the_title($scholarship_id),
        'scholarship_permalink' => get_permalink($scholarship_id),
        'coverages' => get_field('scholarship_coverage', $scholarship_id),
        'eligible_degrees' => $eligible_degrees,
        'deadlines' => $future_deadlines,
        'scholarship_type' => $scholarship_type,
        'country' => $country_name,
    );
}

$previous_institution = '';
$row_color = '';

echo '<table id="example" style="border-collapse: collapse; border: 1px solid black; width: 100%;">';
echo '<thead><tr style="border:none !important;">';
echo '<th style="width:20%;">Institution Name</th>';
if ($country === 'All') {
    echo '<th style="width:15%;">Country</th>';
}
echo '<th style="width:65%;padding:0px !important;">';
echo '<table style="border:none !important;border-collapse:none !important;"><thead><tr>';
echo '<th style="border:none !important;border-right:1px solid gray !important;width:30%;">Scholarship</th>';
echo '<th style="border:none !important;border-right:1px solid gray !important;width:25%;">Coverages</th>';
echo '<th style="border:none !important;border-right:1px solid gray !important;width:20%;">Eligible Degrees</th>';
echo '<th style="border:none !important;border-right:1px solid gray !important;width:25%;">Scholarship Deadlines</th>';
echo '</tr></thead></table></th></tr></thead>';
echo '<tbody>';

foreach ($institution_scholarships as $country_name => $country_institutions) {
    foreach ($country_institutions as $institution_name => $institution) {
        // Switch row color when institution changes
        if ($previous_institution != $institution_name) {
            //$row_color = ($row_color == '#F5F5F5') ? '#ffffff' : '#F5F5F5';
        }
        $previous_institution = $institution_name;

        echo '<tr style="border: 1px solid #ddd; background-color: ' . $row_color . ';">';
        echo '<td style="padding: 10px;"><a style="font-weight:500;font-size:18px;" href="' . $institution['institution_permalink'] . '">' . $institution_name . '</a></td>';
        if ($country === 'All') {
            echo '<td style="padding: 10px;"><a href="' . site_url() . '/currently-open-scholarships-' . str_replace(' ', '-', strtolower($country_name)) . '">' . $country_name . '</a></td>';
        }
        echo '<td style="padding: 0px;">';

        // start nested table for scholarships
        echo '<table class="scholarships-table" style="width: 100%; border: 1px solid #ddd; border-collapse: collapse; margin-top:0px;">';
        echo '<thead></thead>';

        $scholarships = $institution['scholarships'];
        foreach ($scholarships as $scholarship) {
            echo '<tr style="border-bottom: 1px solid #ddd;">';
            echo '<td style="width:30% !important;padding: 0px;"><a href="' . $scholarship['scholarship_permalink'] . '">' . $scholarship['scholarship_title'] . ' (' . $scholarship['scholarship_type'] . ')</a></td>';
            echo '<td style="width:25% !important;;padding: 10px;"><ul>';
            foreach (array_column($scholarship['coverages'], 'coverage') as $coverage) {
                echo '<li>' . $coverage . '</li>';
            }
            echo '</ul></td>';
            echo '<td style="width:20% !important; ;padding: 0px;">';
            echo implode('<br>', $scholarship['eligible_degrees']);
            echo '</td>';
            echo '<td style="width:25% !important;padding: 0px;">';
            $degreeDeadlines = array();
            $currentDate = date('Y-m-d');
            foreach ($scholarship['deadlines'] as $deadline) {
                if (strtotime($deadline['deadline']) >= strtotime($currentDate) && in_array($deadline['degree'], $scholarship['eligible_degrees']) && $deadline['degree'] !== 'PhD') {
                    // Only store the deadline for each degree type if it doesn't already exist in the array
                    if (!array_key_exists($deadline['degree'], $degreeDeadlines)) {
                        $degreeDeadlines[$deadline['degree']] = '<strong>' . $deadline['degree'] . '</strong>: ' . $deadline['deadline'];
                    }
                }
            }
            echo implode('<br>', $degreeDeadlines);
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>'; // end nested table
        echo '</td>';
        echo '</tr>';
    }
}

echo '</tbody>';
echo '</table>';


wp_reset_postdata();


?>

<div style="margin-top:70px !important">
<?php echo $conclusion; ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#example').DataTable({
            "pageLength": 10,
            "lengthChange": false
        });
    });
</script>

<?php get_footer(); ?>
