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
});