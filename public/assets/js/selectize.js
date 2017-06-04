var selectize = {
    
    init: function($el) {
        var self = this;
        
        $el.each(function() {
            var $this = $(this);
            if (! $this.parents(".hide").length) {
                
                console.log('not hidden');
            
                if (! $this.attr('multiple')) {
                    $this.selectize({
                        //theme: "bootstrap",
                        createOnBlur: true,
                        //width: "100%"
                    });
                } else {
                    $this.selectize({
                        createOnBlur: true,
                        // theme: "bootstrap",
                        // width: "100%"
                    });
                }
            }
        }); 
    },
    
    add: function($el, focus) {
        this.init($el.find('select'));
        console.log(123);
        
        if (focus)
            this.focusSelect($el.find('select:first'));
    },
    
    delete: function($el) {
        //$el.find('select').selectize('destroy');
    },
    
    focusSelect: function($el) {
        //$el.selectize("open");
    }
}

$(function() {
    selectize.init($('select'));
});