jQuery(document).ready(function($) {
  
  const updateInstitutionsDeadlinesPage = $('.institution_page_acf-options-update-institutions-deadlines');
  const acfSettings = updateInstitutionsDeadlinesPage.find('.acf-settings-wrap');
  acfSettings.after('<div class="process-data"></div>');
  $('#gs_update_deadlines').on('click', function() {
    
    var offset = 0;
    var batchSize = 20; // Change the batch size here
    var postType = 'institution'; // Change the post type here
    
    updateInstitutionsDeadlines(offset, batchSize, postType);
    
  });
  
  function updateInstitutionsDeadlines(offset, batchSize, postType) {

    // ACF Dates
    const instACFOpeningDate =  $('#institution-opening-date').find('.hasDatepicker').val();
    const instACFDeadlineDate = $('#institution-deadline-date').find('.hasDatepicker').val();
    const instACFNewOpeningDate =  $('#institution-updated-opening-date').find('.hasDatepicker').val();
    const instACFNewDeadlineDate =  $('#institution-updated-deadline-date').find('.hasDatepicker').val();
    const institutionACFCountry = $('#institution-country').find('select').val();
    const institutionACFDegree = $('#institution-degree').find('select').val();



    const data = {
        action: 'update_deadlines', // Change the action name here
        offset: offset,
        batchSize: batchSize,
        postType: postType,
        ...instACFOpeningDate && {
          openingDate: instACFOpeningDate 
        },
        ...instACFDeadlineDate && {
          deadlineDate: instACFDeadlineDate 
        },
        ...institutionACFCountry && {
          institutionCountry: institutionACFCountry 
        },
        ...institutionACFDegree && {
          institutionDegree: institutionACFDegree 
        },
        ...instACFNewOpeningDate && {
          newOpeningDate: instACFNewOpeningDate 
        },
        ...instACFNewDeadlineDate && {
          newDeadlineDate: instACFNewDeadlineDate 
        },
    } 

    $.ajax({
      url: my_ajax_object.ajax_url,
      type: 'POST',
      data,
      success: function(response) {

        acfSettings.find('.process-data');
        $('.process-data').text(`${response.totalUpdated} from ${response.totalPosts}`);
        $('.process-data').css('font-family', 'Roboto');
        $('.process-data').css('background', '#6ea2c750');
        $('.process-data').css('color', '#000');
        $('.process-data').css('border', '2px solid #000000');
        $('.process-data').css('padding', '30px');
        $('.process-data').css('font-size', '1.2rem');
        

        if (response.totalUpdated < response.totalPosts) {
          offset = response.totalUpdated;
          updateInstitutionsDeadlines(offset, batchSize, postType);
        } else {
          $('.process-data').addClass('done');
          $('.process-data.done').css('background', '#6ea2c7');
          $('.process-data').css('color', '#fff');
          $('.process-data.done').text(`All ${response.totalPosts} Posts that met the conditions have been updated`);
          fadeInElementjQuery($('.process-data.done'), 15000);
        }
        
      }
    });
  }

  function fadeInElementjQuery(element, timems) {
    // fade in message and container
    element.css("opacity", 0);
    element.css("display", "block");
    var intervalId = setInterval(function() {
      var opacity = parseFloat(element.css("opacity"));
      if (opacity < 1) {
        element.css("opacity", opacity + 0.1);
      } else {
        clearInterval(intervalId);
        setTimeout(function() {
          var intervalId2 = setInterval(function() {
            var opacity = parseFloat(element.css("opacity"));
            if (opacity > 0) {
              element.css("opacity", opacity - 0.1);
            } else {
              clearInterval(intervalId2);
              element.css("display", "none");
            }
          }, 50);
        }, timems);
      }
    }, 50);
  }
})