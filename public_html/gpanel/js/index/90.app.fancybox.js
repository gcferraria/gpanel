(function( JsB ) {

    var 
        Fancybox = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Fancybox.Super.call( this, elem, caller );
                this.$.fancybox({
                    groupAttr: 'data-rel',
                    prevEffect: 'none',
                    nextEffect: 'none',
                    closeBtn: true,
                    helpers: {
                    title: {
                           type: 'inside'
                        }
                    }
                });   
            }
        })
    ;

    JsB.object( 'App.Fancybox', Fancybox );

})( JsB );