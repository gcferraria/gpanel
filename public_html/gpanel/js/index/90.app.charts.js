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
                        hoverable  : true,
                        clickable  : true,
                        tickColor  : "#eee",
                        borderColor: "#eee",
                        borderWidth: 1
                    },
                    xaxis: {
                        tickLength: 0,
                        tickDecimals: 0,
                        mode: "categories",
                        min: 0,
                        font: {
                            lineHeight: 14,
                            style: "normal",
                            variant: "small-caps",
                            color: "#6F7B8A"
                        }
                    },
                    yaxis: {
                        ticks: 5,
                        tickDecimals: 0,
                        tickColor: "#eee",
                        font: {
                            lineHeight: 14,
                            style: "normal",
                            variant: "small-caps",
                            color: "#6F7B8A"
                       }
                    }, 
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
                        that.root.blockUI(that.context)
                    },
                    'error'     : function( XHR, textStatus ) {
                        that.root.unblockUI(that.context)
                    },
                    'complete'  : function() {
                        that.root.unblockUI(that.context)
                    },
                    'success'   : function( data ) {
                        $.plot(that.$, [{
                            data: data,
                            lines: {
                                fill: 0.6,
                                lineWidth: 0
                            },
                            color: ['#f89f9f']
                        }, {
                            data: data,
                            points: {
                                show: true,
                                fill: true,
                                radius: 5,
                                fillColor: "#f89f9f",
                                lineWidth: 3
                            },
                            color: '#fff',
                            shadowSize: 0
                        }], that.options); 
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
                this.context.$body.$chart.metric = this.$.find('input').val();
                this.context.$body.$chart.reload();
            }
        })
        , Profile = my.Class( JsB, {
             'constructor': function( elem, caller ) {
                Profile.Super.call( this, elem, caller );

                this.bind('click')
            }
            , 'click': function() {
                this.context.$body.$chart.profile = this.name;
                this.context.$body.$chart.reload();
            }
        })
	;

    JsB.object( 'App.Chart'        , Chart   );
    JsB.object( 'App.Chart.Metric' , Metric  );
    JsB.object( 'App.Chart.Profile', Profile );

})(JsB);
