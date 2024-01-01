jQuery(document).ready(function($) {

    function gs_ext_hosting_countries() {
            // Get the value of the hidden input
        if($('.gs-ext-scholarship-hosting-countries')) {

            const hostingCountries = $('.gs-ext-scholarship-hosting-countries').val();
        
            // Split the list of countries into an array
            if(hostingCountries){
    
            const countries = hostingCountries.trim().split(', ');
            
            // Display the first 3 countries
            const firstThreeCountries = countries.slice(0, 3);
            $('.gs-ext-scholarship-hosting-country').text(firstThreeCountries.join(', '));
            
            // Add a click event listener to the toggle link
            $('.gs-ext-scholarship-hosting-country-container #toggle-link').click(function(event) {
                event.preventDefault();
        
            // Check whether to show more or show less
            if ($(this).text() === 'Show more') {
                // Display all the countries
                $('.gs-ext-scholarship-hosting-country').text(countries.join(', '));
            
                // Update the link text
                $(this).text('Show less');
                $(this).parent().find('.ellipsis').removeClass('show');
                $(this).parent().find('.ellipsis').addClass('hide');
            } else {
                // Display only the first 3 countries
                $('.gs-ext-scholarship-hosting-country').text(firstThreeCountries.join(', '));
            
                // Update the link text
                $(this).text('Show more');
                $(this).parent().find('.ellipsis').removeClass('hide');
                $(this).parent().find('.ellipsis').addClass('show');
                }
            });
            }
        }
    }

    function gs_ext_eligible_nationalities() {
            // Get the value of the hidden input
        if($('.gs-ext-scholarship-eligible-nationalities')) {

            const hostingCountries = $('.gs-ext-scholarship-eligible-nationalities').val();
        
            // Split the list of countries into an array
            if(hostingCountries){
    
            const countries = hostingCountries.trim().split(', ');
            
            // Display the first 3 countries
            const firstThreeCountries = countries.slice(0, 3);
            $('.gs-ext-scholarship-nationalities').text(firstThreeCountries.join(', '));
            
            // Add a click event listener to the toggle link
            $('.gs-ext-scholarship-nationalities-container #toggle-link').click(function(event) {
                event.preventDefault();
        
            // Check whether to show more or show less
            if ($(this).text() === 'Show more') {
                // Display all the countries
                $('.gs-ext-scholarship-nationalities').text(countries.join(', '));
            
                // Update the link text
                $(this).text('Show less');
                $(this).parent().find('.ellipsis').removeClass('show');
                $(this).parent().find('.ellipsis').addClass('hide');
            } else {
                // Display only the first 3 countries
                $('.gs-ext-scholarship-nationalities').text(firstThreeCountries.join(', '));
            
                // Update the link text
                $(this).text('Show more');
                $(this).parent().find('.ellipsis').removeClass('hide');
                $(this).parent().find('.ellipsis').addClass('show');
                }
            });
            }
        }
    }

    function gs_ext_eligible_programs() {
            // Get the value of the hidden input
        if($('.gs-ext-scholarship-eligible-programs')) {

            const hostingCountries = $('.gs-ext-scholarship-eligible-programs').val();
        
            // Split the list of countries into an array
            if(hostingCountries){
    
            const countries = hostingCountries.trim().split(', ');
            
            // Display the first 3 countries
            const firstThreeCountries = countries.slice(0, 3);
            $('.gs-ext-scholarship-programs').text(firstThreeCountries.join(', '));
            
            // Add a click event listener to the toggle link
            $('.gs-ext-scholarship-programs-container #toggle-link').click(function(event) {
                event.preventDefault();
        
            // Check whether to show more or show less
            if ($(this).text() === 'Show more') {
                // Display all the countries
                $('.gs-ext-scholarship-programs').text(countries.join(', '));
            
                // Update the link text
                $(this).text('Show less');
                $(this).parent().find('.ellipsis').removeClass('show');
                $(this).parent().find('.ellipsis').addClass('hide');
            } else {
                // Display only the first 3 countries
                $('.gs-ext-scholarship-programs').text(firstThreeCountries.join(', '));
            
                // Update the link text
                $(this).text('Show more');
                $(this).parent().find('.ellipsis').removeClass('hide');
                $(this).parent().find('.ellipsis').addClass('show');
                }
            });
            }
        }
    }

    gs_ext_hosting_countries();
    gs_ext_eligible_nationalities();
    gs_ext_eligible_programs();
});