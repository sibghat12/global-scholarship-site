
jQuery(document).ready(function($) {
    // Open the modal when the menu button with the 'login_form' id is clicked
    jQuery(document).on('click', '.gs-login-btn', function(e) {
        e.preventDefault();
        
        jQuery('#loginModal').modal('show');
    });
});
