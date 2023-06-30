
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
        $(this).parent().find('.ellipsis').removeClass('show');
        $(this).parent().find('.ellipsis').addClass('hide');
    } else {
        // Display only the first 3 countries
        $('.gs-scholarship-nationalities').text(firstThreeCountries.join(', '));
  
        // Update the link text
        $(this).text('Show more');
        $(this).parent().find('.ellipsis').removeClass('hide');
        $(this).parent().find('.ellipsis').addClass('show');
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
        $(this).parent().find('.ellipsis').removeClass('show');
        $(this).parent().find('.ellipsis').addClass('hide');
    } else {
        // Display only the first 3 subjects
        $('.gs-scholarship-subjects').text(firstThreeSubjects.join(', '));
  
        // Update the link text
        $(this).text('Show more');
        $(this).parent().find('.ellipsis').removeClass('hide');
        $(this).parent().find('.ellipsis').addClass('show');
      }
    });
  });

// DOM content loaded

document.addEventListener('DOMContentLoaded', getActiveSection);
document.addEventListener('DOMContentLoaded', getFeebackForm);

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
function getFeebackForm() {
  const yesBtn = document.querySelector('input[value="Yes"]');
  const noBtn = document.querySelector('input[value="No"]');
  const radioInputs = document.querySelectorAll('input[type="radio"]');
  const otherTextarea = document.querySelector('textarea[name="other_improvement"]');
  const buttonsDiv = document.querySelector('.gs-feedback-form-buttons');
  const form = document.querySelector('#gs-feeback-form');

  yesBtn.addEventListener('click', function() {
    buttonsDiv.style.display = "block";
    document.querySelector('.step-2').style.display = "none";
  });

  noBtn.addEventListener('click', function() {
    buttonsDiv.style.display = "block";
    document.querySelector('.step-2').style.display = "block";
    for (var i = 0; i < radioInputs.length; i++) {
      radioInputs[i].parentElement.style.display = "block";
    }
    otherTextarea.style.display = "block";
  });

  for (var i = 0; i < radioInputs.length; i++) {
    radioInputs[i].addEventListener('click', function() {
      if (this.value === "other") {
        otherTextarea.style.display = "block";
      } else {
        otherTextarea.style.display = "none";
      }
    });
  }

  // form.addEventListener('submit', function(event) {
  //   event.preventDefault();
    // var formData = new FormData(form);
    
  // for (var [key, value] of formData.entries()) { 
  //   console.log(key, value);
  // }
    // jQuery.ajax({
    //   url: frontendajax.ajaxurl,
    //   type: 'POST',
    //   dataType: 'json',
    //   action: 'process_feedback_form',
    //   data: formData,
    //   processData: false,
    //   contentType: false,
    //   success: function(response) {
    //     console.log(response);
    //   },
    //   error: function(xhr, status, error) {
    //     console.log("Ajax request failed: " + status + ", " + error);
    //   }
    // });

    jQuery( '[name="submit"]' ).click( function(e) {
      var data = {
        action: 'feedback_form',
        'helpful': document.querySelector('input[name="helpful"]:checked').value,
        'improvement' : document.querySelector('input[name="improvement"]:checked').value,
        'other_improvement': document.querySelector('textarea[name="other_improvement"]').value,
        'scholarship_info': {
          url: document.querySelector('input[name="current_scholarship_info"]').getAttribute('data-scholarship-url'),
          id: document.querySelector('input[name="current_scholarship_info"]').getAttribute('data-scholarship-id'),
          title: document.querySelector('input[name="current_scholarship_info"]').getAttribute('data-scholarship-title'),
        },
      };
      e.preventDefault();
      jQuery.post( 
        frontendajax.ajaxurl, 
          data,                   
          function( response ) {
              // ERROR HANDLING
              console.log(response)
          }
      ); 
  });
  // });
}
