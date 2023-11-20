jQuery(document).ready(function ($) {

    
    console.log("TESTING SEARCH");
    let debounceTimer;

    $(".search-input").on('keyup',function () {
        let textInput = $(this).val().toLowerCase().trim();
        
        clearTimeout(debounceTimer);
        if (textInput.length >= 3) {
          debounceTimer = setTimeout(function() {
        let $url = my_ajax_object.script_url + 'search-data.json';
        let $searchResultsElement = $('#search-results');
        let $searchInput = $('.search-input');
        var results = [];
        var matchedResults = [];
        $.getJSON($url, function(json) {

        if (json) {
            var keys = Object.keys(json);
            $.each(keys, function (index, key) {
                var matchedResults = [];
                $.each(json[key], function (index, value) {
                  if (value.title && value.title.toLowerCase().indexOf(textInput) !== -1) {
                      console.log("value", value)
                        matchedResults.push(value);
                    }
                });
                if (matchedResults.length > 0) {
                    var result = {};
                    result[key] = matchedResults;
                    results.push(result);
                }
            });
        }
          var resultsFiveElements = results.slice(0, 5);
          console.log("resultsFiveElements", resultsFiveElements)
          var resultsHtml = '';
          checkSearchIsActive($searchResultsElement, $searchInput);
          toggleSearchResultsBoxOutside($searchResultsElement, '.gs-homepage-search-form', 'search-input');
          setInputValues();
          $.each(resultsFiveElements, function(index, item) {
            console.log('ITEM', item)
            resultsHtml += `<li class="list-group-item" id="institution_${item.id}">
            <a href="${item.permalink}" class="list_result_item list_result_item_${item.id}" data-institute-link="${item.permalink}" data-institute-title="${item.title}" data-institute="${item.id}">${item.title}</a>
          </li>`;
          });
          $searchResultsElement.empty();
          $searchResultsElement.html(resultsHtml);
        });
      }, 300); // Adjust the delay time (in milliseconds) according to your needs
    }
    });


    
          // Add Text to input on click
          function setInputValues() {
            jQuery(document).on('click','.search-results-container .list_result_item', function(event) {
              // event.preventDefault();
              let currentItem = getCurrentItemValues(this, 'institute');
              $('.search-input').val(currentItem.item_title);
              $('.search-input').data('institute-link',currentItem.item_link);
              $('.search-input').data('institute',currentItem.item_id);
              $('.search-input').data('institute-title',currentItem.item_title);
              $('.search-input').focus();
              let $searchResultsElement = $('#search-results');
              let $searchInput = $('.search-input')
              checkSearchIsActive($searchResultsElement, $searchInput);
              toggleSearchResultsBox($searchResultsElement, $searchInput);
              triggerRedirect('institute');
            })
          } 

          
    function checkSearchIsActive(element, input) {

        if(input.val().length > 0 && element.children().length > 0) {
          element.parent().show();
          element.parent().addClass('active_search');
        } else {
          element.parent().hide();
          element.parent().removeClass('active_search');
        }
        
    }

     // Trigger redirect on click
     const triggerRedirect = (searchType)  => {
        jQuery('.search-submit-search').off().on('click',() => {
          redirectTo(searchType);
        })
    }
    // Toggle Search Results box when item is selected  
    function toggleSearchResultsBox(item, input) {
    $(item).parent().hide();
    $(input).on('click', () => {
        if($(item).children().length > 0) {
        $(item).parent().show();
        }
    })
    }

    // Toggle Search Results box when clicking outside the search section
    function toggleSearchResultsBoxOutside(item, parentElement, inputClass) {
    $(document).on('click', function(event) {
        if (!$(event.target).closest(parentElement).length) {
        $(item).parent().hide();
        } else if($(event.target).closest(parentElement).length) {
        if($(event.target).hasClass(inputClass) ) {
            $(item).parent().show();
        } 
        }
    });
    }
});