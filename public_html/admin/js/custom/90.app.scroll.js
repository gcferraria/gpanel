(function(JsB) {
	
	var
	   	Scroll = my.Class( JsB, {
	   		constructor: function( elem, caller ) {
                Scroll.Super.call( this, elem, caller );
            	
				this.height = 0;
				this.alwaysVisible = false;

                var that = this;
            	this.root.queue.push(function(){
            		that.height = that.$.attr("data-height") ? that.$.attr("data-height") : that.$.css('height');

					that.alwaysVisible = that.$.attr("data-always-visible") ? true : false;

                	that.$.slimScroll({
                    	size         : '7px',
                        color        : '#a1b2bd',
						position     : 'right',
						railVisible  : true, 
						height       : that.height,
						alwaysVisible: that.alwaysVisible
                     });
            	});
			},
			scrollTo: function( position ) {
				this.$.slimScroll({ 'scrollTo': position + 'px' });
			}
	   	})
	;

    JsB.object( 'App.Scroll', Scroll );

})(JsB);