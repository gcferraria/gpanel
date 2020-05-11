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
                    data = { 'metric' : this.metric, 'profile': this.profile, 'date': this.root.$dashboard.$daterange.value() };

                $.ajax({
                    'type'      : 'POST',
                    'url'       : this.url,
                    'data'      : data,
                    'dataType'  : 'json',
                    'beforeSend': function() {
                        that.root.blockUI(that.context,{animate:true})
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

                        var previousPoint = null;
                        that.$.bind("plothover", function (event, pos, item) {
                            $("#x").text(pos.x.toFixed(2));
                            $("#y").text(pos.y.toFixed(2));
                            if (item) {
                                if (previousPoint != item.dataIndex) {
                                    previousPoint = item.dataIndex;

                                    $("#tooltip").remove();
                                    var x = item.datapoint[0].toFixed(2),
                                        y = item.datapoint[1].toFixed(2);

                                    that.show_tooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1]);
                                }
                            } else {
                                $("#tooltip").remove();
                                previousPoint = null;
                            }
                        });                        
                    }
                });
            },
            show_tooltip: function (x, y, xValue, yValue) {
                $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y - 40,
                    left: x - 40,
                    border: '0px solid #ccc',
                    padding: '2px 6px',
                    'background-color': '#fff'
                }).appendTo("body").fadeIn(200);
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
        , PieChart = my.Class( JsB, {
	   		constructor: function( elem, caller ) {
                PieChart.Super.call( this, elem, caller );
                
                var that     = this;
                this.url     = this.$.attr('data-url');
                this.metric  = this.$.attr('data-metric');
                this.profile = this.$.attr('data-profile');

                this.root.queue.push(function(){
                    that.reload();
                });
            }
            , reload: function() {
                var that = this,
                    data = { 'metric' : this.metric, 'profile': this.profile, 'date': this.root.$dashboard.$daterange.value() };

                $.ajax({
                    'type'      : 'POST',
                    'url'       : this.url,
                    'data'      : data,
                    'dataType'  : 'json',
                    'beforeSend': function() {
                        that.root.blockUI(that.context,{animate:true})
                    },
                    'error'     : function( XHR, textStatus ) {
                        that.root.unblockUI(that.context)
                    },
                    'complete'  : function() {
                        that.root.unblockUI(that.context)
                    },
                    'success'   : function( data ) {
                        var children = that.toArray();
                        for ( var idx in children ) {
                            var child = children[ idx ];
                            if ( child != undefined ) {
                                child.update(data[idx]['value'], data[idx]['text'] )
                            }
                        }
                    }   
                });
            }
        })
        , PieObject = my.Class( JsB, {
	   		constructor: function( elem, caller ) {
                PieObject.Super.call( this, elem, caller );
 
                var that = this;
                this.root.queue.push(function(){
                    that.$.easyPieChart({
                        animate  : 1000,
                        size     : 75,
                        lineWidth: 3,
                        barColor : that.$.attr('data-color')
                    });
                });
            }
            , update: function( value, text ) {
                this.$.data('easyPieChart').update(value);
                $('span', this.$).text(value);
                this.$.parent().find('a.title').text(text);
            }
        })
	;

    JsB.object( 'App.Chart'           , Chart    );
    JsB.object( 'App.Chart.Metric'    , Metric   );
    JsB.object( 'App.Chart.Profile'   , Profile  );
    JsB.object( 'App.PieChart'        , PieChart );
    JsB.object( 'App.PieChart.Object' , PieObject);

})(JsB);
