var forms = {
    
    init: function() {
        this.handleRedirect();
        this.handleToggle($("body"));
        this.handleViewEntity($("body"));
        this.focusOnFirstField();
        this.handleShortcuts();
    },
    
    focusOnFirstField: function() {
        $(".form-group:first input, .form-group:first textarea").focus();
    },
    
    handleRedirect: function() {
        
        $(".form-btn-redirect-edit").click(function() {
            var $this = $(this),
                value = $(this).attr('data-redirect'),
                $form = $this.parents("form");
            
            if (! value) value = 'edit';
            
            $form.find("[name=redirect]").val(value);
            $form.submit();
        });
    },
    
    handleToggle: function($el) {
        
        $el.find(".form-toggle").change(function() {
            var value = $(this).val(),
                $options = $(this).parents(".df-content-item").find(".form-toggle-option");
               
            $options.addClass('hide');
            $options.filter(".form-toggle-option-" + value.toString()).removeClass('hide');
            
            selectize.init($("select:not(.selectized)"));
        });
    },
    
    handleViewEntity: function($el) {
        $el.find(".form-view-entity").click(function(e) {
            e.preventDefault();
            window.open('/' + $(this).data('entity-type') + '/' + $(this).parents(".df-content-item").find(".form-group:not(.hide) > .form-entity").val());
        });
    },
    
    handleShortcuts: function() {
        var self = this;
        
        Mousetrap.bind('alt+=', function() {
            self.navigateSection(true, 0);
        });
        
        Mousetrap.bind('alt+-', function() {
            self.navigateSection(false, 0);
        });
    },
    
    navigateSection: function(forward, skip) {
        var $focused = $(':focus'),
            $focusedPanel,
            $targetPanel;
            
        if ($focused) {
           $focusedPanel = $focused.parents(".panel");
        }
        
        if ($focusedPanel && $focusedPanel.length) {
            if (forward) {
                $targetPanel = $focusedPanel.nextAll('.panel:eq(' + skip + ')');
            } else {
                $targetPanel = $focusedPanel.prevAll('.panel:eq(' + skip + ')');
            }
        } else {
            $targetPanel = $(".panel:visible:first");
        }
        
        if ($targetPanel && $targetPanel.length) {
            var $el = $targetPanel.find('input[type=text],select').filter(':first')
            if ($el.length) {
                if ($el.is('select')) {
                    $el[0].selectize.focus();
                } else {
                    $el.focus();
                }
                
                var offset = $targetPanel.offset().top - 100;
                $('html, body').animate({
                    scrollTop: offset
                }, 500);
                
            } else {
                this.navigateSection(forward, skip+1);
            }
        }
    }
}

$(function() {
    forms.init();
});