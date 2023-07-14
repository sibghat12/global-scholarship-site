<?php 

  $eligible_countries = '';
  $countries = get_field('eligible_nationality');

  asort($countries);
  
  $countries = explode(",",str_replace("\'","",implode(",",$countries)));

  $country_array_original = explode(",", str_replace( "'",   "",    implode(",", $country_array_original)));
  

  if($countries) {
    $newArray = array_combine($countries, $countries);
  }

  if($newArray) {
    $diffArray = array_diff($country_array_original ,$newArray );
  } 
  
  if(count($diffArray) < 20 ) {
    
    if(in_array("All Nationalities", $countries )){
      $eligible_countries .= "All Nationalities";
    } else  {
    array_shift($diffArray);
    $eligible_countries .= "All Nationalities except " . convert_array_to_text($diffArray);
  }

  } else {

    if(in_array("All Nationalities", $countries)) { 
      $eligible_countries .= "All Nationalities";
      } else {
      $eligible_countries .= convert_array_to_text($countries);
  }

}

 // Eligible Programs (Subjects)

    $programs = get_field('eligible_programs');
        
    $programs_text = '';



    if (in_array("All Subjects", $programs)){
    $programs_text .= "All Subjects offered at " . get_the_title(get_field("scholarship_institution"));
    } else {
    $programs_text .= convert_array_to_text($programs);
    }           

 ?>
<ul>

<li>  Level of Study: <b><?php  echo $degrees_text; ?></b></li>
<li>  Host Institution:  <a href="<?php echo get_permalink($institution->ID); ?>"><b><?php  echo $institution_name; ?></b> </a></li>    

<?php  if($scholarship_amount > 0 ){ ?>

               <li>  
Scholarship Amount: <b><?php echo number_format($scholarship_amount); ?>  
<?php echo $currency; ?></b></li>    


<?php    }  ?>                  

<li>Scholarship Type: <b><?php echo $scholarship_type; ?> </b> </li>                   

<input type="hidden" class="gs-scholarship-eligible-countries" value="<?php echo $eligible_countries; ?>" />
<li>  Eligible Nationalities:  
    <div class="gs-scholarship-nationalities-container">
        <b class="gs-scholarship-nationalities"></b>
        <?php if($eligible_countries != 'All Nationalities' && (( count($newArray) > 3 && count($diffArray) > 3 )) ) : ?>
            <span class="show_more"><span class="ellipsis">...</span> <a href="#" id="toggle-link">Show more</a></span>
        <?php endif; ?>
    </div>
</li>
<input type="hidden" class="gs-scholarship-eligible-subjects" value="<?php echo $programs_text; ?>" />
<?php if ($programs){
    ?><li>  Eligible Subjects:  
    <div class="gs-scholarship-subjects-container">
        <b class="gs-scholarship-subjects"></b>
        <?php if(count($programs) > 1) : ?>
            <span class="show_more"><span class="ellipsis">...</span> <a href="#" id="toggle-link">Show more</a></span>
        <?php endif; ?>
    </div>   
</li>
        <?php
        }?>
    <?php if($number_of_recipients > 0){ ?>
        <li> Number of Recipients:  <b> <?php  echo $number_of_recipients; ?>      </b>  </li>
        <?php }  else {

        echo "<li>Number of Recipients: <b>Not Specified</b> </li>";

    }?>

 <li> Additional Scholarships Materials Required? <b><?php echo $separate_application; ?></b>  </li>


 <?php 


     $bachelor_open_date = get_field('bachelor_open_date');
     $master_open_date = get_field('master_open_date');


if ($institution_query->have_posts()) {

 $bachelors_deadline = "";
 $masters_deadline = "";
 $bachelors_deadline_label = "";
 $masters_deadline_label = "";
 $bachelor_accpet_all_year = "";
 $master_accept_all_year  ="";

 $has_found_bachelor= false;
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

if ($degree == "Bachelor's") {
  $current_bachelors_deadline = get_sub_field("deadline");
   $bachelor_accpet_all_year = get_sub_field("accepts_application_all_year_round");
  if (empty($bachelors_deadline) ||
      (strtotime($current_bachelors_deadline) > $current_date && (strtotime($current_bachelors_deadline) < strtotime($bachelors_deadline) || strtotime($bachelors_deadline) < $current_date)) ||
      (strtotime($current_bachelors_deadline) < $current_date && strtotime($current_bachelors_deadline) > strtotime($bachelors_deadline))) {
          $bachelors_deadline = $current_bachelors_deadline;
        if($bachelors_deadline=="") {
            if($bachelor_accpet_all_year=="Yes"){
              $bachelors_deadline = "Accepts Application All Year";
            }
          }
          $bachelors_deadline_label = get_sub_field("label");

  }
}

if ($degree == "Master's") {
  $current_masters_deadline = get_sub_field("deadline");
  $master_accept_all_year = get_sub_field("accepts_application_all_year_round");
  if (empty($masters_deadline) ||
      (strtotime($current_masters_deadline) > $current_date && (strtotime($current_masters_deadline) < strtotime($masters_deadline) || strtotime($masters_deadline) < $current_date)) || $master_accept_all_year =="Yes" ||
      (strtotime($current_masters_deadline) < $current_date && strtotime($current_masters_deadline) > strtotime($masters_deadline))) {
          $masters_deadline = $current_masters_deadline;
          if($masters_deadline=="") {
            if($master_accept_all_year=="Yes"){
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

      if (empty($deadline_without_degree) ||
          (strtotime($current_deadline_without_degree) > $current_date && (strtotime($current_deadline_without_degree) < strtotime($deadline_without_degree) || strtotime($deadline_without_degree) < $current_date)) ||
          (strtotime($current_deadline_without_degree) < $current_date && strtotime($current_deadline_without_degree) > strtotime($deadline_without_degree))) {
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
if($bachelors_deadline || $masters_deadline || $accept_all_year || $master_accept_all_year ||  $deadline_without_degree ) {
if($no_degree_selected) {

if ($accept_all_year=="Yes") { 
echo '<li> Admission Deadline: ';
echo "<b>";
echo " Currently Open"; 
echo "</b>"; } else {

if($deadline_without_degree) {
echo '<li> Admission Deadline: ';
echo "<b>";
echo  $deadline_without_degree;

if ($bachelor_open_date == "Yes" || $master_open_date== "Yes") {
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


if($masters_deadline === $bachelors_deadline) {
echo "<b>";  
if($bachelor_accpet_all_year=="Yes"){ echo "Currently Open"; } else {

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



if($bachelors_deadline) {
echo "<li> Bachelor's: ";
if ($bachelor_accpet_all_year=="Yes") { echo ": Currently Open";} else {
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

if($masters_deadline) {

echo "<li> Master's: "; 
if ($master_accept_all_year=="Yes") { echo "Accepts Application All Year"; } else {

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
if($bachelor_accpet_all_year=="Yes"){ echo "Currently Open"; } else {

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
if($master_accept_all_year=="Yes"){ echo "Currently Open"; } else {
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


echo '</li>'; }
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
 $master_accept_all_year  ="";

 $has_found_bachelor= false;
 $has_found_master = false;
 $no_degree_selected = false;
 $current_date_date = date('F j, Y');
 $current_date = time();

 $deadline_without_degree = "";

     $bachelor_open_date = "";
     $master_open_date = "";

while (have_rows("scholarship_deadlines")) {
the_row();

$degree = get_sub_field('degree');

if ($degree == "Bachelor's") {
$current_bachelors_deadline = get_sub_field("deadline");

if (empty($bachelors_deadline) ||
(strtotime($current_bachelors_deadline) > $current_date && strtotime($current_bachelors_deadline) < strtotime($bachelors_deadline)) ||
(strtotime($current_bachelors_deadline) < $current_date && strtotime($current_bachelors_deadline) > strtotime($bachelors_deadline))) {
  $bachelors_deadline = $current_bachelors_deadline;
  $bachelors_deadline_label = get_sub_field("label");
  
    $deadline_date_scholarship = get_sub_field('deadline');
     $open_date_scholarship = get_sub_field('open_date');

     // Convert deadline and open dates to Unix timestamps
$deadline_date_scholarship = strtotime($deadline_date_scholarship);
$open_date_scholarship = strtotime($open_date_scholarship);

// Check if open_date is less than the current date and deadline is greater than the current date
if ($open_date_scholarship < $current_date && $deadline_date_scholarship > $current_date) {

$bachelor_open_date= "Yes";

}
}
}

if ($degree == "Master's") {
$current_masters_deadline = get_sub_field("deadline");

if (empty($masters_deadline) ||
(strtotime($current_masters_deadline) > $current_date && strtotime($current_masters_deadline) < strtotime($masters_deadline)) ||
(strtotime($current_masters_deadline) < $current_date && strtotime($current_masters_deadline) > strtotime($masters_deadline))) {
  $masters_deadline = $current_masters_deadline;
  $masters_deadline_label = get_sub_field("label");

  $deadline_date_scholarship = get_sub_field('deadline');
     $open_date_scholarship = get_sub_field('open_date');

     // Convert deadline and open dates to Unix timestamps
$deadline_date_scholarship = strtotime($deadline_date_scholarship);
$open_date_scholarship = strtotime($open_date_scholarship);

// Check if open_date is less than the current date and deadline is greater than the current date
if ($open_date_scholarship < $current_date && $deadline_date_scholarship > $current_date) {

$master_open_date= "Yes";

}


}
}
}

if (empty($masters_deadline) || empty($bachelors_deadline)) {

while (have_rows("scholarship_deadlines")) {
the_row();

$current_deadline_without_degree = get_sub_field("deadline");

if (empty($deadline_without_degree) ||
(strtotime($current_deadline_without_degree) > $current_date && strtotime($current_deadline_without_degree) < strtotime($deadline_without_degree)) ||
(strtotime($current_deadline_without_degree) < $current_date && strtotime($current_deadline_without_degree) > strtotime($deadline_without_degree))) {
  
  $deadline_without_degree = $current_deadline_without_degree;
  $label_without_degree = get_sub_field("label");

  $deadline_date_scholarship = get_sub_field('deadline');
     $open_date_scholarship = get_sub_field('open_date');

     // Convert deadline and open dates to Unix timestamps
$deadline_date_scholarship = strtotime($deadline_date_scholarship);
$open_date_scholarship = strtotime($open_date_scholarship);



// Check if open_date is less than the current date and deadline is greater than the current date
if ($open_date_scholarship < $current_date && $deadline_date_scholarship > $current_date) {

$bachelor_open_date= "Yes";
$master_open_date="Yes";


}

  $no_degree_selected = true;
}
}
}




if (in_array("PhD", $degrees) && count($degrees) == 1) {
// Do nothing
} else {



if($no_degree_selected) {

if ($master_accept_all_year=="Yes" ||  $bachelor_accpet_all_year =="Yes") { 
echo '<li> </b> Scholarship Deadline: ';
echo "<b>";
echo " Currently Open"; 
echo "</b>"; } else {

if($deadline_without_degree) {
echo '<li> </b> Scholarship Deadline: ';
echo "<b>";
echo  $deadline_without_degree;

if ($bachelor_open_date == "Yes" || $master_open_date== "Yes") {
echo "<i>  (Currently Open)</i>";
} else {
if (strtotime($deadline_without_degree) < strtotime($current_date_date)) {
echo "<i> (Past Deadline)</i>";
} 
}


} }

} else {

echo '<li> </b>Scholarship Deadline: ';

if (in_array("Bachelor's", $degrees) && in_array("Master's", $degrees)) {

if($masters_deadline === $bachelors_deadline) {
echo "<b>";  
if($bachelor_accpet_all_year=="Yes"){ echo "Currently Open"; } else {

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

if($bachelors_deadline) {
echo "<li> Bachelor's: ";
if ($bachelor_accpet_all_year=="Yes") { echo ": Currently Open";} else {
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

if($masters_deadline) {

echo "<li> Master's: "; 
if ($master_accept_all_year=="Yes") { echo ": Currently Open";} else {

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
if($bachelor_accpet_all_year=="Yes"){ echo "Currently Open"; } else {

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
if($master_accept_all_year=="Yes"){ echo "Currently Open"; } else {
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


echo '</li>'; }
}



}






?>



</ul></b>