(function(JsB) {
	
	var
	   	Scroll = my.Class( JsB, {
	   		 'constructor': function( elem, caller ) {
                Scroll.Super.call( this, elem, caller );
            	
            	this.height = 0;

                var that = this;
            	this.root.queue.push(function(){
            		that.height = that.$.attr("data-height") 
            			? that.$.attr("data-height")
            			: that.$.css('height');
                	
                	that.$.slimScroll({
                    	size    : '7px',
                        color   : '#a1b2bd',
                        position: 'right',
                        height  :  that.height,
                     });
            	});
            },
	   	})
	;

    JsB.object( 'App.Scroll', Scroll );

})(JsB);