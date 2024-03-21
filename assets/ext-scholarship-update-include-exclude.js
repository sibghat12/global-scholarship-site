jQuery(document).ready(function($) {

    // Fetch the JSON file with the countries list
    $.getJSON(my_ajax_object.countries_list, function(allRegions) {

        function updateEligibleNationality(include) {
            var initialState = include ? false : true;
            $('input[name^="acf[field_654dad4dd4ad4]"]').prop('checked', initialState);

            var processRegion = function(region, checkStatus) {
                $.each(allRegions[region.replace(/\s+/g, '')] || [], function(index, country) {
                    $('input[name^="acf[field_654dad4dd4ad4]"]').each(function() {
                        if ($(this).val() === country && $(this).val() !== "All Nationalities") {
                            $(this).prop('checked', checkStatus);
                        }
                    });
                });
            };

            $('input[name^="acf[field_' + (include ? '654dad4dd4b11' : '654dad4dd4b4a') + ']"]:checked').each(function() {
                var regionChecked = $(this).val();
                processRegion(regionChecked, include);
            });
        }

        function syncRegionSelection(changedFieldKey, otherFieldKey) {
            var checkedRegions = [];
            $('input[name^="acf[' + changedFieldKey + ']"]:checked').each(function() {
                checkedRegions.push($(this).val());
            });

            $('input[name^="acf[' + otherFieldKey + ']"]').each(function() {
                $(this).prop('checked', !checkedRegions.includes($(this).val()));
            });
        }

        $('input[name^="acf[field_654dad4dd4b11]"]').change(function() {
            updateEligibleNationality(true);
            syncRegionSelection('field_654dad4dd4b11', 'field_654dad4dd4b4a');
        });

        $('input[name^="acf[field_654dad4dd4b4a]"]').change(function() {
            updateEligibleNationality(false);
            syncRegionSelection('field_654dad4dd4b4a', 'field_654dad4dd4b11');
        });

        // Handle "All Nationalities" checkbox
        $('input[name^="acf[field_654dad4dd4ad4]"][value="All Nationalities"]').change(function() {
            if ($(this).is(':checked')) {
                // Deselect all other checkboxes
                $('input[name^="acf[field_654dad4dd4ad4]"]').not(this).prop('checked', false);
            }
        });

        // Prevent selecting "All Nationalities" with any other nationality
        $('input[name^="acf[field_654dad4dd4ad4]"]').not('[value="All Nationalities"]').change(function() {
            if ($(this).is(':checked')) {
                // Deselect "All Nationalities" checkbox
                $('input[name^="acf[field_654dad4dd4ad4]"][value="All Nationalities"]').prop('checked', false);
            }
        });

    });
});
