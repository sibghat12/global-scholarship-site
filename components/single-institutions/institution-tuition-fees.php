<?php if (isset($tuition_fee) && !empty($tuition_fee)) :
        if($ibl > -1 || $iml > -1 || $imu > -1 || $ibu > -1 ) : 

    $average_international_bachelors = null;
    $average_international_masters = null;

    if ($ibl > -1 && $ibu > -1) {
        $average_international_bachelors = number_format(roundNearestHundreth(($ibl + $ibu) / 2));
    } elseif ($ibl > -1) {
        $average_international_bachelors = number_format(roundNearestHundreth($ibl));
    } elseif ($ibu > -1) {
        $average_international_bachelors = number_format(roundNearestHundreth($ibu));
    }


    
    if ($iml > -1 && $imu > -1) {
        $average_international_masters = number_format(roundNearestHundreth(($iml + $imu) / 2));
    } elseif ($iml > -1) {
        $average_international_masters = number_format(roundNearestHundreth($iml));
    } elseif ($imu >-1) {
        $average_international_masters = number_format(roundNearestHundreth($imu));
    }

?>
    <div id="tuition-fees" class="gs-institution-tuition-fees">

        <div class="gs-institution-tutition-fees-text">
        <p class="gs-institution-tuition-fees-title" id="tuition">Tuition Fees at <?php echo $institution_title ?> for International Students</p>
        <?php
        if ($ibl > -1 || $iml > -1 ) : ?>

        <div class="gs-institution-tuition-fees-for-international-average">
            <?php if($average_international_bachelors > -1) : ?>
                <?php if($average_international_bachelors > 0) : ?>
                    <div class="gs-institution-tuition-fees-bachelors gs-institution-tuition-fees-item">
                        <h2><?php echo $average_international_bachelors .' '. $currency; ?></h2>
                        <div class="gs-institution-tuition-fees-note">Average Bachelor’s tuition fees</div>
                    </div>
                <?php elseif($average_international_bachelors == 0 ) :  ?>
                    <div class="gs-institution-tuition-fees-bachelors gs-institution-tuition-fees-item">
                        <h2>Free</h2>
                        <div class="gs-institution-tuition-fees-note">Average Bachelor’s tuition fees</div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if($average_international_masters > -1) : ?>
                <?php if($average_international_masters > 0) : ?>
            <div class="gs-institution-tuition-fees-masters  gs-institution-tuition-fees-item">
                <h2><?php echo $average_international_masters .' '. $currency; ?></h2>
                <div class="gs-institution-tuition-fees-note">Average Master’s tuition fees</div>
            </div>
            <?php elseif($average_international_masters == 0 ) :  ?>
                <div class="gs-institution-tuition-fees-masters gs-institution-tuition-fees-item">
                    <h2>Free</h2>
                <div class="gs-institution-tuition-fees-note">Average Master’s tuition fees</div>
                </div>
            <?php endif; ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>
                  
        <?php
                // Print out tuition fees if it is available

                if ($ibl > -1 && $iml > -1 ) { ?>

                <?php
                if($ibl == 0 && $iml== 0 && $ibu <= 0 && $imu <= 0 ) {
                
                echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . ".<b> The tuition fee for both Bachelor’s and Master’s degrees is free. They don’t charge tuition fees to international students.</b></p>"; ?>

                <?php }  elseif ($ibl == 0 && $iml > 0 ) { 

                    echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . ".</p>"; ?>
                        <?php if($ibu == 0) : ?>
                            <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> are free.
                        <?php else :
                            echo "<p><b>";
                            ?>
                            <?php if($ibu > 0) : ?>
                                <?php if(has_usd_currency($country_name)) : ?>
                                    The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu  ? number_format($ibl) . " " . $currency . " to " . number_format($ibu) . " " . $currency: number_format($ibl) . " " . $currency; ?> per year.
                                <?php else: ?>
                                    The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu ? number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)" . " to " . number_format($ibu) . " " . $currency . " ($ibuUSD $currencyUSD)": number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)"; ?> per year.
                                <?php endif; ?>
                                <?php elseif($ibu == -1) : ?>
                                    <?php if(has_usd_currency($country_name)) : ?>
                                    The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu  ? number_format($ibl) . " " . $currency: number_format($ibl) . " " . $currency; ?> per year.
                                <?php else: ?>
                                    The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu ? number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)" : number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)"; ?> per year.
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    
                    <?php if(has_usd_currency($country_name)) : ?>
                       Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu  ? number_format($iml) . " " . $currency . " to " . number_format($imu) . " " . $currency : number_format($iml) . " " . $currency; ?> per year.</b></p>
                    <?php else: ?>
                        <?php if($imu > 0) : ?>
                           Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu  ? number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)" . " to " . number_format($imu) . " " . $currency . " ($imuUSD $currencyUSD)": number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)"; ?> per year.</b></p>
                        <?php else: ?>
                           Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu  ? number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)" : number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)"; ?> per year.</b></p>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php }  elseif ($ibl > 0 && $iml == 0 ) { 
                    
                    if($imu > 0) {
                        echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . ".</p>"; ?>
                        <?php if(has_usd_currency($country_name)) : ?>
                            <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu  ? number_format($ibl) . " " . $currency . " to " . number_format($ibu) . " " . $currency: number_format($ibl) . " " . $currency; ?> per year.                

                            <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu  ? number_format($iml) . " " . $currency . " to " . number_format($imu) . " " . $currency: number_format($iml) . " " . $currency; ?> per year.</b></p>
                        <?php else: ?>
                            <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu ? number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)" . " to " . number_format($ibu) . " " . $currency . " ($ibuUSD $currencyUSD)": number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)"; ?> per year.                

                            Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu  ? number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)" . " to " . number_format($imu) . " " . $currency . " ($imuUSD $currencyUSD)": number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)"; ?> per year.
                            </b></p>
                        <?php endif;
                    } else {
                        echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . ".</p>"; ?>
                        <?php if(has_usd_currency($country_name)) : ?>
                            <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu  ? number_format($ibl) . " " . $currency . " to " . number_format($ibu) . " " . $currency: number_format($ibl) . " " . $currency; ?> per year.                

                            Master's tuition fee for international students at <?php echo $institution_title ?> are free.</b></p> 
                        <?php else: ?>
                            <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu ? number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)" . " to " . number_format($ibu) . " " . $currency . " ($ibuUSD $currencyUSD)": number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)"; ?> per year.                

                            Master's tuition fee for international students at <?php echo $institution_title ?> are free.</b></p> 
                        <?php endif;
                    }
                     ?>
                <?php } elseif($ibl == -1 && $iml == 0) {
                    ?>
                    <p><b>Master's tuition fee for international students at <?php echo $institution_title ?> are free.</b></p> 
                <?php } elseif($iml == -1 && $ibl == 0) {
                    ?>
                    <p><b>Bachelor's tuition fee for international students at <?php echo $institution_title ?> are free.</b></p> 
                    <?php
                } else {
                    if( $ibu < 0 || $imu < 0 ) {

                        if($ibu < 0 && $imu > 0) {
                            echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . ".</p>"; ?>
                            <?php if(has_usd_currency($country_name)) : ?>
                                <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu ? number_format($ibl) . " " . $currency : number_format($ibl) . " " . $currency; ?> per year.             

                                Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu ? number_format($iml) . " " . $currency . " to " . number_format($imu) . " " . $currency : number_format($iml) . " " . $currency; ?> per year.</b></p>
                            <?php else: ?>
                                <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu ? number_format($ibl) : number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)" ; ?> per year.             

                                Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu ? number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)" . " to " . number_format($imu) . " " . $currency . " ($imuUSD $currencyUSD)": number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)"; ?> per year.</b></p>
                            <?php endif; 

                        } elseif($imu < 0 && $ibu > 0) {
                            echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . ".</p>"; ?>
                            <?php if(has_usd_currency($country_name)) : ?>
                                <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu ? number_format($ibl) . " " . $currency . " to " . number_format($ibu) . " " . $currency: number_format($ibl) . " " . $currency; ?> per year.             
        
                                Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu ? number_format($iml) : number_format($iml) . " " . $currency; ?> per year.</b></p>
                            <?php else: ?>
                                <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu  ? number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)" . " to " . number_format($ibu) . " " . $currency . " ($ibuUSD $currencyUSD)": number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)" ; ?> per year.             
        
                                Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu ? number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)" : number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)"; ?> per year.</b></p>
                            <?php endif; 
        
                        } else {
                            echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . ".</p>"; ?>
                            <?php if(has_usd_currency($country_name)) : ?>
                                <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu ? number_format($ibl) . " " . $currency: number_format($ibl) . " " . $currency; ?> per year.             
        
                                Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu ? number_format($iml) : number_format($iml) . " " . $currency; ?> per year.</b></p>
                            <?php else: ?>
                                <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu ? number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)" : number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)" ; ?> per year.             
        
                                Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu ? number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)" : number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)"; ?> per year.</b></p>
                            <?php endif; 
                        }
                    } else {
                        echo "<p>In this section, we will be discussing the tuition fees for international students at " . $institution_title . ".</p>"; ?>
                        <?php if(has_usd_currency($country_name)) : ?>
                            <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu ? number_format($ibl) . " " . $currency . " to " . number_format($ibu) . " " . $currency: number_format($ibu) . " " . $currency; ?> per year.             

                            Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu ? number_format($iml) . " " . $currency . " to " . number_format($imu) . " " . $currency : number_format($iml) . " " . $currency; ?> per year.</b></p>
                        <?php else: ?>
                            <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu ? number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)" . " to " . number_format($ibu) . " " . $currency . " ($ibuUSD $currencyUSD)": number_format($ibl) . " " . $currency . " ($iblUSD $currencyUSD)" ; ?> per year.             

                            Master's tuition fee for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu ? number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)" . " to " . number_format($imu) . " " . $currency . " ($imuUSD $currencyUSD)": number_format($iml) . " " . $currency . " ($imlUSD $currencyUSD)"; ?> per year.</b></p>
                        <?php endif;
                    }
                 }
                }  elseif ($ibl > -1 )  {   ?>
                
                    <?php  if($ibl == 0) {
                        if( $ibu <= 0) { ?>
                            <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> are free.</b></p>
                            <?php } elseif($ibu > 0) { ?>
                                <?php if(has_usd_currency($country_name)) : ?>
                                <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu  ? 
                                number_format($ibl) . " " . $currency . " to " . number_format($ibu) . " " . $currency  : number_format($ibl) . " " . $currency; ?> per year.</b></p>
                                <?php else: ?>
                                    <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu  ? 
                                    number_format($ibl) . " " . $currency  . " ($iblUSD $currencyUSD)" . " to " . number_format($ibu) . " " . $currency  . " ($ibuUSD $currencyUSD)": number_format($ibl) . " " . $currency  . " ($iblUSD $currencyUSD)"; ?> per year.</b></p>
                                <?php endif?>
                            <?php } ?>
                        <?php } elseif( $ibl > 0 && $ibu > 0) { ?>
                            <?php if(has_usd_currency($country_name)) : ?>
                                <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu  ? 
                                number_format($ibl) . " " . $currency . " to " . number_format($ibu) . " " . $currency  : number_format($ibl) . " " . $currency; ?> per year.</b></p>
                            <?php else: ?>
                                <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu  ? 
                                number_format($ibl) . " " . $currency  . " ($iblUSD $currencyUSD)" . " to " . number_format($ibu) . " " . $currency  . " ($ibuUSD $currencyUSD)": number_format($ibl) . " " . $currency  . " ($iblUSD $currencyUSD)"; ?> per year.</b></p>
                            <?php endif?>
                        <?php  } else { ?>
                            <?php if(has_usd_currency($country_name)) : ?>
                                <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu  ? 
                                number_format($ibl)  : number_format($ibl) . " " . $currency; ?> per year.</b></p>
                            <?php else: ?>
                                <p><b>The Bachelor's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $ibl != $ibu ? 
                                number_format($ibl) . " " . $currency  . " ($iblUSD $currencyUSD)": number_format($ibl) . " " . $currency  . " ($iblUSD $currencyUSD)"; ?> per year.</b></p>
                            <?php endif; ?>
                        
                    <?php }
                } elseif ($iml > -1) { 

                    if($iml == 0) {
                        if( $imu <= 0) { ?>
                            <p><b>The Master's tuition fees for international students at <?php echo $institution_title ?> are free.</b></p>
                        <?php } elseif($imu > 0) { ?>
                                <?php if(has_usd_currency($country_name)) : ?>
                                <p><b>The Master's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu  ? 
                                number_format($iml) . " " . $currency . " to " . number_format($imu) . " " . $currency  : number_format($iml) . " " . $currency; ?> per year.</b></p>
                                <?php else: ?>
                                    <p><b>The Master's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu  ? 
                                    number_format($iml) . " " . $currency  . " ($imlUSD $currencyUSD)" . " to " . number_format($imu) . " " . $currency  . " ($imuUSD $currencyUSD)": number_format($iml) . " " . $currency  . " ($imlUSD $currencyUSD)"; ?> per year.</b></p>
                                <?php endif?>
                            <?php } ?>
                        <?php } elseif( $iml > 0 && $imu > 0) { ?>
                            <?php if(has_usd_currency($country_name)) : ?>
                                <p><b>The Master's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu  ? 
                                number_format($iml) . " " . $currency . " to " . number_format($imu) . " " . $currency  : number_format($iml) . " " . $currency; ?> per year.</b></p>
                            <?php else: ?>
                                <p><b>The Master's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu  ? 
                                number_format($iml) . " " . $currency  . " ($imlUSD $currencyUSD)" . " to " . number_format($imu) . " " . $currency  . " ($imuUSD $currencyUSD)": number_format($iml) . " " . $currency  . " ($imlUSD $currencyUSD)"; ?> per year.</b></p>
                            <?php endif?>
                        <?php  } else { ?>
                            <?php if(has_usd_currency($country_name)) : ?>
                                <p><b>The Master's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu  ? 
                                number_format($iml)  : number_format($iml) . " " . $currency; ?> per year.</b></p>
                            <?php else: ?>
                                <p><b>The Master's tuition fees for international students at <?php echo $institution_title ?> is <?php echo $iml != $imu ? 
                                number_format($iml) . " " . $currency  . " ($imlUSD $currencyUSD)": number_format($iml) . " " . $currency  . " ($imlUSD $currencyUSD)"; ?> per year.</b></p>
                            <?php endif; ?>
                        
                    <?php }
            
            } ?>
                
                <?php  if($ibu == 0 && $imu == 0 ){ ?>

                <p><?php echo $institution_title; ?> is one of the few universities in the world offering free tuition. This is one of the main reasons why 
                <?php echo $institution_title;  ?> is a popular choice among international students.</p>

                <?php } if($ibu == 0 && $imu > 0  ) { ?>
                <p><?php echo $institution_title; ?> is one of the few universities in the world offering free tuition for a Bachelor's degree. This is one of the main reasons why 
                <?php echo $institution_title;  ?> is a popular choice among international students. 
                However, only students at the Bachelor’s level are granted this offer. Master’s students will still need to pay an amount for tuition.</p> 

                <?php } 

                if( $ibu > -1 && $imu == 0 ){?>  


                <p><?php echo $institution_title; ?> is one of the few universities in the world offering free tuition for a Master's degree. This is one of the main reasons why 
                <?php echo $institution_title;  ?> is a popular choice among international students. 
                However, only students at the Master’s level are granted this offer. If you are an undergraduate, you will still need to pay an amount for tuition.</p>


                <?php  }  ?>

            
            <p>When studying abroad, it is best to save as much money as you can. After all, there are other costs to consider besides tuition fees, such as accommodation, meals, transportation, and books.</p>

            <?php if($number_of_scholarships > 0) { ?>

            <?php if($number_of_scholarships > 1) : ?>
            <p>The scholarships at <?php echo $institution_title; ?> can help fund your study expenses. There are currently <?php echo $number_of_scholarships; ?> scholarships being offered to international students at the <?php echo $institution_title; ?>, all with varying requirements, benefits, and application processes. We have compiled them in this list to help you find the scholarship that best fits you.
            </p>
            <?php elseif($number_of_scholarships == 1) : ?>
                <p><?php echo $institution_title; ?> offers a great opportunity for students to experience high-quality education at a low cost. Currently,  <?php echo $institution_title; ?> offers 1 scholarship for international students. When applying, always take note of the requirements needed and the application process since most institutions are particular with every application they receive. As a help, we prepared a summary of all the things you need to know about this scholarship offering.</p>
            <?php endif; ?>
    <?php } ?>
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>
