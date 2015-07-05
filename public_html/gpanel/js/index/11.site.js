(function ( JsB ) {

    var 
        Top = my.Class( JsB, {
            'constructor': function( elem, caller ) {
                Top.Super.call( this, elem, caller );
                
                this.bind('click');
            }
            , 'click': function( ev ) {
                ev.preventDefault();
                this.root.$.animate({scrollTop: 0 }, 'slow');
                return false;
            }
        })
		, Button = my.Class( JsB, {
	   		 'constructor': function( elem, caller ) {
                Button.Super.call( this, elem, caller );
                
                this.bind('click');
            },
            'click': function(){
                this.selected() ? this.deselect() : this.select();

                return false;
            }, 
            'select': function(){
                Button.Super.prototype.select.call( this );  
                this.$.addClass('off');
                this.parent.$panel.show();
            },
            'deselect': function(){
                Button.Super.prototype.deselect.call( this );  
                this.$.removeClass('off');
                this.parent.$panel.hide();
            }
	   	})
	;	

    JsB.object( 'App.Search.Button', Button );
    JsB.object( 'Top', Top );
    
})( JsB );
