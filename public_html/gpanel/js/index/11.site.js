(function ( JsB ) {

    var 
        Top = my.Class( JsB, {
            'constructor': function( elem, caller ) {
                Top.Super.call( this, elem, caller );
                
                this.offset   = this.$.attr('data-jsb-offset')   || 250;
                this.duration = this.$.attr('data-jsb-duration') || 500;

                this.bind('click');
                var that = this;
                
                $(window).scroll( function() {
                    if ( $(this).scrollTop() > that.offset) {
                        that.$.fadeIn(that.duration);
                    } else {
                        that.$.fadeOut(that.duration);
                    }
                }); 
            }
            , 'click': function( ev ) {
                ev.preventDefault();
                this.root.$.animate({ scrollTop: 0 }, this.duration);
                return false;
            }
        })
		, Button = my.Class( JsB, {
	   		 'constructor': function( elem, caller ) {
                Button.Super.call( this, elem, caller );
                
                this.bind('click');
            },
            'click': function() {
                this.selected() ? this.deselect() : this.select();

                return false;
            }, 
            'select': function() {
                Button.Super.prototype.select.call( this );  
                this.$.addClass('off');
                this.parent.$panel.show();
            },
            'deselect': function() {
                Button.Super.prototype.deselect.call( this );  
                this.$.removeClass('off');
                this.parent.$panel.hide();
            }
	   	})
	;	

    JsB.object( 'App.Search.Button', Button );
    JsB.object( 'Top', Top );
    
})( JsB );
