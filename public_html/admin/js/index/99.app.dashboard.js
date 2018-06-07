(function(JsB) {
	
	var
	   Statistics = my.Class( JsB, {
            constructor: function ( elem, caller ) {
                Statistics.Super.call( this, elem, caller );
                
                this.url = this.$.attr('data-url');
                var that = this;
                this.root.queue.push(function(){
                    that.reload();
                });
            }
            , reload: function() {
                var that = this,
                    params = { 'date': this.root.$dashboard.$daterange.value() };

                $.ajax({
                    type      : 'POST',
                    url       : this.url,
                    dataType  : 'json',
                    data      : params,
                    beforeSend: function() {},
                    error     : function( XHR, textStatus ) {},
                    complete  : function() {},
                    success   : function( data ) {
                        that.update( data );
                    }
                });
            }
        })
        , Element = my.Class( JsB, {
            constructor: function ( elem, caller ) {
                Element.Super.call( this, elem, caller );
            }
            , update: function(data) {
                this.$.attr('data-value', data);
                this.$.counterUp({ delay: 10, time: 1000 });
            }
        })
	;

    JsB.object( 'App.DashBoard.Statistics'        , Statistics );
    JsB.object( 'App.DashBoard.Statistics.Element', Element    );

})(JsB);