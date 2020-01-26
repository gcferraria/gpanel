(function(window) {

	var
		App = my.Class( window.JsB ,{
			constructor : function( elem, caller ) {
				App.Super.call(this, elem, caller);
                
                this.isRTL = this.isIE8 = this.isIE9 = this.isIE10 = false;
                this._init(elem);
            }, 
            _init: function(elem) {
                if ($('body').css('direction') === 'rtl')
                    this.isRTL = true;
                                        
                this.isIE8  = !!navigator.userAgent.match(/MSIE 8.0/);
                this.isIE9  = !!navigator.userAgent.match(/MSIE 9.0/);
                this.isIE10 = !!navigator.userAgent.match(/MSIE 10.0/); 
                
                if (this.isIE10)
                    $('html').addClass('ie10'); // detect IE10 version

                if (this.isIE10 || this.isIE9 || this.isIE8)
                    $('html').addClass('ie'); // detect IE10 version
            }, 
            blockUI: function(el, options) {
            	options = $.extend(true, {}, options);

                var html = '';
                if (options.animate) {
                    html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>' + '</div>';
                } else if (options.iconOnly) {
                    html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="/img/loading-spinner-grey.gif" align=""></div>';
                } else if (options.textOnly) {
                    html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
                } else {
                    html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="/img/loading-spinner-grey.gif" align=""><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
                }

                if (el.$.height() <= ($(window).height())) {
                    options.centerY = true;
                }

                el.$.block({
                    message: html,
                    baseZ: options.zIndex ? options.zIndex : 1000,
                    centerY: options.centerY !== undefined ? options.centerY : false,
                    css: {
                        top: '10%',
                        border: '0',
                        padding: '0',
                        backgroundColor: 'none'
                    },
                    overlayCSS: {
                        backgroundColor: options.overlayColor ? options.overlayColor : '#555',
                        opacity: options.boxed ? 0.05 : 0.1,
                        cursor: 'wait'
                    }
                });
            }, 
            unblockUI: function(el) {
            	el.$.unblock({
             		onUnblock: function () {
                        el.$.css('position', '');
                        el.$.css('zoom', '');
                	}
            	});
            }, 
            notification: function( type, message ) {
                switch( type ) {
                    case 'success':
                        toastr.success(message);
                    break;
                    case 'error':
                        toastr.error(message);
                    break;
                }
            }, 
            getResponsiveBreakpoint: function(size) {
                var sizes = {
                    'xs' : 480,
                    'sm' : 768,
                    'md' : 992,
                    'lg' : 1200
                };

                return sizes[size] ? sizes[size] : 0; 
            }, 
            getViewPort: function() {
                var e = window,
                    a = 'inner';
                if (!('innerWidth' in window)) {
                    a = 'client';
                    e = document.documentElement || document.body;
                }

                return {
                    width: e[a + 'Width'],
                    height: e[a + 'Height']
                };
            }, 
            scrollTo: function(el, offeset) {
                var pos = (el && el.length > 0) ? el.offset().top : 0;

                if (el) {
                    if ($('body').hasClass('page-header-fixed')) {
                        pos = pos - $('.page-header').height();
                    } else if ($('body').hasClass('page-header-top-fixed')) {
                        pos = pos - $('.page-header-top').height();
                    } else if ($('body').hasClass('page-header-menu-fixed')) {
                        pos = pos - $('.page-header-menu').height();
                    }
                    pos = pos + (offeset ? offeset : -1 * el.height());
                }

                $('html,body').animate({ scrollTop: pos}, 'slow');
            }
		})
	;

	window.App = App;

})(window);
