var df = {
    
    init: function() {
        $(".df-group").each(function() {
            new dfGroup($(this));
        });
    }
}

function dfGroup($el) {
    
    var self = this;
    
    self.el = $el;
    self.btnAdd = $el.find(".df-add");
    self.btnPrefill = $el.find(".df-prefill");
    self.btnDel = $el.find(".df-delete");
    self.content = $el.find(".df-content");
    self.container = $el.find(".df-container");
    self.indexValue = self.content.attr('data-index-start');
    
    //add a dynamic form section
    self.add = function(silent, noDelete, defaultValue) {
        //clone content
        var clonedContent = self.content.clone();
        
        //replace array with index number
        if (self.indexValue) {
            var clonedContentHTML = clonedContent.html().replace(/\[i\]/g, '[' + self.indexValue + ']');
            
            clonedContent.html(clonedContentHTML);
            
            self.indexValue++;
        }
        
        //clone content and append to container
        clonedContent.appendTo(self.container);
        
        if (defaultValue) {
            
            clonedContent.find("select option").filter(function() {
                return $(this).text() == defaultValue; 
            }).prop('selected', true);
        }
        
        //init selectize for new content
        selectize.add(clonedContent, ! silent);
        
        //init handleToggle
        forms.handleToggle(clonedContent);
        
        //init handleViewEntity
        forms.handleViewEntity(clonedContent);
    
        if (noDelete) {
            
            clonedContent.find(".df-delete").remove();
        
        } else {
        
            //handle delete btn click
            clonedContent.find(".df-delete").click(function() { self.delete(clonedContent) });
        }
        
        if (! defaultValue) {
            clonedContent.find('input[type=text],select').filter(':visible:first').focus();
        }
        
    }
    
    //delete a dynamic form section
    self.delete = function(content) {
        content.remove();
    }
    
    self.prefill = function(values) {
        var valuesCount = values.length;
        for (var i = 0; i < valuesCount; i++) {
            self.add(false, false, values[i]);
        }
    }
    
    //remove selectize before creating content clone
    selectize.delete(self.content);
    
    //detach content from DOM
    self.content.removeClass('df-content').addClass('df-content-item').detach().removeClass('hide');
    
    //handle add btn click
    self.btnAdd.click(function() { self.add() });
    
    //handle del btn click
    self.btnDel.click(function() {self.delete($(this).parents(".df-content-item")) });
    
    //handle prefil btn click
    self.btnPrefill.click(function() {self.prefill($(this).attr('data-values').split(',')) });
    
    //add first record
    if (! self.el.hasClass('df-hidden')) {
        self.add(true, true);
    }
}


$(function() {
    df.init();
});