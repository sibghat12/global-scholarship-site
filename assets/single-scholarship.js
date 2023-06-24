
jQuery(document).ready(function($) {
    // Get the value of the hidden input
    const eligibleCountries = $('.gs-scholarship-eligible-countries').val();
  
    // Split the list of countries into an array
    const countries = eligibleCountries.trim().split(', ');
  
    // Display the first 3 countries
    const firstThreeCountries = countries.slice(0, 3);
    $('.gs-scholarship-nationalities').text(firstThreeCountries.join(', '));
  
    // Add a click event listener to the toggle link
    $('.gs-scholarship-nationalities-container #toggle-link').click(function(event) {
      event.preventDefault();

    // Check whether to show more or show less
    if ($(this).text() === 'Show more') {
        // Display all the countries
        $('.gs-scholarship-nationalities').text(countries.join(', '));
  
        // Update the link text
        $(this).text('Show less');
        $(this).parent().find('.elipsis').removeClass('show');
        $(this).parent().find('.elipsis').addClass('hide');
    } else {
        // Display only the first 3 countries
        $('.gs-scholarship-nationalities').text(firstThreeCountries.join(', '));
  
        // Update the link text
        $(this).text('Show more');
        $(this).parent().find('.elipsis').removeClass('hide');
        $(this).parent().find('.elipsis').addClass('show');
      }
    });
  });

jQuery(document).ready(function($) {
    // Get the value of the hidden input
    const eligibleSubjects = $('.gs-scholarship-eligible-subjects').val();
  
    // Split the list of subjects into an array
    const subjects = eligibleSubjects.trim().split(', ');
  
    // Display the first 3 subjects
    const firstThreeSubjects = subjects.slice(0, 3);
    $('.gs-scholarship-subjects').text(firstThreeSubjects.join(', '));
  
    // Add a click event listener to the toggle link
    $('.gs-scholarship-subjects-container #toggle-link').click(function(event) {
      event.preventDefault();
  
    // Check whether to show more or show less
    if ($(this).text() === 'Show more') {
        // Display all the subjects
        $('.gs-scholarship-subjects').text(subjects.join(', '));
  
        // Update the link text
        $(this).text('Show less');
        $(this).parent().find('.elipsis').removeClass('show');
        $(this).parent().find('.elipsis').addClass('hide');
    } else {
        // Display only the first 3 subjects
        $('.gs-scholarship-subjects').text(firstThreeSubjects.join(', '));
  
        // Update the link text
        $(this).text('Show more');
        $(this).parent().find('.elipsis').removeClass('hide');
        $(this).parent().find('.elipsis').addClass('show');
      }
    });
  });