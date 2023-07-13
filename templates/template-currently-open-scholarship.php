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


.dataTables_filter {
    margin-bottom:30px !important;
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


$allowed_countries = ['United States', 'United Kingdom', 'Canada', 'Australia', 'South Korea'];

$meta_query = array();

if ($country !== 'All') {
    $meta_query[] = array(
        'key' => 'institution_country',
        'value' => $country,
        'compare' => '=',
    );
}

$meta_query[] = array(
    'relation' => 'OR',
    array(
        'key' => 'bachelor_open_date',
        'value' => "Yes",
        'compare' => '='
    ),
    array(
        'key' => 'master_open_date',
        'value' => "Yes",
        'compare' => '='
    )
);

$scholarships_ids = get_posts(array(
    'post_type' => 'scholarships',
    'post_status' => 'publish',
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
    'cache_results' => false,
    'fields' => 'ids',
    'posts_per_page' => -1,
    'meta_query' => $meta_query
));

// Fetch scholarship info
$institution_scholarships = get_scholarships_info($scholarships_ids, $allowed_countries);

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
            echo '<td style="padding: 10px;"><a href="' . site_url() . '/currently-open-scholarships-' . str_replace(' ', '-', strtolower($country_name)) . '/">' . $country_name . '</a></td>';
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
        $('#example').DataTable();




    });
</script>

<?php get_footer(); ?>