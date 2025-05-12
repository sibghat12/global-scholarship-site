<?php
/**
 * The template for displaying single posts adschool
 *
 * @package Donovan
 */

    require(dirname(__DIR__, 1) . '/functions/countries_list_adschool.php');

    $post_id = get_the_ID();

    $excludeCountriesFields = get_field_object('excludeCountries');

    $allCountriesChoices = $excludeCountriesFields['choices'];


    $allCountriesTheChoices = array();
    foreach ($allCountriesChoices as $key => $value) {
        array_push($allCountriesTheChoices, $value);
    }


 $include_region = get_field('include_regions', $post_id);

 $exclude_region = get_field('exclude_regions', $post_id);
 $theExcludedCountries = array();

 if($include_region) {

     $theIncludedCountries = array();
     foreach ($include_region as $key => $region) {
         array_push($theIncludedCountries, $All_Countries_Array[$region]);
     }

     $theIncludedCountries = array_merge(...$theIncludedCountries);
     
     $theExcludedCountries  = array_diff($allCountriesTheChoices, $theIncludedCountries);


     update_field('excludeCountries', $theExcludedCountries, $post_id);

     delete_field('include_regions');

     
 } elseif($exclude_region) {


     foreach ($exclude_region as $key => $region) {
         array_push($theExcludedCountries, $All_Countries_Array[$region]);
     }

     // Flatten the Exlcude Countries
     $theExcludedCountries = array_merge(...$theExcludedCountries);

     $oldExcludedCountries = get_field('excludeCountries', $post_id);

     $theExcludedCountries = array_merge($theExcludedCountries, $oldExcludedCountries);    

     update_field('excludeCountries', $theExcludedCountries, $post_id);
 }

 $Excluded_Countries_AdsInt = $theExcludedCountries;

 delete_field('exclude_regions');

?>


<article id="institutions-<?php the_ID(); ?>" class="institutions-posts">


	<div class="post-content">

		<header class="entry-header">
        

        </header><!-- .entry-header -->

		</div><!-- .entry-content -->

    </div><!-- .post-content -->


<div class="entry-content clearfix">