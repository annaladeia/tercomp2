var replace = {
    
    init: function() {
        var self = this;
        
        self.$replaceTarget = $(".js-replace-target");
        
        if (self.$replaceTarget.length) {
            
            self.$replaceForm = self.$replaceTarget.parents("form");
            
            $(document).on('change', ".js-replace-item", function(e) {
                self.checkSelected();
            });
            
            self.$replaceTarget.change(function() {
                var value = self.$replaceTarget.val();
                setTimeout(function() {
                    if (value > 0 && confirm('Are you sure you want to perform the replacement?')) {
                        self.$replaceForm.submit();
                    } else {
                        self.$replaceTarget[0].selectize.setValue('');
                    }
                });
            });
            
            self.checkSelected();
        }
    },
    
    checkSelected: function() {
        var self = this;
        
        if (self.hasSelectedItems()) {
            self.$replaceTarget[0].selectize.enable();
        } else {
            self.$replaceTarget[0].selectize.disable();
        }
    },
    
    hasSelectedItems: function() {
        return $(".js-replace-item").filter(":checked").length > 0;
    }
    
}

$(function() {
    replace.init();
});