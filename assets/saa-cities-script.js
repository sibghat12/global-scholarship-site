function SAACities() {
    // jquery ready
    console.log("exportSAACitiesCSV");
    jQuery( document ).ready( function ( $ ) {

    const exportCitiesBtn = document.getElementById( 'saa-cities-export' );
    const importCitiesBtn = document.getElementById( 'saa-cities-import' );
    const importCitiesInstitutionsBtn = document.getElementById( 'import-institutions-cities' );
    // Check if there are any results before continue
    if ( exportCitiesBtn ) {
        exportCitiesBtn.addEventListener( 'click', () => {
            console.log( 'Export Cities Button Clicked' );
            var result = confirm( 'Want to Export Cities?' );
            if ( result ) {
                export_saa_cities_csv();
            }
        } );

    }





    if(importCitiesBtn) {
        importCitiesBtn.addEventListener( 'click', () => {
            console.log( 'Import Cities Button Clicked' );
            var result = confirm( 'Want to Import Cities?' );
            if ( result ) {
                getCitiesCsv();
            }
        } );
    }

    if(importCitiesInstitutionsBtn) {
        importCitiesInstitutionsBtn.addEventListener( 'click', () => {
            console.log( 'Import Cities Institutions Button Clicked' );
            var result = confirm( 'Want to Import Cities Institutions?' );  
            if ( result ) {
              getCitiesInstitutions();
            }
        } );
    }

        function export_saa_cities_csv () {
            const data = {
                nonce: saa_cities.nonce,
                action: 'exportSAACitiesCSV',
            };
            jQuery.ajax( {
                url: ajaxurl,
                type: 'POST',
                data,
                success: ( response ) => {
                    console.log("Response", response);
                    // Trim string on left side
                    response = response.trimStart();
                    const downloadLink = document.createElement( 'a' );
                    const fileData = [ '\ufeff' + response ];

                    const blobObject = new Blob( fileData, {
                        type: 'text/csv;charset=utf-8;',
                    } );

                    const url = URL.createObjectURL( blobObject );
                    downloadLink.href = url;

                    // Do the magic
                    downloadLink.download = `saa_cities.csv`;
                    document.body.appendChild( downloadLink );
                    downloadLink.click();
                    document.body.removeChild( downloadLink );
                },
                error: ( error ) => {
                    console.log( error + 'Error Warning' );
                },
            } );
        }

        function getTimestampInSeconds () {
            return Math.floor(Date.now() / 1000)
        }


        // ref: http://stackoverflow.com/a/1293163/2343
        // This will parse a delimited string into an array of
        // arrays. The default delimiter is the comma, but this
        // can be overriden in the second argument.
        function CSVToArray( strData, strDelimiter ){
            // Check to see if the delimiter is defined. If not,
            // then default to comma.
            strDelimiter = (strDelimiter || ",");
     
            // Create a regular expression to parse the CSV values.
            var objPattern = new RegExp(
                (
                    // Delimiters.
                    "(\\" + strDelimiter + "|\\r?\\n|\\r|^)" +
     
                    // Quoted fields.
                    "(?:\"([^\"]*(?:\"\"[^\"]*)*)\"|" +
     
                    // Standard fields.
                    "([^\"\\" + strDelimiter + "\\r\\n]*))"
                ),
                "gi"
                );
     
     
            // Create an array to hold our data. Give the array
            // a default empty first row.
            var arrData = [[]];
     
            // Create an array to hold our individual pattern
            // matching groups.
            var arrMatches = null;
     
     
            // Keep looping over the regular expression matches
            // until we can no longer find a match.
            while (arrMatches = objPattern.exec( strData )){
     
                // Get the delimiter that was found.
                var strMatchedDelimiter = arrMatches[ 1 ];
     
                // Check to see if the given delimiter has a length
                // (is not the start of string) and if it matches
                // field delimiter. If id does not, then we know
                // that this delimiter is a row delimiter.
                if (
                    strMatchedDelimiter.length &&
                    strMatchedDelimiter !== strDelimiter
                    ){
     
                    // Since we have reached a new row of data,
                    // add an empty row to our data array.
                    arrData.push( [] );
     
                }
     
                var strMatchedValue;
     
                // Now that we have our delimiter out of the way,
                // let's check to see which kind of value we
                // captured (quoted or unquoted).
                if (arrMatches[ 2 ]){
     
                    // We found a quoted value. When we capture
                    // this value, unescape any double quotes.
                    strMatchedValue = arrMatches[ 2 ].replace(
                        new RegExp( "\"\"", "g" ),
                        "\""
                        );
     
                } else {
     
                    // We found a non-quoted value.
                    strMatchedValue = arrMatches[ 3 ];
     
                }
     
     
                // Now that we have our value string, let's add
                // it to the data array.
                arrData[ arrData.length - 1 ].push( strMatchedValue );
            }
     
            // Return the parsed data.
            return( arrData );
        }
        const getCitiesCsv = () => {
            jQuery(document).ready(function ($) {
              const data = {
                action: "get_cities_csv",
              };
              $.post(ajaxurl, data, (csvString) => {

                // console.log("csvString",csvString)

                const csvArray = CSVToArray(csvString, ',');

                let properArrays = [];

                csvArray.map(csv => {
                  
                    if(csv[0] == '' || csv[0] == '  ' || csv.length < 1 || csv == undefined) {
                        return;
                    }
                    // console.log("csv",csv)

                    properArrays = [...properArrays, csv]

                })

                console.log("properArrays", properArrays)
                imporCities(properArrays)
              });
            });
          };

          const imporCities = (jsonArray, i = 0) => {
            let inputValueRowsPerRequest = 10;
            const chunkSize = parseInt(inputValueRowsPerRequest); // This should come from the ACF Field.
            const totalNumberInstitutions = jsonArray.length;
            console.log("jsonArray", jsonArray)
            const ajaxCalls = parseInt(Math.ceil(totalNumberInstitutions / chunkSize));
            console.log("ajaxCalls", ajaxCalls);
            console.log("i:", i);

            if (i === ajaxCalls) {
            } else {
                const newArrays = chunkArray(jsonArray, chunkSize);
                console.log("newArrays", newArrays);
                const offset = chunkSize * i; // For each new cycle, offset will increase by a single chunksize.
                jQuery.post(
                    ajaxurl,
                    {
                      action: "import_cities",
                      resultsJSONString: JSON.stringify(newArrays[i]),
                      offset,
                    },
                    (response) => {
                      if (response.status === 0) {
                        console.log("Error happened");
                      } else {
                        i++;
                        imporCities(jsonArray, i);

                      }
                    }
                  );
            }
          }


          const getCitiesInstitutions = () => {
            jQuery(document).ready(function ($) {
              const data = {
                action: "get_cities_institutions",
              };
              $.post(ajaxurl, data, (csvString) => {

                const csvArray = CSVToArray(csvString, ',');

                let properArrays = [];

                csvArray.map(csv => {
                  
                    if(csv[0] == '' || csv[0] == '  ' || csv.length < 1 || csv == undefined) {
                        return;
                    }

                    properArrays = [...properArrays, csv]

                })

                console.log("properArrays", properArrays)
                importCitiesInstitutions(properArrays)
              });
            });
          };

          const importCitiesInstitutions = (jsonArray, i = 0) => {
            let inputValueRowsPerRequest = 10;
            const chunkSize = parseInt(inputValueRowsPerRequest); // This should come from the ACF Field.
            const totalNumberInstitutions = jsonArray.length;
            console.log("jsonArray", jsonArray)
            const ajaxCalls = parseInt(Math.ceil(totalNumberInstitutions / chunkSize));
            console.log("ajaxCalls", ajaxCalls);
            console.log("i:", i);

            if (i === ajaxCalls) {
            } else {
                const newArrays = chunkArray(jsonArray, chunkSize);
                console.log("newArrays", newArrays);
                const offset = chunkSize * i; // For each new cycle, offset will increase by a single chunksize.
                jQuery.post(
                    ajaxurl,
                    {
                      action: "import_cities_institutions",
                      resultsJSONString: JSON.stringify(newArrays[i]),
                      offset,
                    },
                    (response) => {
                      if (response.status === 0) {
                        console.log("Error happened");
                      } else {
                        i++;
                        importCitiesInstitutions(jsonArray, i);

                      }
                    }
                  );
            }
          }

          const chunkArray = (array, chunkSize) => {
            let i = 0,
              tempArray = [];
            for (i = 0; i < array.length; i += chunkSize) {
              tempArray.push(array.slice(i, i + chunkSize));
            }
            return tempArray;
          };
          

        
        } );
}

SAACities();