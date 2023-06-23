// console.log("DFADFS")

// // Get the element that contains the list of countries
// const countryList = document.querySelector('.gs-scholarship-eligible-countries');
// console.log("countryList", countryList)

// // Split the list of countries into an array
// const countries = countryList.textContent.trim().split(', ');

// console.log("countries", countries)
// const toggleLink = document.getElementById('toggle-link');

// if(countries != 'All Nationalities') {

//     // Display the first 3 countries
//     const firstThreeCountries = countries.slice(0, 3);
//     countryList.textContent = firstThreeCountries.join(', ');

//     // Add a click event listener to the toggle link
//     toggleLink.addEventListener('click', function (event) {
//         console.log("event", event.target)
//     event.preventDefault();

//     // Check whether to show more or show less
//     if (toggleLink.textContent === 'Show more') {
//         // Display all the countries
//         countryList.textContent = countries.join(', ');

//         // Update the link text
//         toggleLink.textContent = 'Show less';
//     } else {
//         // Display only the first 3 countries
//         countryList.textContent = firstThreeCountries.join(', ');

//         // Update the link text
//         toggleLink.textContent = 'Show more';
//     }
//     });
// }



jQuery(document).ready(function($) {
    // Get the value of the hidden input
    const eligibleCountries = $('.gs-scholarship-eligible-countries').val();
  
    // Split the list of countries into an array
    const countries = eligibleCountries.trim().split(', ');
  
    // Display the first 3 countries
    const firstThreeCountries = countries.slice(0, 3);
    $('.gs-scholarship-nationalities').text(firstThreeCountries.join(', '));
  
    // Add a click event listener to the toggle link
    $('#toggle-link').click(function(event) {
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