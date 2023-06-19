<?php 

$institute = get_post(get_post_meta($ad_id, 'adsInstitution', true));

$link_post_meta = get_post_meta($ad_id, 'link', true);
if (!empty($link_post_meta)){
  
    $link = $link_post_meta;
} else {
  
    $link = get_post_meta($institute->ID, 'adsIntLink', true);
}





$intake_post_meta = get_post_meta($ad_id, 'intake_dates', true);
if (!empty($intake_post_meta)){
    $intake_dates = $intake_post_meta;
} else {
    $intake_dates = get_post_meta($institute->ID, 'intake_dates', true);
}



// New Code 

$domestic_tuition_fees_INT = get_post_meta($institute->ID, 'domestic_tuition_fees' , true);
$international_tuition_fees_INT = get_post_meta($institute->ID, 'international_tuition_fees' , true);

$domestic_tuition_fees = get_post_meta($ad_id, 'domestic_tuition_fees' , true);
$international_tuition_fees = get_post_meta($ad_id, 'international_tuition_fees' , true);

$country = get_post_meta($institute->ID, 'adsIntCountry', true);

$currency = get_currency($country);




$image_url = get_the_post_thumbnail_url($institute->ID);




?>

<a href="<?php echo $link ?>" target="_blank">
<div class="col-lg-12 my-2 course-card-new " style=" border-radius:5px;box-shadow: 0px 2px 2px rgba(128, 128, 128, 0.3);margin-bottom:20px;padding-bottom:20px !important;">
                
                <div class="col-md-8" >
                    <div class="row" style="margin-bottom:10px !important">
                        
                    <div class="course-img" style="width:100px;float:left;">
                    <?php  if($image_url) {
                              
                     ?>
                   <img  style="width:130px;padding:5px;height: 100px;margin-top:0px;" src="<?php echo $image_url; ?>">
                   <?php  } else { ?>
                  <img  style="width:130px;height: 100px;" src="<?php echo site_url(); ?>/wp-content/uploads/2023/04/Logo-Fleming.png">
                <?php  } ?>
                    </div>

                         <div class="opencourse-title" style=" display: flex;
  flex-direction: column;
  justify-content: center;
  min-height: 100px;float:left;width: calc(100% - 130px);">
                        <h2 style="font-size:26px;line-height:30px !important;color:black;padding-bottom: 0px;padding-top:0px;margin-bottom: 0px;"> <?php echo $ad->post_title; ?> </h2>
                        <p style="margin-bottom:0px;font-size:15px ;line-height:22px ;color:black !important;margin-top:0px;padding-top:0px;padding-top:2px;line-height: 20px !important;"> <?php

                         echo $institute->post_title; ?></p>
                       </div>

                    </div>
                        
                        <div class="clearfix"> </div>

                    <div  class="right-aside right-mobile" style="display:none;padding-top:5px">
                
                <p style="width:45%;float:left;font-size:12px !important;line-height:18px;color:black;font-weight: 400;height:40px;margin-bottom:6px;"> 
                    <span>  <img style="width:24px;height: 24px;float:left;margin-right:4px;" src="https://globalscholarships.com/wp-content/uploads/2023/04/ocp-icon-4.png"> </span>
                    <span style="float:left;line-height: 24px;"> <?php echo get_post_meta($institute->ID, 'adsIntCountry', true); ?> </span>
                </p>

                 

                <p style="width:55%;float:left;font-size:12px !important; line-height: 18px; color:black;  font-weight: 400;height:40px;margin-bottom:6px;" > 
                    <span style="float:left;">  
                 <img style="width:24px;height: 24px;margin-right:4px;" src="https://globalscholarships.com/wp-content/uploads/2023/04/ocp-icon-6.png"> </span> 
                 
                 <span style="float:left;line-height: 24px;"> <?php echo get_post_meta($ad_id, 'course_format', true); ?> </span>

                 </p>
                  
                   <div class="clearfix"> </div>

              
                <p style="line-height:18px !important; color:black;font-size:12px !important;margin-left:0px;font-weight: 400;margin-bottom:20px;"> 
                    
                    <span style="float:left;width:32px;">
                        <img style="width:24px;height: 24px;margin-right:4px;" src="https://globalscholarships.com/wp-content/uploads/2023/04/ocp-icon-5.png">
                         </span> 

                    <span style="float:left;  width: calc(100% - 32px) !important; line-height: 24px;"><?php echo $intake_dates; ?></span></p> 
                     <div class="clearfix"> </div> 
               </div>


                  <div class="clearfix"> </div>

                    <div class="row">
                        <p id="short" style="font-size:12px;line-height: 18px !important;padding-right:3%;color:black;">
                            <?php $des = get_post_meta($ad_id, 'description', true);

                             if (strlen($des) > 200) {
    $des = substr($des, 0, 200);
    $des = $des . ' <span class="read-more" style="font-size:12px;font-weight:600;margin-left:5px;border-bottom:1px solid #77a6c9 ;color:#77a6c9;"> Read More </span>';
}

echo $des;
                             ?>
                        </p>

                          <p id="full" style="height:auto;display:none;font-size:12px;line-height: 18px !important;padding-right:3%;color:black;">
                            <?php $des = get_post_meta($ad_id, 'description', true);
                            echo $des;
                             ?>
                        </p>


                    </div>

<div class="clearfix"> </div>
                    <div class="row funded-line" style="position:absolute;bottom:0px;margin-top:0px;">
                      
                     <p  style="font-size:12px;line-height: 18px;color:black;margin-bottom:0px !important;
                     line-height: 22px !important;">
                       
                       

                              
                       <span title="We work closely with these partner universities to match you with the best possible courses"  style="font-size:14px; font-weight: 600; display: block;"> Partner University  
                                  <i style="margin-left:5px;margin-top:5px;color:gray;" class="fas fa-exclamation-circle"></i>
                               </span>
                           <span style="width:100% !important;">
                           <strong>  *<?php echo $institute->post_title; ?>  does not offer fully-funded scholarships.  </strong>
                         </span> 
                              
                        </p>
                    </div>

                </div>

               <div class="col-md-4" style="border-left:1px solid #77a6c9;">
                <div  class="right-aside right-desktop" style="padding-top:5px">
                
                <p style="font-size:13px !important;color:black;font-weight: 400;height:40px;margin-bottom:0px;"> 
                    <span>  <img style="width:28px;height: 28px;float:left;margin-right:8px;" src="https://globalscholarships.com/wp-content/uploads/2023/04/ocp-icon-4.png"> </span>
                    <span style="float:left;margin-top:-2px;"> <?php echo get_post_meta($institute->ID, 'adsIntCountry', true); ?> </span>
                </p>

                 <div class="clearfix"> </div>

                <p style="font-size:12px !important;  line-height:22px;color:black;  font-weight: 400;height:40px;margin-bottom:0px;" > 
                    <span style="float:left;">  
                 <img style="width:28px;height: 28px;margin-right:8px;" src="https://globalscholarships.com/wp-content/uploads/2023/04/ocp-icon-6.png"> </span> 
                 
                 <span style="float:left; margin-top:-2px;"> <?php echo get_post_meta($ad_id, 'course_format', true); ?> </span>

                 </p>
                  
                   <div class="clearfix"> </div>

              
                <p style="line-height:22px !important; color:black;font-size:13px !important;margin-left:0px;font-weight: 400;margin-bottom:10px;"> 
                    
                    <span style="float:left;width:39px;">
                        <img style="width:28px;height: 28px;margin-right:8px;" src="https://globalscholarships.com/wp-content/uploads/2023/04/ocp-icon-5.png">
                         </span> 

                    <span style="float:left;  width: calc(100% - 39px) !important; margin-top:-2px;  "><?php echo $intake_dates; ?></span></p>


                    <div class="clearfix"> </div> 
               </div>
                  <div class="clearfix"> </div>
                
                  
                <div style="
     padding-bottom:0px !important;margin-top:10px;width:100%;" class="annual-tuition annual-tuition-div" >

                <p style="line-height:20px;width:100%;text-align: center;font-size:13px ;
                font-weight: 700;float:left;margin-bottom:0px !important;color:black;" class="annual-tuition"> Annual Tuition Fee*  </p>

               

                <div class="clearfix"> </div>
               
                <div style="float:left;width:50% !important;border-right:1px solid gray !important;" class="domestic">
                     <p style="font-size:13px !important;margin-bottom:0px; color:black; text-align: center;line-height: 20px !important;">  <strong>Domestic</strong><br>

                      <?php if($domestic_tuition_fees){
                        echo number_format($domestic_tuition_fees)  ." ". $currency;
                      }  elseif($domestic_tuition_fees_INT) {
                        
                        echo number_format($domestic_tuition_fees_INT)  ." ". $currency;
                      }else {
                        
                        echo "N/A";
                      }
                     ?> </p></div>

                     <div style="float:left;width:50% !important;" class="international">
                     <p style="font-size:13px !important;margin-bottom:0px; color:black; text-align: center;
                      line-height: 20px !important;"> <strong> 
                      International </strong>
                      <br> 
                      
                      <?php
                      
                      if($international_tuition_fees){
                        echo number_format($international_tuition_fees) ." ".  $currency ;
                      }  elseif ($international_tuition_fees_INT)  {
                       
                        echo number_format($domestic_tuition_fees_INT)  ." ". $currency;
                      }else {

                           echo "N/A";
                      
                     }

                       ?>

                       </p></div>

                
                <div class="clearfix"> </div>
                <div class="row funded-line-mobile" style="display:none;padding-top:10px;margin-top:10px;">
                     <p style="padding-left:20px;font-size:12px;line-height: 18px !important;color:black;text-align: left !important;">

                          
                         <span title="We work closely with these partner universities to match you with the best possible courses."  style="font-size:14px; margin-bottom:10px;font-weight: 600; display: block;"> Partner University  
                                  <i style="margin-left:5px;margin-top:5px;color:gray;" class="fas fa-exclamation-circle"></i>
                               </span>

                         <strong> *<?php echo $institute->post_title; ?>  does not offer fully-funded scholarships.  </strong>
                           
                        </p>
                    </div>



              </div>

                 
                   
            
               </div>

            </div>
        </a>

          <div class="clearfix"> </div>
          <br>