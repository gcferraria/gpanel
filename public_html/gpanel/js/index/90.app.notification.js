(function(JsB) {
	
	var
	   	Pulsate = my.Class( JsB, {
	   		 'constructor': function( elem, caller ) {
                Pulsate.Super.call( this, elem, caller );
            	
            	var that = this;
            	this.root.queue.push(function(){
            		that.$.pulsate({
                    	'color' : "#66bce6",
                     	'repeat': 15
                 	});
            	});
            },
        })
    ;

    JsB.object( 'App.Notification.Pulsate', Pulsate );

})(JsB);