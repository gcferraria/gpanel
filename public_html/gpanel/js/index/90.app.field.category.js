(function( JsB ) {
    
    var
        Selector = my.Class( JsB.object('Input'), {
            'constructor': function( elem, caller ) {
                Selector.Super.call( this, elem, caller );
                
                this.name    = 'category';
                this.min     = 2;
                this.delay   = 0;
                this.timeout = null;
                
                var that = this;
                this.context.bind('mouseleave', function() {
                    that.context.$results.hide();
                })
                
                this.bind('focus');
                this.bind('keydown');
            }
            , 'focus': function() {
                if ( this.value() != '' )
                    this.context.$results.show();
            }
            , 'keydown': function( ev ) {
                var that     = this,
                    keypress = ev.keyCode,
                    value    = this.value();
                    
                switch ( keypress ) {
                    case 38: // up
                        ev.preventDefault();
                        that.context.$results.previous();
                    break;
                    case 40: // down
                        ev.preventDefault();
                        that.context.$results.next();
                    break;
                    default:
                        
                        clearTimeout( this.timeout );
                        this.timeout = setTimeout( function() {
                            that.search();
                        }, this.delay);
                        
                    break;
                }
            }
            , 'search': function() {
                var value  = this.value().replace(/[\\]+|[\/]+/g,""),
                    length = value.length,
                    min    = this.min;
                
                if ( length >= min ) 
                    this._load();
                else
                    this.context.$results.hide();
                
                return;
            }
            , '_load': function() {
                var that = this;
                
                $.ajax({
                    'type'      : 'POST',
                    'url'       : this.$.attr('data-jsb-url'),
                    'data'      : { 'q': this.value() },
                    'dataType'  : 'json',
                    'beforeSend': function() { that.$.addClass('spinner') },
                    'complete'  : function() { that.$.removeClass('spinner') },
                    'error'     : function() { that.$.removeClass('spinner') },
                    'success'   : function( data ) {
                        that.context.$results.update( data );
                        that.context.$results.$.show();
                    }
                });
            }
        })
        , Results = my.Class( JsB, {
            'constructor': function( elem, caller ) {
                Results.Super.call( this, elem, caller );
                
                this.name = 'results';
                
                // Calculate Width based on category fields.
                var width = this.context.$category.$.outerWidth();
                this.$.width( width );
            }
            , 'next': function () {
                var selected = this.selected(true)[0],
                    next     = selected
                             ? selected.next()
                             : 0;
                
                if ( !next && this.length > 0 )
                    next = 0;
                    
                this.select( next );
            }
            , 'previous': function () {
                var selected = this.selected(true)[0],
                    previous = selected
                             ? selected.previous()
                             : this.length - 1;
                
                if ( !previous && this.length > 0 )
                    previous = this.length - 1;
                
                this.select( previous );
            }
        })
        , Field = my.Class( JsB.object('Input'), {
            'constructor': function( elem, caller ) {
                Field.Super.call( this, elem, caller );
                
                this.name = 'field';
            }
            , 'update': function() {
                var data     = [],
                    children = this.context.$container.toArray();
                
                var i;
                for ( i in children ) {
                    var child = children[ i ];
                    
                    if ( typeof( child ) === 'object' )
                        data.push( child.name );
                }
                
                if ( data.length <= 0 )
                    this.$.val('');
                else
                    this.value( data );
            }
            , 'value': function( data ) {
                if ( data && data.length > 0 )
                    Field.Super.prototype.value.call( this, JSON.stringify( data ) );
                else {
                    data = Field.Super.prototype.value.call( this );
                    if ( data )
                        return JSON.parse( data );
                }
                
                return 1;
            }
            , 'reset': function( empty ) {
                Field.Super.prototype.reset.call( this );
                
                // Clear Category Selector.
                this.context.$category.reset();
                
                // Hide Results.
                this.context.$results.hide();
                
                // Empty Results.
                if ( empty )
                    this.context.$container.empty();
            }
        })
        , Result = my.Class( JsB, {
            'constructor': function( elem, caller ) {
                Result.Super.call( this, elem, caller );
                
                this.bind('mouseover');
                this.bind('click');
            }
            , 'mouseover': function( ev ) {
                ev.preventDefault;
                
                // Tell to my parent to selected me.
                this.parent.select( this );
            }
            , 'click': function( ev ) {
                ev.preventDefault();
                
                this.context.$container.update({
                        'name' : this.name,
                        '$name': this.$name.$.text(),
                        '$path': this.$path.$.text(),
                    });
                
                // Clear Category Selector.
                this.context.$category.reset();
                
                // Hide Results.
                this.context.$results.hide();
                
                return false;
            }
        })
        , Container = my.Class( JsB, {
            'constructor': function( elem, caller ) {
                Container.Super.call( this, elem, caller );
                
                var that  = this;
                this.name = 'container';
                
                // Build List based on field value.
                this.root.queue.push( function() {
                    that.update( that.context.$field.value() );
                });
            }
            , 'update': function( data ) {
                var items = [];
                
                if ( data instanceof Array )
                    items = data;
                else if ( typeof( data ) === 'object' )
                    items.push( data );
                else
                    return;
                
                Container.Super.prototype.update.call( this, items );
                
                // Update Hidden Field.
                this.context.$field.update();
                
                // Select first item.
                if ( this.length > 0 )
                    this[0].select();
                
                // Show Container.
                this.show();
            }
            , 'dettach': function( item ) {
                Container.Super.prototype.dettach.call( this, item );
                
                this.context.$field.update();
                
                // Hide Container if there are no children.
                if ( this.length == 0 )
                    this.hide();
                else
                    this[0].select()
            }
            , 'swap': function( child1, child2 ) {
                Container.Super.prototype.swap.call( this, child1,child2 );
                
                this.context.$field.update();
                this[0].select();
            }
        })
        , Delete = my.Class( JsB, {
            'constructor': function( elem, caller ) {
                Delete.Super.call( this, elem, caller );
                
                this.name = 'delete';
                this.bind( 'click' );
            }
            , 'click': function( ev ) {
                var item      = this.parent,
                    container = item.parent;
                
                // Delete Item.
                container.dettach( item );
                
                return false;
            }
        })
        , Up = my.Class( JsB, {
            'constructor': function( elem, caller ) {
                Up.Super.call( this, elem, caller );
                
                this.name = 'up';
                this.bind( 'click' );
            }
            , 'click': function( ev ) {
                var item = this.parent,
                    prev = item.previous();
                    
                item.parent.swap( item, prev );
                
                return false;
            }
        })
        , Down = my.Class( JsB, {
            'constructor': function( elem, caller ) {
                Down.Super.call( this, elem, caller );
                
                this.name = 'down';
                this.bind( 'click' );
            }
            , 'click': function( ev ) {
                var item = this.parent,
                    next = item.next();
                    
                item.parent.swap( item, next );
                
                return false;
            }
        })
    ;
    
    JsB.object( 'App.Category.Selector'     , Selector  );
    JsB.object( 'App.Category.Field'        , Field     );
    JsB.object( 'App.Category.Results'      , Results   );
    JsB.object( 'App.Category.Results.Item' , Result    );
    JsB.object( 'App.Category.Container'    , Container );
    JsB.object( 'App.Category.Delete'       , Delete    );
    JsB.object( 'App.Category.Up'           , Up        );
    JsB.object( 'App.Category.Down'         , Down      );
    
})( JsB );