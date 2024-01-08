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

    function gs_ext_eligible_institutions() {
            // Get the value of the hidden input
        if($('.gs-ext-scholarship-eligible-institutions')) {

            const eligibleInstitutions = $('.gs-ext-scholarship-eligible-institutions').val();
        
            console.log("eligibleInstitutions",eligibleInstitutions)
            // Split the list of institutions into an array
            if(eligibleInstitutions){
    
            const institutions = eligibleInstitutions.trim().split(', ');
            
            // Display the first 3 institutions
            const firstThreeInstitutions = institutions.slice(0, 3);
            $('.gs-ext-scholarship-eligible-universities').text(firstThreeInstitutions.join(', '));
            
            // Add a click event listener to the toggle link
            $('.gs-ext-scholarship-eligible-universities-container #toggle-link').click(function(event) {
                event.preventDefault();
        
            // Check whether to show more or show less
            if ($(this).text() === 'Show more') {
                // Display all the institutions
                $('.gs-ext-scholarship-eligible-universities').text(institutions.join(', '));
            
                // Update the link text
                $(this).text('Show less');
                $(this).parent().find('.ellipsis').removeClass('show');
                $(this).parent().find('.ellipsis').addClass('hide');
            } else {
                // Display only the first 3 institutions
                $('.gs-ext-scholarship-eligible-universities').text(firstThreeInstitutions.join(', '));
            
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
    gs_ext_eligible_institutions();
});

// DOM content loaded

document.addEventListener('DOMContentLoaded', getActiveSection);

function getActiveSection() {
  // Get the current hash value
  var currentHash = window.location.hash;
  
  // Get all the navigation links
  var navLinks = document.querySelectorAll('.gs-scholarship-items-container a');
  
  // Loop through each navigation link to add or remove the "active" class
  navLinks.forEach(function(link) {
    // Get the link's hash value
    var linkHash = link.getAttribute('href');
    
    // Check if the link's hash matches the current hash
    if (linkHash === currentHash) {
      // Add the "active" class to the link
      link.classList.add('active');
    } else {
      // Remove the "active" class from the link
      link.classList.remove('active');
    }
    
    // Add a click event listener to the link to update the active section
    link.addEventListener('click', function(event) {
      // Prevent the default link behavior
      event.preventDefault();
      
      // Get the hash value of the clicked link
      var clickedHash = link.getAttribute('href');
      
      // Update the current hash value
      window.location.hash = clickedHash;
      
      // Update the active section
      getActiveSection();
    });
  });
}