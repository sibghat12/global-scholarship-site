jQuery(document).ready(function($) {
    const $authorColumnComment = $('[data-colname="Author"]');
    const $mailtoLinks = $authorColumnComment.find('a[href^="mailto:"]');
    const $ipLinks = $authorColumnComment.find('a[href$="&mode=detail"]');
 
    $ipLinks.each(function() {
        $(this).css('display', 'none');
    });

    $mailtoLinks.each(function() {
        $(this).css('display', 'none');
    });
});