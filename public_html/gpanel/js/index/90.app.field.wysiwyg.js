(function( JsB ) {
    
    var
        TinyMce = my.Class( JsB, {
            constructor: function( elem, caller ) {
                TinyMce.Super.call( this, elem, caller );
                
                var that = this;
                this.root.queue.push( function() {
                    that.$.ckeditor( function() { /* callback code */ },
                        {
                            'language'               : JsB.APP_LANGUAGE,
                            'toolbarStartupExpanded' : true,
                            'startupShowBorders'     : true,
                            'startupOutlineBlocks'   : true,
                        }
                    );
                });
            }
            , ckeditor: function() {
                return this.$.ckeditorGet();
            }
            , value: function() {
                return this.$.val();
            }
            , disable: function() {
                return;
            }
            , enable: function() {
                return;
            }
            , update: function( data ) {
                this.ckeditor().setData( data );
            }
        })
    ;

    JsB.object( 'App.Wysiwyg', TinyMce );

})( JsB );
