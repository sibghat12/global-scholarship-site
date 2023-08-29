jQuery(document).ready(function($) {
  
  const updateInstitutionsDeadlinesPage = $('.institution_page_acf-options-update-institutions-deadlines');
  const acfSettings = updateInstitutionsDeadlinesPage.find('.acf-settings-wrap');
  acfSettings.after('<div class="process-data"></div>');
  $('#gs_preview_institutions').on('click', function() {
    
    var offset = 0;
    var batchSize = -1; // Change the batch size here
    var postType = 'institution'; // Change the post type here
    
    getInstitutionsPreview(offset, batchSize, postType);
    
  });

  $('#gs_update_deadlines').on('click', function() {
    
    var offset = 0;
    var batchSize = 20; // Change the batch size here
    var postType = 'institution'; // Change the post type here
    
    updateInstitutionsDeadlines(offset, batchSize, postType);
    
  });
  
  function updateInstitutionsDeadlines(offset, batchSize, postType) {
    $('.process-data').css('display','block');
    $('.process-data').css('opacity','1');

    if($('.process-data').hasClass('done')) {
      $('.process-data').removeClass('done');
    }
    
    // ACF Dates
    const institutionACFStatus = $('#institution-status').find('select').val();
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
        ... institutionACFStatus && {
          postStatus: institutionACFStatus,
        },
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
        // $('.process-data').css('display','block');

        acfSettings.find('.process-data');
        $('.process-data').text(`Number of Posts looped ${response.totalUpdated} from ${response.totalPosts} Posts.`);
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
          $('.process-data.done').text(`Posts that met the conditions have been updated (Total Posts Looped: ${response.totalPosts}).`);
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

  function getInstitutionsPreview(offset, batchSize, postType) {
    console.log("Institutions Preview HERE")

    const institutionACFStatus = $('#institution-status').find('select').val();
    const instACFOpeningDate =  $('#institution-opening-date').find('.hasDatepicker').val();
    const instACFDeadlineDate = $('#institution-deadline-date').find('.hasDatepicker').val();
    const instACFNewOpeningDate =  $('#institution-updated-opening-date').find('.hasDatepicker').val();
    const instACFNewDeadlineDate =  $('#institution-updated-deadline-date').find('.hasDatepicker').val();
    const institutionACFCountry = $('#institution-country').find('select').val();
    const institutionACFDegree = $('#institution-degree').find('select').val();

    const data = {
      action: 'institutions_preview', // Change the action name here
      offset: offset,
      batchSize: batchSize,
      postType: postType,
      ... institutionACFStatus && {
        postStatus: institutionACFStatus,
      },
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
        console.log("response Preview", response)
      }
    });

  }
})