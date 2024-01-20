<?php


$institute = $fields["scholarship_institution"];

$accept_value = "";
//$accept_value_for_master = "";
if( have_rows('admission_deadlines', $institute->ID) ) {

    // For Bachlor's
    while( have_rows('admission_deadlines', $institute->ID) ) { 
     the_row(); 
      $accept_value = get_sub_field('accepts_application_all_year_round' , $institute->ID);
     
   }

}

// $opening_soon_labels = check_opening_soon($institute->ID);
// print_r($opening_soon_labels);

$currentDate = time();


   $bachelor_opeing_soon = "";
   if (have_rows('admission_deadlines', $institute->ID)) {
         while (have_rows('admission_deadlines', $institute->ID)) {
         the_row();
        $degree_value = get_sub_field('degree');
              if ($degree_value == "Bachelor's") {
                $endDate = get_sub_field('deadline');
                $startDate = get_sub_field('open_date');

                $startDate = strtotime($startDate);
                $endDate = strtotime($endDate);

                

                if (!empty($startDate)) {

                    if ($startDate < $currentDate && $endDate > $currentDate) {
                         
                        $bachelor_opeing_soon = "Yes";
                        break;

                    }
                }

            } 

        }
    }

//echo $scholarship->ID;
//echo $bachelor_opeing_soon;
//  if($scholarship->=='49630'){
//   echo $bachelor_opeing_soon;
// }
 
  $master_opeing_soon = "";
   if (have_rows('admission_deadlines', $institute->ID)) {
         while (have_rows('admission_deadlines', $institute->ID)) {
         the_row();
        $degree_value = get_sub_field('degree');
              if ($degree_value == "Master's") {
                $endDate = get_sub_field('deadline');
                $startDate = get_sub_field('open_date');

                $startDate = strtotime($startDate);
                $endDate = strtotime($endDate);

                if (!empty($startDate)) {

                    if ($startDate < $currentDate && $endDate > $currentDate) {
                         
                        $master_opeing_soon = "Yes";
                        break;

                    }
                }

            } 

        }
    } 

    if($master_opeing_soon=="" && $bachelor_opeing_soon=="") {
        if (have_rows('admission_deadlines', $institute->ID)) {
         while (have_rows('admission_deadlines', $institute->ID)) {
         the_row();
         $degree_value = get_sub_field('degree');
            
                $endDate = get_sub_field('deadline');
                $startDate = get_sub_field('open_date');

                $startDate = strtotime($startDate);
                $endDate = strtotime($endDate);

                if (!empty($startDate)) {

                    if ($startDate < $currentDate && $endDate > $currentDate) {
                         
                        $master_opeing_soon = "Yes";
                        $bachelor_opeing_soon= "Yes";
                        
                        break;

                    }
                }
        }
    } 
    }



$city = get_post($institute->cities);
$city_name = get_the_title($city);
$country_name = get_post_meta($city->ID, 'country', TRUE);
$currency = get_currency($country_name);

$pos = strpos($city_name, ','); // Find position of the first occurrence of comma
if ($pos !== false) {
    $city_name = substr($city_name, 0, $pos); // Extract the part of the string before the comma
}




//$amount =  convert_to_usd($scholarship->amount_in_numbers, $current_currency);
//$currency = "USD";

$amount = number_format(floatval($scholarship->amount_in_numbers));
//$amount = $scholarship->amount_in_numbers;
$id = $scholarship->ID;

$degress = get_field('eligible_degrees');
$masters_deadline = get_field('current_masters_scholarship_deadline');

$masters_deadline = date_create($masters_deadline);
$masters_deadline = date_format( $masters_deadline , "F j, Y" );

// if($masters_deadline=="March 15, 2050"){
//     echo $masters_deadline;
// } 


$bachelors_deadline = get_field('current_bachelors_scholarship_deadline');
$bachelors_deadline = date_create($bachelors_deadline);
$bachelors_deadline = date_format( $bachelors_deadline , "F j, Y" );

$check_deadlines = "";

if(strtotime($masters_deadline) == strtotime($bachelors_deadline)){
 $check_deadlines = "same";
}

$phd_only = false;
if(count($degress) == 1 && $degress[0] == "PhD" ){
    $phd_only = true;
}

$md = strtotime(get_field('current_masters_scholarship_deadline'));
$bd = strtotime(get_field('current_bachelors_scholarship_deadline'));
$cd = date("Y-m-d H:i:s");
$cd = strtotime($cd);

$datet = "March 15, 2010";
$timestamp = strtotime($datet);

//echo count($degress);

$programs = get_field("eligible_programs", $id, true); 

if(count($programs) > 13) {
  $programs_array  = array_slice($programs, 0, 13);
  $programs_array = implode(', ', $programs_array);
}else {


   $count = count($programs);
$lastItem = array_pop($programs);
$programs_array = implode(', ', $programs);

if ($count > 1) {
    $programs_array .= " and " . $lastItem;
} else {
    $programs_array .= $lastItem;
}



}



//echo convert_array_to_text(get_field("eligible_programs", $id, true));




?>


<div class="card-wide custom-ad-card px-3">
	<div class="row px-3 py-4 scard-row" >

		<div class="s-course-details">

                <div class="sc-title-div" >

                 <div class="title-left" >
                     <a href="<?php echo get_permalink($scholarship->ID); ?>" target="_blank"  >
                <h2 style="padding-left:0px !important;padding-top:0px !important;" class="add-heading custom-ad-heading " >
                    <?php echo $scholarship->post_title; ?></h2></a>
                    <p class="sc-institute"> <strong> <?php echo $institute->post_title; ?> </strong> <br>
                      <?php echo $city_name . ", " . $country_name; ?></p>
                 </div>

                 <div  class="title-right heading-updated">

                    <?php if($phd_only == false) { ?>
                       
                       <p class="open-tag"> 
                       <?php 
                        if($accept_value=="Yes") {
                               echo "CURRENTLY OPEN";
                            } else {

                         if(count($degress) > 1) {

                           if(get_field('bachelor_open_date') == "Yes" && get_field('master_open_date') == "No"  
                            && in_array("Bachelor's" , $degress)) {  ?>
                               CURRENTLY OPEN FOR BACHELOR'S
                           <?php  }

                            if(get_field('bachelor_open_date') == "No" && get_field('master_open_date') == "Yes" 
                             && in_array("Master's" , $degress))
                        {  ?>
                               CURRENTLY OPEN FOR MASTER'S
                           <?php  }

                           if(get_field('bachelor_open_date') == "Yes" && get_field('master_open_date') == "Yes") { 
                                if (in_array("Bachelor's", $degress) && in_array("Master's" , $degress)) {
                            ?>
                               CURRENTLY OPEN 
                           <?php  }  elseif( in_array("Master's" , $degress ) && in_array("PhD" , $degress) &&  !in_array("Bachelor's" , $degress ) )  { ?>
                             CURRENTLY OPEN FOR MASTER'S
                           <?php  } else {
                                        
                           }     

                             }

                         } 

                        else {
                        
                        if($degress[0]=="Bachelor's"){
                            
                              if(get_field('bachelor_open_date')=="Yes") {
                             ?>
                         CURRENTLY OPEN 
                         <?php    }



                        } if ($degress[0]=="Master's"){ 
                           
                                   if(get_field('master_open_date')=="Yes") {
                                ?>
                       CURRENTLY OPEN
                       <?php  }}
                     } } }  ?>
                     </p>
                 </div>
                </div> 
				
                <div class="clearfix"> </div>



            
                <div class="sc-details-tag">
                    <div class="sc-details-left" >
                     <p class="degrees-tag-icon">
                     
                     <p style="width: 30px; !important; float:left;color:black;" >
                      <img  src="https://globalscholarships.com/wp-content/uploads/2023/03/icon-1-1.png"> </p>  
                     <p style="width: calc(100% - 30px) !important;  float:left;color:black;"><?php echo convert_array_to_text(get_field("eligible_degrees", $id, true)) ?> </p> <br> 
                       <div class="clearfix"> </div>

                     <p style="width:30px !important; float:left !important;" > <img   src="https://globalscholarships.com/wp-content/uploads/2023/03/icon-2-1.png"> </p> 
                     <p style="width: calc(100% - 30px) !important;  float:left;color:black;"> <strong> <?php echo $scholarship->amount_category ; ?>  </strong>
                          <?php if($amount) { ?>
                       • Scholarship Amount: <?php echo $amount . " " . $currency; ?>  <?php  } ?> </p>  <br>
                     <div class="clearfix"> </div>
                    
                    <?php if( $phd_only  ) { ?>
                           
                            <?php if(count($programs) > 13) { ?>

                        <p style="width:30px !important; float:left !important;" > <img    src="https://globalscholarships.com/wp-content/uploads/2023/03/icon-3-1.png"> </p> 
                        <p style="width: calc(100% - 30px) !important;  float:left;color:black;"> <?php echo $programs_array; ?>  ....
                           <br><a href="<?php echo get_permalink($scholarship->ID); ?>" target="_blank" style='color:#5590BC !important;font-weight:600;font-size:15px !important; ' > Show More Subjects </a></p>  
                        
                       <div class="clearfix"> </div>

                        <?php  } else { ?>

                             <p style="width:30px !important; float:left !important;" > <img    src="https://globalscholarships.com/wp-content/uploads/2023/03/icon-3-1.png"> </p>
                             <p style="width: calc(100% - 30px) !important;  float:left;color:black;"> <?php echo $programs_array; ?>   <br> </p>
                          
                              <div class="clearfix"> </div>


                      <?php  } ?>
                        

                  <?php  } else { ?>
                        
                         <?php if(count($programs) > 13) { ?>

                    <p  style="width: 30px !important; float:left !important;" > <img    src="https://globalscholarships.com/wp-content/uploads/2023/03/icon-3-1.png">  </p>
                    <p style="width: calc(100% - 30px) !important; float:left !important; color:black;"> <?php echo $programs_array; ?> ....
                      <br><a href="<?php echo get_permalink($scholarship->ID); ?>" target="_blank" style='color:#5590BC !important;font-weight:600;font-size:15px !important; ' > Show More Subjects </a> </p> 
                     
                   <div class="clearfix"> </div>  

                      <?php } else { ?>

                             <p style="width:30px !important; float:left !important;" > <img    src="https://globalscholarships.com/wp-content/uploads/2023/03/icon-3-1.png"> </p>
                             <p style="width: calc(100% - 30px) !important;  float:left;color:black;"> <?php echo $programs_array; ?>   <br> </p>
                          
                              <div class="clearfix"> </div>


                      <?php  } ?>




                  <?php  } ?>
                    
                     <?php

                      

                      if ( $phd_only == false) {

                              

                      if($check_deadlines=="same") {      
                         
                            
                            if(in_array("Master's" , $degress) && in_array("PhD" , $degress) && !in_array("Bachelor's" , $degress)) {

                                if($md > $timestamp) {

                             ?>
                                        <p style="width: 30px !important; float:left;color:black;"> <img  src="https://globalscholarships.com/wp-content/uploads/2023/03/icon-4-1.png">  </p> 
                                        <p style="width: calc(100% - 30px) !important;  float:left;color:black;" ><strong> Deadline </strong> </p> <br>
                                        <div class="clearfix"> </div>
                                        <p style="width: 50px; !important; float:left;color:black;" >  </p> 

                                        <p class="deadline-tag" style="padding-left:3px;color:black;">   Master's: <?php 
                                       if($masters_deadline=="March 15, 2050"){
                                             echo  "Accepts Applications All Year ";
                                           }else  {
                                            echo $masters_deadline; 
                                          } ?>  
                        
                            <?php 

                             if(get_field('master_open_date') == "No") {

                             if ($md > $cd) { if($master_opeing_soon=="Yes") { ?> 
                            <span style="padding-left:5px;font-size:14px;font-weight:300;" class="flagg" > (Opening Soon)  </span>
                             <?php } }  ?>  

                            <?php  if ($md < $cd) { ?> 
                            <span style="padding-left:5px;font-size:14px;font-weight:300;" class="flagg" > (Past Deadline)  </span>
                            <?php } } } ?> 

                        </p>
                                    <div class="clearfix"> </div>

                         

                    
          
                        <span> <a class="sc-readmore" href="<?php echo get_permalink($scholarship->ID); ?>" target="_blank">
                            <button> Learn More</button></a> </span>     

                           <?php  }  else { 

                                if($md > $timestamp) {

                          if($md > $cd ) { ?>
                         <p style="width: 30px !important; float:left;color:black;"> <img  src="https://globalscholarships.com/wp-content/uploads/2023/03/icon-4-1.png">  </p> 
                         <p style="width: calc(100% - 30px) !important; float:left;color:black;">Deadline: <?php 
                           
                           if($accept_value=="Yes" || $masters_deadline=="March 15, 2050" ) {
                            
                                echo "Accepts Applications All Year";
                            
                           } else {
                         if($masters_deadline=="March 15, 2050") { echo "Accepts Application All Year"; } else { echo $masters_deadline; } ?>   
                             <?php if(get_field('bachelor_open_date') == "No" || get_field('master_open_date') == "No") {  ?>
                         <span style="padding-left:5px;font-size:14px;font-weight:300;" class="flagg">
                         <?php if($accept_value=="Yes" || $masters_deadline=="March 15, 2050" ) { ?>
                           
                           <?php  } elseif ($master_opeing_soon=="Yes")  { ?>  (Opening Soon)  <?php } else { } ?>
                      </span>
                                 <?php } ?>

                     </p>  
                        <?php } } ?>


                         <?php if($md < $cd ) { ?>
                         <p style="width: 30px !important; float:left;color:black;"> <img  src="https://globalscholarships.com/wp-content/uploads/2023/03/icon-4-1.png">  </p> 
                         <p style="width: calc(100% - 30px) !important; float:left;color:black;">Deadline: <?php 
                          if($accept_value=="Yes" || $bachelors_deadline=="March 15, 2050" ) {
                            
                                echo "Accepts Application All Year";
                             
                           }  else {
                         if($bachelors_deadline=="March 15, 2050") { echo "Accepts Applications All Year"; } else {
                          echo $bachelors_deadline;
                         }
                          ?>  
                          <?php if(get_field('bachelor_open_date') == "No" || get_field('master_open_date') == "No") {  ?>
                            <span style="padding-left:5px;font-size:14px;font-weight:300;" class="flagg"> (Past Deadline) </span>
                                  <?php } } ?>
                             </p>  
                        <?php  } } ?>
                         
                         <div class="clearfix"> </div>

                         

                    
          
                        <span> <a class="sc-readmore" href="<?php echo get_permalink($scholarship->ID); ?>" target="_blank">
                            <button> Learn More</button></a> </span>

                    <?php } } 

                     
                     else { ?> 

                       
                       
                       
                       
                         <?php 
                            //...
                          if(in_array("Bachelor's" , $degress) && in_array("Master's" , $degress)) { ?>

                            <?php if($md > $timestamp || $bd > $timestamp) { ?>

                              <p style="width: 30px !important; float:left;color:black;" > <img   src="https://globalscholarships.com/wp-content/uploads/2023/03/icon-4-1.png"> </p>
                       <p style="width: calc(100% - 30px) !important;  float:left;color:black;" ><strong> Deadline </strong> </p> <br>
                       <div class="clearfix"> </div>
                                

                       
                             
                             <?php if (in_array("Bachelor's", $degress)) { 
                                 if($bd > $timestamp) {
                                ?>
                            <p style="width: 50px; !important; float:left;color:black;" >  </p> 
                            <p style="color:black;" class="deadline-tag"  style="padding-left:3px;color:black;">  Bachelor's: 
                              <?php if($bachelors_deadline=="March 15, 2050") { echo "Accepts Application All Year"; } else {
                          echo $bachelors_deadline;
                         }  ?>  

                            <?php 
                        
                            if(get_field('bachelor_open_date') == "No") {
                                                          if ($bd > $cd) {  if($bachelor_opeing_soon=="Yes") { ?> 
                            <span style="padding-left:5px;font-size:14px;font-weight:300;" class="flagg" > (Opening Soon)  </span>
                             <?php } }  ?>  

                            <?php  if ($bd < $cd) { ?> 
                           <span style="padding-left:5px;font-size:14px;font-weight:300;" class="flagg"> (Past Deadline)  </span>
                             <?php }  ?> 

                             </p> 

                            
                            <?php } } } ?>
                              
                           
                            <?php if (in_array("Master's", $degress)) { 
                                      if($md > $timestamp) {
                              ?>
                            <p style="width: 50px !important; float:left;color:black;" >  </p> 
                            <p class="deadline-tag" style="padding-left:3px;color:black;">   Master's: <?php
                             
                           if($masters_deadline=="March 15, 2050") { echo "Accepts Application All Year"; } else {
                          echo $masters_deadline;
                         }

                              ?>  
                        
                            <?php 

                             if(get_field('master_open_date') == "No") {

                             if ($md > $cd) {  if($master_opeing_soon=="Yes") { ?> 
                            <span style="padding-left:5px;font-size:14px;font-weight:300;" class="flagg" > (Opening Soon)  </span>
                             <?php } }  ?>  

                            <?php  if ($md < $cd) { ?> 
                            <span style="padding-left:5px;font-size:14px;font-weight:300;" class="flagg" > (Past Deadline)  </span>
                            <?php }  ?> 

                        </p> 
                            <?php } } } } } elseif(in_array("Master's" , $degress) && in_array("PhD" , $degress) && !in_array("Bachelor's" , $degress)) { ?>
                                
                                <?php   if($md > $timestamp) { ?>
                                 
                                  <p style="width: 30px !important; float:left;color:black;" > <img   src="https://globalscholarships.com/wp-content/uploads/2023/03/icon-4-1.png"> </p>

                               <p style="width: calc(100% - 30px) !important;  float:left;color:black;" ><strong> Deadline </strong> </p> <br>
                       <div class="clearfix"> </div>
                              <p style="width: 50px !important; float:left;color:black;" >  </p> 
                            <p class="deadline-tag" style="padding-left:3px;color:black;">   Master's: <?php if($masters_deadline=="March 15, 2050") { echo "Accepts Application All Year"; } else {
                          echo $masters_deadline;
                         } ?>  
                        
                            <?php 

                             if(get_field('master_open_date') == "No") {

                             if ($md > $cd) {  if($master_opeing_soon=="Yes") { ?> 
                            <span style="padding-left:5px;font-size:14px;font-weight:300;" class="flagg" > (Opening Soon)  </span>
                             <?php } }  ?>  

                            <?php  if ($md < $cd) { ?> 
                            <span style="padding-left:5px;font-size:14px;font-weight:300;" class="flagg" > (Past Deadline)  </span>
                            <?php } } ?> 

                        </p>


                          <?php } } else { ?>

                               

                              
                             
                             <?php  if(in_array("Bachelor's", $degress)) {

                                 if($bd > $timestamp) { ?>

                                 	 <p style="width: 30px !important; float:left;color:black;" > <img   src="https://globalscholarships.com/wp-content/uploads/2023/03/icon-4-1.png"> </p>
                           <p style="width: calc(100% - 30px) !important;  float:left;color:black;" >  Deadline: 

                             <?php   if($bachelors_deadline=="March 15, 2050") { echo "Accepts Application All Year"; } else {
                          echo $bachelors_deadline;
                         }
                                if(get_field('bachelor_open_date') == "No") {
                                 if ($bd > $cd) { if($bachelor_opeing_soon=="Yes") { ?> 
                                    <span style="padding-left:5px;font-size:14px;font-weight:300;" class="flagg" > (Opening Soon)  </span>
                                 <?php } }  ?>  
                                 <?php  if ($bd < $cd) { ?> 
                                   <span style="padding-left:5px;font-size:14px;font-weight:300;" class="flagg"> (Past Deadline)  </span>
                             <?php }  ?> 
                               </p> 

                            
                            <?php } }
                             } elseif (in_array("Master's", $degress)) {

                                       if($md > $timestamp) { ?>

                                       	 <p style="width: 30px !important; float:left;color:black;" > <img   src="https://globalscholarships.com/wp-content/uploads/2023/03/icon-4-1.png"> </p>
                           <p style="width: calc(100% - 30px) !important;  float:left;color:black;" >  Deadline: 

                                <?php   if($masters_deadline=="March 15, 2050") { echo "Accepts Application All Year"; } else {
                          echo $masters_deadline;
                         }

                                if(get_field('master_open_date') == "No") {
                                    
                                 if ($md > $cd) {  if($master_opeing_soon=="Yes") { ?> 
                                    <span style="padding-left:5px;font-size:14px;font-weight:300;" class="flagg" > (Opening Soon)  </span>
                                 <?php } }  ?>  
                                 <?php  if ($md < $cd) { ?> 
                                   <span style="padding-left:5px;font-size:14px;font-weight:300;" class="flagg"> (Past Deadline)  </span>
                             <?php }  ?> 
                               </p> 

                            
                            <?php }
                             } } else {

                             }   ?>

                             </p>
                              


                          <?php  } ?>



                    

                      
                                <span> <a class="sc-readmore" href="<?php echo get_permalink($scholarship->ID); ?>" target="_blank">
                            <button>  Learn More</button></a> </span>

                        <?php
                                
                            } 







                      }
                            else { ?>

                            <span> <a class="sc-readmore" href="<?php echo get_permalink($scholarship->ID); ?>" target="_blank">
                            <button>  Learn More</button></a> </span> <?php  } ?>
                      </p>
                  </div>

                 
                
                </div>

<div class="clearfix"> </div>
                 
            
                    
               


            	
            
 

		</div> <!-- Course Details -->
	</div> <!-- Row px -3 -->
</div> <!-- Card Wide -->

