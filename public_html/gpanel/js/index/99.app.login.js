(function(JsB) {
	
	var
	   Login = my.Class( JsB, {
            constructor: function ( elem, caller ) {
                Login.Super.call( this, elem, caller );
            }
            , select: function() {
                Login.Super.prototype.select.call( this );
                this.$login.$.slideUp(200);
                this.$forget.$.slideDown(200);
            }
            , deselect: function() {
                Login.Super.prototype.deselect.call( this );
                this.$forget.$.slideUp(200);
                this.$login.$.slideDown(200);
            }
        } )
       , Form = my.Class( JsB.object('App.Form.Ajax'), {
             constructor: function ( elem, caller ) {
                Form.Super.call( this, elem, caller );
            }
            , _beforeSend: function() {
                this.$fields.$button.$.button('loading');
                this.disable();
            }
            , _onComplete    : function() {
                this.$fields.$button.$.button('reset');
                this.enable();
            }
        })
        , Navigation = my.Class(JsB, {
            constructor: function ( elem, caller ) {
                Navigation.Super.call( this, elem, caller );
                this.bind('click');
            }
            , click: function( ev, args ) {
                this.root.$login.selected() ? this.root.$login.deselect() : this.root.$login.select();
                return false;
            }
        })
	;

    JsB.object( 'App.Login'           , Login      );
    JsB.object( 'App.Login.Navigation', Navigation );
    JsB.object( 'App.Form.Ajax.Login' , Form       );
    
})(JsB);