jQuery(document).ready(function ($) {
    console.log("TESTING Scholarship SEARCH");
    let debounceTimer;
  
    $(".search-input").on("keyup", function () {
      let textInput = $(this).val().toLowerCase();
      let $searchResultsElement = $("#search-results");
      let $searchInput = $(".search-input");
  
      checkSearchIsActive($searchResultsElement, $searchInput);
  
      // clearTimeout(debounceTimer);
      if (textInput.length >= 2) {
        // debounceTimer = setTimeout(function() {
        let $url = my_ajax_object.script_url + "search-scholarship-data.json";
  
        var results = [];
        var matchedResults = [];
        $.getJSON($url, function (json) {
          if (json) {
            let keys = Object.keys(json);
            let remainingResults = 5; // Change according to how many results we want
            $.each(keys, function (index, key) {
              let matchedResults = $.grep(json[key], function (value) {
                return (
                  value.title &&
                  value.title.toLowerCase().indexOf(textInput) !== -1
                );
              });
  
              if (matchedResults.length > 0 && remainingResults > 0) {
                let result = {};
                result[key] = matchedResults.slice(0, remainingResults);
                results.push(result);
                remainingResults -= matchedResults.length;
              }
            });
          }
          var resultsHtml = "";
          toggleSearchResultsBoxOutside(
            $searchResultsElement,
            "#scholarship-search-box-wrapper",
            "search-input"
          );
          setInputValues();
          $.each(results, function (index, result) {
            let key = Object.keys(result)[0]; // Get the key from the result object
            let items = result[key]; // Get the items array corresponding to the key
  
            // Mapping keys to headings
            // const typeHeadings = {
            // //   gs_country: "Country",
            // //   gs_subject: "Subject",
            //   gs_scholarship_institutions: "Institutions",
            //   gs_scholarship_scholarships: "Scholarships",
            //   // Add more keys and their respective headings if needed
            // };
  
            // Get the heading for the current key (type)
            // let heading = typeHeadings[key] || "Other"; // Default heading if not found in typeHeadings
  
            // Add the heading before the items
            // resultsHtml += `<h3 class="list-group-item type-heading">${heading}</h3>`;
  
            $.each(items, function (itemIndex, item) {
              let title = item.title; // Get the title dynamically
              let permalink = item.permalink; // Get the permalink dynamically
              let institution_scholarships = item.institution_scholarships; // Get the permalink dynamically
              let institution_scholarship = item.institution_scholarship; // Get the permalink dynamically
              let scholarship_type = item.scholarship_type; // Get the permalink dynamically
              let dataInstitute = ""; // Initialize the data-institute attribute
  
              // Check if item.id exists and is not empty or undefined
              if (item.id) {
                dataInstitute = `data-institute="${item.id}"`; // Set data-institute attribute
              }
  
                // Check if institution_scholarships exists, otherwise use institution_scholarship
                let scholarshipsToShow = institution_scholarships ? 'Number of Scholarships Offered: ' + institution_scholarships : institution_scholarship + ' | ' + scholarship_type;

              resultsHtml += `<li class="list-group-item" id="${key}_${itemIndex}">
                          <a href="${permalink}" class="list_result_item list_result_item_${key}_${itemIndex}" 
                          data-link="${permalink}" data-title="${title}" ${dataInstitute}>
                          <b>${title}</b><div>${scholarshipsToShow}</div></a>
                      </li>`;
            });
          });
  
          $searchResultsElement.empty();
  
          $searchResultsElement.css({
            background: "rgb(237 237 237)",
            "z-index": "99999999999999999999999999999999999999999",
            position: "absolute",
            top: "-30px",
            width: "100%",
            margin: "0",
            "border-top": "1px solid #ccc",
            padding: "0px",
            "box-shadow": "0px 4px 9px rgba(0, 0, 0, 0.1)",
            "list-style": "none",
          });
          $searchResultsElement.html(resultsHtml);
        });
        // }, 300); // Adjust the delay time (in milliseconds) according to your needs
      } else {
        return;
      }
    });
  
    // Add Text to input on click
    function setInputValues() {
      jQuery(document).on(
        "click",
        ".search-results-container .list-group-item",
        function (event) {
          // event.preventDefault();
          let theLink = $(this).find("a");
          console.log("this", this);
          // console.log("theLink", theLink)
          let currentItem = getCurrentItemValues(theLink);
          console.log("currentItem", currentItem);
          $(".search-input").val(currentItem.item_title);
          $(".search-input").data("link", currentItem.item_link);
          $(".search-input").data("institute", currentItem.item_id);
          $(".search-input").data("title", currentItem.item_title);
          $(".search-input").focus();
          let $searchResultsElement = $("#search-results");
          let $searchInput = $(".search-input");
          checkSearchIsActive($searchResultsElement, $searchInput);
          toggleSearchResultsBox($searchResultsElement, $searchInput);
          triggerRedirect();
          window.location.href = currentItem.item_link;
        }
      );
    }
  
    function checkSearchIsActive(element, input) {
      if (input.val().length > 2 && element.children().length > 0) {
        element.parent().addClass("active_search");
        element.parent().show();
      } else {
        element.parent().hide();
        element.parent().removeClass("active_search");
      }
    }
  
    // Trigger redirect on click
    const triggerRedirect = () => {
      jQuery(".search-submit-search")
        .off()
        .on("click", () => {
          redirectTo();
        });
    };
  
    function redirectTo() {
      let link = $(".search-input").data("link");
      if (link) {
        window.location.href = link;
      }
    }
    // Toggle Search Results box when item is selected
    function toggleSearchResultsBox(item, input) {
      $(item).parent().hide();
      $(input).on("click", () => {
        if ($(input).val().length >= 3 && $(item).children().length > 0) {
          $(item).parent().show();
        }
      });
    }
  
    // Toggle Search Results box when clicking outside the search section
    function toggleSearchResultsBoxOutside(item, parentElement, inputClass) {
      $(document).on("click", function (event) {
        if (!$(event.target).closest(parentElement).length) {
          $(item).parent().hide();
        } else if ($(event.target).closest(parentElement).length) {
          if (
            $(event.target).hasClass(inputClass) &&
            $(inputClass).val()?.length >= 3
          ) {
            $(item).parent().show();
          }
        }
      });
    }
  
    function getCurrentItemValues(item) {
      const item_link = $(item).data(`link`);
      const item_id = $(item).data(`id`);
      const item_title = $(item).data(`title`);
  
      return {
        ...(item_id && {
          item_id,
        }),
        ...(item_link && {
          item_link,
        }),
        ...(item_title && {
          item_title,
        }),
      };
    }
  });
  