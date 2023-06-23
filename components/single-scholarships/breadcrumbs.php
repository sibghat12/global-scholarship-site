<div style="padding-left:15px;" class="breadcrumbs">
        <a href="<?php echo site_url(); ?>/scholarship-search/<?php echo $hyphenated ?>"> <?php echo $country_name; ?> Scholarships  </a> /
        <a href="<?php echo get_permalink($institution->ID); ?>"> <?php echo $institution_name ." Scholarships";  ?> </a> /
        <a href="#"> <?php  echo $scholarship_title; ?> </a>
        <br>
        <?php 
        if (count($degrees) == 1){ ?>
            
            <a href="<?php echo site_url(); ?>/scholarship-search/<?php echo $degrees_formatted_array[0] ?>">
            <?php  echo  $degrees[0] . " Scholarships  </a>" ?>
            
            <?php }

            else if (count($degrees) == 2){ ?>
                
            <a href="<?php echo site_url(); ?>/scholarship-search/<?php echo $degrees_formatted_array[0] ?>">
            <?php  echo  $degrees[0] . " Scholarships  </a>" ?>

            /  <a href="<?php echo site_url(); ?>/scholarship-search/<?php echo $degrees_formatted_array[1] ?>">
            <?php  echo  $degrees[1] . " Scholarships  </a>" ?>

            
            <?php } else if (count($degrees) == 3){  ?>

                <a href="<?php echo site_url(); ?>/scholarship-search/<?php echo $degrees_formatted_array[0] ?>">
                <?php  echo  $degrees[0] . " Scholarships  </a>" ?>

            /  <a href="<?php echo site_url(); ?>/scholarship-search/<?php echo $degrees_formatted_array[1] ?>">
            <?php  echo  $degrees[1] . " Scholarships  </a>" ?>


            /  <a href="<?php echo site_url(); ?>/scholarship-search/<?php echo $degrees_formatted_array[2] ?>">
            <?php  echo   $degrees[2] . " Scholarships  </a>" ?>
        
        <?php } 


            ?>
        

    </div>