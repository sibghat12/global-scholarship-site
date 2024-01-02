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

// Eligible Institutions (&& ||) Eligible Country's Institutions
asort($eligible_institution_countries);
// echo '<pre>';
// print_r($eligible_institution_countries);
// echo '</pre>';

// $eligible_countries = explode(",", str_replace("\'", "", implode(",", $eligible_countries)));

// if($eligible_countries) {
//     $eligible_countries_array = array_combine($eligible_countries, $eligible_countries);
// }
$gs_eligible_places = '';

// echo '<pre>';
// print_r($eligible_institution_countries);
// echo '</pre>';

// if($eligible_institution_countries) {
//     $gs_eligible_places .= generate_countries_universities_text($eligible_institution_countries);
// }

// if($eligible_institutions) {
//     $gs_eligible_places .= convert_array_to_text($eligible_institutions);
// } 
$gs_eligible_places = '';

if ($eligible_institution_countries && $eligible_institutions) {
    $countries_text = generate_countries_universities_text($eligible_institution_countries);
    $institutions_text = convert_array_to_text($eligible_institutions);

    // Adding a space between texts
    $gs_eligible_places .= $countries_text . ', and ' . $institutions_text;
} elseif ($eligible_institution_countries) {
    $gs_eligible_places .= generate_countries_universities_text($eligible_institution_countries);
} elseif ($eligible_institutions) {
    $gs_eligible_places .= convert_array_to_text($eligible_institutions);
}
// elseif($eligible_countries) {
//     $gs_eligible_places .= 
// }
// echo '<pre>';
// print_r($eligible_countries);
// echo '</pre>';

//  echo '<pre>';
//  print_r($gs_eligible_places);
//  echo '</pre>';
 

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
    <li>Eligible Universities: <b><?php echo $gs_eligible_places; ?></b></li>
    <?php if($number_of_recipients) : ?>
        <li>Number of Recipients: <b><?php echo $number_of_recipients; ?></b></li>
    <?php endif; ?>
    <li>Scholarship Type: <b><?php echo $scholarship_category; ?> </b></li>
    <?php if ($scholarship_amount > 0) { ?>

        <li>Scholarship Amount: <b><?php echo number_format($scholarship_amount); ?>
        <?php echo $currency; ?></b></li>


<?php    }  ?>    <li>Scholarship Duration: <b>1 Year</b></li>
    <li>Application Deadline: <b>January 24, 2024</b></li>
    


    <li>Scholarship Type: <b><?php echo $scholarship_type; ?> </b> </li>

    <input type="hidden" class="gs-scholarship-eligible-countries" value="<?php echo $eligible_countries; ?>" />
    <li> Eligible Nationalities:
        <div class="gs-scholarship-nationalities-container">
            <b class="gs-scholarship-nationalities"></b>
            <?php if ($eligible_countries != 'All Nationalities' && ((count($newArray) > 3 && count($diffArray) > 3))) : ?>
                <span class="show_more"><span class="ellipsis">...</span> <a href="#" id="toggle-link">Show more</a></span>
            <?php endif; ?>
        </div>
    </li>
    <input type="hidden" class="gs-scholarship-eligible-subjects" data-institution-title="<?php echo get_the_title(get_field("scholarship_institution")); ?>" value="<?php echo htmlspecialchars(json_encode($programs)); ?>" />
    <?php if ($programs) {
    ?><li> Eligible Subjects:
            <div class="gs-scholarship-subjects-container">
                <b class="gs-scholarship-subjects"></b>
                <?php if (count($programs) > 3 && !in_array("All Subjects", $programs)) : ?>
                    <span class="show_more"><span class="ellipsis">...</span> <a href="#" id="toggle-link">Show more</a></span>
                <?php endif; ?>
            </div>
        </li>
    <?php
    } ?>
    <?php if ($number_of_recipients > 0) { ?>
        <li> Number of Recipients: <b> <?php echo $number_of_recipients; ?> </b> </li>
    <?php } else {

        echo "<li>Number of Recipients: <b>Not Specified</b> </li>";
    } ?>

    <li> Additional Scholarships Materials Required? <b><?php echo $separate_application; ?></b> </li>


    <?php


    $bachelor_open_date = get_field('bachelor_open_date');
    $master_open_date = get_field('master_open_date');


    if ($institution_query->have_posts()) {

        $bachelors_deadline = "";
        $masters_deadline = "";
        $bachelors_deadline_label = "";
        $masters_deadline_label = "";
        $bachelor_accpet_all_year = "";
        $master_accept_all_year  = "";

        $has_found_bachelor = false;
        $has_found_master = false;
        $no_degree_selected = false;
        $current_date_date = date('F j, Y');
        $current_date = time();

        while ($institution_query->have_posts()) {
            $institution_query->the_post();

            if (have_rows('admission_deadlines')) {

                // Push Deadline according to the degree
                while (have_rows('admission_deadlines')) {
                    the_row();

                    $degree = get_sub_field('degree');

                    if ($degree == "Bachelor's" || $degree == "") {
                        $current_bachelors_deadline = get_sub_field("deadline");
                        $bachelor_accpet_all_year = get_sub_field("accepts_application_all_year_round");
                        if (
                            empty($bachelors_deadline) ||
                            (strtotime($current_bachelors_deadline) > $current_date && (strtotime($current_bachelors_deadline) < strtotime($bachelors_deadline) || strtotime($bachelors_deadline) < $current_date)) ||
                            (strtotime($current_bachelors_deadline) < $current_date && strtotime($current_bachelors_deadline) > strtotime($bachelors_deadline))
                        ) {
                            $bachelors_deadline = $current_bachelors_deadline;
                            if ($bachelors_deadline == "") {
                                if ($bachelor_accpet_all_year == "Yes") {
                                    $bachelors_deadline = "Accepts Application All Year";
                                }
                            }
                            $bachelors_deadline_label = get_sub_field("label");
                        }
                    }

                    if ($degree == "Master's" || $degree == "") {
                        $current_masters_deadline = get_sub_field("deadline");
                        $master_accept_all_year = get_sub_field("accepts_application_all_year_round");
                        if (
                            empty($masters_deadline) ||
                            (strtotime($current_masters_deadline) > $current_date && (strtotime($current_masters_deadline) < strtotime($masters_deadline) || strtotime($masters_deadline) < $current_date)) || $master_accept_all_year == "Yes" ||
                            (strtotime($current_masters_deadline) < $current_date && strtotime($current_masters_deadline) > strtotime($masters_deadline))
                        ) {
                            $masters_deadline = $current_masters_deadline;
                            if ($masters_deadline == "") {
                                if ($master_accept_all_year == "Yes") {
                                    $masters_deadline = "Accepts Application All Year";
                                }
                            }
                            $masters_deadline_label = get_sub_field("label");
                        }
                    }
                }




                if (empty($masters_deadline) || empty($bachelors_deadline)) {

                    if (!$has_found_bachelor && !$has_found_master) {

                        while (have_rows('admission_deadlines')) {
                            the_row();
                            $current_deadline_without_degree = get_sub_field("deadline");

                            if (
                                empty($deadline_without_degree) ||
                                (strtotime($current_deadline_without_degree) > $current_date && (strtotime($current_deadline_without_degree) < strtotime($deadline_without_degree) || strtotime($deadline_without_degree) < $current_date)) ||
                                (strtotime($current_deadline_without_degree) < $current_date && strtotime($current_deadline_without_degree) > strtotime($deadline_without_degree))
                            ) {
                                $deadline_without_degree = $current_deadline_without_degree;
                                $label_without_degree = get_sub_field("label");
                                $accept_all_year = get_sub_field("accepts_application_all_year_round");
                                $no_degree_selected = true;
                            }
                        }
                    }
                }
            }
        }



        if (in_array("PhD", $degrees) && count($degrees) == 1) {
            // Do nothing
        } else {

            echo "</b>";
            if ($bachelors_deadline || $masters_deadline || $accept_all_year || $master_accept_all_year ||  $deadline_without_degree) {
                if ($no_degree_selected) {

                    if ($accept_all_year == "Yes") {
                        echo '<li> Admission Deadline: ';
                        echo "<b>";
                        echo " Currently Open";
                        echo "</b>";
                    } else {

                        if ($deadline_without_degree) {
                            echo '<li> Admission Deadline: ';
                            echo "<b>";
                            echo  $deadline_without_degree;

                            if ($bachelor_open_date == "Yes" || $master_open_date == "Yes") {
                                echo "<i> (Currently Open)</i>";
                            } else {
                                if (strtotime($deadline_without_degree) < strtotime($current_date_date)) {
                                    echo "<i> (Past Deadline)</i>";
                                }
                            }
                        }
                    }
                } else {

                    echo '<li> Admission Deadline: ';

                    if (in_array("Bachelor's", $degrees) && in_array("Master's", $degrees)) {


                        if ($masters_deadline === $bachelors_deadline) {
                            echo "<b>";
                            if ($bachelor_accpet_all_year == "Yes") {
                                echo "Currently Open";
                            } else {

                                echo  $bachelors_deadline;

                                if ($bachelor_open_date == "Yes") {
                                    echo "<i>  (Currently Open)</i>";
                                } else {
                                    if (strtotime($bachelors_deadline) < strtotime($current_date_date)) {
                                        echo "<i> (Past Deadline)</i>";
                                    }
                                }
                                echo " </b>";
                            }
                        } else {

                            // Both Bachelor's and Master's degrees are in the array
                            echo " <ul style='padding-left:100px;font-weight:700;margin-top:0px;line-height:28px;font-size:17px;'>";



                            if ($bachelors_deadline) {
                                echo "<li> Bachelor's: ";
                                if ($bachelor_accpet_all_year == "Yes") {
                                    echo ": Currently Open";
                                } else {
                                    echo  $bachelors_deadline;

                                    if ($bachelor_open_date == "Yes") {
                                        echo "<i>   (Currently Open)</i>";
                                    } else {
                                        if (strtotime($bachelors_deadline) < strtotime($current_date_date)) {
                                            echo "<i>  (Past Deadline)</i>";
                                        }
                                    }
                                }
                                echo "</li>";
                            }

                            if ($masters_deadline) {

                                echo "<li> Master's: ";
                                if ($master_accept_all_year == "Yes") {
                                    echo "Accepts Application All Year";
                                } else {

                                    echo $masters_deadline;
                                    if ($master_open_date == "Yes") {
                                        echo "<i>  (Currently Open)</i>";
                                    } else {
                                        if (strtotime($masters_deadline) < strtotime($current_date_date)) {
                                            echo "<i> (Past Deadline)</i>";
                                        }
                                    }
                                }


                                echo " </li>";
                            }


                            echo "</ul>";
                        }
                    } elseif (in_array("Bachelor's", $degrees)) {
                        // Only Bachelor's degree is in the array
                        echo "<b>";
                        if ($bachelor_accpet_all_year == "Yes") {
                            echo "Currently Open";
                        } else {

                            echo  $bachelors_deadline;

                            if ($bachelor_open_date == "Yes") {
                                echo "<i>  (Currently Open)</i>";
                            } else {
                                if (strtotime($bachelors_deadline) < strtotime($current_date_date)) {
                                    echo "<i> (Past Deadline)</i>";
                                }
                            }
                        }
                        echo " </b>";
                    } elseif (in_array("Master's", $degrees)) {
                        echo "<b>";
                        if ($master_accept_all_year == "Yes") {
                            echo "Currently Open";
                        } else {
                            // Only Master's degree is in the array

                            echo  $masters_deadline;

                            if ($master_open_date == "Yes") {
                                echo "<i>  (Currently Open)</i>";
                            } else {
                                if (strtotime($masters_deadline) < strtotime($current_date_date)) {
                                    echo "<i> (Past Deadline)</i>";
                                }
                            }
                        }
                        echo "</b>";
                    }


                    echo '</li>';
                }
            }
        }
    }




    //Scholarship Deadline
    wp_reset_postdata();
    if (have_rows("scholarship_deadlines")) {

        $bachelors_deadline = "";
        $masters_deadline = "";
        $bachelors_deadline_label = "";
        $masters_deadline_label = "";
        $bachelor_accpet_all_year = "";
        $master_accept_all_year  = "";

        $has_found_bachelor = false;
        $has_found_master = false;
        $no_degree_selected = false;
        $current_date_date = date('F j, Y');
        $current_date = time();

        $deadline_without_degree = "";

        $bachelor_open_date = "";
        $master_open_date = "";

        $future_bachelor_dates = array(); // Array to store future Bachelor's deadlines
        $future_master_dates = array(); // Array to store future Master's deadlines
        $future_no_degree_dates = array();

        while (have_rows("scholarship_deadlines")) {
            the_row();

            $degree = get_sub_field('degree');


            if ($degree == "Bachelor's" || empty($degree)) {
                $current_bachelors_deadline = get_sub_field("deadline");

                $deadline_date_scholarship = get_sub_field('deadline');
                $open_date_scholarship = get_sub_field('open_date');

                // Convert deadline and open dates to Unix timestamps
                $deadline_date_scholarship = strtotime($deadline_date_scholarship);
                $open_date_scholarship = strtotime($open_date_scholarship);

                // Check if open_date is less than the current date and deadline is greater than the current date
                if ($open_date_scholarship < $current_date && $deadline_date_scholarship > $current_date) {
                    $bachelor_open_date = "Yes";
                }

                $future_bachelor_dates[] = $current_bachelors_deadline;
            }

            if ($degree == "Master's" || empty($degree)) {
                $current_masters_deadline = get_sub_field("deadline");

                $deadline_date_scholarship = get_sub_field('deadline');
                $open_date_scholarship = get_sub_field('open_date');

                // Convert deadline and open dates to Unix timestamps
                $deadline_date_scholarship = strtotime($deadline_date_scholarship);
                $open_date_scholarship = strtotime($open_date_scholarship);

                // Check if open_date is less than the current date and deadline is greater than the current date
                if ($open_date_scholarship < $current_date && $deadline_date_scholarship > $current_date) {
                    $master_open_date = "Yes";
                }

                $future_master_dates[] = $current_masters_deadline;
            }
        }



        $nearest_future_date = null;
        $nearest_past_date = null;

        foreach ($future_bachelor_dates as $current_deadline) {
            // Convert deadline to a Unix timestamp
            $current_deadline_timestamp = strtotime($current_deadline);

            // Check if the deadline is in the future
            if ($current_deadline_timestamp > $current_date) {
                // Check if there's no previously found future deadline or if the current deadline is closer than the previously found one
                if (empty($nearest_future_date) || abs($current_deadline_timestamp - $current_date) < abs(strtotime($nearest_future_date) - $current_date)) {
                    $nearest_future_date = $current_deadline;
                }
            } elseif ($current_deadline_timestamp < $current_date) {
                // Check if there's no previously found past deadline or if the current past deadline is closer than the previously found one
                if (empty($nearest_past_date) || abs($current_deadline_timestamp - $current_date) < abs(strtotime($nearest_past_date) - $current_date)) {
                    $nearest_past_date = $current_deadline;
                }
            }
        }

        // Now $nearest_future_date contains the nearest future Bachelor's deadline, and $nearest_past_date contains the nearest past deadline
        if (!empty($nearest_future_date)) {
            $bachelors_deadline = $nearest_future_date;
        } elseif (!empty($nearest_past_date)) {
            $bachelors_deadline = $nearest_past_date;
        } else {
        }




        $nearest_future_master_date = null;
        $nearest_past_master_date = null;

        foreach ($future_master_dates as $current_deadline) {
            // Convert deadline to a Unix timestamp
            $current_deadline_timestamp = strtotime($current_deadline);

            // Check if the deadline is in the future
            if ($current_deadline_timestamp > $current_date) {
                // Check if there's no previously found future deadline or if the current deadline is closer than the previously found one
                if (empty($nearest_future_master_date) || abs($current_deadline_timestamp - $current_date) < abs(strtotime($nearest_future_master_date) - $current_date)) {
                    $nearest_future_master_date = $current_deadline;
                }
            } elseif ($current_deadline_timestamp < $current_date) {
                // Check if there's no previously found past deadline or if the current past deadline is closer than the previously found one
                if (empty($nearest_past_master_date) || abs($current_deadline_timestamp - $current_date) < abs(strtotime($nearest_past_master_date) - $current_date)) {
                    $nearest_past_master_date = $current_deadline;
                }
            }
        }

        // Now $nearest_future_master_date contains the nearest future Master's deadline, and $nearest_past_master_date contains the nearest past deadline
        if (!empty($nearest_future_master_date)) {
            $masters_deadline = $nearest_future_master_date;
        } elseif (!empty($nearest_past_master_date)) {
            $masters_deadline = $nearest_past_master_date;
        } else {
        }



        if (empty($masters_deadline) || empty($bachelors_deadline)) {

            while (have_rows("scholarship_deadlines")) {
                the_row();

                $current_deadline_without_degree = get_sub_field("deadline");

                $deadline_without_degree = $current_deadline_without_degree;
                $label_without_degree = get_sub_field("label");

                $deadline_date_scholarship = get_sub_field('deadline');
                $open_date_scholarship = get_sub_field('open_date');

                // Convert deadline and open dates to Unix timestamps
                $deadline_date_scholarship = strtotime($deadline_date_scholarship);
                $open_date_scholarship = strtotime($open_date_scholarship);

                // Check if open_date is less than the current date and deadline is greater than the current date
                if ($open_date_scholarship < $current_date && $deadline_date_scholarship > $current_date) {

                    $bachelor_open_date = "Yes";
                    $master_open_date = "Yes";
                }
                // Check if the found deadline is in the future

                $future_no_degree_dates[] = $deadline_without_degree;

                $no_degree_selected = true;
            }
        }


        $nearest_future_no_degree_date = null;
        $nearest_past_no_degree_date = null;

        foreach ($future_no_degree_dates as $current_deadline) {
            // Convert deadline to a Unix timestamp
            $current_deadline_timestamp = strtotime($current_deadline);

            // Check if the deadline is in the future
            if ($current_deadline_timestamp > $current_date) {
                // Check if there's no previously found future deadline or if the current deadline is closer than the previously found one
                if (empty($nearest_future_no_degree_date) || abs($current_deadline_timestamp - $current_date) < abs(strtotime($nearest_future_no_degree_date) - $current_date)) {
                    $nearest_future_no_degree_date = $current_deadline;
                }
            } elseif ($current_deadline_timestamp < $current_date) {
                // Check if there's no previously found past deadline or if the current past deadline is closer than the previously found one
                if (empty($nearest_past_no_degree_date) || abs($current_deadline_timestamp - $current_date) < abs(strtotime($nearest_past_no_degree_date) - $current_date)) {
                    $nearest_past_no_degree_date = $current_deadline;
                }
            }
        }


        if (!empty($nearest_future_no_degree_date)) {
            $deadline_without_degree = $nearest_future_no_degree_date;
        } elseif (!empty($nearest_past_no_degree_date)) {
            $deadline_without_degree = $nearest_past_no_degree_date;
        } else {
        }





        if (in_array("PhD", $degrees) && count($degrees) == 1) {
            // Do nothing
        } else {


            if ($no_degree_selected) {

                if ($master_accept_all_year == "Yes" ||  $bachelor_accpet_all_year == "Yes") {
                    echo '<li> </b> Scholarship Deadline: ';
                    echo "<b>";
                    echo " Currently Open";
                    echo "</b>";
                } else {

                    if ($deadline_without_degree) {
                        echo '<li> </b> Scholarship Deadline: ';
                        echo "<b>";
                        echo  $deadline_without_degree;

                        if ($bachelor_open_date == "Yes" || $master_open_date == "Yes") {
                            echo "<i>  (Currently Open)</i>";
                        } else {
                            if (strtotime($deadline_without_degree) < strtotime($current_date_date)) {
                                echo "<i> (Past Deadline)</i>";
                            }
                        }
                    }
                }
            } else {

                echo '<li> </b>Scholarship Deadline: ';

                if (in_array("Bachelor's", $degrees) && in_array("Master's", $degrees)) {

                    if ($masters_deadline === $bachelors_deadline) {
                        echo "<b>";
                        if ($bachelor_accpet_all_year == "Yes") {
                            echo "Currently Open";
                        } else {

                            echo  $bachelors_deadline;

                            if ($bachelor_open_date == "Yes" || $master_open_date == "Yes") {
                                echo "<i>  (Currently Open)</i>";
                            } else {
                                if (strtotime($bachelors_deadline) < strtotime($current_date_date)) {
                                    echo "<i> (Past Deadline)</i>";
                                }
                            }
                            echo " </b>";
                        }
                    } else {



                        // Both Bachelor's and Master's degrees are in the array
                        echo " <ul style='padding-left:100px;font-weight:700;margin-top:0px;line-height:28px;font-size:17px;'>";

                        if ($bachelors_deadline) {
                            echo "<li> Bachelor's: ";
                            if ($bachelor_accpet_all_year == "Yes") {
                                echo ": Currently Open";
                            } else {
                                echo  $bachelors_deadline;


                                if ($bachelor_open_date == "Yes") {
                                    echo "<i> (Currently Open)</i>";
                                } else {
                                    if (strtotime($bachelors_deadline) < strtotime($current_date_date)) {
                                        echo "<i> (Past Deadline)</i>";
                                    }
                                }
                            }
                            echo "</li>";
                        }

                        if ($masters_deadline) {

                            echo "<li> Master's: ";
                            if ($master_accept_all_year == "Yes") {
                                echo ": Currently Open";
                            } else {

                                echo $masters_deadline;
                                if ($master_open_date == "Yes") {
                                    echo "<i>  (Currently Open)</i>";
                                } else {
                                    if (strtotime($masters_deadline) < strtotime($current_date_date)) {
                                        echo "<i> (Past Deadline)</i>";
                                    }
                                }
                            }


                            echo " </li>";
                        }


                        echo "</ul>";
                    }
                } elseif (in_array("Bachelor's", $degrees)) {
                    // Only Bachelor's degree is in the array
                    echo "<b>";
                    if ($bachelor_accpet_all_year == "Yes") {
                        echo "Currently Open";
                    } else {

                        echo  $bachelors_deadline;
                        if ($bachelor_open_date == "Yes") {
                            echo "<i> (Currently Open)</i>";
                        } else {
                            if (strtotime($bachelors_deadline) < strtotime($current_date_date)) {
                                echo "<i> (Past Deadline)</i>";
                            }
                        }
                    }
                    echo " </b>";
                } elseif (in_array("Master's", $degrees)) {
                    echo "<b>";
                    if ($master_accept_all_year == "Yes") {
                        echo "Currently Open";
                    } else {
                        // Only Master's degree is in the array

                        echo  $masters_deadline;

                        if ($master_open_date == "Yes") {
                            echo "<i> (Currently Open)</i>";
                        } else {
                            if (strtotime($masters_deadline) < strtotime($current_date_date)) {
                                echo "<i> (Past Deadline)</i>";
                            }
                        }
                    }
                    echo "</b>";
                }


                echo '</li>';
            }
        }
    }






    ?>



</ul></b>