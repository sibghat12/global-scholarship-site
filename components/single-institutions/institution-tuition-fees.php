<?php if (isset($tuition_fee) && !empty($tuition_fee)) :
?>
    <div class="gs-institution-tuition-fees">

        <div class="gs-institution-tutition-fees-text">
                  
        <?php
                // Print out tuition fees if it is available

                if ($ibl > -1 && $iml > -1 ) {

                echo "<h1  class='gs-institution-tuition-fees-title' id='tuition'>Tuition Fees at " . $institution_title . " for International Students</h1>";

                if($ibl == 0 && $iml== 0 && $ibu == 0 && $iml == 0 ) {
                
                echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . "."; ?>
                <b> The tuition fee for both bachelor’s and master’s degrees is free. They don’t charge tuition fees to international students. </b> 


                <?php }  elseif ($ibl == 0 && $iml > 0 ) { 

                    echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . "."; ?>
                    The bachelor's tuition fees for international students at <?php echo $institution_title ?> are free.             

                Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu ? number_format($iml) . " " . $currency . " to " . number_format($imu) . " " . $currency : number_format($iml) . " " . $currency; ?> per year. </p> 



                <?php }  elseif ($ibl > 0 && $iml == 0 ) { 
                    
                echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . "."; ?>
                The bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu ? number_format($ibl) . " " . $currency . " to " . number_format($ibu) . " " . $currency: number_format($ibl) . " " . $currency; ?> per year.                

                Master's tuition fee for international students at <?php echo $institution_title ?> are free. </p> 

                <?php } else {

                echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . "."; ?>
                The bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu ? number_format($ibl) . " " . $currency . " to " . number_format($ibu) . " " . $currency: number_format($ibl) . " " . $currency; ?> per year.             

                Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu ? number_format($iml) . " " . $currency . " to " . number_format($imu) . " " . $currency : number_format($iml) . " " . $currency; ?> per year. </p> 


                <?php } 
                }




                else if ($ibl > -1 )  {   ?>
                
                

                <?php  if($ibl==0) { 

                    echo "<h2>Tuition Fees at " . $institution_title . " for International Students</h2>"; ?>

                <p>The bachelor's tuition fees for international students at <?php echo $institution_title ?> are free.</p>

                <?php  } else { ?>

                <?php echo "<h2>Tuition Fees at " . $institution_title . " for International Students</h2>"; ?>
                <p>The bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu ? 
                    number_format($ibl) . " " . $currency . " to " . number_format($ibu) . " " . $currency: number_format($ibl) . " " . $currency; ?> per year.</p>


                
                <?php } } else if ($iml > -1 ) { 
                
                

                    
                    if($iml==0) {
                    
                    echo "<h2>Tuition Fees at " . $institution_title . " for International Students</h2>"; ?>
                    <p>Master's tuition fee for international students at <?php echo $institution_title ?> is free. </p> 

                    <?php } else {

                    echo "<h2>Tuition Fees at " . $institution_title . " for International Students</h2>"; ?>
                

                <p>Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu ? number_format($iml) . " " . $currency . " to " . number_format($imu) . " " . $currency : number_format($iml) . " " . $currency; ?> per year. </p> 
                

                <?php } } ?>
                
                
                

                <?php  if($ibu == 0 && $imu == 0  ){ ?>

                <p> <?php echo $institution_title; ?> is one of the few universities in the world offering free tuition. This is one of the main reasons why 
                <?php echo $institution_title;  ?> is a popular choice among international students.  </p>

                <?php } if($ibu == 0 && $imu > 0  ) { ?>
                <p> <?php echo $institution_title; ?> is one of the few universities in the world offering free tuition for a bachelor's degree. This is one of the main reasons why 
                <?php echo $institution_title;  ?> is a popular choice among international students. 
                However, only students at the bachelor’s level are granted this offer. Master’s students will still need to pay an amount for tuition.
                </p> 

                <?php } 

                if( $ibu > 0 && $imu == 0 ){?>  


                <p> <?php echo $institution_title; ?> is one of the few universities in the world offering free tuition for a master's degree. This is one of the main reasons why 
                <?php echo $institution_title;  ?> is a popular choice among international students. 
                However, only students at the master’s level are granted this offer. If you are an undergraduate, you will still need to pay an amount for tuition . </p>


                <?php  } if($ibu == 0 && $imu == 0 ) { ?>


                <?php  }

            ?>

            
    <p>When studying abroad, it is best to save as much money as you can. After all, there are other costs to consider besides tuition fees, such as accommodation, meals, transportation, and books.
    </p>

    <?php if($number_of_scholarships > 0) { ?>



            <p>The scholarships at <?php echo $institution_title; ?> can help fund your study expenses. There are currently <?php echo $number_of_scholarships; ?> scholarships being offered to international students at the <?php echo $institution_title; ?>, all with varying requirements, benefits, and application processes. We have compiled them in this list to help you find the scholarship that best fits you.
            </p>
    <?php } ?>
        </div>
<?php endif; ?>
