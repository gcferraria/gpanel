(function ( JsB ) {

    var 
        Top = my.Class( JsB, {
            constructor: function( elem, caller ) {
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
            , click: function( ev ) {
                ev.preventDefault();
                this.root.$.animate({ scrollTop: 0 }, this.duration);
                return false;
            }
        })
		, Button = my.Class( JsB, {
	   		 constructor: function( elem, caller ) {
                Button.Super.call( this, elem, caller );
                
                this.bind('click');
            },
            click: function() {
                this.selected() ? this.deselect() : this.select();

                return false;
            }, 
            select: function() {
                Button.Super.prototype.select.call( this );  
                this.$.addClass('off');
                this.parent.$panel.show();
            },
            deselect: function() {
                Button.Super.prototype.deselect.call( this );  
                this.$.removeClass('off');
                this.parent.$panel.hide();
            }
	   	})
        , Icon = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Icon.Super.call( this, elem, caller );
                
                this.iconClass = this.$.attr('class');
            },
            value: function ( value ) {
                if ( value ) {
                    this.$.removeClass( this.iconClass ).addClass("fa fa-warning");
                    this.$.attr('data-original-title',value ).tooltip({'container':'body'});
                }
                else {
                    this.$.removeClass("fa fa-warning").addClass( this.iconClass);
                    this.$.attr('data-original-title','' );
                }
            }
        })
         , Tooltip = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Tooltip.Super.call( this, elem, caller );
                
                this.$.tooltip({container: 'body',title: this.$.attr('title')});
            }
        })    
	;	

    JsB.object( 'App.Search.Button', Button );
    JsB.object( 'Top'              , Top    );
    JsB.object( 'Icon'             , Icon   );
    JsB.object( 'Tooltip'          , Tooltip);

})( JsB );