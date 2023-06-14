<?php
/**
 * Template Name: Scholarship Past Deadline
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


<div class="mm fixed-div">
<p style="font-size:24px;padding-bottom:5px; margin-top:0px;padding-bottom:0px;margin-bottom:0px;margin-left:0px;"> Scholarships Past Deadline: </p>
<p style="margin-top:10px;font-size:16px;" class="link-for-past">
    <a   href="#sixmonths"  style="color:black !important;margin-left:0px !important;"  class="activeee">   Past Deadline  (After 6  Months )    </a>  |
    <a   href="#threemonth" style="color:black !important;" >  Past Deadline   ( After 3 Months )  </a>  |
    <a   href="#onemonth"   style="color:black !important;" > Past Deadline   ( After  1   Month  )  </a>   |
    <a   href="#week"       style="color:black !important;" >   Past Deadline ( After  1 Week     )  </a>   
</p>

</div>

<div id="sixmonths">

<p style="font-size:23px;margin-top:60px;"> 1 - Scholarships Past Deadline (After 6 Months) </p>
<hr>
<?php 

// Fetch all scholarships
$scholarship_args = array(
    'post_type'      => 'scholarships',
    'posts_per_page' => -1,
);

$scholarship_query = new WP_Query($scholarship_args);
$scholarships = array();

// Process scholarships and group by country
$grouped_scholarships = array();

$currentDate = time();
$sixMonthsAgo = strtotime('-6 months', $currentDate);

if ($scholarship_query->have_posts()) {
    while ($scholarship_query->have_posts()) {
        $scholarship_query->the_post();
        $scholarship_id = get_the_ID();
       $has_found_row = false;
        $institution = get_field('scholarship_institution', $scholarship_id);
        if ($institution) {
            $city = get_post($institution->cities);
            if ($city) {
                $country_name = get_post_meta($city->ID, 'country', TRUE);

                if (!isset($grouped_scholarships[$country_name])) {
                    $grouped_scholarships[$country_name] = array();
                }

                $scholarship_data = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'link'  => get_permalink(),
                    'deadlines_bachelor' => array(),
                    'deadlines_master' => array()
                );


                if (have_rows('scholarship_deadlines', $scholarship_id)) {
                    while (have_rows('scholarship_deadlines', $scholarship_id)) {
                        the_row();

                        $degree_value = get_sub_field('degree');
                        $deadline_date = get_sub_field('deadline');
                        
                        if(empty($deadline_date)){
                            continue;
                        }

                        $label = get_sub_field('label');
                        $deadline_timestamp = strtotime($deadline_date);

                        if ($deadline_timestamp && $deadline_timestamp <= $currentDate && $deadline_timestamp <= $sixMonthsAgo) {
                            if ($degree_value == "Bachelor's") {
                                $scholarship_data['deadlines_bachelor'][] = array(
                                    'label' => $label,
                                    'deadline' => $deadline_date
                                );
                                $has_found_row = true;
                            } elseif ($degree_value == "Master's") {
                                $scholarship_data['deadlines_master'][] = array(
                                    'label' => $label,
                                    'deadline' => $deadline_date
                                );
                                $has_found_row = true;
                            } else {
                                $scholarship_data['deadlines_bachelor'][] = array(
                                    'label' => $label,
                                    'deadline' => $deadline_date,
                                    'no_degree_selected' => true
                                );
                                $has_found_row = true;
                            }
                        }
                    }
                }
                if(empty($has_found_row)){
            continue;
        }
                $grouped_scholarships[$country_name][] = $scholarship_data;
            }
        }
    }
    wp_reset_postdata();
}


$count_six_month = 1;

// Display scholarships grouped by country
foreach ($grouped_scholarships as $country => $scholarships) {
        if (count($scholarships) > 0) { 
    echo '<h1 style="padding-left:0px;padding-top:10px;padding-bottom:0px;font-size:20px;">' . $country . '</h1>';
    echo '<table class="striped-table" style="border-collapse: collapse; width: 100%;">';
    echo "<tr> <th> Scholarship Name </th> <th> Label </th>  <th> Past Deadline <br> (After 6 Months) </th>  </tr>";

    foreach ($scholarships as $scholarship) {
        echo "<tr>";
        echo '<td>' . $count_six_month . ' - <a href="' . site_url() . '/wp-admin/post.php?post=' . $scholarship['id'] . '&action=edit">' . $scholarship['title'] . '</a></td>';

        echo "<td>";
        foreach ($scholarship['deadlines_bachelor'] as $bachelor_deadline) {
            echo $bachelor_deadline['label'] . "<br>";
        }
        foreach ($scholarship['deadlines_master'] as $master_deadline) {
            echo $master_deadline['label'] . "<br>";
        }
        echo "</td>"; 

                echo "<td>";
        foreach ($scholarship['deadlines_bachelor'] as $bachelor_deadline) {
            if (isset($bachelor_deadline['no_degree_selected']) && $bachelor_deadline['no_degree_selected']) {
                echo "Bachelor's and Master's : " . $bachelor_deadline['deadline'] . "<br>";
            } else {
                echo "Bachelor's : " . $bachelor_deadline['deadline'] . "<br>";
            }
        }
        foreach ($scholarship['deadlines_master'] as $master_deadline) {
            if (isset($master_deadline['no_degree_selected']) && $master_deadline['no_degree_selected']) {
                echo "Bachelor's and Master's : " . $master_deadline['deadline'] . "<br>";
            } else {
                echo "Master's : " . $master_deadline['deadline'] . "<br>";
            }
        }
        echo "</td>";

        echo "</tr>";
        $count_six_month++;
    }
    echo "</table>";
}
}



?>


</div>




<div id="threemonth">
<br>
<p style="font-size:23px;"> 2 - Past Deadline (After 3 Months) </p>
<hr>

<?php

// Fetch all scholarships
$scholarship_args = array(
    'post_type'      => 'scholarships',
    'posts_per_page' => -1,
);

$scholarship_query = new WP_Query($scholarship_args);
$scholarships = array();

// Process scholarships and group by country
$grouped_scholarships = array();

$currentDate = time();
$threemonthAgo = strtotime('-3 months', $currentDate);

if ($scholarship_query->have_posts()) {
    while ($scholarship_query->have_posts()) {
        $scholarship_query->the_post();
        $scholarship_id = get_the_ID();
       $has_found_row = false;
        $institution = get_field('scholarship_institution', $scholarship_id);
        if ($institution) {
            $city = get_post($institution->cities);
            if ($city) {
                $country_name = get_post_meta($city->ID, 'country', TRUE);

                if (!isset($grouped_scholarships[$country_name])) {
                    $grouped_scholarships[$country_name] = array();
                }

                $scholarship_data = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'link'  => get_permalink(),
                    'deadlines_bachelor' => array(),
                    'deadlines_master' => array()
                );


                if (have_rows('scholarship_deadlines', $scholarship_id)) {
                    while (have_rows('scholarship_deadlines', $scholarship_id)) {
                        the_row();

                        $degree_value = get_sub_field('degree');
                        $deadline_date = get_sub_field('deadline');
                        
                        if(empty($deadline_date)){
                            continue;
                        }

                        $label = get_sub_field('label');
                        $deadline_timestamp = strtotime($deadline_date);

                      if ($deadline_timestamp && $deadline_timestamp <= $currentDate && $deadline_timestamp <= $threemonthAgo && $deadline_timestamp >= $sixMonthsAgo) {
                            if ($degree_value == "Bachelor's") {
                                $scholarship_data['deadlines_bachelor'][] = array(
                                    'label' => $label,
                                    'deadline' => $deadline_date
                                );
                                $has_found_row = true;
                            } elseif ($degree_value == "Master's") {
                                $scholarship_data['deadlines_master'][] = array(
                                    'label' => $label,
                                    'deadline' => $deadline_date
                                );
                                $has_found_row = true;
                            } else {
                                $scholarship_data['deadlines_bachelor'][] = array(
                                    'label' => $label,
                                    'deadline' => $deadline_date,
                                    'no_degree_selected' => true
                                );
                                $has_found_row = true;
                            }
                        }
                    }
                }
                if(empty($has_found_row)){
            continue;
        }
                $grouped_scholarships[$country_name][] = $scholarship_data;
            }
        }
    }
    wp_reset_postdata();
}


$count_six_month = 1;

// Display scholarships grouped by country
foreach ($grouped_scholarships as $country => $scholarships) {
        if (count($scholarships) > 0) { 
    echo '<h1 style="padding-left:0px;padding-top:10px;padding-bottom:0px;font-size:20px;">' . $country . '</h1>';
    echo '<table class="striped-table" style="border-collapse: collapse; width: 100%;">';
    echo "<tr> <th> Scholarship Name </th> <th> Label </th>  <th> Past Deadline <br> (After 3 Months) </th>  </tr>";

    foreach ($scholarships as $scholarship) {
        echo "<tr>";
        echo '<td>' . $count_six_month . ' - <a href="' . site_url() . '/wp-admin/post.php?post=' . $scholarship['id'] . '&action=edit">' . $scholarship['title'] . '</a></td>';

        echo "<td>";
        foreach ($scholarship['deadlines_bachelor'] as $bachelor_deadline) {
            echo $bachelor_deadline['label'] . "<br>";
        }
        foreach ($scholarship['deadlines_master'] as $master_deadline) {
            echo $master_deadline['label'] . "<br>";
        }
        echo "</td>"; 

                echo "<td>";
        foreach ($scholarship['deadlines_bachelor'] as $bachelor_deadline) {
            if (isset($bachelor_deadline['no_degree_selected']) && $bachelor_deadline['no_degree_selected']) {
                echo "Bachelor's and Master's : " . $bachelor_deadline['deadline'] . "<br>";
            } else {
                echo "Bachelor's : " . $bachelor_deadline['deadline'] . "<br>";
            }
        }
        foreach ($scholarship['deadlines_master'] as $master_deadline) {
            if (isset($master_deadline['no_degree_selected']) && $master_deadline['no_degree_selected']) {
                echo "Bachelor's and Master's : " . $master_deadline['deadline'] . "<br>";
            } else {
                echo "Master's : " . $master_deadline['deadline'] . "<br>";
            }
        }
        echo "</td>";

        echo "</tr>";
        $count_six_month++;
    }
    echo "</table>";
}
}






?>


</div>








<div id="onemonth">
  <br>
<p style="font-size:23px;"> 3 - Past Deadline (After 1 Month) </p>
<hr>

<?php 



// Fetch all scholarships
$scholarship_args = array(
    'post_type'      => 'scholarships',
    'posts_per_page' => -1,
);

$scholarship_query = new WP_Query($scholarship_args);
$scholarships = array();

// Process scholarships and group by country
$grouped_scholarships = array();

$currentDate = time();
$onemonthAgo = strtotime('-1 month', $currentDate);

if ($scholarship_query->have_posts()) {
    while ($scholarship_query->have_posts()) {
        $scholarship_query->the_post();
        $scholarship_id = get_the_ID();
       $has_found_row = false;
        $institution = get_field('scholarship_institution', $scholarship_id);
        if ($institution) {
            $city = get_post($institution->cities);
            if ($city) {
                $country_name = get_post_meta($city->ID, 'country', TRUE);

                if (!isset($grouped_scholarships[$country_name])) {
                    $grouped_scholarships[$country_name] = array();
                }

                $scholarship_data = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'link'  => get_permalink(),
                    'deadlines_bachelor' => array(),
                    'deadlines_master' => array()
                );


                if (have_rows('scholarship_deadlines', $scholarship_id)) {
                    while (have_rows('scholarship_deadlines', $scholarship_id)) {
                        the_row();

                        $degree_value = get_sub_field('degree');
                        $deadline_date = get_sub_field('deadline');
                        
                        if(empty($deadline_date)){
                            continue;
                        }

                        $label = get_sub_field('label');
                        $deadline_timestamp = strtotime($deadline_date);

                     if ($deadline_timestamp && $deadline_timestamp <= $currentDate && $deadline_timestamp <= $onemonthAgo && $deadline_timestamp >= $threemonthAgo) {
                            if ($degree_value == "Bachelor's") {
                                $scholarship_data['deadlines_bachelor'][] = array(
                                    'label' => $label,
                                    'deadline' => $deadline_date
                                );
                                $has_found_row = true;
                            } elseif ($degree_value == "Master's") {
                                $scholarship_data['deadlines_master'][] = array(
                                    'label' => $label,
                                    'deadline' => $deadline_date
                                );
                                $has_found_row = true;
                            } else {
                                $scholarship_data['deadlines_bachelor'][] = array(
                                    'label' => $label,
                                    'deadline' => $deadline_date,
                                    'no_degree_selected' => true
                                );
                                $has_found_row = true;
                            }
                        }
                    }
                }
                if(empty($has_found_row)){
            continue;
        }
                $grouped_scholarships[$country_name][] = $scholarship_data;
            }
        }
    }
    wp_reset_postdata();
}


$count_six_month = 1;

// Display scholarships grouped by country
foreach ($grouped_scholarships as $country => $scholarships) {
        if (count($scholarships) > 0) { 
    echo '<h1 style="padding-left:0px;padding-top:10px;padding-bottom:0px;font-size:20px;">' . $country . '</h1>';
    echo '<table class="striped-table" style="border-collapse: collapse; width: 100%;">';
    echo "<tr> <th> Scholarship Name </th> <th> Label </th>  <th> Past Deadline <br> (After 1 Month) </th>  </tr>";

    foreach ($scholarships as $scholarship) {
        echo "<tr>";
        echo '<td>' . $count_six_month . ' - <a href="' . site_url() . '/wp-admin/post.php?post=' . $scholarship['id'] . '&action=edit">' . $scholarship['title'] . '</a></td>';

        echo "<td>";
        foreach ($scholarship['deadlines_bachelor'] as $bachelor_deadline) {
            echo $bachelor_deadline['label'] . "<br>";
        }
        foreach ($scholarship['deadlines_master'] as $master_deadline) {
            echo $master_deadline['label'] . "<br>";
        }
        echo "</td>"; 

                echo "<td>";
        foreach ($scholarship['deadlines_bachelor'] as $bachelor_deadline) {
            if (isset($bachelor_deadline['no_degree_selected']) && $bachelor_deadline['no_degree_selected']) {
                echo "Bachelor's and Master's : " . $bachelor_deadline['deadline'] . "<br>";
            } else {
                echo "Bachelor's : " . $bachelor_deadline['deadline'] . "<br>";
            }
        }
        foreach ($scholarship['deadlines_master'] as $master_deadline) {
            if (isset($master_deadline['no_degree_selected']) && $master_deadline['no_degree_selected']) {
                echo "Bachelor's and Master's : " . $master_deadline['deadline'] . "<br>";
            } else {
                echo "Master's : " . $master_deadline['deadline'] . "<br>";
            }
        }
        echo "</td>";

        echo "</tr>";
        $count_six_month++;
    }
    echo "</table>";
}
}




?>
</div>

<div id="week">
  <br>
<p style="font-size:23px;"> 4 - Past Deadline (After 1 Week) </p>
<hr>

<?php 




// Fetch all scholarships
$scholarship_args = array(
    'post_type'      => 'scholarships',
    'posts_per_page' => -1,
);

$scholarship_query = new WP_Query($scholarship_args);
$scholarships = array();

// Process scholarships and group by country
$grouped_scholarships = array();

$currentDate = time();
$oneweekAgo = strtotime('-1 week', $currentDate);

if ($scholarship_query->have_posts()) {
    while ($scholarship_query->have_posts()) {
        $scholarship_query->the_post();
        $scholarship_id = get_the_ID();
       $has_found_row = false;
        $institution = get_field('scholarship_institution', $scholarship_id);
        if ($institution) {
            $city = get_post($institution->cities);
            if ($city) {
                $country_name = get_post_meta($city->ID, 'country', TRUE);

                if (!isset($grouped_scholarships[$country_name])) {
                    $grouped_scholarships[$country_name] = array();
                }

                $scholarship_data = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'link'  => get_permalink(),
                    'deadlines_bachelor' => array(),
                    'deadlines_master' => array()
                );


                if (have_rows('scholarship_deadlines', $scholarship_id)) {
                    while (have_rows('scholarship_deadlines', $scholarship_id)) {
                        the_row();

                        $degree_value = get_sub_field('degree');
                        $deadline_date = get_sub_field('deadline');
                        
                        if(empty($deadline_date)){
                            continue;
                        }

                        $label = get_sub_field('label');
                        $deadline_timestamp = strtotime($deadline_date);

                 if ($deadline_timestamp && $deadline_timestamp <= $currentDate && $deadline_timestamp <= $oneweekAgo && $deadline_timestamp >= $onemonthAgo) {
                            if ($degree_value == "Bachelor's") {
                                $scholarship_data['deadlines_bachelor'][] = array(
                                    'label' => $label,
                                    'deadline' => $deadline_date
                                );
                                $has_found_row = true;
                            } elseif ($degree_value == "Master's") {
                                $scholarship_data['deadlines_master'][] = array(
                                    'label' => $label,
                                    'deadline' => $deadline_date
                                );
                                $has_found_row = true;
                            } else {
                                $scholarship_data['deadlines_bachelor'][] = array(
                                    'label' => $label,
                                    'deadline' => $deadline_date,
                                    'no_degree_selected' => true
                                );
                                $has_found_row = true;
                            }
                        }
                    }
                }
                if(empty($has_found_row)){
            continue;
        }
                $grouped_scholarships[$country_name][] = $scholarship_data;
            }
        }
    }
    wp_reset_postdata();
}


$count_six_month = 1;

// Display scholarships grouped by country
foreach ($grouped_scholarships as $country => $scholarships) {
        if (count($scholarships) > 0) { 
    echo '<h1 style="padding-left:0px;padding-top:10px;padding-bottom:0px;font-size:20px;">' . $country . '</h1>';
    echo '<table class="striped-table" style="border-collapse: collapse; width: 100%;">';
    echo "<tr> <th> Scholarship Name </th> <th> Label </th>  <th> Past Deadline <br> (After 1 Week) </th>  </tr>";

    foreach ($scholarships as $scholarship) {
        echo "<tr>";
        echo '<td>' . $count_six_month . ' - <a href="' . site_url() . '/wp-admin/post.php?post=' . $scholarship['id'] . '&action=edit">' . $scholarship['title'] . '</a></td>';

        echo "<td>";
        foreach ($scholarship['deadlines_bachelor'] as $bachelor_deadline) {
            echo $bachelor_deadline['label'] . "<br>";
        }
        foreach ($scholarship['deadlines_master'] as $master_deadline) {
            echo $master_deadline['label'] . "<br>";
        }
        echo "</td>"; 

                echo "<td>";
        foreach ($scholarship['deadlines_bachelor'] as $bachelor_deadline) {
            if (isset($bachelor_deadline['no_degree_selected']) && $bachelor_deadline['no_degree_selected']) {
                echo "Bachelor's and Master's : " . $bachelor_deadline['deadline'] . "<br>";
            } else {
                echo "Bachelor's : " . $bachelor_deadline['deadline'] . "<br>";
            }
        }
        foreach ($scholarship['deadlines_master'] as $master_deadline) {
            if (isset($master_deadline['no_degree_selected']) && $master_deadline['no_degree_selected']) {
                echo "Bachelor's and Master's : " . $master_deadline['deadline'] . "<br>";
            } else {
                echo "Master's : " . $master_deadline['deadline'] . "<br>";
            }
        }
        echo "</td>";

        echo "</tr>";
        $count_six_month++;
    }
    echo "</table>";
}
}









?>


</div>













</div>


<style type="">
    td, th{
        text-align:left !important;
    border: 1px solid #cdcdcd; padding: 5px;
}
th {
    background: #f7f7f7 !important;
}
 .striped-table {
            border-collapse: collapse;
            width: 100%;
        }

        .striped-table td {
           
            padding: 10px;
        }

        .striped-table tr:nth-child(even) {
            background-color: #f7f7f7;
        }

        .activeee {
            color:black !important;
            font-weight: 700;
           
            padding-bottom:5px;
        }

  .link-for-past a {
    padding-bottom:5px;
   margin-left:15px !important;
    margin-right:15px;font-size:14px;
    color:black !important;
   }
 .fixed-div {
    padding-top:10px;
    padding-bottom:10px;
  position: fixed;
  background: white !important;
  width:100% !important;
  z-index: 1000; /* Ensure the div stays on top of other content */
}

</style>


<script type="text/javascript">
     jQuery(document).ready(function () {
            jQuery('.link-for-past a').on('click', function (event) {
                

                // Remove the 'activee' class from all <a> tags
                jQuery('.link-for-past a').removeClass('activeee');

                // Add the 'activee' class to the clicked <a> tag
                jQuery(this).addClass('activeee');
            });
        });


     jQuery(document).ready(function() {
  var fixedDiv = jQuery('.fixed-div');
  var originalTopPosition = fixedDiv.offset().top;

  jQuery(window).scroll(function() {
    var scrollTop = jQuery(window).scrollTop();

    if (scrollTop >= 300) {
      fixedDiv.css({
        position: 'fixed',
        top: 0,
        background: '#f7f7f7',
        paddingTop:'40px'
      });
    } else {
      fixedDiv.css({
        position: 'static',
      });
    }
  });
});
</script>




</div>




<?php get_footer(); ?>