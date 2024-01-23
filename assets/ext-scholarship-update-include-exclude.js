jQuery(document).ready(function($) {
    

    // Include Regions

    // const include_regions_related_posts = document.getElementById('acf-field_654dad4dd4b11-All-Countries');
    // console.log("include_regions_related_posts", include_regions_related_posts)
    // const include_regions_related_posts_ul = include_regions_related_posts.closest('ul');
    // include_regions_related_posts_ul.classList.add('include_region_related_class');
        
    // // Exclude Regions

    // const exclude_regions_checkbox_related_posts = document.getElementById('acf-field_654dad4dd4b4a-All-Countries');
    // const regons_related_posts_ul = exclude_regions_checkbox_related_posts.closest('ul');
    // regons_related_posts_ul.classList.add('exclude_related_posts_regions_class');

    // // Excluded Countries

    // const exclude_countries_related_posts = document.getElementById('acf-field_65246ff2a2ac0-Afghanistan');
    // const exclude_countries_related_posts_ul = exclude_countries_related_posts.closest('ul');
    // exclude_countries_related_posts_ul.classList.add('exclude_countries_related_class');

    // console.log("HHHHHHHHHHHHHHHHERTERTERTER");


    /**
     * Include Regions Logic
     * 
     */
     // Fetch the JSON file with the countries list
     $.getJSON(my_ajax_object.countries_list, function(allRegions) {
        // console.log("allRegions", allRegions)
        // Listen for changes on the "include_regions" checkboxes
        $('input[name^="acf[field_654dad4dd4b11]"]').change(function() {
            // When a region is checked or unchecked
            var regionChecked = $(this).val(); // Get the value of the checked region
            var isChecked = $(this).is(':checked'); // Whether the checkbox was checked or unchecked

            // console.log("regionChecked", regionChecked)
            // console.log("$(this)", $(this))
            // console.log("isChecked", regionChecked + ' ' + $(this).is(':checked'))
            // Loop through all the countries in the checked region
            $.each(allRegions[regionChecked.replace(/\s+/g, '')] || [], function(index, country) {
                // Find the corresponding country checkbox in "eligible_nationality"
                $('input[name^="acf[field_654dad4dd4ad4]"]').each(function() {
                    if ($(this).val() === country) {
                        // Check or uncheck it based on the "include_regions" checkbox
                        $(this).prop('checked', isChecked);
                    }
                });
            });
        });
    });

    /**
     * 
     * Exclude Regions Logic
     */

    // Fetch the JSON file with the countries list
    $.getJSON(my_ajax_object.countries_list, function(allRegions) {
        // Initially, check all countries in "eligible_nationality"

        // Listen for changes on the "exclude_regions" checkboxes
        $('input[name^="acf[field_654dad4dd4b4a]"]').change(function() {
            $('input[name^="acf[field_654dad4dd4ad4]"]').prop('checked', true);

            // When a region is checked or unchecked
            var regionChecked = $(this).val(); // Get the value of the checked region
            var isChecked = $(this).is(':checked'); // Whether the checkbox was checked or unchecked

            // Loop through all the countries in the checked region
            $.each(allRegions[regionChecked.replace(/\s+/g, '')] || [], function(index, country) {
                // Find the corresponding country checkbox in "eligible_nationality"
                $('input[name^="acf[field_654dad4dd4ad4]"]').each(function() {
                    if ($(this).val() === country) {
                        // Uncheck it if the region is checked, and vice versa
                        $(this).prop('checked', !isChecked);
                    }
                });
            });
        });
    });


        // Fetch the JSON file with the countries list
        $.getJSON(my_ajax_object.countries_list, function(allRegions) {
            // Function to update "eligible_nationality" based on selected "exclude_regions"
            function updateEligibleNationality() {
                // Initially, check all countries in "eligible_nationality"
                $('input[name^="acf[field_654dad4dd4ad4]"]').prop('checked', true);
    
                // Get all checked "exclude_regions"
                $('input[name^="acf[field_654dad4dd4b4a]"]:checked').each(function() {
                    var regionChecked = $(this).val(); // Get the value of the checked region
                    
                    // Loop through all the countries in the checked region
                    $.each(allRegions[regionChecked.replace(/\s+/g, '')] || [], function(index, country) {
                        // Find the corresponding country checkbox in "eligible_nationality"
                        $('input[name^="acf[field_654dad4dd4ad4]"]').each(function() {
                            if ($(this).val() === country) {
                                // Uncheck the country
                                $(this).prop('checked', false);
                            }
                        });
                    });
                });
            }
    
            // Listen for changes on the "exclude_regions" checkboxes
            $('input[name^="acf[field_654dad4dd4b4a]"]').change(function() {
                updateEligibleNationality();
            });
        });
});