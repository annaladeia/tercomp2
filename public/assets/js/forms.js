var forms = {
    
    init: function() {
        this.handleRedirect();
        this.handleToggle($("body"));
        this.focusOnFirstField();
    },
    
    focusOnFirstField: function() {
        console.log(123);
        $(".form-group:first input, .form-group:first textarea").focus();
    },
    
    handleRedirect: function() {
        
        $(".form-btn-redirect-edit").click(function() {
            var $form = $(this).parents("form");
            
            $form.find("[name=redirect]").val('edit');
            $form.submit();
        });
    },
    
    handleToggle: function($el) {
        
        $el.find(".form-toggle").change(function() {
            var value = $(this).val(),
                $options = $(this).parents(".df-content-item").find(".form-toggle-option");
               
            $options.addClass('hide');
            $options.filter(".form-toggle-option-" + value.toString()).removeClass('hide');
        });
    }
}

$(function() {
    forms.init();
});