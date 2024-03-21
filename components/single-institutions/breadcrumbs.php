<?php 
        if($number_of_scholarships > 0 ) :
?>
<!-- <div class="gs-institutions-breadcrumbs">
        <a class="gs-institutions-breadcrumb-home" href="<?php echo site_url(); ?>">Home</a> >
        <a class="gs-institutions-breadcrumb-home" href="<?php echo site_url(); ?>/scholarship-search/<?php echo $hyphenated ?>"><?php echo $country_name ." Scholarships";  ?></a> >
        <a class="gs-institutions-breadcrumb-institution" href="#"> <?php  echo $title; ?> </a>
        <br>
</div> -->

<?php
if (function_exists('rank_math_the_breadcrumbs')) { 
        rank_math_the_breadcrumbs();
         }
?>

<?php endif;
