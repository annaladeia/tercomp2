var actions = {
    
    init: function() {
        $(".btn-confirm-delete").click(function(e) {
            if (! confirm('Are you sure you want to delete this record?'))
                e.preventDefault(); 
        });
    }
    
}

$(function() {
    actions.init();
});