var tables = {
    
    init: function() {
        if ($(".table").length) {
            $(".table").DataTable({
                "columnDefs": [ {
                  "targets"  : 'no-sort',
                  "orderable": false,
                }]
            });
        }
    }
    
}

$(function() {
    tables.init();
});