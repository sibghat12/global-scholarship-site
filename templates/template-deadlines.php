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

$countries_list = get_the_countries();

?>

<?php get_header();  ?>
<article id="template-deadlines-by-country" class="deadlines-by-country">

<h1>Deadlines By Country</h1>

    <?php foreach($countries_list as $index => $country) : ?>
        <?php
           $gs_institutions_scholarships = get_scholarships_by_country($country);

            

            $gs_country = $gs_institutions_scholarships['country'];
            $gs_institutions = $gs_institutions_scholarships['institutions'];
            echo "<h2>" . $gs_country ."</h2>";

            echo '<table class="data-table">';
            ?>
            <thead>
                <tr>
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
                $institution_deadline = $institution_admissions_deadline['deadline'];
                $institution_label = $institution_admissions_deadline['label'];
                $institution_degree = $institution_admissions_deadline['degree'];
                
                // Institutions Rows
                foreach($institution_admissions_deadlines as $institution_admissions_deadline) {
                    echo "<tr>";
                    $institution_deadline = $institution_admissions_deadline['deadline'];
                    $institution_last_updated = get_the_modified_date('Y-m-d', $gs_single_institution);
                    $institution_label = $institution_admissions_deadline['label'];
                    $institution_degree = $institution_admissions_deadline['degree'];
                    $institution_title = get_the_title($gs_single_institution);
                    $institution_last_author = get_the_last_modified_user_name($gs_single_institution);

                    $author_id = get_post_field('post_author', $gs_single_institution); // Get the author ID of the post
                    $author = get_user_by('id', $author_id); // Get the user object for the author ID

                    $institution_author_name = $author->display_name;

                    if( isset($institution_deadline) && !empty( $institution_deadline) ) :
                        echo "<td>" . $institution_deadline ."</td>";
                    else:
                        echo "<td></td>";
                    endif;
                    if( isset($institution_last_updated) && !empty( $institution_last_updated) ) :
                        echo "<td>" . $institution_last_updated ."</td>";
                    else:
                        echo "<td></td>";
                    endif;
                    if( isset($institution_title) && !empty( $institution_title) ) :
                        echo "<td>" . $institution_title ."</td>";
                    else:
                        echo "<td></td>";
                    endif;
                    if( isset($institution_degree) && !empty( $institution_degree) ) :
                        echo "<td>" . $institution_degree ."</td>";
                    else:
                        echo "<td></td>";
                    endif;
                    if( isset($institution_label) && !empty( $institution_label) ) :
                        echo "<td>" . $institution_label ."</td>";
                    else:
                        echo "<td></td>";
                    endif;
                    if( isset($institution_last_author) && !empty( $institution_last_author) ) :
                        echo "<td>" . $institution_last_author ."</td>";
                    else:
                        echo "<td>". $institution_author_name ."</td>";
                    endif;
                    
                    

                    echo "</tr>";
                }

                // Scholarships Rows

                foreach($the_scholarships as $key => $scholarship ) {

                    $scholarship_deadlines = get_field('scholarship_deadlines', $scholarship);

                    if(isset($scholarship_deadlines) && !empty($scholarship_deadlines)) {
                        $scholarship_deadline = $scholarship_deadlines['deadline'];
                        $scholarship_last_updated = get_the_modified_date('Y-m-d', $scholarship);
                        $scholarship_label = $scholarship_deadlines['label'];
                        $scholarship_degree = $scholarship_deadlines['degree'];
                        $scholarship_title = get_the_title($scholarship);
                        $scholarship_last_author = get_the_last_modified_user_name($scholarship);

                        $scholarship_author_id = get_post_field('post_author', $scholarship); // Get the author ID of the post
                        $scholarship_author = get_user_by('id', $scholarship_author_id); // Get the user object for the author ID
    
                        $scholarship_author_name = $scholarship_author->display_name;

                        echo "<tr>";
    
                        if( isset($scholarship_deadline) && !empty( $scholarship_deadline) ) :
                            echo "<td>" . $scholarship_deadline ."</td>";
                        else:
                            echo "<td></td>";
                        endif;
                        if( isset($scholarship_last_updated) && !empty( $scholarship_last_updated) ) :
                            echo "<td>" . $scholarship_last_updated ."</td>";
                        else:
                            echo "<td></td>";
                        endif;
                        if( isset($scholarship_title) && !empty( $scholarship_title) ) :
                            echo "<td>" . $scholarship_title ."</td>";
                        else:
                            echo "<td></td>";
                        endif;
                        if( isset($scholarship_degree) && !empty( $scholarship_degree) ) :
                            echo "<td>" . $scholarship_degree ."</td>";
                        else:
                            echo "<td></td>";
                        endif;
                        if( isset($scholarship_label) && !empty( $scholarship_label) ) :
                            echo "<td>" . $scholarship_label ."</td>";
                        else:
                            echo "<td></td>";
                        endif;
                        if( isset($scholarship_last_author) && !empty( $scholarship_last_author) ) :
                            echo "<td>" . $scholarship_last_author ."</td>";
                        else:
                            echo "<td>" . $scholarship_author_name . "</td>";
                        endif;


                        echo "</tr>";
                    }

                    // echo '<pre>';
                    // print_r($scholarship_deadlines);
                    // echo '</pre>';
                    
                }
                
            endforeach;
                echo "</tbody>";

            ?>

            <?php
            echo '</table>';


            ?>

    <?php endforeach; ?>

    
</article>

<?php get_footer(); ?>
