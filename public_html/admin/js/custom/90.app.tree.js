(function( JsB ) {

    var
        Tree = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Tree.Super.call( this, elem, caller );

                var that = this;
                this.root.queue.push( function() {
                    that.$.jstree({
                        'core' : {
                            'themes' : {
                                'responsive': true
                            },
                            'check_callback' : true,
                            'data' : {
                                url : function (node) {
                                    var id = ( node.id != '#' ) ? node.id : 1;
                                    return '/categories/index/' + id + '.json';
                                },
                                data : function (node) {
                                    return { 'selected' : that.$.attr('data-jsb-category') };
                                }
                            },
                        },
                        'types' : {
                            'default' : {
                                'icon' : 'fa fa-folder icon-state-warning icon-lg'
                            },
                        },
                        'plugins': ['types']
                    })
                    .on('loaded.jstree', function ( event, data ) {})
                    .delegate( 'a', 'click', function( event ) {
                        window.location = event.currentTarget.href;
                    });
                });
            }, 
            reload: function( node ) {
                this.$.jstree( 'refresh', node );
            }
        })
    ;

    JsB.object( 'App.Tree', Tree );

})( JsB );
