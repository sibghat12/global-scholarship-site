console.log("DEAdLINES")

jQuery(document).ready(function ($) {
    const tdClosed = $('td[data-status="closed"]');
    if (tdClosed) {
    const trParent = tdClosed.closest('tr');
    trParent.addClass('closed');
    }
});