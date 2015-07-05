(function( JsB ) {

    var
        DataTable = my.Class( JsB, {
            'constructor': function( elem, caller ) {
                DataTable.Super.call( this, elem, caller );

                this.table  = null;
                this.source = this.$.attr('data-source') || null;

                var that = this;
                this.root.queue.push(function(){
                    sorting = [];
                    if( that['$selectAll'] !== undefined )
                        sorting.push(0);
                    if( that['$actions'] !== undefined )
                        sorting.push(that.get_columns_number());

                    that.table = that.$.dataTable({
                        "aaSorting"     : [],
                        "sServerMethod" : "POST",
                        "sAjaxSource"   : that.source,
                        "bProcessing"   : true,
                        "bServerSide"   : true,
                        'bAutoWidth'    : false,
                        'bDeferRender'  : true,
                        "iDisplayLength": 10,
                        "oLanguage"     : {
                            "sUrl": "/datatables.json"
                        },
                        "aoColumnDefs" : [{  // define columns sorting options(by default all columns are sortable extept the first checkbox column)
                            'bSortable' : false,
                            'aTargets'  : sorting
                        }],
                        fnDrawCallback: function( oSettings ) {
                            caller.$.find('.dataTables_filter input').addClass("form-control input-medium input-inline");
                            caller.$.find('.dataTables_length select').addClass("form-control input-xsmall");
                        },
                        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                            var id = $( nRow ).attr('id');
                            if( that['$' + id ] !== undefined )
                                that.dettach( that['$' + id ] )

                            that.attach( nRow );
                        }
                    });
                });
            }
            , 'reload': function() {
                var elem = this.parent;
                app.blockUI(elem);
                this.table._fnAjaxUpdate({'sEcho': this.table.sEcho});
                window.setTimeout(function () {
                    app.unblockUI(elem);
                }, 1000);
            }
            , 'get_columns_number': function() {
                return this.$.find('thead>tr:first th').size() - 1;
            }
            , 'delete_row': function( url ) {
                var that = this,
                    elem = this.context.parent;

                $.ajax({
                    'type'      : 'GET',
                    'url'       : url,
                    'dataType'  : 'json',
                    'beforeSend': function() { app.blockUI(elem); },
                    'error'     : function( XHR, textStatus ) {},
                    'complete'  : function() { app.unblockUI(elem); },
                    'success'   : function( data ) {
                        if ( data.result == 1 )
                            that.table._fnAjaxUpdate();

                        var type =  ( data.result == 1 ) ? 'success' : 'error';
                        app.notification( type, data.message );
                    }
                });
            }
            , getRowsSelected: function() {
                var rows = [];
                $('tbody > tr > td:nth-child(1) input[type="checkbox"]:checked', this.$ ).each(function(){
                    rows.push({name: $(this).attr("name"), value: $(this).val(), url: $(this).attr("data-url") });
                });

                return rows;
            }
        })

        , Delete = my.Class( JsB, {
            'constructor': function( elem, caller ) {
                Delete.Super.call( this, elem, caller );
                this.bind('click');
            },
            'click': function() {
                var that = this;
                bootbox.confirm( this.$.attr('data-text'), function(result) {
                    if( result ) {
                        that.context.delete_row( that.$.attr('data-url') );
                    }
                });
                return false;
            }
        })
    ;
    JsB.object( 'App.DataTable'       , DataTable );
    JsB.object( 'App.DataTable.Delete', Delete    );

})( JsB );