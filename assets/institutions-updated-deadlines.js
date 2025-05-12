jQuery(document).ready(function ($) {
    $('#gs-feedback-table').DataTable( {
        responsive: true,
        // order:[[7, 'desc']],
        // "columnDefs": [ {
        //     "targets": 0,
        //     "orderable": false
        // } ]
    } );
});

jQuery(document).ready(function ($) {
    const allCheckbox = $("#select-all-checkbox")
    allCheckbox.change(function() {
        if ($(this).is(":checked")) {
        $(".gs-feedback-table tbody td input[type='checkbox']").prop("checked", true);
        } else {
        $(".gs-feedback-table tbody td input[type='checkbox']").prop("checked", false);
        }
    });
});

