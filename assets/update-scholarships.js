jQuery(document).ready(function($) {
  
    $('#update-gs-scholarships').on('click', function() {
      
      var offset = 0;
      var batchSize = 20; // Change the batch size here
      var postType = 'scholarships'; // Change the post type here
      
      updateScholarships(offset, batchSize, postType);
      
    });
    
    function updateScholarships(offset, batchSize, postType) {
      
      $.ajax({
        url: my_ajax_object.ajax_url,
        type: 'POST',
        data: {
          action: 'save_scholarships_deadline_post_meta', // Change the action name here
          offset: offset,
          batchSize: batchSize,
          postType: postType,
        },
        success: function(response) {
          
          console.log(response);
          
          if (response.totalUpdated < response.totalPosts) {
            offset = response.totalUpdated;
            updateScholarships(offset, batchSize, postType);
          }
          
        }
      });
      
    }
})