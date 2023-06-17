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



?>


<div class="card-wide custom-ad-card px-3">
	<div class="row px-3 py-4">

		<div class="s-course-details">

				<a href="<?php echo $link ?>" target="_blank"><p class="custom-ad-heading"><?php echo $ad->post_title; ?></p></a>
            
                 
            
                    <div class="info-tags">
                        

                        <div class="tag-with-icon">
                            <span class="scholarship-amount"> Institution: <?php echo $institute->post_title; ?></span>
                        </div>
                        <div class="tag-with-icon">
                            <span class="scholarship-amount"> Country: <?php echo get_post_meta($institute->ID, 'adsIntCountry', true); ?></span>
                        </div>
                        <div class="tag-with-icon">
                            <span class="scholarship-amount"> Format: <?php echo get_post_meta($ad_id, 'course_format', true); ?></span>
                        </div>

                        <?php if ($intake_dates){ ?>
                        <div class="tag-with-icon">
                            <span class="scholarship-amount"> Intake Dates: <?php echo $intake_dates; ?></span>
                        </div>

                        <?php }?>
                       
                        
                        
                        <?php if ($domestic_tuition_fees || $international_tuition_fees) { ?>
                        <div class="tag-with-icon">
                            <span class="scholarship-amount"> Annual Tuition Fee: 
                                  
                                  <?php if (empty($domestic_tuition_fees) && !empty($international_tuition_fees)) {
                                      echo number_format($international_tuition_fees) . ' ' . $currency . ' (International)';
                                  } elseif (!empty($domestic_tuition_fees) && empty($international_tuition_fees)) {
                                      echo number_format($domestic_tuition_fees) . ' ' . $currency . ' (Domestic)';
                                  } elseif ($domestic_tuition_fees == $international_tuition_fees) {
                                      echo number_format($domestic_tuition_fees) . ' ' . $currency . ' (Domestic and International)';
                                  } else {
                                      echo number_format($domestic_tuition_fees) . ' ' . $currency . ' (Domestic) - ' . number_format($international_tuition_fees) . ' ' . $currency . ' (International)';
                                  } ?> 

                               
                                </span>
                        </div>
                    <?php } else { ?>

                     <?php if ($domestic_tuition_fees_INT || $international_tuition_fees_INT) { ?>
                        <div class="tag-with-icon">
                            <span class="scholarship-amount"> Annual Tuition Fee: 
                                  
                                  <?php if (empty($domestic_tuition_fees_INT) && !empty($international_tuition_fees_INT)) {
                                      echo number_format($international_tuition_fees_INT) . ' ' . $currency . ' (International)';
                                  } elseif (!empty($domestic_tuition_fees_INT) && empty($international_tuition_fees_INT)) {
                                      echo number_format($domestic_tuition_fees_INT) . ' ' . $currency . ' (Domestic)';
                                  } elseif ($domestic_tuition_fees_INT == $international_tuition_fees_INT) {
                                      echo number_format($domestic_tuition_fees_INT) . ' ' . $currency . ' (Domestic and International)';
                                  } else {
                                      echo number_format($domestic_tuition_fees_INT) . ' ' . $currency . ' (Domestic) - ' . number_format($international_tuition_fees_INT) . ' ' . $currency . ' (International)';
                                  } ?> 

                               
                                </span>
                        </div>
                    <?php }} ?>
                       
                        
                        
                    </div> <!-- Info Tags -->
                <p>  
                <span class="description line-clamp-3"><?php echo get_post_meta($ad_id, 'description', true) ?> </span><span class="ad-read-more">Read More...</span> <span class="ad-read-less display-none-text">Read Less</span>

            </p>


            	<a href="<?php echo $link ?>" target="_blank"><div class="more-link filter-btn"><button>Apply Now</button></div></a>
            
 

		</div> <!-- Course Details -->
	</div> <!-- Row px -3 -->
</div> <!-- Card Wide -->