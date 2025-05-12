document.addEventListener('DOMContentLoaded', getActiveSection);

function getActiveSection() {
    // Get the current hash value
    var currentHash = window.location.hash;
    
    // Get all the navigation links
    var navLinks = document.querySelectorAll('.gs-institution-items-container a');
    
    // Loop through each navigation link to add or remove the "active" class
    navLinks.forEach(function(link) {
      // Get the link's hash value
      var linkHash = link.getAttribute('href');
      
      // Check if the link's hash matches the current hash
      if (linkHash === currentHash) {
        // Add the "active" class to the link
        link.classList.add('active');
      } else {
        // Remove the "active" class from the link
        link.classList.remove('active');
      }
      
      // Add a click event listener to the link to update the active section
      link.addEventListener('click', function(event) {
        // Prevent the default link behavior
        event.preventDefault();
        
        // Get the hash value of the clicked link
        var clickedHash = link.getAttribute('href');
        
        // Update the current hash value
        window.location.hash = clickedHash;
        
        // Update the active section
        getActiveSection();
      });
    });
}