var map = {
    
    init: function() {
    
        var self = this;
        self.$container = $("#cy");
        
        if (self.$container.length) {
            
            var documentID = $("[name='documentID']").val();
            
            var graphP = $.ajax({
                url: '/documents/getMapJSON/' + documentID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    self.initCy(data);
                }
              });
        }
    },
    
    initCy: function(data) {
    
        var cy = cytoscape({

          container: this.$container[0],
        
          elements: data,
        
          layout: {
            name: 'preset'
          },
        
          style: [
            {
              selector: 'node',
              style: {
                'content': 'data(label)',
                'width': '50px',
                'height': '50px',
                'font-size': '15px'
              }
            }
          ]
        
        });
        
        cy.on('select', function(evt){
            evt.target.data({label: evt.target.data('id')});
        });
        
        cy.on('unselect', function(evt) {
            evt.target.data({label: ''});
        });
    }
};

$(function() {
    map.init();
});