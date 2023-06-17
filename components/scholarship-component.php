<?php 

   
   
    $id = get_the_ID();
    $scholarship_type = get_field('scholarship_type');
    $scholarship_amount = get_field('amount_in_numbers');
    $scholarship_category = get_field('amount_category');
    $eligibility_criteria = 'eligibility_criteria';
    $coverage = 'scholarship_coverage';
    $university_name = $name;
    $scholarship_name = get_the_title($id);
    $eligible_degrees = get_field('eligible_degrees');
    $eligible_degrees = convert_array_to_text($eligible_degrees);
    $currency = "USD";

    if(empty(get_scholarship_criteria_coverage($eligibility_criteria, "criteria", get_the_ID()))){
        $show_eligibility = false;
    } else {
        $show_eligibility = true;
    };
?>
    
    <h4> <?php echo $count .". ". $scholarship_name; ?> </h4>

    <ul>
    	<li> <b><a href="<?php echo get_permalink($id)?>">Scholarship Page</a> </b></li>
    	<li> Scholarship Type:  <?php echo $scholarship_category; ?> </li>
    	<?php if($scholarship_amount > 0) {?>
    	<li> Scholarship Amount:  <?php echo number_format($scholarship_amount) . " ". $current_currency; ?> </li>
        <?php } ?>
    	<li> Degrees Offered : <?php echo $eligible_degrees; ?>  </li>

    </ul> 	

    
    <?php 




// If Scholarship Is No # 1 For Undergraduate    
    
if($count % 3 == 1 && $program =="undergraduate") { ?>
     
    <p> <b><a href="<?php echo get_permalink($id)?>"><?php echo $scholarship_name ?></a></b> is a <?php echo get_adjective_scholarship_amount($scholarship_category); ?>  scholarship offered to international students.
    <?php if($scholarship_category == "Full Funding"  || $scholarship_category == 'Full Tuition'){ ?>
    This is one of the most generous scholarships at the <?php echo  $university_name ?>.</p>
    <?php }else { ?>
    </p>
    <?php } ?>

    <?php if ($show_eligibility){ ?>
    <p> To be considered for this undergraduate scholarship at <?php echo $university_name ?>, 
    you must meet the following eligibility requirements: </p>
    <?php echo  get_scholarship_criteria_coverage($eligibility_criteria, "criteria", get_the_ID());  ?>

    <?php } ?>
    <p> You can check the full list of requirements listed in the scholarship link above. You will also find the specific steps to submit your application for <?php  get_the_title($id) ?> there. </p>
    <p> It’s important to submit your application before the deadline indicated on the scholarship page, as this will provide the selection committee time to consider your application. Successful applicants will receive the following benefits: </p>
    <?php echo  get_scholarship_criteria_coverage("scholarship_coverage", "coverage", get_the_ID());   

}   



// If Scholarship Is No # 2 For Undergraduate

if($count % 3 == 2 &&  $program =="undergraduate") { ?>

    <p>Another undergraduate scholarship for international students worth checking at <?php   echo $university_name; ?> is 
    <b><a href="<?php echo get_permalink($id)?>"><?php  echo  $scholarship_name; ?></a></b>. 
        
            <?php if ($show_eligibility){ ?>
This is a <?php echo get_adjective_scholarship_amount($scholarship_category);  ?> scholarship for undergraduate students who meet the following eligibility requirements: </p>
    <?php echo  get_scholarship_criteria_coverage($eligibility_criteria, "criteria", get_the_ID()); } ?>
    <p> To get started on your application, check out the list of documents you need to prepare through the scholarship link. Like with other 
    <?php echo $university_name ?>  scholarships for international students, make sure to prepare and submit your application before the application deadline. The <?php echo  $scholarship_name ?> provides successful applicants with the following awards: </p>
    <?php echo  get_scholarship_criteria_coverage($coverage, "coverage", get_the_ID());  ?>
    <?php  if($scholarship_category == "Full Funding"  || $scholarship_category == 'Full Tuition'){ ?>
    <p> With these benefits, <b><a href="<?php echo get_permalink($id)?>"><?php echo  $scholarship_name ?></a></b> will allow you to cut down your study costs dramatically.  </p>
    <?php } if($scholarship_category== "Partial Funding") { ?>
    <p> Although it doesn’t cover the full cost of your study, <b><a href="<?php echo get_permalink($id)?>"><?php echo  $scholarship_name; ?></a></b> will be able to lower your study costs and allow you to save your money. </p> 
    <?php  } 

}  


// If Scholarship Is No # 3 For Undergraduate

if($count % 3 == 0 &&  $program =="undergraduate") { ?>


    <p> Next on the list is <b><a href="<?php echo get_permalink($id)?>"><?php echo  $scholarship_name ?></a></b>.     <?php if ($show_eligibility){ ?>
It is a <?php echo get_adjective_scholarship_amount($scholarship_category) ?>  undergraduate scholarship at <?php echo $university_name; ?> that grants funding to international students who meet the following criteria: </p>
    <?php echo  get_scholarship_criteria_coverage($eligibility_criteria, "criteria", get_the_ID()); } ?>
    <?php if($scholarship_category == "Full Funding"  || $scholarship_category == 'Full Tuition'){ ?>
    <p> Students who receive this undergraduate scholarship have nothing left to worry about financially while studying at 
     <?php echo $university_name; ?>.
    <?php } if($scholarship_category== "Partial Funding") { ?>
    <p> Students who receive this undergraduate scholarship don’t need to worry much about finances while studying at 
    <?php echo  $university_name ?> </p> 
    <?php } ?>
    <p> Successful applicants will receive the following benefits: </p>  
    <?php echo  get_scholarship_criteria_coverage($coverage, "coverage", get_the_ID());  ?>

<?php   } 


if($count % 3 == 1 && $program == "graduate"){ ?>

    <p> <?php echo  $university_name; ?> also provides financial support to international students in <?php echo  $eligible_degrees ?> programs 
    through <b><a href="<?php echo get_permalink($id)?>"><?php echo  $scholarship_name ?></a></b>.     <?php if ($show_eligibility){ ?>
Interested applicants for this <?php echo get_adjective_scholarship_amount($scholarship_category) ?> scholarship must meet the following certain eligibility requirements 
    to be considered:</p>
    
    <?php echo  get_scholarship_criteria_coverage($eligibility_criteria, "criteria", get_the_ID());  }?>

    <p>  Through <b><a href="<?php echo get_permalink($id)?>"><?php echo $scholarship_name ?></a></b>, <?php echo $eligible_degrees; ?> students at the <?php echo $university_name; ?> enjoy the following benefits: </p>
    <?php echo  get_scholarship_criteria_coverage($coverage, "coverage", get_the_ID());  ?>

    <?php if($scholarship_category == "Full Funding"  || $scholarship_category == 'Full Tuition'){ ?>
    <p>   <b><a href="<?php echo get_permalink($id)?>"><?php echo $scholarship_name; ?></a></b> is a great scholarship to apply to if you are on a tight budget.  </p>
    <?php } if($scholarship_category== "Partial Funding") { ?>
    
    <p> You will still need to shoulder some costs, but getting a <b><a href="<?php echo get_permalink($id)?>"><?php echo $scholarship_name; ?></a></b> grant will 
       help you fund your studies significantly.  </p>
   
    <?php  } ?>
    
    <p> All practical information related to preparing and submitting your application is available at the scholarship link above. Make sure 
    to prepare and send your documents in time for the application deadline.  </p>

 
 <?php }



if($count % 3 == 2 && $program=="graduate"){ ?>

   
   <p> As an international student in a graduate program, living abroad can be quite costly if 
     you don’t prepare for your expenses. This is why <?php echo  get_adjective_scholarship_amount($scholarship_category); ?> scholarships like <?php echo $scholarship_name ?> are available at the  <?php echo $university_name; ?> for qualified students. </p>

     <?php if ($show_eligibility){ ?>
  <p>  <b><a href="<?php echo get_permalink($id)?>"><?php echo   $scholarship_name ?></a></b> is open to  <?php echo $eligible_degrees ?> international students who meet the following eligibility requirements: </p>

    <?php echo  get_scholarship_criteria_coverage($eligibility_criteria, "criteria", get_the_ID());  }?>

    <p>  <?php echo  $university_name ?> awards the following scholarship benefits to successful applicants: </p>
    
    <?php echo  get_scholarship_criteria_coverage($coverage, "coverage", get_the_ID());  ?>

    <?php if($scholarship_category == "Full Funding"  || $scholarship_category == 'Full Tuition'){ ?>
    
    <p>   Clearly, <b><a href="<?php echo get_permalink($id)?>"><?php echo  $scholarship_name ?></a></b> offers some of the best benefits for  <?php echo $eligible_degrees; ?> students at
     <?php echo   $university_name; ?>. </p>


     <?php } if($scholarship_category== "Partial Funding") { ?>
       <p> Clearly, this scholarship offers very valuable benefits to deserving students.   </p> 
    <?php } ?>
    <p> Make sure to check out the scholarship link for the requirements you need to complete and submit before the deadline.  </p>
    
 <?php } 

// Graduate Scholarship For scholarship # 3 .

if($count % 3 == 0 &&  $program=="graduate") { ?>

    <p>  <b><a href="<?php echo get_permalink($id)?>"><?php echo  $scholarship_name; ?></a></b> is a  <?php echo  get_adjective_scholarship_amount($scholarship_category); ?> scholarship offered to  <?php echo $eligible_degrees; ?> students at <?php  echo $university_name; ?>.     <?php if ($show_eligibility){ ?>
Students need to meet the following requirements to be eligible: </p>

    <?php echo  get_scholarship_criteria_coverage($eligibility_criteria, "criteria", get_the_ID()); } ?>
    
    <p> Successful applicants are granted the following benefits: </p>

    <?php echo  get_scholarship_criteria_coverage($coverage, "coverage", get_the_ID());  ?>

    <?php if($scholarship_category == "Full Funding"  || $scholarship_category == 'Full Tuition'){ ?>
    
    <p> Getting this scholarship will be a big help financially as
    you pursue your <?php echo $eligible_degrees; ?> degree at <?php echo  $university_name; ?>. </p>

    <?php } if($scholarship_category== "Partial Funding") { ?>
    
    <p> There are other fees to pay for, but getting this scholarship will still help you financially as an <?php  $eligible_degrees ?> international student at <?php echo $university_name; ?>.   </p>
    
    <?php } 

} ?>



  







   


    
    




