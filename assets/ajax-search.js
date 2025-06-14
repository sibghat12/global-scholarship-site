jQuery(document).ready(function ($) {
  console.log("TESTING SEARCH");

  function handleSearch() {
    let textInput = $(this).val().toLowerCase();
    let $searchResultsElement = $("#search-results");
    let $searchInput = $(".search-input");

    checkSearchIsActive($searchResultsElement, $searchInput);

    if (textInput.length >= 2) {
      let $url = my_ajax_object.script_url + "search-data.json";

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
          ".gs-homepage-search-form",
          "search-input"
        );
        setInputValues();
        $.each(results, function (index, result) {
          let key = Object.keys(result)[0]; // Get the key from the result object
          let items = result[key]; // Get the items array corresponding to the key

          // Mapping keys to headings
          const typeHeadings = {
            gs_country: "Country",
            gs_subject: "Subject",
            gs_institutions: "Institutions",
            gs_scholarships: "Scholarships",
            // Add more keys and their respective headings if needed
          };

          // Get the heading for the current key (type)
          let heading = typeHeadings[key] || "Other"; // Default heading if not found in typeHeadings

          // Add the heading before the items
          resultsHtml += `<h3 class="list-group-item type-heading">${heading}</h3>`;

          $.each(items, function (itemIndex, item) {
            let title = item.title; // Get the title dynamically
            let permalink = item.permalink; // Get the permalink dynamically
            let dataInstitute = ""; // Initialize the data-institute attribute

            // Check if item.id exists and is not empty or undefined
            if (item.id) {
              dataInstitute = `data-institute="${item.id}"`; // Set data-institute attribute
            }

            resultsHtml += `<li class="list-group-item" id="${key}_${itemIndex}">
                          <a href="${permalink}" class="list_result_item list_result_item_${key}_${itemIndex}" 
                          data-link="${permalink}" data-title="${title}" ${dataInstitute}>
                          ${title}</a>
                      </li>`;
          });
        });

        $searchResultsElement.empty();

        $searchResultsElement.css({
          background: "rgb(237 237 237)",
          "z-index": "99999999999999999999999999999999999999999",
          position: "absolute",
          width: "88%",
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
  }
  $(".search-input").on("keyup", handleSearch);
  $(".search-input").on("focus", handleSearch);

  const searchInput = document.querySelector(".search-input");
  const searchTerms = [
    "Business",
    "Nursing",
    "Belt and Road Scholarship",
    "University of Oxford",
    "Finland",
    "United Kingdom",
    "France",
  ];

  let termIndex = 0;

  function autoType() {
    const searchTerm = searchTerms[termIndex];
    searchInput.setAttribute(
      "placeholder",
      `What are you looking for? ${searchTerm}`
    );
    termIndex = (termIndex + 1) % searchTerms.length;
  }

  setInterval(autoType, 2000);

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
    // Handle click event on the search button
    jQuery(".search-submit-search").off().on("click", redirectTo);

    // Handle "Enter" keypress event within the search input
    jQuery(".search-input").on("keypress", function (e) {
      // Check if the pressed key is "Enter"
      if (e.which === 13) {
        // 13 is the Enter key
        redirectTo();
      }
    });
  };
  triggerRedirect();
  function redirectTo() {
    let link = jQuery(".search-input").data("link");
    if (link) {
      window.location.href = link;
    } else {
      link = `${
        my_ajax_object.site_url +
        "/scholarship-search/?query=" +
        jQuery(".search-input").val()
      }`;
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
