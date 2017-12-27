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
            click: function( ev ) {
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
        , Sidebar = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Sidebar.Super.call( this, elem, caller );

                var that = this;
                this.root.queue.push(function(){
                    if ( $.cookie && $.cookie('sidebar_closed') === '1' && 
                         app.getViewPort().width >= app.getResponsiveBreakpoint('md') 
                    ) {
                        this.close();
                    }
                });
            }
            , isClosed: function() {
                return (this.root.$.hasClass('page-sidebar-closed'));
            }   
            , open: function() {
                this.root.$.removeClass('page-sidebar-closed');
                this.$.removeClass('page-sidebar-menu-closed');

                if ($.cookie) { $.cookie('sidebar_closed', '0'); }
            }
            , close: function() {
                this.root.$.addClass('page-sidebar-closed');
                this.$.addClass('page-sidebar-menu-closed');

                if ($.cookie) { $.cookie('sidebar_closed', '1'); }
            }
            , toogle: function() {
                if ( this.isClosed() ) {
                    this.open();
                } else {
                    this.close();
                }
            }
        }) 
        , Toogle = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Toogle.Super.call( this, elem, caller );

                this.bind('click');
            }  
            , click: function(ev) {
                ev.preventDefault();
                this.root.$sidebar.toogle();
                $(window).trigger('resize');
            }
        })
	;	

    JsB.object( 'Top'               , Top     );
    JsB.object( 'Icon'              , Icon    );
    JsB.object( 'Tooltip'           , Tooltip );
    JsB.object( 'App.Sidebar'       , Sidebar );
    JsB.object( 'App.Toogle'        , Toogle  );
    JsB.object( 'App.Search.Button' , Button  );

})( JsB );