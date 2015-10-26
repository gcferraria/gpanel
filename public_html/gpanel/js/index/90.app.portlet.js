(function ( JsB ) {

    var
        Portlet = my.Class( JsB, {
            'constructor': function ( elem, caller ) {
                Portlet.Super.call( this, elem, caller );
            }
        })
        , Collapse = my.Class( JsB, {
            'constructor': function ( elem, caller ) {
                Collapse.Super.call( this, elem, caller );

                this.bind('click');
                this.$.tooltip({container: 'body',title: this.$.attr('title')});
            }
            , 'click': function(ev) {
                ev.preventDefault();
                this.selected() ? this.deselect() : this.select();
                return false;
            }
            , 'select': function() {
                Collapse.Super.prototype.select.call( this );
                this.$.removeClass("collapse").addClass("expand");
                this.context.$body.$.slideUp(200);
            }
            , 'deselect': function() {
                Collapse.Super.prototype.deselect.call( this );
                this.$.removeClass("expand").addClass("collapse");
                this.context.$body.$.slideDown(200);
            }
        })
        , Reload = my.Class( JsB, {
            'constructor': function ( elem, caller ) {
                Reload.Super.call( this, elem, caller );

                this.bind('click');
                this.$.tooltip({container: 'body',title: this.$.attr('title')});
            }
            , 'click': function(ev) {
                ev.preventDefault();
                if( this.context.$body['$table'] !== undefined )
                    this.context.$body.$table.reload();
                else if( this.context.$body['$chart'] !== undefined )
                    this.context.$body.$chart.reload();
                else
                    this.context.$body.reload();
                return false;
            }
        })
        , Remove = my.Class( JsB, {
            'constructor': function ( elem, caller ) {
                Remove.Super.call( this, elem, caller );

                this.bind('click');
                this.$.tooltip({container: 'body',title: this.$.attr('title')});
            }
            , 'click': function(ev) {
                ev.preventDefault();
                this.root.dettach( this.context );
                return false;
            }
        })
    ;

    JsB.object( 'App.Portlet'         , Portlet  );
    JsB.object( 'App.Portlet.Collapse', Collapse );
    JsB.object( 'App.Portlet.Reload'  , Reload   );
    JsB.object( 'App.Portlet.Remove'  , Remove   );

})( JsB );
