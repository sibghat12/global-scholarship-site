jQuery(document).ready(function($) {
  
  console.log("DEADLINES INSTITUTIONS")
  $('#gs_update_deadlines').on('click', function() {
    
    var offset = 0;
    var batchSize = 20; // Change the batch size here
    var postType = 'institution'; // Change the post type here
    
    updateInstitutionsDeadlines(offset, batchSize, postType);
    
  });
  
  function updateInstitutionsDeadlines(offset, batchSize, postType) {
    // Define the options for date formatting
    const options = { 
      year: 'numeric', 
      month: 'long', 
      day: 'numeric' 
    };

    // Dates
    const instOpeningDate =  $('#institution-opening-date').val();
    const instDeadlineDate = $('#institution-deadline-date').val()
    const instNewOpeningDate =  $('#institution-updated-opening-date').val()
    const instNewDeadlineDate =  $('#institution-updated-deadline-date').val();
    
    let openingDate, deadlineDate, newOpeningDate, newDeadlineDate;
    if(instOpeningDate) {
      openingDate = new Date(instOpeningDate);
    }
    if(instDeadlineDate) {
      deadlineDate = new Date(instDeadlineDate);
    }
    if(instNewOpeningDate) {
      newOpeningDate = new Date(instNewOpeningDate);
    }
    if(instNewDeadlineDate) {
      newDeadlineDate = new Date(instNewDeadlineDate);
    }
    
    // Conditions
    let formattedOpeningDate = openingDate && openingDate.toLocaleDateString('en-US', options);
    let formattedDeadlineDate = deadlineDate && deadlineDate.toLocaleDateString('en-US', options);
    let institutionCountry = $('#institution-country').val();
    let institutionDegree = $('#institution-degree').val();

    // New Dates
    let formattedNewOpeningDate = newOpeningDate && newOpeningDate.toLocaleDateString('en-US', options);
    let formattedNewDeadlineDate = newDeadlineDate && newDeadlineDate.toLocaleDateString('en-US', options);
    


    // console.log("formattedOpeningDate",formattedOpeningDate)
    // console.log("formattedDeadlineDate",formattedDeadlineDate)
    // console.log("institutionCountry",institutionCountry)
    // console.log("institutionDegree",institutionDegree)

    const data = {
        action: 'update_deadlines', // Change the action name here
        offset: offset,
        batchSize: batchSize,
        postType: postType,
        ...formattedOpeningDate && {
          openingDate: formattedOpeningDate 
        },
        ...formattedDeadlineDate && {
          deadlineDate: formattedDeadlineDate 
        },
        ...institutionCountry && {
          institutionCountry: institutionCountry 
        },
        ...institutionDegree && {
          institutionDegree: institutionDegree 
        },
        ...formattedNewOpeningDate && {
          newOpeningDate: formattedNewOpeningDate 
        },
        ...formattedNewDeadlineDate && {
          newDeadlineDate: formattedNewDeadlineDate 
        },
    } 

    $.ajax({
      url: my_ajax_object.ajax_url,
      type: 'POST',
      data,
      success: function(response) {
        
        console.log(response);
        
        if (response.totalUpdated < response.totalPosts) {
          offset = response.totalUpdated;
          updateInstitutionsDeadlines(offset, batchSize, postType);
        }
        
      }
    });
    
  }
})