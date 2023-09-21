<?php if (isset($tuition_fee) && !empty($tuition_fee)) :

    $average_international_bachelors = 0;
    $average_international_masters = 0;

    if ($ibl > 0 && $ibu > 0) {
        $average_international_bachelors = number_format(roundNearestHundreth(($ibl + $ibu) / 2));
    } elseif ($ibl > 0) {
        $average_international_bachelors = number_format(roundNearestHundreth($ibl));
    } elseif ($ibu > 0) {
        $average_international_bachelors = number_format(roundNearestHundreth($ibu));
    }


    
    if ($iml > 0 && $imu > 0) {
        $average_international_masters = number_format(roundNearestHundreth(($iml + $imu) / 2));
    } elseif ($iml > 0) {
        $average_international_masters = number_format(roundNearestHundreth($iml));
    } elseif ($imu > 0) {
        $average_international_masters = number_format(roundNearestHundreth($imu));
    }

?>
    <div id="institution-tuition-fees" class="gs-institution-tuition-fees">

        <div class="gs-institution-tutition-fees-text">
        <h2 class='gs-institution-tuition-fees-title' id='tuition'>Tuition Fees at <?php echo $institution_title ?> for International Students</h2>       
                  
        <?php
                // Print out tuition fees if it is available

                if ($ibl > -1 && $iml > -1 ) { ?>

                <div class="gs-institution-tuition-fees-for-international-average">
                    <?php if($average_international_bachelors > 0) : ?>
                    <div class="gs-institution-tuition-fees-bachelors">
                        <h2><?php echo $average_international_bachelors .' '. $currency; ?></h2>
                        <div class="gs-institution-tuition-fees-note">Average Bachelor’s tuition fees</div>
                    </div>
                    <?php endif; ?>
                    <?php if($average_international_masters > 0) : ?>
                    <div class="gs-institution-tuition-fees-masters">
                        <h2><?php echo $average_international_masters .' '. $currency; ?></h2>
                        <div class="gs-institution-tuition-fees-note">Average Master’s tuition fees</div>
                    </div>
                    <?php endif; ?>
                </div>

                <?php
                if($ibl == 0 && $iml== 0 && $ibu == 0 && $iml == 0 ) {
                
                echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . ".</p>"; ?>
                <b>The tuition fee for both bachelor’s and master’s degrees is free. They don’t charge tuition fees to international students. </b> 


                <?php }  elseif ($ibl == 0 && $iml > 0 ) { 

                    echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . ".</p>"; ?>
                    <p><b>The bachelor's tuition fees for international students at <?php echo $institution_title ?> are free.             

                Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu && $imlUSD != $imuUSD ? number_format($iml) . " " . $currency . "($imlUSD $currencyUSD)" . " to " . number_format($imu) . " " . $currency . "($imuUSD $currencyUSD)": number_format($iml) . " " . $currency . "($imlUSD $currencyUSD)"; ?> per year.</b></p> 



                <?php }  elseif ($ibl > 0 && $iml == 0 ) { 
                    
                echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . ".</p>"; ?>
                <p><b>The bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu && $iblUSD && $ibuUSD ? number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)" . " to " . number_format($ibu) . " " . $currency . " ($ibuUSD $currencyUSD)": number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)"; ?> per year.                

                Master's tuition fee for international students at <?php echo $institution_title ?> are free.</b></p> 

                <?php } else {

                echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . ".</p>"; ?>
                <p><b>The bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu && $iblUSD != $ibuUSD ? number_format($ibl) . " " . $currency . " ($ibuUSD $currencyUSD)" . " to " . number_format($ibu) . " " . $currency . " ($ibuUSD $currencyUSD)": number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)" ; ?> per year.             

                Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu && $imlUSD != $imuUSD ? number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)" . " to " . number_format($imu) . " " . $currency . " ($imuUSD $currencyUSD)": number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)"; ?> per year.</b></p> 


                <?php } 
                }




                else if ($ibl > -1 )  {   ?>
                
                

                <?php  if($ibl==0) { 

                    ?>

                <p><b>The bachelor's tuition fees for international students at <?php echo $institution_title ?> are free.</b></p>

                <?php  } else { ?>
                <p><b>The bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu &&$iblUSD != $ibuUSD ? 
                    number_format($ibl) . " " . $currency  . " ($iblUSD $currencyUSD)" . " to " . number_format($ibu) . " " . $currency  . " ($ibuUSD $currencyUSD)": number_format($ibl) . " " . $currency  . " ($iblUSD $currencyUSD)"; ?> per year.</b></p>


                
                <?php } } else if ($iml > -1 ) { 

                    if($iml==0) {
                    ?>
                    <p><b>Master's tuition fee for international students at <?php echo $institution_title ?> is free.</b></p> 

                    <?php } else {
                        ?>
                    <p><b>Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu && $imlUSD != $imuUSD ? number_format($iml) . " " . $currency  . " ($imlUSD $currencyUSD)" . " to " . number_format($imu) . " " . $currency . " ($imuUSD $currencyUSD)" : number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)"; ?> per year.</b></p> 
                
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
    </div>
<?php endif; ?>
