var forms = {
    
    init: function() {
        this.handleRedirect();   
    },
    
    handleRedirect: function() {
        
        $(".form-btn-redirect-edit").click(function() {
            var $form = $(this).parents("form");
            
            $form.find("[name=redirect]").val('edit');
            $form.submit();
        });
    }
}

$(function() {
    forms.init();
});