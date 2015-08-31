(function ( JsB ) {

    var
        Field = my.Class( JsB, {
            'constructor': function( elem, caller ) {
                Field.Super.call( this, elem, caller );

                this.maxlength = this.$.attr('maxlength');

                if ( this.maxlength != undefined ) {
                    this.$.maxlength({
                        limitReachedClass: "label label-danger",
                        alwaysShow: true
                    });
                }
            }
            , 'enable': function() {
                this.$.prop('disabled', false);
            }
            , 'disable': function() {
                this.$.prop('disabled', true);
            }
        })
        , Input = my.Class( Field, {
            'constructor': function( elem, caller ) {
                Input.Super.call( this, elem, caller );

                this.placeholder = this.$.attr('placeholder');
            }
            , 'value': function ( value ) {
                if ( value )
                    this.$.val( value );

                return this.$.val();
            }
            , 'reset': function() {
                this.$.val('');
            }
        })
        , Password = my.Class( Input, {
            'constructor': function( elem, caller ) {
                Password.Super.call( this, elem, caller );
            }
        })
        , CheckBox = my.Class( Input, {
            'constructor': function( elem, caller ) {
                CheckBox.Super.call( this, elem, caller );

                // Save the initial status.
                this.enabled = ( this.value() != undefined );
                this.$.uniform();
            }
            , 'reset': function() {
                this.$.attr("checked", this.enabled);
            }
            , 'value': function() {
                return this.$.attr('checked');
            }
        })
        , Radio = my.Class( Input, {
            'constructor': function( elem, caller ) {
                Radio.Super.call( this, elem, caller );
                this.$.uniform();
            }
        })
        , Spinner = my.Class( Input, {
            'constructor': function( elem, caller ) {
                Spinner.Super.call( this, elem, caller );

                this.$.spinner( { value:0, min: 0, max: 200 } );
            }
            , 'reset': function() {
                this.$.val(0);
            }
        })
        , Tag = my.Class( Input, {
            'constructor': function( elem, caller ) {
                Tag.Super.call( this, elem, caller );

                this.$.tagsInput({
                    width       : 'auto',
                    defaultText : this.$.attr('data-text'),
                });
            }
            , 'reset': function() {
                this.$.importTags('');
            }
        })
        , Upload = my.Class( Input, {
            'constructor': function( elem, caller ) {
                Upload.Super.call( this, elem, caller );

                var that = this;
                this.$.fileupload({
                    url            : '/media/upload.json',
                    dataType       : 'json',
                    formData       : { 'element' : this.$.attr('id') },
                    start: function( e ) {
                        that.parent.$progress.show();
                        that.parent.$error.value( null );
                    },
                    always: function( e, data ) {
                        that.parent.$progress.hide();
                        that.parent.$progress.$bar.$.css({'width': '0%'});
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        that.parent.$progress.$bar.$.css({'width': progress + '%' });
                    },
                    done: function (e, data) {
                        if( data.result.result == 1 ) {
                            that.parent.$files.update({
                                '$filename' : data.result.filename,
                                '$open' : {'href' : data.result.url }
                            });
                        }
                        else
                            that.parent.$error.value( data.result.error );
                    }
                 });
            }
        })
        , Textarea = my.Class( Field, {
            'constructor': function( elem, caller ) {
                Textarea.Super.call( this, elem, caller );
            }
        })
        , Select = my.Class( Field, {
            'constructor': function( elem, caller ) {
                Select.Super.call( this, elem, caller );

                this.bind('change');
            }
            , 'change': function() {
                return false;
            }
            , 'value': function( value ) {
                return ( value )
                    ? this.$.val( value )
                    : this.$.val();
            }
            , 'reset': function() {
                this.$.val('');
            }
            , 'text': function() {
                return $("option:selected", this.$).text();
            }
            , 'addOption': function( option ) {
                if ( this.$.find('option[value="'+option.value+'"]').length > 0 ) {
                    this.$.find('option[value="'+option.value+'"]').prop('selected',true);
                    return;
                }

                this.$.append( $('<option></option>').attr('value',option.value).text(option.text).prop('selected', true) );
            }
        })
        , Select2 = my.Class( Field, {
            'constructor': function( elem, caller ) {
                Select2.Super.call( this, elem, caller );

                var that = this;
                this.$.select2({
                    'placeholder'    : that.$.attr('placeholder'),
                    'allowClear'     : true,
                    'multiple'       : that.isMultiple,
                    'formatResult'   : that.format,
                    'formatSelection': that.format
                });
            }
            , format: function(state) {}
        })
        , DateTime = my.Class( Input, {
            'constructor': function( elem, caller ) {
                DateTime.Super.call( this, elem, caller );

                var that = this;
                this.root.queue.push(function() {
                    that.$.find(">:first-child").datetimepicker({
                        autoclose     : true,
                        todayBtn      : true,
                        minuteStep    : 10,
                        weekStart     : 1,
                        todayHighlight: true,
                        language      : '' + JsB.APP_LANGUAGE + ''
                    });
                });
            }
        })
        , DateRange = my.Class( Input, {
            'constructor': function( elem, caller ) {
                DateRange.Super.call( this, elem, caller );

                this.format    = this.$.attr('data-date-format');
                this.separator = this.$.attr('data-separator') || '/';

                var that = this;
                this.root.queue.push(function() {
                    that.elem().daterangepicker({
                        format   : that.format,
                        separator: ' ' + that.separator + ' ',
                        locale: {
                            applyLabel      : 'Aplicar',
                            fromLabel       : 'De',
                            toLabel         : 'Até',
                            cancelLabel     : 'Limpar',
                            customRangeLabel: 'Custom Range',
                            daysOfWeek      : ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                            monthNames      : ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Otubro', 'Novembro', 'Dezembro'],
                            firstDay        : 1
                        } 
                    },
                    function(start, end) {
                        that.start(start,end);
                    });
                });
            }
            , 'elem' : function() {
                console.log("1");
                return this.$.find('>:first-child');
            }
            , 'start': function(start, end) {
                console.log("2");
                this.$field.$.val(start.format( this.format ) + ' ' + this.separator + ' ' + end.format( this.format ));
            }
        })
    ;

    JsB.object( 'Input'    , Input     );
    JsB.object( 'Password' , Password  );
    JsB.object( 'CheckBox' , CheckBox  );
    JsB.object( 'Radio'    , Radio     );
    JsB.object( 'Select'   , Select    );
    JsB.object( 'Select2'  , Select2   );
    JsB.object( 'Textarea' , Textarea  );
    JsB.object( 'Spinner'  , Spinner   );
    JsB.object( 'DateTime' , DateTime  );
    JsB.object( 'DateRange', DateRange );
    JsB.object( 'Tag'      , Tag       );
    JsB.object( 'Upload'   , Upload    );

})( JsB );
