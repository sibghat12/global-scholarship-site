<?php
/**
 * Template Name: Deadlines By Country
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

$countries_list = get_gs_countries();
$today_date = strtotime(date("F j, Y"));
$params = get_query_info();

$country        = $params["country"];
$country = ucwords($country);



?>

<?php get_header();  ?>
<article id="template-deadlines-by-country" class="deadlines-by-country">

<h1>Deadlines By Country</h1>

        <?php
           $gs_institutions_scholarships = get_scholarships_by_country($country);

            

            $gs_country = $gs_institutions_scholarships['country'];
            $gs_institutions = $gs_institutions_scholarships['institutions'];
            $available_institutions_country_count = count($gs_institutions);
            echo "<h2>(" . $gs_country . ")  Institutions Count: $available_institutions_country_count"."</h2>";

            echo '<table class="table table-bordered data-table" style="width:100%">';
            ?>
            <thead>
                <tr>
                    <th class="th-title">Opening Date</th>
                    <th class="th-title">Deadline</th>
                    <th class="th-title">Last Updated</th>
                    <th class="th-title">University/Scholarship Name</th>
                    <th class="th-title">Degree</th>
                    <th class="th-title">Label</th>
                    <th class="th-title">Status</th>
                    <th class="th-title">Updated by</th>
                </tr>
            </thead>
            <?php
                echo "<tbody>";
            foreach($gs_institutions as $key => $gs_single_institution) :
                
                // Scholarships Data
                $scholarships_per_institition = get_scholarships($gs_single_institution);
                $the_scholarships = $scholarships_per_institition->posts;

                // Institutions Data
                $institution_admissions_deadlines = get_field('admission_deadlines', $gs_single_institution);
                // $institution_deadline = $institution_admissions_deadline['deadline'];
                // $institution_label = $institution_admissions_deadline['label'];
                // $institution_degree = $institution_admissions_deadline['degree'];
                
            // Institutions Rows
            if(isset($institution_admissions_deadlines) && !empty($institution_admissions_deadlines)) :
                foreach($institution_admissions_deadlines as $institution_admissions_deadline) {
                    echo "<tr>";
                    $institution_accept_all_year = $institution_admissions_deadline['accepts_application_all_year_round'];
                    $institution_opening_date = $institution_admissions_deadline['open_date'];
                    $institution_deadline = $institution_admissions_deadline['deadline'];
                    $institution_last_updated = get_the_modified_date('', $gs_single_institution);
                    $institution_label = $institution_admissions_deadline['label'];
                    $institution_degree = $institution_admissions_deadline['degree'];
                    $institution_title = get_the_title($gs_single_institution);
                    $institution_permalink = get_the_permalink($gs_single_institution);
                    $institution_last_author = get_the_last_modified_user_name($gs_single_institution);
                    $institution_target_date = strtotime($institution_deadline);
                    $author_id = get_post_field('post_author', $gs_single_institution); // Get the author ID of the post
                    $author = get_user_by('id', $author_id); // Get the user object for the author ID

                    $institution_author_name = $author->display_name;

                    $institution_deadline_sort_date = $institution_deadline;
                    $timestampinstitutedeadline = strtotime($institution_deadline_sort_date);
                    $formattedDateInstituteDeadline = date("Ymd", $timestampinstitutedeadline);

                    $institution_opening_date_sort_date = $institution_opening_date;
                    $timestampinstituteopening = strtotime($institution_opening_date_sort_date);
                    $formattedDateInstituteOpening = date("Ymd", $timestampinstituteopening);

                    $institution_last_updated_sort_date = $institution_last_updated;
                    $timestampinstitutelastupdated = strtotime($institution_last_updated_sort_date);
                    $formattedDateInstituteLastUpdated = date("Ymd", $timestampinstitutelastupdated);

                    

                    if($institution_accept_all_year == 'No') {
                        if(isset($institution_opening_date) && !empty($institution_opening_date)) {
                            echo "<td data-order=".$formattedDateInstituteOpening.">" . $institution_opening_date . "</td>";
                        } else {
                            echo "<td data-order=".$formattedDateInstituteOpening."></td>";
                        }
                    } elseif($institution_accept_all_year == 'Yes') {
                        echo "<td data-order=".$formattedDateInstituteOpening.">" ."OPEN ALL YEAR" . "</td>";
                    }

                    if($institution_accept_all_year == 'No') {
                        if(isset($institution_deadline) && !empty($institution_deadline)) {
                            echo "<td data-order=".$formattedDateInstituteDeadline.">" . $institution_deadline . "</td>";
                        } else {
                            echo "<td data-order=".$formattedDateInstituteDeadline."></td>";
                        }
                    } elseif($institution_accept_all_year == 'Yes') {
                        echo "<td data-order=".$formattedDateInstituteDeadline.">" ."OPEN ALL YEAR" . "</td>";
                    }
                    if( isset($institution_last_updated) && !empty( $institution_last_updated) ) :
                        echo "<td data-order=".$formattedDateInstituteLastUpdated.">". $institution_last_updated ."</td>";
                    else:
                        echo "<td data-order=".$formattedDateInstituteLastUpdated."></td>";
                    endif;
                    if( isset($institution_title) && !empty( $institution_title) ) :
                        echo "<td><a href=". $institution_permalink .">" . $institution_title ."</a></td>";
                    else:
                        echo "<td></td>";
                    endif;
                    if( isset($institution_degree) && !empty( $institution_degree) ) :
                        echo "<td>" . $institution_degree ."</td>";
                    else:
                        echo "<td>Bachelor’s and Master’s</td>";
                    endif;
                    if( isset($institution_label) && !empty( $institution_label) ) :
                        echo "<td>" . $institution_label ."</td>";
                    else:
                        echo "<td></td>";
                    endif;
                    if( isset($institution_target_date) && !empty( $institution_target_date) ) :
                        if( $today_date < $institution_target_date ) :
                            echo "<td data-status='oepn'>OPEN</td>";
                        else:
                            echo "<td data-status='closed'>CLOSED</td>";
                        endif;
                    else:
                        echo "<td data-status='empty'></td>";
                    endif;
                    if( isset($institution_last_author) && !empty( $institution_last_author) ) :
                        echo "<td>" . $institution_last_author ."</td>";
                    else:
                        echo "<td>". $institution_author_name ."</td>";
                    endif;
                    
                    echo "</tr>";
                }
            endif;

                // Scholarships Rows

                foreach($the_scholarships as $key => $scholarship ) {

                    $scholarship_deadlines = get_field('scholarship_deadlines', $scholarship);

                    if(isset($scholarship_deadlines) && !empty($scholarship_deadlines)) {

                        foreach($scholarship_deadlines as $scholarship_deadline) {

                            $the_scholarship_opening_date = $scholarship_deadline['open_date'];
                            $the_scholarship_deadline = $scholarship_deadline['deadline'];
                            $the_scholarship_label = $scholarship_deadline['label'];
                            $the_scholarship_degree = $scholarship_deadline['degree'];
                            $scholarship_target_date = strtotime($the_scholarship_deadline);

                            $the_scholarship_deadline_sort_date = $the_scholarship_deadline;
                            $timestampscholarshipsdeadline = strtotime($the_scholarship_deadline_sort_date);
                            $formattedDateScholarshipsDeadline = date("Ymd", $timestampscholarshipsdeadline);

                            
                            $the_scholarship_opening_date_sort_date = $the_scholarship_opening_date;
                            $timestampscholarshipsopening = strtotime($the_scholarship_opening_date_sort_date);
                            $formattedDateScholarshipsOpening = date("Ymd", $timestampscholarshipsopening);


                        }
                        
                        $the_scholarship_last_updated = get_the_modified_date('', $scholarship);
                        $scholarship_title = get_the_title($scholarship);
                        $scholarship_permalink = get_the_permalink($scholarship);
                        $scholarship_last_author = get_the_last_modified_user_name($scholarship);

                        $scholarship_author_id = get_post_field('post_author', $scholarship); // Get the author ID of the post
                        $scholarship_author = get_user_by('id', $scholarship_author_id); // Get the user object for the author ID
    
                        $scholarship_author_name = $scholarship_author->display_name;

                        
                        $scholarship_last_updated_sort_date = $the_scholarship_last_updated;
                        $timestampscholarshiplastupdated = strtotime($scholarship_last_updated_sort_date);
                        $formattedDateScholarshipLastUpdated = date("Ymd", $timestampscholarshiplastupdated);

                        echo "<tr>";
    
                        if( isset($the_scholarship_opening_date) && !empty( $the_scholarship_opening_date) ) :
                            echo "<td data-order=".$formattedDateScholarshipsOpening.">" . $the_scholarship_opening_date ."</td>";
                        else:
                            echo "<td data-order=".$formattedDateScholarshipsOpening."></td>";
                        endif;
                        if( isset($the_scholarship_deadline) && !empty( $the_scholarship_deadline) ) :
                            echo "<td data-order=".$formattedDateScholarshipsDeadline.">" . $the_scholarship_deadline ."</td>";
                        else:
                            echo "<td data-order=".$formattedDateScholarshipsDeadline."></td>";
                        endif;
                        if( isset($the_scholarship_last_updated) && !empty( $the_scholarship_last_updated) ) :
                            echo "<td data-order=".$formattedDateScholarshipLastUpdated.">" . $the_scholarship_last_updated ."</td>";
                        else:
                            echo "<td data-order=".$formattedDateScholarshipLastUpdated."></td>";
                        endif;
                        if( isset($scholarship_title) && !empty( $scholarship_title) ) :
                            echo "<td><a href=". $scholarship_permalink .">" . $scholarship_title ."</a></td>";
                        else:
                            echo "<td></td>";
                        endif;
                        if( isset($the_scholarship_degree) && !empty( $the_scholarship_degree) ) :
                            echo "<td>" . $the_scholarship_degree ."</td>";
                        else:
                            echo "<td>Master's and PhD</td>";
                        endif;
                        if( isset($the_scholarship_label) && !empty( $the_scholarship_label) ) :
                            echo "<td>" . $the_scholarship_label ."</td>";
                        else:
                            echo "<td></td>";
                        endif;
                        if( isset($scholarship_target_date) && !empty( $scholarship_target_date) ) :
                            if( $today_date < $scholarship_target_date ) :
                                echo "<td data-status='open'>OPEN</td>";
                            else:
                                echo "<td data-status='closed'>CLOSED</td>";
                            endif;
                        else:
                            echo "<td data-status='empty'></td>";
                        endif;
                        if( isset($scholarship_last_author) && !empty( $scholarship_last_author) ) :
                            echo "<td>" . $scholarship_last_author ."</td>";
                        else:
                            echo "<td>" . $scholarship_author_name . "</td>";
                        endif;

                        echo "</tr>";
                    }

                }
                
            endforeach;
                echo "</tbody>";

            ?>

            <?php
            echo '</table>';


            ?>


    
</article>

<?php get_footer(); ?>
