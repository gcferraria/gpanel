(function ( JsB ) {

    var
        Form = my.Class( JsB, {
            'constructor': function ( elem, caller ) {
                Form.Super.call( this, elem, caller );

                this.fields = [];
                this.action = this.$.attr('action');
                this.method = this.$.attr('method') || 'post';

                var that = this;
                this.root.queue.push(function(){
                    that.fields = that.$fields.toArray();
                });
            }
            , 'submit': function( ev ) {
                ev.preventDefault();
                this.$.submit();
            }
            , 'redirect': function( data ) {
                setTimeout( function() { window.location = data.url }, data.duration || 0 );
            }
            , 'disable': function() {
                for ( var idx in this.fields ) {
                    var field = this.fields[ idx ];

                    if ( field.$field )
                        field.$field.disable();
                }
            }
            , 'enable': function() {
                for ( var idx in this.fields ) {
                    var field = this.fields[ idx ];

                    if ( field.$field )
                        field.$field.enable();
                }
            }
            , 'show_errors': function( errors ) {
                if ( typeof( errors ) == 'object' ) {
                    for ( var idx in this.fields ) {
                        var field = this.fields[ idx ];

                        if ( field.$error === undefined )
                            continue;

                        var error = errors[ field.name ];
                        if ( error !== undefined ) {
                            field.$.addClass('has-error');
                            field.$error.update( error );
                        }
                        else {
                            field.$.removeClass('has-error');
                            field.$error.update('');
                        }
                    }
                }
            }
            , 'clean_errors': function() {
                for ( var idx in this.fields ) {
                    var field = this.fields[ idx ];

                    if ( field.$error === undefined )
                        continue;

                    field.$.removeClass('has-error');
                    field.$error.update('');
                }
            }
            , 'reset': function() {
                for ( var idx in this.fields ) {
                    var field = this.fields[ idx ];

                    field.$.removeClass('has-error');
                    if ( field.$error ) field.$error.value( null );
                    if ( field.$field ) {
                        field = field.$field;
                        if ( typeof field.reset === 'function' )
                            field.reset( true );
                        else
                            field.$.val('');
                    }
                }
            }
            , 'notification': function( args ) {
                app.notification( args[0], args[1] );
            }
        })

        , AjaxForm = my.Class( Form, {
            'constructor': function ( elem, caller ) {
                AjaxForm.Super.call( this, elem, caller );

                this.async = true;
            }
            , 'submit': function( ev, args ) {
                var that = this,
                    data = this.$.serializeArray();

                // to prevent another request, while others do not finish.
                if ( this._request )
                    this._request.abort();

                // If adicional args are defined, push into form data.
                if ( args != undefined && typeof args == 'object' )
                    data.push( args );

                this._request = $.ajax({
                    'type'      : this.method,
                    'url'       : this.action,
                    'async'     : this.async,
                    'data'      : data,
                    'dataType'  : 'json',
                    'beforeSend': function() { that._beforeSend(); },
                    'error'     : function( XHR, textStatus ) { that._onError( XHR, textStatus ); },
                    'complete'  : function() { that._onComplete(); },
                    'success'   : function( data ) {
                        that._request = null;
                        that._onSuccess( data );
                    }
                });
            }
            , _beforeSend: function() {
                this.$button.$.button('loading');
                this.disable();
            }
            , _onComplete    : function() {
                this.$button.$.button('reset');
                this.enable();
            }
            , _onError       : function( XHR, textStatus ) {}
            , _onSuccess     : function( data ) {
                this.update( data );
                var top = this.$.offset()['top'];
                $('html, body').animate({ 'scrollTop': top - 100 }, 'slow');
            }
        })

        , Submit = my.Class( JsB, {
            'constructor': function ( elem, caller ) {
                Submit.Super.call( this, elem, caller );

                this.name = 'button';
                this.bind('click');
            }
            , 'click': function( ev, args ) {
                this.context.submit( ev );
                return false;
            }
        })
    ;

    JsB.object( 'App.Form'            , Form     );
    JsB.object( 'App.Form.Ajax'       , AjaxForm );
    JsB.object( 'App.Form.Ajax.Submit', Submit   );

})( JsB );
