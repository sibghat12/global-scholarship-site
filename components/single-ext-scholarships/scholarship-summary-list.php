<?php

    // Eligible Nationalities (Countries)

    $eligible_nationalities_string = '';
    asort($eligible_nationalities);

    $eligible_nationalities = explode(",", str_replace("\'", "", implode(",", $eligible_nationalities)));

    $nationality_array_original = explode(",", str_replace("'", "", implode(",", $nationality_array_original)));


    if($eligible_nationalities) {
        $eligible_nationalities_array = array_combine($eligible_nationalities, $eligible_nationalities);
    }

    if($eligible_nationalities_array) {
        $diff_eligible_nationalities_array = array_diff($nationality_array_original, $eligible_nationalities_array);
    }

    if(count($diff_eligible_nationalities_array) < 20) {

        if(in_array("All Nationalities", $eligible_nationalities)) {
            $eligible_nationalities_string .= "All Nationalities";
        } else {
            array_shift($diff_eligible_nationalities_array);
            $eligible_nationalities_string .= "All Nationalities except " . convert_array_to_text($diff_eligible_nationalities_array);
        }

    } else {

        if(in_array("All Nationalities", $eligible_nationalities)) {
            $eligible_nationalities_string .= "All Nationalities";
        } else {
            $eligible_nationalities_string .= convert_array_to_text($eligible_nationalities);
        }

    }




    // Eligible Programs (Subjects)

    $programs_string = '';
    asort($programs);

    $programs = explode(",", str_replace("\'", "", implode(",", $programs)));

    $programs_array_original = explode(",", str_replace("'", "", implode(",", $programs_array_original)));


    if($programs) {
        $programs_array = array_combine($programs, $programs);
    }

    if($programs_array) {
        $diff_programs_array = array_diff($programs_array_original, $programs_array);
    }

    if(count($diff_programs_array) < 20) {

        if(in_array("All Subjects", $programs)) {
            $programs_string .= "All Programs";
        } else {
            array_shift($diff_programs_array);
            $programs_string .= "All Programs except " . convert_array_to_text($diff_programs_array);
        }

    } else {

        if(in_array("All Subjects", $programs)) {
            $programs_string .= "All Programs";
        } else {
            $programs_string .= convert_array_to_text($programs);
        }

    }

    // Eligible Institutions (||) Eligible Country's Institutions
    $gs_eligible_places = '';

    asort($eligible_institution_countries);
    asort($eligible_institutions);


    if($eligible_institution_countries) {
        $eligible_institution_countries_array = array_combine($eligible_institution_countries, $eligible_institution_countries);
    }

    if($eligible_institutions) {
        $eligible_institutions_array = array_combine($eligible_institutions, $eligible_institutions);
    }
    $gs_eligible_institutions = convert_array_to_text($eligible_institutions);
    $gs_eligible_countries = generate_countries_universities_text($eligible_institution_countries);

    if ($eligible_institution_countries) {
        if(in_array("All Universities Worldwide", $eligible_institution_countries_array)) {
            $gs_eligible_places .= "All Universities Worldwide";
        } else {
            $gs_eligible_places .= $gs_eligible_countries;
        }
    } elseif ($eligible_institutions) {
        $gs_eligible_places .= $gs_eligible_institutions;
}


?>
<ul>

    <li>Level of Study: <b><?php echo $degrees_text; ?></b></li>
    <?php if($scholarship_host_country) : ?>
        <li>Host Country: <b><?php echo $scholarship_host_country; ?></b></li>
    <?php endif; ?>
    <?php if($scholarship_funded_by): ?>
        <li>Offered By: <b><?php echo $scholarship_funded_by ?></b></li>
    <?php endif; ?>
    <input type="hidden" class="gs-ext-scholarship-eligible-nationalities" value="<?php echo $eligible_nationalities_string; ?>" />
    <li>  Eligible Countries:  
        <div class="gs-ext-scholarship-nationalities-container">
            <b class="gs-ext-scholarship-nationalities"></b>
            <?php if($eligible_nationalities_string != 'All Nationalities' && ((count($eligible_nationalities_array) > 3 && count($diff_eligible_nationalities_array) > 3))) : ?>
                <span class="show_more"><span class="ellipsis">...</span> <a href="#" id="toggle-link">Show more</a></span>
            <?php endif; ?>
        </div>
    </li>
    <input type="hidden" class="gs-ext-scholarship-eligible-programs" value="<?php echo $programs_string; ?>" />
    <li>  Eligible Programs:  
        <div class="gs-ext-scholarship-programs-container">
            <b class="gs-ext-scholarship-programs"></b>
            <?php if($programs_string != 'All Programs' && ((count($programs_array) > 3 && count($diff_programs_array) > 3))) : ?>
                <span class="show_more"><span class="ellipsis">...</span> <a href="#" id="toggle-link">Show more</a></span>
            <?php endif; ?>
        </div>
    </li>
    <input type="hidden" class="gs-ext-scholarship-eligible-institutions" value="<?php echo $gs_eligible_places; ?>" />
    <li>Eligible Universities: 
        <div class="gs-ext-scholarship-eligible-universities-container">
                <b class="gs-ext-scholarship-eligible-universities"></b>
                <?php  if($eligible_institution_countries) : ?>
                    <?php if($gs_eligible_places != 'All Universities Worldwide' && (count($eligible_institution_countries_array) > 3 )) : ?>
                        <span class="show_more"><span class="ellipsis">...</span> <a href="#" id="toggle-link">Show more</a></span>
                    <?php endif; ?>
                <?php elseif($eligible_institutions): ?>
                    <?php if (count($eligible_institutions_array) > 3 ) : ?>
                        <span class="show_more"><span class="ellipsis">...</span> <a href="#" id="toggle-link">Show more</a></span>
                    <?php endif; ?>
                <?php endif; ?>
        </div>
    </li>
    
    <?php if ($number_of_recipients > 0) { ?>
        <li> Number of Recipients: <b> <?php echo $number_of_recipients; ?> </b> </li>
    <?php } else {

        echo "<li>Number of Recipients: <b>Not Specified</b> </li>";
    } ?>

    <li>Scholarship Type: <b><?php echo $scholarship_category; ?> </b></li>
    <?php if ($scholarship_amount > 0) { ?>
        <li>Scholarship Amount: <b><?php echo number_format($scholarship_amount); ?>
        <?php echo $currency; ?></b></li>
    <?php    }  ?>    

    <?php
    $scholarship_duration_html='';
    if ($scholarship_duration) {
        $duration_text = '';
        $similar_duration = true;
        $same_number = $scholarship_duration[0]['number'];
        $same_label = $scholarship_duration[0]['label'];
    
        foreach ($scholarship_duration as $duration) {
            $duration_text .= '<li>' . $duration['degrees'] . ': ' . $duration['number'] . ' ' . $duration['label'] . '</li>';
            if ($duration['number'] !== $same_number || $duration['label'] !== $same_label) {
                $similar_duration = false;
            }
        }
    
        if ($similar_duration) {
            $duration_text = '<li>';
            foreach ($scholarship_duration as $key => $duration) {
                $duration_text .= $duration['degrees'];
                if ($key !== count($scholarship_duration) - 1) {
                    $duration_text .= ' and ';
                }
            }
            $duration_text .= ': '. $same_number . ' ' . $same_label . '</li>';
        }
    
        $scholarship_duration_html .= '<ul class="gs-ext-scholarships-duration">' . $duration_text . '</ul>';
    } 
    ?>
    <li>Scholarship Duration: <?php echo $scholarship_duration_html; ?></li>
    
    
    <li>Scholarship Type: <b><?php echo $scholarship_type; ?> </b> </li>

    <?php
$current_date = strtotime(date("Y-m-d")); // Get current date
$deadline_text = '';


// Variables to track criteria for common deadline display
$all_accepts_application_all_year_round = true;
$all_deadlines_same_date = true;
$common_deadline = null;

foreach ($scholarship_deadlines as $index => $deadline) {
    $deadline_date = strtotime($deadline['deadline']);

        if ($deadline['accepts_application_all_year_round'] !== 'Yes') {
            $all_accepts_application_all_year_round = false;
        }
        if ($deadline_date !== $common_deadline) {
            $all_deadlines_same_date = false;
        }
    
    
}


if ($all_accepts_application_all_year_round) {
    $deadline_text = 'Accept Application All Year';
    echo '<li>Application Deadline: <b>' . $deadline_text . '</b></li>';

} else {
    // Check if all deadlines have 'accepts_application_all_year_round' as 'No'

    if ($all_deadlines_same_date) {
        $formatted_common_deadline = date("F j, Y", $common_deadline);
        if ($current_date >= $common_deadline) {
            $deadline_text = "$formatted_common_deadline (Past Deadline)";
        } else {
            $deadline_text = "$formatted_common_deadline (Current Deadline)";
        }
        echo '<li>Application Deadline: <b>' . $deadline_text . '</b></li>';
    } else {
        echo '<li>Application Deadline: <ul>';
        
        foreach ($scholarship_deadlines as $deadline) {
            $deadline_date = strtotime($deadline['deadline']);
            $formatted_deadline = date("F j, Y", $deadline_date);

            if ($deadline['accepts_application_all_year_round'] === 'Yes') {
                $deadline_text = 'Accept Application All Year';
            } else {
                if ($current_date >= $deadline_date) {
                    $deadline_text = $formatted_deadline . ' (Past Deadline)';
                } else {
                    $deadline_text = $formatted_deadline . ' (Open)';
                }
            }
            echo '<li>' . $deadline['degree'] . ': <b>'. $deadline_text .'</b></li>';
        }

        echo '</ul></li>';
    }
}
?>

    <?php
    // $current_date = strtotime(date("Y-m-d")); // Get current date
    // $deadline_text = '';

    // // Variables to track criteria for common deadline display
    // $all_accepts_application_all_year_round = false;
    // $all_deadlines_same_date = false;
    // $common_deadline = null;

    // foreach ($scholarship_deadlines as $index => $deadline) {
    //     $deadline_date = strtotime($deadline['deadline']);

    //     if ($index === 0) {
    //         $common_deadline = $deadline_date;
    //     } else {
    //         if ($deadline['accepts_application_all_year_round'] == $scholarship_deadlines[$index - 1]['accepts_application_all_year_round']) {
    //             $all_accepts_application_all_year_round = true;
    //         }
    //         if ($deadline_date == $common_deadline) {
    //             $all_deadlines_same_date = true;
    //         }
    //     }

    // }

    // if ($all_accepts_application_all_year_round && $all_deadlines_same_date) {
    //     if ($all_accepts_application_all_year_round) {
    //         $deadline_text = 'Accept Application All Year';
    //     } elseif ($all_deadlines_same_date && $common_deadline !== null) {
    //         $formatted_common_deadline = date("F j, Y", $common_deadline);
    //         if ($current_date >= $common_deadline) {
    //             $deadline_text = "$formatted_common_deadline (Past Deadline)";
    //         } else {
    //             $deadline_text = "$formatted_common_deadline (Current Deadline)";
    //         }
    //     }

    //     echo '<li>Application Deadline: <b>' . $deadline_text . '</b></li>';
    // } else {
    //     // Display individual deadlines if they don't meet the common criteria
    //     echo '<li>Application Deadline: <ul>';

    //     foreach ($scholarship_deadlines as $deadline) {
    //         $deadline_date = strtotime($deadline['deadline']);
    //         $formatted_deadline = date("F j, Y", $deadline_date);

    //         if ($deadline['accepts_application_all_year_round'] === 'Yes') {
    //             $deadline_text = 'Accept Application All Year';
    //         } else {
    //             if ($current_date >= $deadline_date) {
    //                 $deadline_text = $formatted_deadline . ' (Past Deadline)';
    //             } else {
    //                 $deadline_text = $formatted_deadline . ' (Open)';
    //             }
    //         }
    //         echo '<li>' . $deadline['degree'] . ': <b>'. $deadline_text .'</b></li>';
    //     }

    //     echo '</ul></li>';
    // }
?>


    <!-- <li>Application Deadline:  -->

    <?php
        // //Scholarship Deadline
        // $current_date = strtotime(date("Y-m-d")); // Get current date
        // $deadline_text = '';
        // echo '<ul>';

        // foreach ($scholarship_deadlines as $deadline) {
        //     $deadline_date = strtotime($deadline['deadline']);
        //     $formatted_deadline = date("F j, Y", $deadline_date);


        //     if ($deadline['accepts_application_all_year_round'] === 'Yes') {
        //         $deadline_text = 'Accept Application All Year';
        //     } else {
        //         if ($current_date >= $deadline_date) {
        //             $deadline_text = $formatted_deadline . ' (Past Deadline)';
        //         } else {
        //             $deadline_text = $formatted_deadline . ' (Open)';
        //         }
        //     }
        //     echo '<li>' . $deadline['degree'] . ': '. $deadline_text .'</li>';


        // }

        // echo '</ul>';
    ?>
    <!-- </li> -->
</ul>
