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
    $gs_eligible_countries = generate_countries_institutions_text($eligible_institution_countries);

    if ($eligible_institution_countries) {
        if(in_array("All Universities Worldwide", $eligible_institution_countries_array)) {
            $gs_eligible_places .= "All Universities Worldwide";
        } else {
            $gs_eligible_places .= $gs_eligible_countries;
        }
    } elseif ($eligible_institutions) {
        $gs_eligible_places .= $gs_eligible_institutions;
}

$offered_by_orgs = [];
if($scholarship_funded_by) {
    foreach($scholarship_funded_by as $scholarship_offered_org) {
        array_push($offered_by_orgs, $scholarship_offered_org['offered_by']);
    }
}

?>
<ul>

    <li>Level of Study: <b><?php echo $degrees_text; ?></b></li>
    <?php if($scholarship_host_country) : ?>
        <li>Host Country: <b><?php echo $scholarship_host_country; ?></b></li>
    <?php endif; ?>
    <?php if($scholarship_funded_by): ?>
        <li>Offered By: <b><?php echo convert_array_to_text($offered_by_orgs); ?></b></li>
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
    <li>Eligible Institutions: 
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
            $label = ($duration['number'] == 1) ? rtrim($duration['label'], 's') : $duration['label'];

            $duration_text .= '<li>' . $duration['degrees'] . ': <b>' . $duration['number'] . ' ' . $label . '</b></li>';
            if ($duration['number'] !== $same_number || $duration['label'] !== $same_label) {
                $similar_duration = false;
            }
        }
    
        if ($similar_duration) {
            // $degrees_count = count($scholarship_duration);
            $duration_text = '<span>';
            // foreach ($scholarship_duration as $key => $duration) {
            //     // $duration_text .= $duration['degrees'];
            //     // if ($key === $degrees_count - 2) {
            //     //     $duration_text .= ', and '; // Add a comma before the last degree
            //     // } elseif ($key !== $degrees_count - 1) {
            //     //     $duration_text .= ', ';
            //     // }
            // }
            $duration_text .= ': '. $same_number . ' ' . $label . '</span>';
            $scholarship_duration_html .= '<span class="gs-ext-scholarships-single-duration"><b>' . $duration_text . '</b></span>';

        } else {
            $scholarship_duration_html .= '<ul class="gs-ext-scholarships-duration">' . $duration_text . '</ul>';
        }
    
    } 
    ?>
    <li>Scholarship Duration: <?php echo $scholarship_duration_html; ?></li>
    
    
    <li>Scholarship Type: <b><?php echo $scholarship_type; ?> </b> </li>

    <?php
    if($scholarship_deadlines) {
        $current_date = date('Y-m-d'); // Current date in 'Y-m-d' format
    
        // Extracting unique deadlines and checking if all 'accepts_application_all_year_round' are 'Yes' or 'No'
        $unique_deadlines = array_unique(array_column($scholarship_deadlines, 'deadline'));
        $unique_acceptance = array_unique(array_column($scholarship_deadlines, 'accepts_application_all_year_round'));
    
        // Check conditions
        if (count($unique_acceptance) === 1 && reset($unique_acceptance) === 'Yes') {
            echo '<li>Application Deadline: <b>Accept Application All Year</b></li>';
        } elseif (count($unique_acceptance) === 1 && reset($unique_acceptance) === 'No') {
            if (count($unique_deadlines) === 1) {
                $deadline = reset($unique_deadlines);
                echo '<li>Application Deadline: <b>' . (strtotime($deadline) >= strtotime($current_date) ? $deadline . ' (Open)' : $deadline .' (Past Deadline)') . '</b></li>';
            } else {
                echo '<li>Application Deadline:<ul>';
                foreach ($scholarship_deadlines as $deadline) {
                    echo '<li>' . $deadline['degree'] . ': <b>' . ($deadline['accepts_application_all_year_round'] === 'Yes' ? 'Accept Application All Year' : (strtotime($deadline['deadline']) >= strtotime($current_date) ? $deadline['deadline'] . ' (Open)' :  $deadline['deadline'] . ' (Past Deadline)')) . '</b></li>';
                }
                echo '</ul></li>';
            }
        } else {
            echo '<li>Application Deadline:<ul>';
            foreach ($scholarship_deadlines as $deadline) {
                echo '<li>' . $deadline['degree'] . ': <b>' . ($deadline['accepts_application_all_year_round'] === 'Yes' ? 'Accept Application All Year' : (strtotime($deadline['deadline']) >= strtotime($current_date) ? $deadline['deadline'] . ' (Open)' :  $deadline['deadline'] . ' (Past Deadline)')) . '</b></li>';
            }
            echo '</ul></li>';
        }
    }
  ?>
</ul>
