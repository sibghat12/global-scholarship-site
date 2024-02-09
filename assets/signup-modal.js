jQuery(document).ready(function($) {
    // Open the modal
    $('.gs-signup-btn').on('click', function(e) {
        e.preventDefault();
        $('#gsSignupModal').show();
    });


    // Close the modal when user clicks anywhere outside of the modal
    $(window).on('click', function(event) {
        var modal = $('#gsSignupModal');
        if ($(event.target).is(modal)) {
            modal.hide();
        }
    });


    // Toggle Password
    $('#gsSignupModal .gs-modal-dialog .mp-hide-pw button').click(function() {
        var $passwordInput = $('#user_pass');
        if ($passwordInput.attr('type') === 'password') {
            $passwordInput.attr('type', 'text');
            $(this).html('<span class="dashicons dashicons-hidden" aria-hidden="true"></span>'); // Change icon if needed
        } else {
            $passwordInput.attr('type', 'password');
            $(this).html('<span class="dashicons dashicons-visibility" aria-hidden="true"></span>'); // Revert icon
        }
    });

    let clientId = '332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com';
    let redirectUri = window.location.origin + '/google-callback'; // Adjust the path as necessary
    let scope = 'openid email profile';
    let responseType = 'code';
    let loginUrl = 'https://accounts.google.com/o/oauth2/v2/auth' +
                '?client_id=' + encodeURIComponent(clientId) +
                '&redirect_uri=' + encodeURIComponent(redirectUri) +
                '&response_type=' + encodeURIComponent(responseType) +
                '&scope=' + encodeURIComponent(scope);

    // $('.gs-btn').on('click', function(e) {
    //     console.log("e.target", e.target)

    //     // Example of how to use the login URL: redirect or attach to an element's event
    //     // Redirect to the login URL
    //     window.location.href = loginUrl;

    // })
    
    // Or attach the login URL to a button click event
    var loginButton = document.getElementById('googleLoginButton'); // Ensure you have this element in your HTML
    if (loginButton) {
        loginButton.addEventListener('click', function() {
            window.location.href = loginUrl;
        });
    }


        // // Signup Multistep Modal Logic

        // var currentStep = 0;
        // var steps = document.getElementsByClassName("form-step");
        // var navSteps = document.querySelectorAll(".steps-navigation .step");
        // var navStepContainer = document.querySelector(".steps-navigation");
    
        // showStep(currentStep); // Initialize the form to show the first step
    
        // // Update the moveStep function to highlight steps
        // function moveStep(next) {
        //     steps[currentStep].style.display = "none"; // Hide current step
        //     currentStep += next ? 1 : -1;
            
        //     if (currentStep >= steps.length) {
        //         document.getElementById("gsMultiStepFormRegister").submit(); // Submit form if on the last step
        //         return;
        //     }
        //     showStep(currentStep);
        // }
    
        // function showStep(n) {
        //     steps[n].style.display = "block"; // Show the current step
        //     updateStepsNavigation(n);
        // }
    
        // function updateStepsNavigation(currentStep) {
        //     // Reset all steps to default state and remove line-active class from all steps
        //     navSteps.forEach(function(step, index) {
        //         step.classList.remove("step-active", "step-completed", "line-active");
        //         if (index < currentStep) {
        //             // Add step-completed to all steps before the current step
        //             step.classList.add("step-completed");
        //         } else if (index === currentStep) {
        //             // Add step-active to the current step
        //             step.classList.add("step-active");
        //         }
        //         // Adding line-active class based on step's state
        //         if (index <= currentStep) {
        //             step.classList.add("line-active");
        //         }
        //     });
        
        //     // Ensure the line before the first step is not colored
        //     if (currentStep > 0) {
        //         navSteps[0].classList.add("line-active");
        //     }
        // }
        
        // // Attach event listeners to next and previous buttons
        // var continueBtn = document.querySelector(".gs-signup-button-continue");
        // var nextButtons = document.querySelectorAll(".next-btn");
        // var prevButtons = document.querySelectorAll(".prev-btn");
        
        // nextButtons.forEach(function(button) {
        //     button.addEventListener("click", function() { moveStep(true); });
        // });

        // continueBtn.addEventListener("click", function() { moveStep(true); navStepContainer.style.display="flex"; });
        
        // prevButtons.forEach(function(button) {
        //     button.addEventListener("click", function() { moveStep(false); });
        // });
        
        // // Direct navigation to previous steps
        // navSteps.forEach((step, index) => {
        //     step.addEventListener("click", () => {
        //         if (index <= currentStep) {
        //             steps[currentStep].style.display = "none";
        //             currentStep = index;
        //             showStep(currentStep);
        //         }
        //     });
        // });
        

        // Signup Multistep Modal Logic
        var currentStep = 0;
        var steps = document.getElementsByClassName("form-step");
        var navSteps = document.querySelectorAll(".steps-navigation .step");
        var navStepContainer = document.querySelector(".steps-navigation");

        // Initially hide the steps navigation
        navStepContainer.style.display = "none";

        showStep(currentStep); // Initialize the form to show the first step

        function moveStep(next) {
            steps[currentStep].style.display = "none"; // Hide current step
            currentStep += next ? 1 : -1;
            
            // if (currentStep >= steps.length) {
                // document.getElementById("gsMultiStepFormRegister").submit(); // Submit form if on the last step
                // return;
            // }
            showStep(currentStep);
        }

        function showStep(n) {
            steps[n].style.display = "block"; // Show the current step
            updateStepsNavigation(n);

            // Show navigation steps starting from the second step
            if (n >= 1) {
                navStepContainer.style.display = "flex"; // Show the navigation steps
            } else {
                navStepContainer.style.display = "none"; // Hide the navigation steps for the first step
            }
        }

        function updateStepsNavigation(currentStep) {
            // Adjust the navigation steps based on the current step
            navSteps.forEach(function(step, index) {
                step.classList.remove("step-active", "step-completed", "line-active");
                if (index < currentStep - 1) { // Adjust index for visual representation
                    step.classList.add("step-completed");
                } else if (index === currentStep - 1) {
                    step.classList.add("step-active");
                }
                if (index < currentStep) {
                    step.classList.add("line-active");
                }
            });
        }

        // Attach event listeners to next and previous buttons
        var continueBtn = document.querySelector(".gs-signup-button-continue");
        var nextButtons = document.querySelectorAll(".next-btn");
        var prevButtons = document.querySelectorAll(".prev-btn");

        nextButtons.forEach(function(button) {
            button.addEventListener("click", function() { moveStep(true); });
        });

        continueBtn.addEventListener("click", function() {
            // Check if the current step is the last step before submitting
            if (currentStep === steps.length - 1) {
                // Prepare form data for AJAX request
                var formData = new FormData();
                formData.append('action', 'gs_register_new_user'); // The action hook for wp_ajax_ and wp_ajax_nopriv_
                formData.append('security', myAjax.security); // Nonce for security
                
                // Append form fields to formData
                formData.append('email', document.querySelector('input[name="email"]').value);
                formData.append('password', document.querySelector('input[name="password"]').value);
                formData.append('first_name', document.querySelector('input[name="first_name"]').value);
                formData.append('last_name', document.querySelector('input[name="last_name"]').value);
                // Continue appending other form fields as needed...
        
                // AJAX request to register the user
                fetch(myAjax.ajaxurl, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin' // Include cookies in the request
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert('User Registered Successfully!');
                        // Optionally, redirect or update UI here
                    } else {
                        // Handle errors
                        alert(data.data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            } else {
                moveStep(true); // Otherwise, just move to the next step
            }
        });
        // continueBtn.addEventListener("click", function() { moveStep(true); });

        prevButtons.forEach(function(button) {
            button.addEventListener("click", function() { moveStep(false); });
        });

        // Direct navigation to previous steps
        navSteps.forEach((step, index) => {
            step.addEventListener("click", () => {
                if (index <= currentStep) {
                    steps[currentStep].style.display = "none";
                    currentStep = index;
                    showStep(currentStep);
                }
                // Check if we're navigating backwards; forward navigation might need validation
              if (index < currentStep) {
                  steps[currentStep].style.display = "none"; // Hide the current step
                  currentStep = index + 1; // Adjust because navigation starts from step 2 visually
                  showStep(currentStep);
              }
            });

        });

});