var googleSignInConfig = googleSignInConfig || {client_id: '332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com'};
console.log("googleSignInConfig",googleSignInConfig.client_id)

window.onload = function() {
    google.accounts.id.initialize({
        client_id: "332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com",
        callback: handleCredentialResponse
    });
    google.accounts.id.renderButton(
        document.getElementById("buttonDiv"),
        { theme: "outline", size: "large" }  // customization attributes
    );
    google.accounts.id.prompt(); // Display the One Tap prompt
};

function handleCredentialResponse(response) {
    console.log("Encoded JWT ID token: " + response.credential);
    // Send this response.credential (JWT ID token) to your server to be verified and to log the user in.
}
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



