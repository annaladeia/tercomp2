var select2 = {
    
    init: function($el) {
        var self = this;
        
        $el.select2();
        
        $el.each(function() {
            var $this = $(this);
            if (! $this.attr('multiple')) {
                $this.select2({
                    theme: "bootstrap",
                    selectOnClose: true,
                    width: "100%"
                }).data('select2').on("focus", function (e) {
                    self.focusSelect($this);
                });
            } else {
                $this.select2({
                    theme: "bootstrap",
                    width: "100%"
                });
            }
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