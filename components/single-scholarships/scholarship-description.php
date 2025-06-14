<p>
Do you want a scholarship in <?php echo $country_name; ?>? Consider studying at <?php echo $institution_name; ?>, a <?php echo strtolower($institution_type); ?> institution founded in <?php echo $founded_year; ?> and located in <?php echo $city_name . ", " . $country_name; ?>. <?php echo $institution_name; ?> offers <?php echo $scholarship_title; ?>, one of the <?php echo get_adjective_scholarship_amount($scholarship_type);?> scholarships for <?php 
echo ( str_contains($degrees_text, 'PhD') ) ? str_replace('PhD', 'Ph.D.', $degrees_text) : $degrees_text; ?> students.
</p>