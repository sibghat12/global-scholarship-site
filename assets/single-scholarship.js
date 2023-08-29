
jQuery(document).ready(function($) {
    // Get the value of the hidden input
    if($('.gs-scholarship-eligible-countries')) {

      const eligibleCountries = $('.gs-scholarship-eligible-countries').val();
    
      // Split the list of countries into an array
      if(eligibleCountries){

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
      }
    }

  });

jQuery(document).ready(function($) {
    // Get the value of the hidden input
    if($('.gs-scholarship-eligible-subjects')) {

      const eligibleSubjects = $('.gs-scholarship-eligible-subjects').val();
      const institutionTitle = $('.gs-scholarship-eligible-subjects').data('institution-title');
      let theEligibleSubjects = JSON.parse(eligibleSubjects);
    
      if(eligibleSubjects) {

        // Split the list of subjects into an array
        // const subjects = eligibleSubjects.trim().split(', ');

        // Display the first 3 subjects
        const firstThreeSubjects = theEligibleSubjects.slice(0, 3);
        let basicSubjectsText = convertArrayToText(firstThreeSubjects)
        let theSubjectText = '';

        if(basicSubjectsText.includes('All Subjects') && firstThreeSubjects.length >= 1 ) {
          theSubjectText += "All Subjects offered at " + institutionTitle;
        } else {
          theSubjectText += basicSubjectsText;
        }

        $('.gs-scholarship-subjects').text(theSubjectText);
        // Add a click event listener to the toggle link
        $('.gs-scholarship-subjects-container #toggle-link').click(function(event) {
          event.preventDefault();
      
        // Check whether to show more or show less
        if ($(this).text() === 'Show more') {
            // Display all the subjects
            $('.gs-scholarship-subjects').text(theEligibleSubjects.join(', '));
      
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
      }
    }
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
  const feedbackFormContainer = document.querySelector('.gs-feedback-form-container');
  const $buttonsDiv = jQuery('.gs-feedback-form-buttons');
  const form = document.querySelector('#gs-feedback-form');
  const spinner = document.querySelector('.lds-roller'); // new line

  const thankYouMessage = document.createElement('p'); // new line
  thankYouMessage.innerHTML = 'Thank you for your feedback.'; // new line

  jQuery(document).ready(function($) {
    // Hide all the step-2 divs initially
    $(".step-2").hide();
    $buttonsDiv.hide();
  
    // Get the labels
    var labelQuestion = $(".gs-feedback-radio-question");
  
    // Attach an event listener to each label
    labelQuestion.on("click", function() {
      // Get the value of the input associated with the label
      var value = $(this).find("input").val();
  
      // Hide all the step-2 divs
      $(".step-2").hide();
  
      // Show the step-2 div with the matching data-feedback-type attribute
      $(".step-2[data-feedback-type='" + value + "']").css({"display": "flex","flex-direction": "column"} );
      $buttonsDiv.show();
    });

    // Hide all the textareas initially
    $("textarea.gs-user-comment").hide();

    // Get the labels
    var labels = $(".gs-feedback-radio-label");

    // Attach an event listener to each label
    labels.on("click", function() {
      // Get the value of the input associated with the label
      var value = $(this).find("input").val();

      // Hide all the textareas
      $("textarea.gs-user-comment").hide();

      // Show the textarea with the matching name
      $("textarea.gs-user-comment[name='" + value + "_improvement']").show();
    });
  });

  
  jQuery('.gs-feedback-form-buttons [name="submit"]').click(function(e) {
    e.preventDefault();
    // Check if the input radio is checked
    var improvementRadio = document.querySelector('input[name="improvement"]:checked');
    if (!improvementRadio) {
      // Show error message
      alert('Please select an improvement type.');
      return;
    }
    // Get the value of the selected radio button
    // var improvement = improvementRadio.value;

    // // Check if the textarea for the selected radio button has value
    // var textarea = document.querySelector('textarea[name="' + improvement + '_improvement"]');
    // if (textarea.value == '') {
    //   // Show error message
    //   alert('Please provide feedback for the selected improvement type.');
    //   return;
    // }
        // Get the value of the selected radio button
        var improvement = document.querySelector('input[name="improvement"]:checked').value;
        var warning = document.querySelector(`.improvement_warning`);
        var textareas = document.querySelectorAll('textarea[name^="' + improvement + '_improvement"]');
    
        // Check if the textarea for the selected radio button is empty
        var textarea = document.querySelector('textarea[name="' + improvement + '_improvement"]');
        if (textarea.value == '') {
          // Append warning message
          if (!warning) {
            warning = document.createElement('div');
            warning.classList.add('improvement_warning')
            warning.style.color             = "#ca0000";
            warning.style.fontSize          = "16px";
            warning.style.border            = "1px solid #2da6ff";
            warning.style.borderRadius      = "16px";
            warning.style.backgroundColor   = "#BCE2FE70";
            warning.style.margin            = "8px";
            warning.style.padding           = "16px";
            form.appendChild(warning);
          }
    
          warning.textContent = getWarningText(improvement);
    
          // Hide warning message when the user starts typing in the textarea
          textareas.forEach(function(textarea) {
            textarea.addEventListener('input', function() {
              warning.style.display = "none";
            });
            if( textarea.value == '' ) {
              warning.style.display = "block";
            }
          });
    
          // Show warning message when the user selects a different radio button, even if there are another textarea in the form with text, but their radio buttons are not checked.
          document.querySelector('input[name="improvement"]').addEventListener('change', function() {
            var currentRadioButton = document.querySelector('input[name="improvement"]:checked');
            var currentTextarea = document.querySelector('textarea[name^="' + currentRadioButton.value + '_improvement"]');
            warning.style.display = currentTextarea.value == '' ? 'block' : 'none';
          });
    
          spinner.style.display = "none";
    
          // Stop sending the request
          return;
        }
    
    var data = {
      action: 'feedback_form',
      'gs_email': document.querySelector('input[name="gs_email"]').value,
      'helpful': document.querySelector('input[name="helpful"]:checked').value,
      // Scholarship Information Inputs
      ... (document.querySelector('input[name="helpful"]:checked').value == 'scholarship-information') &&
        {
          'improvement': document.querySelector('input[name="improvement"]:checked').value,
          ...document.querySelector('textarea[name="incorrect_info_improvement"]').value != '' && {
            'incorrect_info_improvement': document.querySelector('textarea[name="incorrect_info_improvement"]').value,
          },
          ...document.querySelector('textarea[name="outdated_info_improvement"]').value != '' && {
            'outdated_info_improvement': document.querySelector('textarea[name="outdated_info_improvement"]').value,
          },
          ...document.querySelector('textarea[name="not_for_international_improvement"]').value != '' && {
            'not_for_international_improvement': document.querySelector('textarea[name="not_for_international_improvement"]').value,
          },
        },
      ... (document.querySelector('input[name="helpful"]:checked').value == 'page-content') &&
        {
          'improvement': document.querySelector('input[name="improvement"]:checked').value,
          ...document.querySelector('textarea[name="not_easy_to_read_improvement"]').value != '' && {
            'not_easy_to_read_improvement': document.querySelector('textarea[name="not_easy_to_read_improvement"]').value,
          },
          ...document.querySelector('textarea[name="details_missing_improvement"]').value != '' && {
            'details_missing_improvement': document.querySelector('textarea[name="details_missing_improvement"]').value,
          },
          ...document.querySelector('textarea[name="not_clear_procedures_improvement"]').value != '' && {
            'not_clear_procedures_improvement': document.querySelector('textarea[name="not_clear_procedures_improvement"]').value,
          },
        },
      ... (document.querySelector('input[name="helpful"]:checked').value == 'suggestions') &&
        {
          'improvement': document.querySelector('input[name="improvement"]:checked').value,
          ...document.querySelector('textarea[name="suggestion_improvement"]').value != '' && {
            'suggestion_improvement': document.querySelector('textarea[name="suggestion_improvement"]').value,
          },
        },
      'scholarship_info': {
        url: document.querySelector('input[name="current_scholarship_info"]').getAttribute('data-scholarship-url'),
        edit_url: document.querySelector('input[name="current_scholarship_info"]').getAttribute('data-scholarship-edit-page-url'),
        id: document.querySelector('input[name="current_scholarship_info"]').getAttribute('data-scholarship-id'),
        title: document.querySelector('input[name="current_scholarship_info"]').getAttribute('data-scholarship-title'),
      },
      'date': new Date().toISOString().slice(0, 19).replace('T', ' ')
    };
    // show spinner
    spinner.style.display = "inline-block";


    jQuery.post(
      frontendajax.ajaxurl,
      data,
      function(response) {
        // ERROR HANDLING
        console.log(response)
        if(warning) {
          warning.remove();
        }

        // hide spinner
        spinner.style.display = "none";

        // hide form
        form.style.display ="none";

        // display thank you message
        feedbackFormContainer.appendChild(thankYouMessage);

        fadeInElement(feedbackFormContainer);
      });
  });
}

function getWarningText(improvement) {
  switch (improvement) {
    case "incorrect_info":
      return "Please type your comment in the 'Incorrect Information' textarea before submitting the form.";
    case "outdated_info":
      return "Please type your comment in the 'Outdated Details' textarea before submitting the form.";
    case "not_for_international":
      return "Please type your comment in the 'Not for International Students' textarea before submitting the form.";
    case "not_easy_to_read":
      return "Please type your comment in the 'Not Easy to Read' textarea before submitting the form.";
    case "details_missing":
      return "Please type your comment in the 'Details Missing' textarea before submitting the form.";
    case "not_clear_procedures":
      return "Please type your comment in the 'Not Clear Procedures' textarea before submitting the form.";
    case "suggestion":
      return "Please type your comment in the 'Suggestion' textarea before submitting the form.";
    default:
      return "";
  }
}

function fadeInElement(Element) {
  
          // fade in message and container
          Element.style.opacity = 0;
          Element.style.display = "block";
          var intervalId = setInterval(function() {
            var opacity = parseFloat(Element.style.opacity);
            if (opacity < 1) {
              Element.style.opacity = opacity + 0.1;
            } else {
              clearInterval(intervalId);
              setTimeout(function() {
                var intervalId2 = setInterval(function() {
                  var opacity = parseFloat(Element.style.opacity);
                  if (opacity > 0) {
                    Element.style.opacity = opacity - 0.1;
                  } else {
                    clearInterval(intervalId2);
                    Element.style.display = "none";
                  }
                }, 50);
              }, 10000);
            }
          }, 50);
}

function convertArrayToText(arrayList) {
  if (arrayList) {
    if (arrayList.length === 1) {
      return arrayList[0];
    }
    if (arrayList.length === 2) {
      return arrayList[0] + " and " + arrayList[1];
    }
    var formatText = arrayList.join(", ");
    formatText = formatText.replace(/,([^,]*)$/, ", and$1");
    return formatText;
  } else {
    return "";
  }
}