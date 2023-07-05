<?php 
if($scholarship_type == 'Partial Funding') {
    $scholarship_type = 'partially funded';
} elseif($scholarship_type == 'Full Funding') {
    $scholarship_type = 'fully funded';
} elseif( $scholarship_type == 'Full Tuition') {
    $scholarship_type = 'full tuition';
}

?>
<p>
Do you want a scholarship in <?php echo $country_name; ?>? Consider studying at <?php echo $institution_name; ?>, a <?php echo strtolower($institution_type); ?> institution founded in <?php echo $founded_year; ?> and located in <?php echo $city_name . ", " . $country_name; ?>. This institution offers scholarships, which includes <?php echo $scholarship_title; ?>, one of the <?php echo $scholarship_type;?> scholarships for <?php echo strtolower($degrees_text); ?> students.
</p>