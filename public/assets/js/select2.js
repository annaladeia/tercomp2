var select2 = {
    
    init: function($el) {
        var self = this;
        
        $el.select2({
            theme: "bootstrap",
            selectOnClose: true
        });
        
        $el.each(function() {
            var $this = $(this);
            $this.data('select2').on("focus", function (e) {
                self.focusSelect($this);
            });            
        }); 
    },
    
    add: function($el, focus) {
        this.init($el.find('select'));
        
        if (focus)
            this.focusSelect($el.find('select:first'));
    },
    
    delete: function($el) {
        $el.find('select').select2('destroy');
    },
    
    focusSelect: function($el) {
        $el.select2("open");
    }
}

$(function() {
    select2.init($('select'));
});