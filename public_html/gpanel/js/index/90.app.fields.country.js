(function ( JsB ) {

    var
        Country = my.Class( JsB.object('Select2'), {
            'constructor': function( elem, caller ) {
                JsB.FLAGS_PATH = jQuery(elem).attr('data-flags-path');
                Country.Super.call( this, elem, caller );
            }
            , format: function(state) {
                if ( !state.id )
                    return state.text;

                return "<img class='flag' src='" + JsB.FLAGS_PATH + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
            }
        })

    JsB.object( 'Country', Country );

})( JsB );
