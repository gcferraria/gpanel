(function(window) {

	var
		App = my.Class( window.JsB ,{
			'constructor' : function( elem, caller ) {
				App.Super.call(this, elem, caller);
			}
			, 'blockUI': function(el, centerY) {
            	el.$.block({
                    message: '<img src="/images/ajax-loader-big.gif" align="">',
                    centerY: centerY != undefined ? centerY : true,
                    css: {
                        top: '10%',
                        border: 'none',
                        padding: '2px',
                        backgroundColor: 'none'
                    },
                    overlayCSS: {
                        backgroundColor: '#000',
                        opacity: 0.1,
                        cursor: 'wait'
                    }
               });
         	}
 			, 'unblockUI': function(el) {
            	el.$.unblock({
             		onUnblock: function () {
                 		el.$.removeAttr("style");
                	}
            	});
        	}
            , notification: function( type, message ) {
                switch( type ) {
                    case 'success':
                        toastr.success(message);
                    break;
                    case 'error':
                        toastr.error(message);
                    break;
                }
            }
		})
	;

	window.App = App;

})(window);