(function(JsB) {

	var
	   	Chart = my.Class( JsB, {
	   		constructor: function( elem, caller ) {
                Chart.Super.call( this, elem, caller );

                this.url     = this.$.attr('data-url');
                this.metric  = this.$.attr('data-metric');
                this.profile = this.$.attr('data-profile');
                this.options = {
                    grid: {
                        hoverable: true,
                        tickColor: "#eee",
                        borderColor: "#eee",
                        borderWidth: 1
                    }
                };

                var that = this;
                this.root.queue.push(function(){
                    that.reload();
                });
            }
            , reload: function( options ) {
                var that = this,
                    data = { 'metric' : this.metric, 'profile': this.profile };

                $.ajax({
                    'type'      : 'POST',
                    'url'       : this.url,
                    'data'      : data,
                    'dataType'  : 'json',
                    'beforeSend': function() {
                        that.root.blockUI(that.caller)
                    },
                    'error'     : function( XHR, textStatus ) {
                        that.root.unblockUI(that.caller)
                    },
                    'complete'  : function() {
                        that.root.unblockUI(that.caller)
                    },
                    'success'   : function( data ) {
                        $.plot(that.$, data, that.options);
                    }
                });
            }
	   	})
        , Metric = my.Class( JsB, {
             'constructor': function( elem, caller ) {
                Metric.Super.call( this, elem, caller );

                this.bind('click')
            }
            , 'click': function() {
                this.parent.parent.$chart.metric = this.$.find('input').val();
                this.parent.parent.$chart.reload();
            }
        })
        , Profile = my.Class( JsB, {
             'constructor': function( elem, caller ) {
                Profile.Super.call( this, elem, caller );

                this.bind('click')
            }
            , 'click': function() {
                this.parent.$chart.profile = this.name;
                this.parent.$chart.reload();
            }
        })
	;

    JsB.object( 'App.Chart'        , Chart   );
    JsB.object( 'App.Chart.Metric' , Metric  );
    JsB.object( 'App.Chart.Profile', Profile );

})(JsB);
