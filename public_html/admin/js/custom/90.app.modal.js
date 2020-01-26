(function(JsB) {
	
	var
	   	Modal = my.Class( JsB, {
	   		constructor: function( elem, caller ) {
                Modal.Super.call( this, elem, caller );

            	var that = this;
                this.caller = caller;

            	this.root.queue.push(function(){
            		that.$.modal({show: false})
                    .on('shown.bs.modal', function (e) {
                        that.show(e);
                    });
            	});
            },
            open: function( caller ) {
                this.caller = caller;
                this.$.modal('show');
            },
            show: function( ev ) {
                return false;
            },
            hide: function( ev ) {
                this.$.modal('hide'); 
            }
        })
    ;

    JsB.object( 'App.Modal', Modal );

})(JsB);