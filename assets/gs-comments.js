jQuery(document).ready(function ($) {
    const $commentsAuthors = $('.comments-container').find('.comment-author');
    
    $commentsAuthors.each(function (index, author) {
        const $authorElement = $(author);
        const authorHTML = $authorElement.html();
        const modifiedHTMLwithoutAT = authorHTML.replace(' at ', '');

        $authorElement.html(modifiedHTMLwithoutAT);
    });
});