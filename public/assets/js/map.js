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
    
    setLayout: function(name) {
        var layout = this.cy.layout({
            name: name
        });
        
        layout.run();
    },
    
    initCy: function(data) {
        
        var self = this;
    
        self.cy = cytoscape({

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
                'font-size': '15px',
                'background-color': 'data(color)',
                'z-index': 'data(zindex)'
              }
            }
          ]
        
        });
        
        self.cy.on('select', function(evt){
            evt.target.data({label: evt.target.data('id')});
        });
        
        self.cy.on('unselect', function(evt) {
            evt.target.data({label: ''});
        });
    }
};

$(function() {
    map.init();
});