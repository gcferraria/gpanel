(function( JsB ) {
    
    var
        Field = my.Class( JsB.object('Input'), {
            constructor: function( elem, caller ) {
                Field.Super.call( this, elem, caller );
            }
            , 'update': function() {
                var data     = [],
                    children = this.parent.$files.toArray();
                
                for ( var idx in children ) {
                    var child = children[ idx ],
                        text  = child.$filename.$.text();
                    
                    if ( typeof( child ) === 'object' ) {
                        if ( this.isMultiple )
                            data.push( text );
                        else
                            data = text;
                    }
                }
                
                if ( data.length <= 0 )
                    this.$.val('');
                else
                    this.value( data );
            }
            , value: function( value ) {    
                if ( value && value.length > 0 ) {
                    if ( value instanceof Array )
                        Field.Super.prototype.value.call( this, JSON.stringify( value ) );
                    else
                        Field.Super.prototype.value.call( this, value );
                }
                else {
                    value = Field.Super.prototype.value.call( this );
                    if ( value )
                        return JSON.parse( value );
                }
               
                return 1;
            }
            , 'reset': function() {
                Field.Super.prototype.reset.call( this );
                this.parent.$files.empty();
            }
        })
        
        , Progress = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Progress.Super.call( this, elem, caller );
            }
            , show: function() {
                this.$.removeClass('display-hide');
            }
            , hide: function() {
                this.$.addClass('display-hide');
            }
        })

        , Files = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Files.Super.call( this, elem, caller );
                
                var that = this;
                this.root.queue.push( function() {
                    that.update( that.parent.$field.value() );
                });
            }
            , update: function( data ) {
                var items = [];
                
                if ( data instanceof Array )
                    items = data;
                else if ( typeof( data ) === 'object' )
                    items.push( data );
                else
                    return;
                    
                Files.Super.prototype.update.call( this, items );
                
                // Update Hidden Field.
                this.parent.$field.update();
            }
            , dettach: function( item ) {
                Files.Super.prototype.dettach.call( this, item );
                this.parent.$field.update();
            }
        })

        , Delete = my.Class( JsB, {
            'constructor': function( elem, caller ) {
                Delete.Super.call( this, elem, caller );
                
                this.bind( 'click' );
            }
            , 'click': function( ev ) {
                var item      = this.parent,
                    container = item.parent;
                
                container.dettach( item );
                return false;
            }
        })

        , OpenModal = my.Class( JsB, {
            'constructor': function( elem, caller ) {
                OpenModal.Super.call( this, elem, caller );
                this.bind( 'click' );
            }
            , 'click': function( ev ) {
                app.$upload.show( this );
                return false;
            }
        })

        , Modal = my.Class( JsB, {
            'constructor': function( elem, caller ) {
                Modal.Super.call( this, elem, caller );
                
                this.values = [];
                this.button;

                var that = this;
                this.$.modal({'show': false})
                .on('shown.bs.modal', function (e) {
                    that.vales = [];
                })
                .on('hide.bs.modal', function (e) {
                    if( that.values instanceof Array ) {
                        if( that.values.length ) {
                            for ( var idx in that.values ) {
                                var file = that.values[idx];
                                that.button.parent.$files.update({
                                    '$filename' : file.value,
                                    '$open' : {'href' : file.url }
                                });
                            }
                        }
                    }
                })
                ;
            }
            , show: function( caller ) {
                this.button = caller;
                this.$.modal('show'); 
            }
            , hide: function() {
                this.$.modal('hide');
            }
        })
        
        , Save = my.Class( JsB, {
            'constructor': function( elem, caller ) {
                Save.Super.call( this, elem, caller );
                this.bind('click')
            }
            , click: function() {
                this.parent.values = this.parent.$table.getRowsSelected();
                this.parent.hide(); 
            }
        })
    ;
    
    JsB.object( 'App.Upload.Field'       , Field     );
    JsB.object( 'App.Upload.Progress'    , Progress  );
    JsB.object( 'App.Upload.Files'       , Files     );
    JsB.object( 'App.Upload.Files.Delete', Delete    );
    JsB.object( 'App.Upload.OpenModal'   , OpenModal );
    JsB.object( 'App.Modal.Upload'       , Modal     );
    JsB.object( 'App.Modal.Upload.Save'  , Save      );

})( JsB );
