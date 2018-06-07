(function( JsB ) {
    
    var
        Modal = my.Class( JsB.object('App.Modal'), {
            constructor: function( elem, caller ) {
                Modal.Super.call( this, elem, caller );
                this.params = {}
                this.values = [];
            }
            ,   show: function( ev ) {  
                this.values = [];
                Modal.Super.prototype.show.call( this, ev );
            }
            ,   hide: function ( ev ) {
                this.params = {};
                if( this.values instanceof Array ) {
                    if( this.values.length ) {
                        for ( var idx in this.values ) {
                            var file = this.values[idx];
                            this.caller.parent.$files.update({
                                '$filename' : file.$title.$.attr('filename'),
                                '$open' : {'href' : file.$link.$.attr('href') }
                            });
                        }
                    }
                }
                Modal.Super.prototype.hide.call( this, ev );
            }
            ,   open: function( caller ) {
                this.$content.$assets.$form.clear();
                Modal.Super.prototype.open.call( this, caller );
            }
        })
        ,   Open = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Open.Super.call( this, elem, caller );
                this.bind( 'click' );
            }
            ,   click: function( ev ) {
                ev.preventDefault();

                if ( this.isImage !== undefined && this.isImage )
                    app.$upload.params = {'name': 'type', 'value': 'image'};
                  
                if ( this.isVideo !== undefined && this.isVideo )
                    app.$upload.params = {'name': 'type', 'value': 'video'};
                
                return app.$upload.open( this );
            }
        })
        ,   Save = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Save.Super.call( this, elem, caller );
                this.bind('click')
            }
            ,   click: function( ev ) {
                ev.preventDefault();
                this.context.values = this.parent.$assets.$results.selected(true);
                return this.context.hide(ev);
            }
        })
        ,   Table = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Table.Super.call( this, elem, caller );
            }
        })
        ,   Form = my.Class( JsB.object('App.Form.Ajax'), {
            constructor: function( elem, caller ) {
                Form.Super.call( this, elem, caller );
                this.name = 'form';
            }
            ,   submit: function( ev, args ) {
                Form.Super.prototype.submit.call( this, ev, app.$upload.params );   
            }
            ,   _beforeSend: function() {
                this.context.$more.hide();
                Form.Super.prototype._beforeSend.call( this );
            }
            ,   _onSuccess: function( data ) {
                this.context.update( data );
            }
            ,   addPage: function( value ) {
                this.$page.value( parseInt( this.$page.value() ) + 1 );
            }
            ,   clear: function() {
                this.$fields.$search.$clear.click();
            }
            ,   reset: function() {
                this.$page.value(1);
            }
        })
        ,   Select = my.Class( JsB.object( 'Select2' ), {
            constructor: function( elem, caller ) {
                Select.Super.call( this, elem, caller );
            }
            ,   change: function( ev ) {
                this.context.submit( ev );
                return false;
            }
        })
        ,   Search = my.Class( JsB.object( 'App.Form.Ajax.Submit' ), {
            constructor: function( elem, caller ) {
                Search.Super.call( this, elem, caller );
            }
            ,   click: function( ev ) {
                this.context.reset();
                this.context.parent.$results.empty();

                return Search.Super.prototype.click.call( this, ev );
            }
        })
        ,   Clear = my.Class( JsB.object( 'App.Form.Ajax.Submit' ), {
            constructor: function( elem, caller ) {
                Clear.Super.call( this, elem, caller );
                this.name = 'clear';
            }
            ,   click: function( ev ) {
                this.context.reset();
                this.context.parent.$results.empty();
                
                this.context.$fields.$search.$field.reset();
                this.context.$fields.$orderBy.$field.reset();
                this.context.$fields.$orderDir.$field.reset();

                return Clear.Super.prototype.click.call( this, ev );
            }
        })
        ,   Results = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Results.Super.call( this, elem, caller );
            }
            ,   update: function( data ) {
                var length  = this.length,
                    lastIdx = length > 0 ? length -1 : 0;

                Results.Super.prototype.update.call( this, data );

                if( this.length == 0 )
                    return;

                var 
                    scroller = this.context.context.$content,
                    oLast    = this[ lastIdx ],
                    nLast    = this[ this.length - 1 ],
                    nTop     = nLast.$.offset().top  + nLast.$.height(),
                    oTop     = oLast.$.offset().top  + oLast.$.height(),
                    top      = scroller.$.scrollTop() + ( nTop - oTop )
                ;

                if ( lastIdx != 0 )
                    scroller.scrollTo(top);
            }
        })
        ,   Item = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Item.Super.call( this, elem, caller );
                this.bind('click');
            }
            ,   click: function(ev) { 
                ev.preventDefault();
                this.toggle('select','deselect');
                return false;
            }
            ,   select: function() {
                Item.Super.prototype.select.call( this.parent );
            }
            ,   deselect: function() {
                Item.Super.prototype.deselect.call( this.parent );
            }
        })
        ,   More = my.Class( JsB, {
            constructor: function( elem, caller ) {
                More.Super.call( this, elem, caller );
                
                this.bind('click');
            }
            ,   click: function( ev ) {
                this.context.$form.addPage();
                this.context.$form.submit();

                return false;
            }
        })
        
    ;

    JsB.object( 'App.Modal.Assets'             , Modal   );
    JsB.object( 'App.Modal.Assets.Open'        , Open    );
    JsB.object( 'App.Modal.Assets.Save'        , Save    );
    JsB.object( 'App.Modal.Assets.Form'        , Form    );
    JsB.object( 'App.Modal.Assets.Form.Select' , Select  );
    JsB.object( 'App.Modal.Assets.Form.Search' , Search  );
    JsB.object( 'App.Modal.Assets.Form.Clear'  , Clear   );
    JsB.object( 'App.Modal.Assets.Results'     , Results );
    JsB.object( 'App.Modal.Assets.Results.Item', Item    );
    JsB.object( 'App.Modal.Assets.Results.More', More    );

})( JsB );