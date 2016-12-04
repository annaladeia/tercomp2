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
    self.btnDel = $el.find(".df-delete");
    self.content = $el.find(".df-content");
    self.container = $el.find(".df-container");
    
    //add a dynamic form section
    self.add = function(silent, noDelete) {
        //clone content
        var clonedContent = self.content.clone();
        
        //clone content and append to container
        clonedContent.appendTo(self.container);
        
        //init select2 for new content
        select2.add(clonedContent, ! silent);
        
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
        
    }
    
    //delete a dynamic form section
    self.delete = function(content) {
        content.remove();
    }
    
    //remove select2 before creating content clone
    select2.delete(self.content);
    
    //detach content from DOM
    self.content.removeClass('df-content').addClass('df-content-item').detach().removeClass('hide');
    
    //handle add btn click
    self.btnAdd.click(function() { self.add() });
    
    //handle del btn click
    self.btnDel.click(function() {self.delete($(this).parents(".df-content-item")) });
    
    //add first record
    if (! self.el.hasClass('df-hidden')) {
        self.add(true, true);
    }
}


$(function() {
    df.init();
});