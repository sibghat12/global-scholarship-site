// Intitutions Import And Export JS Script

function institutions_scripts() {
  console.log("HELLLLo institutions_scripts");
  const importBtn = document.querySelector("#btn_import_institutions");
  const deleteBtn = document.querySelector("#delete-saa-institutions");
  const exportBtn = document.querySelector("#btn_export_institutions");

  if (importBtn) {
    importBtn.addEventListener("click", () => {
      console.log("IMPORT BUTTON Clicked");
      var result = confirm("Want to Import institutions?");
      if (result) {
        getInstitutionsJson();
      }
    });
  }
  if (exportBtn) {
    exportBtn.addEventListener("click", () => {
      console.log("Export BUTTON Clicked");
      var result = confirm("Want to Export institutions?");
      if (result) {
        export_institutions();
      }
    });
  }

  if (deleteBtn) {
    deleteBtn.addEventListener("click", () => {
      var result = confirm("Want to delete?");
      if (result) {
        getInstitutionsCount();
      }
    });
  }
  const export_institutions = () => {
    const data = {
      action: "export_institutions_data",
      // reviewsNum,
    };
    jQuery.ajax({
      url: ajaxurl,
      type: "POST",
      data,
      success: (response) => {
        console.log("Response", response);
      },
    });
  };

  const getInstitutionsJson = () => {
    jQuery(document).ready(function ($) {
      const data = {
        action: "get_institutions_json",
      };
      $.post(ajaxurl, data, (jsonString) => {
        console.log(jsonString);
        const jsonArray = JSON.parse(jsonString);
        console.log(jsonArray);
        importInstitutions(jsonArray);
      });
    });
  };

  // Mazen Code
  const importInstitutions = (jsonArray, i = 0) => {
    let inputValueRowsPerRequest = 10;
    // if ( jQuery( '#acf-field_602d15b943099-field_6051445d5967d' ) ) {
    // 	inputValueRowsPerRequest = jQuery(
    // 		'#acf-field_602d15b943099-field_6051445d5967d'
    // 	).val();
    // }
    const chunkSize = parseInt(inputValueRowsPerRequest); // This should come from the ACF Field.
    const totalNumberInstitutions = jsonArray.length;
    const ajaxCalls = parseInt(Math.ceil(totalNumberInstitutions / chunkSize));
    console.log("ajaxCalls", ajaxCalls);
    console.log("i:", i);
    if (i === ajaxCalls) {
      // const activeLoader = document.querySelector( '.spinner.is-active' );
      // if ( activeLoader ) {
      //     console.log("Loader is Active")
      //     // activeLoader.classList.remove( 'is-active' );
      //     // syncBtn.disabled = false;
      //     // Process.innerHTML = `All Data was successfully Added`;
      //     // setTimeout( () => {
      //     // Process.remove();
      //     // }, 5000 );
      //     // setSyncProcessOff();
      // }
    } else {
      const newArrays = chunkArray(jsonArray, chunkSize);
      console.log("newArrays", newArrays);
      const offset = chunkSize * i; // For each new cycle, offset will increase by a single chunksize.
      jQuery.post(
        ajaxurl,
        {
          action: "import_institutions",
          resultsJSONString: JSON.stringify(newArrays[i]),
          offset,
        },
        (response) => {
          if (response.status === 0) {
            console.log("Error happened");
          } else {
            i++;
            importInstitutions(jsonArray, i);
            // if ( offset + chunkSize < totalNumberInstitutions ) {
            // Process.innerHTML = `Adding rows ${ offset } : ${
            //     offset + chunkSize
            // }, and removing extra posts`;
            // } else {
            // }
          }
        }
      );
    }
  };
  const chunkArray = (array, chunkSize) => {
    let i = 0,
      tempArray = [];
    for (i = 0; i < array.length; i += chunkSize) {
      tempArray.push(array.slice(i, i + chunkSize));
    }
    return tempArray;
  };

  const getInstitutionsCount = () => {
    jQuery(document).ready(function ($) {
      const data = {
        action: "get_institutions_number",
      };
      $.post(ajaxurl, data, (response) => {
        response = JSON.parse(response);
        deleteInstititons(response);
      });
    });
  };

  const deleteInstititons = (institutionsNum) => {
    jQuery(document).ready(function ($) {
      const data = {
        action: "delete_institutions",
        institutionsNum,
      };
      const theNum = data.institutionsNum;
      if (theNum === 0) {
        console.log("theNum is 0");
      } else {
        console.log(theNum);
        $.ajax({
          url: ajaxurl,
          type: "POST",
          data,
          success: (response) => {
            if (response.status === 0) {
              // DO not go to the next step.
            } else {
              console.log("data.institutionsNum", data.institutionsNum);
              // Go to the next step
              // if ( data.institutionsNum > 100 ) {
              // 	Process.innerHTML = `Removing from ${
              // 		data.institutionsNum
              // 	} - ${ data.institutionsNum - 100 }`;
              // } else {
              // 	Process.innerHTML = `All Posts were Removed Now is importing data from Google Sheet`;
              // }
              getInstitutionsCount();
            }
          },
          error: (error) => {
            console.log(error);
            console.log("Error Warning");
          },
        });
      }
    });
  };
}
institutions_scripts();
