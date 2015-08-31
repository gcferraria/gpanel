(function(window) {

	var
		App = my.Class( window.JsB ,{
			constructor : function( elem, caller ) {
				App.Super.call(this, elem, caller);
                
                this.isRTL = this.isIE8 = this.isIE9 = this.isIE10 = false;
                this._init(elem)
			}
			, _init: function(elem) {
                if ($('body').css('direction') === 'rtl')
                    this.isRTL = true;
                                        
                this.isIE8  = !!navigator.userAgent.match(/MSIE 8.0/);
                this.isIE9  = !!navigator.userAgent.match(/MSIE 9.0/);
                this.isIE10 = !!navigator.userAgent.match(/MSIE 10.0/); 
                
                if (this.isIE10)
                    $('html').addClass('ie10'); // detect IE10 version

                if (this.isIE10 || this.isIE9 || this.isIE8)
                    $('html').addClass('ie'); // detect IE10 version
            }
            , blockUI: function(el, centerY) {
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
 			, unblockUI: function(el) {
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
