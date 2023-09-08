jQuery(document).ready(function($) {

  let previewShowing = false;
  let updatingProcess = false;
  var allInstitutionsUpdated = [];
  const updateDeadlinesButton = $('#gs_update_deadlines').find('button');
  const previewInstitutionsButton = $('#gs_preview_institutions').find('button');
  console.log("updateDeadlinesButton", updateDeadlinesButton)
  console.log("previewInstitutionsButton", previewInstitutionsButton)

  const updateInstitutionsDeadlinesPage = $('.institution_page_acf-options-update-institutions-deadlines');
  const acfSettings = updateInstitutionsDeadlinesPage.find('.acf-settings-wrap');
  acfSettings.after('<div class="process-data"></div>');
  acfSettings.after('<div class="preview-data"></div>');
 
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
    updatingProcess = true;
    
    if(updatingProcess) {
      updateDeadlinesButton.prop('disabled', true);
    }
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


      // Get the institutionsUpdated array
      var institutionsUpdated = response?.institutionsUpdated;

      // If the institutionsUpdated array is not empty
      if (institutionsUpdated) {
        // Add the institutionsUpdated array to the allInstitutionsUpdated array
        allInstitutionsUpdated = allInstitutionsUpdated.concat(institutionsUpdated);
      }
      const today = new Date();

      const day = today.getDate();
      const month = today.getMonth() + 1; // January is 0, so we need to add 1
      const year = today.getFullYear();
      
      const monthNames = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ];
      
      const formattedDate = `${day} ${monthNames[month - 1]}, ${year}`;
    
      $('.preview-data').css('font-family', 'Roboto');
      $('.preview-data').css('background', '#6ea2c750');
      $('.preview-data').css('color', '#000');
      $('.preview-data').css('border', '2px solid #000000');
      $('.preview-data').css('padding', '30px');
      $('.preview-data').css('font-size', '1.2rem');
  
      let html = `<h2>List of Institutions (${allInstitutionsUpdated?.length}) that have been updated.</h2>
      
      <div class="gs-dates-update">
      <div class="gs-opening-dates-to-update">
      Past Dates:
      <ul class="gs-update-deadlines-dates">
        <li>Opening Date: <span class="gs-update-deadlines-opening-date">${instACFOpeningDate}</span></li>
        <li>Deadline Date: <span class="gs-update-deadlines-deadline-date">${instACFDeadlineDate}</span></li>
      </ul>
      </div>
      <div class="gs-opening-dates-updated">
      New Dates:
      <ul class="gs-updated-deadlines-dates">
        <li>Opening Date: <span class="gs-updated-deadlines-opening-date">${instACFNewOpeningDate}</span></li>
        <li>Deadline Date: <span class="gs-updated-deadlines-deadline-date">${instACFNewDeadlineDate}<span></li>
      </ul>
      </div>
      <div>On <span class="gs-updated-deadlines-formatted-date">${formattedDate}</span></div>
      </div>
      <hr/>
      <ol class="gs-updated-deadlines-ordered-list">`; // Start the  list
    
      $.each(allInstitutionsUpdated, function(indexInArray, institution) {
        html += `<li class="gs-updated-deadlines-list-item"><a href="${institution.permalink}" data-institution-title="${institution.title}" data-institution-country="${institution.country}" data-institution-id="${institution.id}">${institution.title}</a><span> (${institution.country})</span></li>`;
      });
      html += '</ol>'; // End the  list

      $('.preview-data').html(html);

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
          updatingProcess = false;
          if(!updatingProcess) {
            updateDeadlinesButton.prop('disabled', false);
            $('.preview-data').addClass('done');
            getUpdatedInstitutionsData();
            // Here run a function that gets all the data from the frontend and send back to the database :)
          }
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
    previewShowing = true;
    if(previewShowing) {
      previewInstitutionsButton.prop('disabled', true);
    }
    const loaderHtml = '<div class="loader"></div>';

    
    $('.preview-data').css('font-family', 'Roboto');
    $('.preview-data').css('background', '#6ea2c750');
    $('.preview-data').css('color', '#000');
    $('.preview-data').css('border', '2px solid #000000');
    $('.preview-data').css('padding', '30px');
    $('.preview-data').css('font-size', '1.2rem');


    $('.preview-data').html(loaderHtml);

    const theLoader = $('.preview-data').find('.loader');

    theLoader.css( 'display', 'block');
    theLoader.css( 'margin', '20px auto');
    theLoader.css( 'border', '4px solid #f3f3f3');
    theLoader.css( 'borderRadius', '50px');
    theLoader.css( 'borderTop', '4px solid #3498db');
    theLoader.css( 'width', '30px');
    theLoader.css( 'height', '30px');
    theLoader.css( 'animation', 'spin 2s linear infinite');

    if(previewShowing) {
      $('.preview-data').css('display','block');
      $('.preview-data').css('opacity','1');
  
      if($('.preview-data').hasClass('done')) {
        $('.preview-data').removeClass('done');
      }
    }

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
        const previewElement = acfSettings.find('.preview-data');
        console.log("response Preview", response)

        console.log("previewElement", previewElement)


        if (response?.institutionsData) {
          
          // Hide the loader

          let html = `<div class="gs-deadlines-preview-data-container"><h2 class="gs-deadlines-preview-data-heading">List of Institutions (<span class="gs-deadlines-preview-data-gs-deadlines-preview-data-number-institutions">${response?.institutionsData?.length}</span>) that will be updated according the criteria selected in (Institution Deadlines Conditions)</h2><ol>`; // Start the  list
        
          $.each(response?.institutionsData, function(indexInArray, institution) {
            html += `<li><a href="${institution.permalink}" data-institution-title="${institution.title}" data-institution-country="${institution.country}" data-institution-id="${institution.id}">${institution.title}</a><span> (${institution.country})</span></li>`;
          });
        
          html += '</ol>'; // End the  list
          html += '</div>'; // End of Preivew Deadlines Element
        
          $('.preview-data').html(html);
        } else {
          previewShowing = false;
          if(!previewShowing) {
            previewInstitutionsButton.props('disabled', false);
          }
          $('.loader').css('display', 'none');
          $('.preview-data').html('');
        }
        previewShowing = false;
        if(!previewShowing) {
          previewInstitutionsButton.prop('disabled', false);
        }
        
      }
    });

  }

  function getUpdatedInstitutionsData() {

    const previewDataDone = $('.preview-data.done');
    const getOpeningDeadlineDateUpdate = previewDataDone.find('.gs-dates-update').find('.gs-opening-dates-to-update').find('.gs-update-deadlines-dates').find('.gs-update-deadlines-opening-date').text();
    const getDeadlineDeadlineDateUpdate = previewDataDone.find('.gs-dates-update').find('.gs-opening-dates-to-update').find('.gs-update-deadlines-dates').find('.gs-update-deadlines-deadline-date').text();

    
    const getOpeningDeadlineDateUpdated = previewDataDone.find('.gs-dates-update').find('.gs-opening-dates-updated').find('.gs-updated-deadlines-dates').find('.gs-updated-deadlines-opening-date').text();
    const getDeadlineDeadlineDateUpdated = previewDataDone.find('.gs-dates-update').find('.gs-opening-dates-updated').find('.gs-updated-deadlines-dates').find('.gs-updated-deadlines-deadline-date').text();

    console.log("getOpeningDeadlineDateUpdated", getOpeningDeadlineDateUpdated)
    console.log("getDeadlineDeadlineDateUpdated", getDeadlineDeadlineDateUpdated)

    const getDateDeadlinesUpdate = previewDataDone.find('.gs-updated-deadlines-formatted-date').text();

    // // Get all institutions Updated (Done) Deadlines ids

    let updatedInstitutionsIds = [];
    let updatedInstitutionsElems = previewDataDone.find('.gs-updated-deadlines-ordered-list').find('.gs-updated-deadlines-list-item').find('*[data-institution-id]');
    $.each(updatedInstitutionsElems, function (indexInArray, element) { 
      updatedInstitutionsIds.push($(element).data('institution-id'));
    });

    // console.log("updatedInstitutionsElems", updatedInstitutionsElems);

    const ajaxData = {
      action: 'update_deadlines_data',
      openingDeadlineDateUpdate: getOpeningDeadlineDateUpdate,
      deadlineDeadlineDateUpdate: getDeadlineDeadlineDateUpdate,
      openingDeadlineDateUpdated: getOpeningDeadlineDateUpdated,
      deadlineDeadlineDateUpdated: getDeadlineDeadlineDateUpdated,
      updateDeadlinesDate: getDateDeadlinesUpdate,
      updatedInstitutionsIds: updatedInstitutionsIds,
      date: new Date().toISOString().slice(0, 19).replace('T', ' ')
    };

    $.ajax({
      url: my_ajax_object.ajax_url,
      type: 'POST',
      data: ajaxData,
      success: function(response) {
        console.log("response :::: Institutions::::", response);
        
      }
    });
  }
})