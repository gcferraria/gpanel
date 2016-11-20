(function(JsB) {
	
	var
	   	Modal = my.Class( JsB, {
	   		 'constructor': function( elem, caller ) {
                Modal.Super.call( this, elem, caller );
            	
            	var that = this;
            	this.root.queue.push(function(){
            		// Force destroy on close.
                    that.$.on('hidden.bs.modal', function () {
                        that.$.data('bs.modal', null);
                    });
            	});
            },
        })
    ;

    JsB.object( 'App.Modal', Modal );

})(JsB);