jQuery(document).ready(function($) {

    // Fetch the JSON file with the countries list
    $.getJSON(my_ajax_object.countries_list, function(allRegions) {
        // Function to update "eligible_nationality" based on selected regions
        function updateEligibleNationality(include) {
            // Determine the initial state based on the action (include or exclude)
            var initialState = include ? false : true;
            $('input[name^="acf[field_654dad4dd4ad4]"]').prop('checked', initialState);

            // Function to process each region
            var processRegion = function(region, checkStatus) {
                // Loop through all the countries in the region
                $.each(allRegions[region.replace(/\s+/g, '')] || [], function(index, country) {
                    // Find the corresponding country checkbox in "eligible_nationality"
                    $('input[name^="acf[field_654dad4dd4ad4]"]').each(function() {
                        if ($(this).val() === country && $(this).val() !== "All Nationalities") {
                            // Set the checkbox status, skip if it's "All Nationalities"
                            $(this).prop('checked', checkStatus);
                        }
                    });
                });
            };


            // Process "include_regions" or "exclude_regions"
            $('input[name^="acf[field_' + (include ? '654dad4dd4b11' : '654dad4dd4b4a') + ']"]:checked').each(function() {
                var regionChecked = $(this).val();
                processRegion(regionChecked, include);
            });
        }

            // Function to sync the selection between include and exclude regions
            function syncRegionSelection(changedFieldKey, otherFieldKey) {
                var checkedRegions = [];
                // Collect all checked regions in the changed field
                $('input[name^="acf[' + changedFieldKey + ']"]:checked').each(function() {
                    checkedRegions.push($(this).val());
                });

                // Check all in the other field except those in the checkedRegions
                $('input[name^="acf[' + otherFieldKey + ']"]').each(function() {
                    $(this).prop('checked', !checkedRegions.includes($(this).val()));
                });

            }

            // Listen for changes on the "include_regions" checkboxes
            $('input[name^="acf[field_654dad4dd4b11]"]').change(function() {
                updateEligibleNationality(true);
                syncRegionSelection('field_654dad4dd4b11', 'field_654dad4dd4b4a');
            });

            // Listen for changes on the "exclude_regions" checkboxes
            $('input[name^="acf[field_654dad4dd4b4a]"]').change(function() {
                updateEligibleNationality(false);
                syncRegionSelection('field_654dad4dd4b4a', 'field_654dad4dd4b11');
            });
    });
});