(function ( JsB ) {

    var
        Field = my.Class( JsB, {
            constructor: function( elem, caller ) {
                Field.Super.call( this, elem, caller );

                this.maxlength = this.$.attr('maxlength');

                if ( this.maxlength != undefined ) {
                    this.$.maxlength({
                        limitReachedClass: "label label-danger",
                        alwaysShow: true
                    });
                }

                var that = this;
                this.root.queue.push(function(){
                    // Search for dependent fields and hide/show dependents
                    $('[data-parent=' + that.parent.name + ']').each(function(){
                        if( !$(this).attr('data-parent-values').includes( that.$.val() ) )
                            $(this).addClass('hidden');
                        else 
                            $(this).removeClass('hidden');
                    });
                });
            }
            , change: function(ev) {
                var that = this;

                // Search for dependent fields and hide/show dependents
                $('[data-parent=' + this.parent.name + ']').each(function(){
                    if( !$(this).attr('data-parent-values').includes( that.$.val() ) )
                        $(this).addClass('hidden');
                    else 
                        $(this).removeClass('hidden');
                });

                return false;
            }
            , enable: function() {
                this.$.prop('disabled', false);
            }
            , disable: function() {
                this.$.prop('disabled', true);
            }
        })
        , Input = my.Class( Field, {
            constructor: function( elem, caller ) {
                Input.Super.call( this, elem, caller );

                this.placeholder = this.$.attr('placeholder');
            }
            , value: function ( value ) {
                if ( value )
                    this.$.val( value );

                return this.$.val();
            }
            , reset: function() {
                this.$.val('');
            }
        })
        , Email = my.Class( Input, {
            constructor: function( elem, caller ) {
                Email.Super.call( this, elem, caller );
            }
        })
        , Password = my.Class( Input, {
            constructor: function( elem, caller ) {
                Password.Super.call( this, elem, caller );

                var that = this;
                that.initialized = false;
                this.root.queue.push(function(){
                    that.$.keydown(function () {
                        if (that.initialized === false) {
                            that.$.pwstrength({
                                ui: { showVerdictsInsideProgressBar: false, showVerdicts: false }
                            });

                            that.$.pwstrength("addRule", "myRule", function (options, word, score) {
                                return word.match(/[a-z].[0-9]/) && score;
                            }, 10, true);

                            // set as initialized 
                            that.initialized = true;
                        }
                    });    
                });
            }
        })
        , CheckBox = my.Class( Input, {
            constructor: function( elem, caller ) {
                CheckBox.Super.call( this, elem, caller );

                // Save the initial status.
                this.enabled = ( this.value() != undefined );
            }
            , reset: function() {
                this.$.attr("checked", this.enabled);
            }
            , value: function() {
                return this.$.attr('checked');
            }
        })
        , Spinner = my.Class( Input, {
            constructor: function( elem, caller ) {
                Spinner.Super.call( this, elem, caller );

                var that = this;
                this.root.queue.push(function(){
                    that.$.TouchSpin( { initval:0, min: 0, max: 200 } );    
                });
            }
            , reset: function() {
                this.$.val(0);
            }
        })
        , Tag = my.Class( Input, {
            constructor: function( elem, caller ) {
                Tag.Super.call( this, elem, caller );

                this.$.tagsinput({
                    trimValue: true
                });
            }
        })
        , Upload = my.Class( Input, {
            constructor: function( elem, caller ) {
                Upload.Super.call( this, elem, caller );

                var that = this;
                this.$.fileupload({
                    url            : '/media/upload.json',
                    dataType       : 'json',
                    acceptFileTypes: /(\.|\/)(gif|jpe?g|png|mp4|pdf)$/i,
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
                        else {
                            that.parent.$error.value( data.result.error );
                        }
                    }
                });
            }
        })
        , Textarea = my.Class( Field, {
            constructor: function( elem, caller ) {
                Textarea.Super.call( this, elem, caller );
            }
        })
        , Select = my.Class( Field, {
            constructor: function( elem, caller ) {
                Select.Super.call( this, elem, caller );

                this.bind('change');
            }
            , value: function( value ) {
                return ( value )
                    ? this.$.val( value )
                    : this.$.val();
            }
            , reset: function() {
                this.$.val('');
            }
            , text: function() {
                return $("option:selected", this.$).text();
            }
            , addOption: function( option ) {
                if ( this.$.find('option[value="'+option.value+'"]').length > 0 ) {
                    this.$.find('option[value="'+option.value+'"]').prop('selected',true);
                    return;
                }

                this.$.append( $('<option></option>').attr('value',option.value).text(option.text).prop('selected', true) );
            }
        })
        , Select2Base = my.Class( Field, {
            constructor: function( elem, caller ) {
                Select2Base.Super.call( this, elem, caller );

                var that = this;
                this.root.queue.push(function(){
                    that.$.select2({
                        'placeholder'    : that.$.attr('placeholder'),
                        'allowClear'     : true,
                        'multiple'       : that.isMultiple,
                        'formatResult'   : that.format,
                        'formatSelection': that.format,
                        'width'          : null,
                        'theme'          : "bootstrap",
                    }).on('change', function (ev) {
                        that.change(ev);
                    });
                });
            }
            , format: function(state) {
                return;
            }
            , reset: function() {
                this.$.select2("val","");
            }
        })
        , Select2 = my.Class( Select2Base, {
            constructor: function( elem, caller ) {
                Select2.Super.call( this, elem, caller );
            }
            , format: function(state) {
                return state.text;
            }
        })
        , Country = my.Class( Select2Base, {
            constructor: function( elem, caller ) {
                JsB.FLAGS_PATH = jQuery(elem).attr('data-flags-path');
                Country.Super.call( this, elem, caller );
            }
            , format: function(state) {
                if ( !state.id )
                    return state.text;

                return "<img class='flag' src='" + JsB.FLAGS_PATH + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
            }
        })
        , DateTime = my.Class( Input, {
            constructor: function( elem, caller ) {
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
            constructor: function( elem, caller ) {
                DateRange.Super.call( this, elem, caller );

                this.format    = this.$.attr('data-date-format') || 'YYYY-MM-DD';
                this.startDate = this.$.attr('data-start-date')  || new Date(new Date().getFullYear(), 0, 1);
                this.endDate   = this.$.attr('data-end-date')    || new Date();

                var that = this;
                this.root.queue.push(function() {
                    that.$.daterangepicker({
                        startDate: that.startDate,
                        endDate  : that.endDate,
                        maxDate  : that.endDate,
                        showDropdowns: true,
                        timePicker: false,
                        timePickerIncrement: 1,
                        buttonClasses: ['btn green-haze'],
                        cancelClass: 'default',
                        separator: '  ',
                        locale: {
                            applyLabel: 'Aplicar',
                            format    : that.format,
                            fromLabel : 'De',
                            toLabel   : 'Até',
                            daysOfWeek: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                            firstDay  : 1
                        }
                    },
                    function (start, end) {
                        $('#dashboard-report-range span').html( start.format( that.format ) + ' / ' + end.format( that.format ));
                        
                        var widgets = caller.toArray();
                        while ( widget = widgets.shift() ) {
                            if ( (widget.$reload !== undefined ) ) { 
                                widget.$reload.click();
                            }
                        }
                        caller.$visits.$body.$chart.reload();
                        caller.$statistics.reload();
                    });

                    $('#dashboard-report-range span').html( that.formatDate( that.startDate )  + ' / ' + that.formatDate( that.endDate) );
                    $('#dashboard-report-range').show(); 
                });
            }
            , formatDate : function(date) {
                var d     = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day   = '' + d.getDate(),
                    year  = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [year, month, day].join('-');
            }
            , value: function() {
                return this.$.find('span').text();
            }  
        })
        , DateRangeInput = my.Class(Input, {
            constructor: function( elem, caller ) {
                DateRangeInput.Super.call( this, elem, caller );
            
                this.format    = this.$.attr("data-date-format");
                this.separator = this.$.attr("data-separator") || "/";
                
                var that = this;
                this.root.queue.push(function() {
                    that.$.find(">:first-child").daterangepicker({
                        format: that.format,
                        separator: " " + that.separator + " ",
                        locale: {
                            applyLabel: 'Aplicar',
                            format    : that.format,
                            fromLabel : 'De',
                            toLabel   : 'Até',
                            daysOfWeek: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                            firstDay  : 1
                        }
                    }, function(s, r) {
                        that.$field.$.val(s.format(that.format) + " " + that.separator + " " + r.format(that.format))
                    });
                });
            }
        })
        , IconPicker = my.Class(Input, {
            constructor: function( elem, caller ) {
                IconPicker.Super.call( this, elem, caller );
            
                var that = this;
                this.root.queue.push(function() {
                    that.$.iconpicker({
                        hideOnSelect: true
                    });
                });
            }
        })
        , Username = my.Class(JsB, {
            constructor: function( elem, caller ) {
                Username.Super.call( this, elem, caller );
                this.bind('click');
            }
            , click: function( ev, args ) {
                var that = this;
                $.post( that.$.attr('data-url'), { username: that.parent.$field.value() }, function (res) {
                    // TODO
                }, 'json');

                return false;
            }
        })
    ;

    JsB.object( 'Input'         , Input          );
    JsB.object( 'Password'      , Password       );
    JsB.object( 'CheckBox'      , CheckBox       );
    JsB.object( 'Select'        , Select         );
    JsB.object( 'Select2'       , Select2        );
    JsB.object( 'Textarea'      , Textarea       );
    JsB.object( 'Spinner'       , Spinner        );
    JsB.object( 'DateTime'      , DateTime       );
    JsB.object( 'DateRange'     , DateRange      );
    JsB.object( 'DateRangeInput', DateRangeInput );
    JsB.object( 'Tag'           , Tag            );
    JsB.object( 'Upload'        , Upload         );
    JsB.object( 'Country'       , Country        );
    JsB.object( 'IconPicker'    , IconPicker     );
    JsB.object( 'Email'         , Email          );
    JsB.object( 'Username'      , Username       );

})( JsB );
