(function( JsB ) {

    var
        DataTable = my.Class( JsB, {
            constructor: function( elem, caller ) {
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
                        "bStateSave"    : true, // save datatable state(pagination, sort, etc) in cookie.
                        "iDisplayLength": 10,
                        "oLanguage"     : { "sUrl": "/datatables.json" },
                        "aoColumnDefs" : [{  // define columns sorting options(by default all columns are sortable extept the first checkbox column)
                            'bSortable' : false,
                            'aTargets'  : sorting
                        }],
                        fnDrawCallback: function( oSettings ) {
                            caller.$.find('.dataTables_filter input').addClass("form-control input-small input-inline");
                            caller.$.find('.dataTables_length select').addClass("form-control input-xsmall");
                        },
                        fnRowCallback: function( nRow, aData, iDisplayIndex ) {
                            var id = $( nRow ).attr('id');
                            if( that['$' + id ] !== undefined )
                                that.dettach( that['$' + id ] )

                            that.attach( nRow );
                        }
                    });

                    that.table.find('.group-checkable').change(function () {
                        var set = $('tbody > tr > td:nth-child(1) input[type="checkbox"]', this.$ );
                        var checked = jQuery(this).is(":checked");
                        jQuery(set).each(function () {
                            if (checked) {
                                $(this).prop("checked", true);
                            } else {
                                $(this).prop("checked", false);
                            }
                        });
                        jQuery.uniform.update(set);
                    });
                });
            }
            , reload: function() {
                var elem = this.parent;
                app.blockUI(elem,{animate:true});

                this.table._fnAjaxUpdate({'sEcho': this.table.sEcho});
                
                // If CheckBox for SelectAll records exists, remove the checked value.
                var selectAll = $('thead > tr > th:nth-child(1) input[type="checkbox"]');
                if ( selectAll !== undefined ) {
                    $(selectAll).prop("checked", false);
                    jQuery.uniform.update(selectAll);
                }

                window.setTimeout(function () {
                    app.unblockUI(elem);
                }, 1000);
            }
            , get_columns_number: function() {
                return this.$.find('thead>tr:first th').size() - 1;
            }
            , delete_row: function( url ) {
                var that = this,
                    elem = this.context.parent;

                $.ajax({
                    'type'      : 'GET',
                    'url'       : url,
                    'dataType'  : 'json',
                    'beforeSend': function() { app.blockUI(elem, {animate:true}); },
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
                    rows.push({name: $(this).attr("name"), value: $(this).attr("id"), url: $(this).attr("data-url") });
                });

                return rows;
            }
        })

        , Delete = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Delete.Super.call( this, elem, caller );
                this.bind('click');
            },
            click: function() {
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