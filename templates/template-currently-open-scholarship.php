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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"/>
<!-- Load DataTables -->

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>






<?php get_header(); 

// Get the values from the ACF fields
$country_field = get_field('country');
$intro = get_field('intro');
$conclusion = get_field('conclusion');



?>


<h1 style="font-size:36px;padding-bottom:20px;text-align:center;"> Currently Open Scholarship </h1>

<?php echo $intro; ?>


<?php

$scholarships = get_posts(array(
    'post_type' => 'scholarships',
    'post_status' => 'publish',
    'posts_per_page' => -1, // Retrieve all posts
));




$allowed_countries = ['United States', 'United Kingdom', 'Canada', 'Australia', 'South Korea'];
if ($country_field !== 'All') {
    $allowed_countries = [$country_field];
}


$institution_scholarships = array();

foreach ($scholarships as $scholarship) {
    $institution_id = get_field('scholarship_institution', $scholarship->ID);
    $institution = get_post($institution_id);
    $institution_name = $institution->post_title;
    $cities_id = get_field('cities', $institution_id);
    $cities = get_post($cities_id);
    $country = get_field('country', $cities_id);

    if (!in_array($country, $allowed_countries)) {
        continue;
    }

    $scholarship_deadlines = get_field('scholarship_deadlines', $scholarship->ID);
    $admission_deadlines = get_field('admission_deadlines', $institution_id);
    $eligible_degrees = get_field('eligible_degrees', $scholarship->ID);
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

    if (!isset($institution_scholarships[$country])) {
        $institution_scholarships[$country] = array();
    }

    if (!isset($institution_scholarships[$country][$institution_name])) {
        $institution_scholarships[$country][$institution_name] = array(
            'institution_permalink' => get_permalink($institution->ID),
            'scholarships' => array()
        );
    }

    $institution_scholarships[$country][$institution_name]['scholarships'][] = array(
        'scholarship_title' => $scholarship->post_title,
        'scholarship_permalink' => get_permalink($scholarship->ID),
        'coverages' => get_field('scholarship_coverage', $scholarship->ID),
        'eligible_degrees' => $eligible_degrees,
        'deadlines' => $future_deadlines
    );
}

// Continue with the table generation code


$table_id_counter = 1;
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
$table_id_counter++;
        $count++;
    }
    echo '</tbody>';
    echo '</table>';
}
}

?>




<?php echo $conclusion; ?>

<script type="text/javascript">
   jQuery(document).ready(function($) {
    $('#example').DataTable();
});


</script>

<?php get_footer(); ?>

