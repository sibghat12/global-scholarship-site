
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
  const feedbackFormContainer = document.querySelector('.gs-feeback-form-container');
  const yesBtn = document.querySelector('input[value="Yes"]');
  const noBtn = document.querySelector('input[value="No"]');
  const radioInputs = document.querySelectorAll('.gs-feedback-radio-label input[type="radio"]');
  // const otherTextarea = document.querySelector('textarea[name="other_improvement"]');
  const buttonsDiv = document.querySelector('.gs-feedback-form-buttons');
  const $buttonsDiv = jQuery('.gs-feedback-form-buttons');
  const form = document.querySelector('#gs-feeback-form');
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
    $("textarea").hide();

    // Get the labels
    var labels = $(".gs-feedback-radio-label");

    // Attach an event listener to each label
    labels.on("click", function() {
      // Get the value of the input associated with the label
      var value = $(this).find("input").val();
      console.log("value", value)

      // Hide all the textareas
      $(".gs-user-comment").hide();

      // Show the textarea with the matching name
      $(".gs-user-comment[name='" + value + "_improvement']").show();
    });
  });

  
  // if (yesBtn) {
  //   yesBtn.addEventListener('click', function() {
  //     buttonsDiv.style.display = "flex";
  //     document.querySelector('.step-2').style.display = "none";
  //     showTextareaBasedOnRadioInput(); // Show textarea fields based on radio inputs
  //   });
  // }

  // if (noBtn) {
  //   noBtn.addEventListener('click', function() {
  //     buttonsDiv.style.display = "flex";
  //     document.querySelector('.step-2').style.display = "block";
  //     for (var i = 0; i < radioInputs.length; i++) {
  //       radioInputs[i].parentElement.style.display = "block";
  //     }
  //     otherTextarea.style.display = "block";
  //     showTextareaBasedOnRadioInput(); // Show textarea fields based on radio inputs
  //   });
  // }

  // if (radioInputs && radioInputs.length > 0) {
  //   for (var i = 0; i < radioInputs.length; i++) {
  //     radioInputs[i].addEventListener('click', function() {
  //       showTextareaBasedOnRadioInput(); // Show textarea fields based on radio inputs
  //     });

  //     // Check the initial state of the radio inputs
  //     if (radioInputs[i].checked) {
  //       showTextareaBasedOnRadioInput(); // Show textarea fields based on radio inputs
  //     }
  //   }
  // }

  jQuery('[name="submit"]').click(function(e) {
    e.preventDefault();

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
    // spinner.style.display = "inline-block";

    jQuery.post(
      frontendajax.ajaxurl,
      data,
      function(response) {
        // ERROR HANDLING
        console.log(response)

        // // hide spinner
        // spinner.style.display = "none";

        // // hide form
        // form.style.display ="none";

        // // display thank you message
        // feedbackFormContainer.appendChild(thankYouMessage);

        // fadeInElement(feedbackFormContainer);
      }
    );
  });
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

// function showTextareaBasedOnRadioInput() {
//   const radioInputs = document.querySelectorAll('.gs-feedback-radio-label input[type="radio"]');
//   const incorrectInfoTextarea = document.querySelector('textarea[name="incorrect_info_improvement"]');
//   const outdatedInfoTextarea = document.querySelector('textarea[name="outdated_info_improvement"]');
//   const notForInternationalTextarea = document.querySelector('textarea[name="not_for_international_improvement"]');
//   const otherTextarea = document.querySelector('textarea[name="other_improvement"]');

//   for (var i = 0; i < radioInputs.length; i++) {
//     if (radioInputs[i].checked) {
//       if (radioInputs[i].value == "incorrect_info") {
//         incorrectInfoTextarea.style.display = "block";
//       } else {
//         incorrectInfoTextarea.style.display = "none";
//       }

//       if (radioInputs[i].value == "outdated_info") {
//         outdatedInfoTextarea.style.display = "block";
//       } else {
//         outdatedInfoTextarea.style.display = "none";
//       }

//       if (radioInputs[i].value == "not_for_international_students") {
//         notForInternationalTextarea.style.display = "block";
//       } else {
//         notForInternationalTextarea.style.display = "none";
//       }
//       if (radioInputs[i].value == "other") {
//         otherTextarea.style.display = "block";
//       } else {
//         otherTextarea.style.display = "none";
//       }
//     }
//   }

// }


function convertArrayToText(arrayList) {
  console.log("arrayList", arrayList)
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