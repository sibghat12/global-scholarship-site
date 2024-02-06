var googleSignInConfig = googleSignInConfig || {client_id: '332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com'};
console.log("googleSignInConfig",googleSignInConfig.client_id)

// window.onload = function() {
//     google.accounts.id.initialize({
//         client_id: '332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com',
//         callback: handleCredentialResponse
//     });
//     google.accounts.id.renderButton(
//         document.getElementById("buttonDiv"),
//         { theme: "outline", size: "large" }  // customization attributes
//     );
//     google.accounts.id.prompt(); // Display the One Tap prompt
// };
// function handleCredentialResponse(response) {
//     console.log("Encoded JWT ID token: " + response.credential);
//     // Use Fetch API to send the ID token to your server for verification and to log the user in
//     fetch(myAjax.ajaxurl, {
//         method: 'POST',
//         credentials: 'same-origin', // Include cookies for the current domain
//         headers: {
//             'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8',
//         },
//         body: `action=google_login&id_token=${encodeURIComponent(response.credential)}`
//     })
//     .then(res => {
//         if (!res.ok) {
//             throw new Error('Network response was not ok');
//         }
//         return res.json(); // Parse JSON response from the server
//     })
//     .then(data => {
//         console.log('Server response:', data);
//         // Handle successful authentication here (e.g., redirect to a dashboard)
//         if (data.success && data.redirect_url) {
//             window.location.href = data.redirect_url; // Redirect user based on server response
//         }
//     })
//     .catch(error => {
//         console.error('Error:', error);
//         // Handle errors here, such as showing a message to the user
//     });
// }

// function handleCredentialResponse(response) {
//     console.log("Encoded JWT ID token: " + response.credential);
//     // Send this response.credential (JWT ID token) to your server to be verified and to log the user in.
//     $.ajax({
//         url: myAjax.ajaxurl, // Use wp_localize_script to define this variable in PHP
//         type: 'POST',
//         data: {
//             action: 'google_login', // The WordPress action hook for AJAX
//             id_token: response.credential
//         },
//         success: function(res) {
//             console.log('Server response:', res);
//             // Handle successful authentication here (e.g., redirect to a dashboard)
//         },
//         error: function(xhr, status, error) {
//             console.error('Error:', error);
//             // Handle errors here
//         }
//     });
// }
// function onSignIn(googleUser) {
//     var id_token = googleUser.getAuthResponse().id_token;
//     // Forward the ID token to your server as a query parameter
//     window.location.href = 'https://gs.lndo.site/google-auth?credential=' + encodeURIComponent(id_token);
// }
// onSignIn(googleUser)
// function onSignIn(googleUser) {
//     var id_token = googleUser.getAuthResponse().id_token;
//     // Use AJAX to send this token to your server
//     jQuery.ajax({
//         url: myAjax.ajaxurl, // Make sure this is defined elsewhere or replaced with a correct AJAX handler URL
//         type: 'POST',
//         data: {
//             action: 'google_login', // WordPress AJAX action
//             id_token: id_token
//         },
//         success: function(response) {
//             console.log('User logged in successfully.');
//             // Handle success
//         },
//         error: function(xhr, status, error) {
//             console.error('Login failed.', error);
//             // Handle error
//         }
//     });
// }

// Initialize Google Sign-In
// function initGoogleSignIn() {
//     gapi.load('auth2', function() {
//         gapi.auth2.init({
//             client_id: googleSignInConfig.client_id // Use the localized client_id
//         });
//     });
// }


jQuery(document).ready(function($) {
    // Open the modal
    $('.gs-login-btn').on('click', function(e) {
        e.preventDefault();
        $('#gsLoginModal').show();
    });


    // Close the modal when user clicks anywhere outside of the modal
    $(window).on('click', function(event) {
        var modal = $('#gsLoginModal');
        if ($(event.target).is(modal)) {
            modal.hide();
        }
    });
});
    
    // function onSignIn(googleUser) {
    //     var id_token = googleUser.getAuthResponse().id_token;
    //     // Use AJAX to send this token to your server
    //     $.ajax({
    //         url: myAjax.ajaxurl, // Use the ajaxurl variable that WordPress automatically provides
    //         type: 'POST',
    //         data: {
    //             action: 'google_login', // This corresponds to the WordPress action hook
    //             id_token: id_token
    //         },
    //         success: function(response) {
    //             console.log('User logged in successfully.');
    //             console.log("response:", response);
    //             // You can redirect the user or update the UI as needed
    //         },
    //         error: function(xhr, status, error) {
    //             console.error('Login failed.', error);
    //         }
    //     });
    // }
    // onSignIn(googleUser)
    

// function onSignIn(googleUser) {
//     var id_token = googleUser.getAuthResponse().id_token;
//     // Use AJAX to send this token to your server
//     jQuery.ajax({
        
//         url: '/wp-content/themes/Avada-Child-Theme/google-sigin.php', // Adjust the path as necessary
//         type: 'POST',
//         data: {
//             'id_token': id_token
//         },
//         success: function(response) {
//             console.log('User logged in successfully.');
//             console.log("response:::", response)
//             // Handle the response.
//         },
//         error: function(xhr, status, error) {
//             console.error('Login failed.');
//             // Handle errors here
//         }
//     });
// }



const client = google.accounts.oauth2.initCodeClient({
    client_id: '332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com',
    scope: 'https://www.googleapis.com/auth/calendar.readonly',
    ux_mode: 'popup',
    callback: (response) => {
      const xhr = new XMLHttpRequest();
      xhr.open('POST', code_receiver_uri, true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      // Set custom header for CRSF
      xhr.setRequestHeader('X-Requested-With', 'XmlHttpRequest');
      xhr.onload = function() {
        console.log('Auth code response: ' + xhr.responseText);
      };
      xhr.send('code=' + response.code);
    },
  });