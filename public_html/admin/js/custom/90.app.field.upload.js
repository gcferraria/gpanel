(function( JsB ) {
    
    var
        Field = my.Class( JsB.object('Input'), {
            constructor: function( elem, caller ) {
                Field.Super.call( this, elem, caller );
            }, 
            update: function() {
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
            }, 
            value: function( value ) {    
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
            }, 
            reset: function() {
                Field.Super.prototype.reset.call( this );
                this.parent.$files.empty();
            }
        }), 
        DelBtn = my.Class( JsB, {
            constructor: function( elem, caller ) {
                DelBtn.Super.call( this, elem, caller );
                this.bind( 'click' );
            }, 
            click: function(ev) {
                this.parent.$files[0].$delete.click();
            }
        }), 
        Progress = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Progress.Super.call( this, elem, caller );
            }, 
            show: function() {
                this.$.removeClass('display-hide');
            }, 
            hide: function() {
                this.$.addClass('display-hide');
            }
        }), 
        Files = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Files.Super.call( this, elem, caller );
                
                var that = this;
                this.root.queue.push( function() {
                    that.update( that.parent.$field.value() );
                });
            }, 
            update: function( data ) {
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
            }, 
            dettach: function( item ) {
                Files.Super.prototype.dettach.call( this, item );
                this.parent.$field.update();
            }, 
            swap: function( child1, child2 ) {
                Files.Super.prototype.swap.call( this, child1,child2 );
                
                this.parent.$field.update();
                this[0].select();
            }
        }), 
        Delete = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Delete.Super.call( this, elem, caller );
                
                this.bind( 'click' );
            }, 
            click: function( ev ) {
                var item      = this.parent,
                    container = item.parent;
                
                container.dettach( item );
                return false;
            }
        }),
        Up = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Up.Super.call( this, elem, caller );
                
                this.name = 'up';
                this.bind( 'click' );
            }, 
            click: function( ev ) {
                var item = this.parent,
                    prev = item.previous();
                    
                item.parent.swap( item, prev );
                
                return false;
            }
        }), 
        Down = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Down.Super.call( this, elem, caller );
                
                this.name = 'down';
                this.bind( 'click' );
            }, 
            click: function( ev ) {
                var item = this.parent,
                    next = item.next();
                    
                item.parent.swap( item, next );
                
                return false;
            }
        })
    ;
    
    JsB.object( 'App.Upload.Field'       , Field    );
    JsB.object( 'App.Upload.Delete'      , DelBtn   );
    JsB.object( 'App.Upload.Progress'    , Progress );
    JsB.object( 'App.Upload.Files'       , Files    );
    JsB.object( 'App.Upload.Files.Delete', Delete   );
    JsB.object( 'App.Upload.Up'          , Up       );
    JsB.object( 'App.Upload.Down'        , Down     );

})( JsB );
