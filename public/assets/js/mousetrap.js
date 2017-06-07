var mt = {
    
    init: function() {;
        
        Mousetrap.prototype.stopCallback = function(e, el, combo) {
            return false;
        };
        
        $(".mousetrap").each(function() {
            var $this = $(this),
                shortcut = $(this).attr('data-shortcut');
            
            if (shortcut) {
                Mousetrap.bind(shortcut, function(e) {
                    mt.active = true;
                    $this.click();   
                    mt.active = false;
                });
            }
        });
    },
}

$(function() {
    mt.init();
});