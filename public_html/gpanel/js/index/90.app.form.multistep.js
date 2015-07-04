(function ( JsB ) {

    var
        Form = my.Class( JsB.object('App.Form.Ajax'), {
             'constructor': function ( elem, caller ) {
                Form.Super.call( this, elem, caller );

                this.async  = false;
                this.length = 0;

                var that = this;
                this.root.queue.push(function(){
                    that.$.bootstrapWizard({
                        nextSelector    : '.button-next',
                        previousSelector: '.button-previous',
                        onTabClick      : function (tab, navigation, index, clickedIndex) {
                            return false;
                        },
                        onPrevious: function( tab, navigation, index ) {
                            that.handle(tab, navigation, index);
                            that.previous(tab, navigation, index );
                        },
                        onNext: function (tab, navigation, index) {
                            if( that.next( tab, navigation, index ) )
                                that.handle(tab, navigation, index);
                            else
                                return false;
                        },
                        onTabShow: function(tab, navigation, index) {
                            that.length = navigation.find('li').length;
                            var $current = index+1;
                            var $percent = ($current/that.length) * 100;
                            $('.progress-bar').css({width:$percent+'%'});
                        }
                    });
                });
            }
            , 'handle': function( tab, navigation, index ) {
                var total   = navigation.find('li').length;
                var current = index + 1;

                if (current > 1)
                    this.$previous.show();
                else
                    this.$previous.hide();

                if (current >= total) {
                    this.$next.hide();
                    this.$button.show();
                } else {
                    this.$next.show();
                    this.$button.hide();
                }
            }
            , 'next': function( tab, navigation, index ) {
                this.hasErrors = false;
                this.submit(null, { 'name': 'step', 'value': index });
                return ( this.hasErrors == false );
            }
            , '_onSuccess': function( data ) {
                if ( data.show_errors !== undefined ) this.hasErrors = true;
                else this.clean_errors();

                this.update( data );
            }
            , 'previous': function( tab, navigation, index ) {
                this.clean_errors();
            }
        })
        , Navigation = my.Class( JsB, {
            'constructor': function ( elem, caller ) {
                Navigation.Super.call( this, elem, caller );
            }
            , 'hide': function() {
                this.$.addClass('hide');
            }
            , 'show': function() {
                this.$.removeClass('hide');
            }
        })
        , Submit = my.Class( JsB.object('App.Form.Ajax.Submit'), {
            'constructor': function ( elem, caller ) {
                Submit.Super.call( this, elem, caller );
            }
            , 'hide': function() {
                this.$.addClass('hide');
            }
            , 'show': function() {
                this.$.removeClass('hide');
            }
            , 'click': function( ev, args ) {
                this.context.submit( ev, { 'name': 'step', 'value': this.context.length });
                return false;
            }
        })
    ;

    JsB.object( 'App.Form.Multistep'           , Form       );
    JsB.object( 'App.Form.Multistep.Navigation', Navigation );
    JsB.object( 'App.Form.Multistep.Submit'    , Submit     );

})( JsB );
