(function ( JsB ) {

    var
        Portlet = my.Class( JsB, {
            constructor: function ( elem, caller ) {
                Portlet.Super.call( this, elem, caller );
            }
        })
        , Collapse = my.Class( JsB, {
            constructor: function ( elem, caller ) {
                Collapse.Super.call( this, elem, caller );

                this.bind('click');
                this.$.tooltip({container: 'body',title: this.$.attr('title')});
            }
            , click: function(ev) {
                ev.preventDefault();
                this.selected() ? this.deselect() : this.select();
                return false;
            }
            , select: function() {
                Collapse.Super.prototype.select.call( this );
                this.$.removeClass("collapse").addClass("expand");
                this.context.$body.$.slideUp(200);
            }
            , deselect: function() {
                Collapse.Super.prototype.deselect.call( this );
                this.$.removeClass("expand").addClass("collapse");
                this.context.$body.$.slideDown(200);
            }
        })
        , Reload = my.Class( JsB, {
            constructor: function ( elem, caller ) {
                Reload.Super.call( this, elem, caller );

                this.bind('click');
                this.$.tooltip({container: 'body',title: this.$.attr('title')});
            }
            , click: function() {
                if( this.context.$body['$table'] !== undefined )
                    this.context.$body.$table.reload();
                else if( this.context.$body['$chart'] !== undefined )
                    this.context.$body.$chart.reload();
                else
                    this.context.$body.reload();
                return false;
            }
        })
        , Remove = my.Class( JsB, {
            constructor: function ( elem, caller ) {
                Remove.Super.call( this, elem, caller );

                this.bind('click');
                this.$.tooltip({container: 'body',title: this.$.attr('title')});
            }
            , click: function(ev) {
                ev.preventDefault();
                this.root.dettach( this.context );
                return false;
            }
        })
        , Actions = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Actions.Super.call( this, elem, caller );
                this.bind('click');
            }
            , click: function(ev) {
                return false;
            }
            , execute: function( url, params ) {
                var    
                    that = this,
                    elem = this.context.parent
                ;

                $.ajax({
                    type      : 'POST',
                    url       : url,
                    dataType  : 'json',
                    data      : params,
                    beforeSend: function() { app.blockUI(elem); },
                    error     : function() {},
                    complete  : function() { app.unblockUI(elem); },
                    success   : function( data ) {
                        // force reload.
                        that.context.$body.$table.table._fnAjaxUpdate();

                        // Update element with data and actions with JSON origin.
                        that.update( data );
                    }
                });
            }
            , notification: function( args ) {
                app.notification( args[0], args[1] );
            }
        }) 
        , Action =  my.Class( Actions, {
            constructor: function ( elem, caller ) {
                Action.Super.call( this, elem, caller );
            }
            , click: function(ev) {
                var that = this;
                bootbox.confirm( this.$.attr('data-text'), function(result) {
                    if( result ) {
                        var params = {};
                        var rowsSelected = that.context.context.$body.$table.getRowsSelected(); 
                        if ( rowsSelected !== undefined ) 
                            params['rows'] = rowsSelected; 

                        that.context.execute(that.$.attr('data-url'), params);
                    }
                });
                return false;
            }
        })
    ;

    JsB.object( 'App.Portlet'               , Portlet  );
    JsB.object( 'App.Portlet.Collapse'      , Collapse );
    JsB.object( 'App.Portlet.Reload'        , Reload   );
    JsB.object( 'App.Portlet.Remove'        , Remove   );
    JsB.object( 'App.Portlet.Actions'       , Actions  );
    JsB.object( 'App.Portlet.Actions.Action', Action   );

})( JsB );
