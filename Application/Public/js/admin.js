
( function( $ ) {
    $( document ).on( 'ready', function() {
        'use strict';

        $('.fa-question-circle').popover();
        // Dashboard
        if ( $( '#transactions-chart' ).length > 0 ) {
            var _this = $( "#transactions-chart" );
            var _t_ctx = _this.get( 0 ).getContext( "2d" );

            _this.loading();
            $.ajax( {
                url : _this.data( 'url' ),
                data: { opt: 'transaction' },
                dataType: 'json',
                type: 'POST',
                cache: false,
                success: function( response_data ) {
                    console.log( response_data );
                    for( var i = 0; i < response_data.data.length; i++ ) {
                        response_data.data[i] = parseInt( response_data.data[i] );
                    }
                    var transactions = new Chart( _t_ctx ).Bar( {
                        labels: response_data.labels,
                        datasets: [ {
                            label: "My Second dataset",
                            fillColor: "rgba(151,187,205,0.5)",
                            strokeColor: "rgba(151,187,205,0.8)",
                            highlightFill: "rgba(151,187,205,0.75)",
                            highlightStroke: "rgba(151,187,205,1)",
                            data: response_data.data,
                        } ]
                    } );
                    _this.loaded();
                }
            } );
        }
        if ( $( '#users-chart' ).length > 0 ) {
            var _this = $( '#users-chart' );
            var _u_ctx = _this.get( 0 ).getContext( "2d" );

            _this.loading();
            $.ajax( {
                url : _this.data( 'url' ),
                data: { opt: 'user' },
                dataType: 'json',
                type: 'POST',
                cache: false,
                success: function( response_data ) {
                    for( var i = 0; i < response_data.length; i++ ) {
                        response_data[i].value = parseInt( response_data[i].value );
                    }
                    var users = new Chart( _u_ctx ).Pie( response_data );
                    var users_legend = $( '#users-chart-legend' );
                    users_legend.html( users.generateLegend() );

                    _this.loaded();
                }
            } );
            
        }

        // Users
        if ( $( '#users-table' ).length > 0 ) {
            var beforeDeleteCallback = function() {
            }
            var _this = $( '#users-table' );
            var _pager = $( '#users-grid-pager' );
            _this.jqGrid( {
                colModel: [
                    { label: 'ID', name: 'id', index: 'id', width: 50, key: true, search: false, },
                    { label: 'Email', name: 'email', index: 'email', width: 180 },
                    { label: 'Group', name: 'group', index: 'group', align: 'center', formatter: 'select', editoptions : { value: "0:User;10:Administrator" }, width: 100 },
                    { label: 'Third Party Login', name: 'third_party', index: 'third_party', width: 120 },
                    { label: 'Status', name: 'login_status', index: 'login_status', align: 'center', formatter: 'select', editoptions : { value: "0: Normal; 1:Locked; 2:Deleted; 3:Expire;" }, width: 100 },
                    { label: 'Last IP', name: 'latest_ip', index: 'latest_ip', align: 'center', width: 100 },
                    { label: 'Last Login', name: 'latest_date', index: 'latest_date', align: 'center', width: 150 },

                    { label: 'First Name', name: 'first_name', index: 'first_name', width: 80 },
                    { label: 'Last Name', name: 'last_name', index: 'last_name', width: 80 },
                    { label: 'Gender', name: 'gender', index: 'gender', formatter: 'select', editoptions: { value: "1:Male;2:Female" }, width: 80 },
                    { label: 'Country Code', name: 'country_code', index: 'country_code', width: 100 },
                    { label: 'Mobile', name: 'mobile', index: 'mobile', width: 120 },
                    { label: 'Address', name: 'address', index: 'address', width: 210 },
                    { label: 'Emergency Name', name: 'emergency_name', index: 'emergency_name', width: 80 },
                    { label: 'Emergency Country Code', name: 'emergency_country_code', index: 'emergency_country_code', width: 80 },
                    { label: 'Emergency Mobile', name: 'emergency_mobile', index: 'emergency_mobile', width: 80 },
                    { label: 'Latitude', name: 'lat', index: 'lat', width: 100 },
                    { label: 'Longitude', name: 'lng', index: 'lng', width: 100 },

                    { label: 'Status', name: 'login_status', index: 'login_status', editable: true, formatter: 'select', edittype: 'select', editoptions: { value: "0:Normal; 1:Lock; 2:Deleted; 3:Expire" }, width: 0.1 },
                    { label: 'Password', name: 'password', index: 'password', editable: true, width: 0.1 },
                ],
                url: _this.data( 'url' ),
                datatype: "json",
                jsonReader : {
                    root: 'rows',
                    page: 'page',
                    total: 'total',
                    records: "records",
                    id: "id",
                },
                mtype: 'POST',

                editurl: _this.data( 'editurl' ),
                edit: {
                    closeAfterEdit: true,
                    closeOnEscape: true,
                },

                height: 500,

                pager : _pager,
                rowNum: 20,
                viewrecords: true,

                multiselect: true,
                multiboxonly: true,
                rownumbers: false,

                loadComplete: function () {
                },
            } );
            _this.jqGrid( 'navGrid', '#users-grid-pager', { 
                search: true,
                searchicon: 'fa fa-search fa-lg fa-fw',
                edit: true,
                editicon: 'fa fa-pencil fa-lg fa-fw',
                add: false, 
                del: false,
                // delicon: 'fa fa-times fa-lg fa-fw',
                refresh: true,
                refreshicon: 'fa fa-refresh fa-lg fa-fw',
                view: true,
                viewicon: 'fa fa-search-plus fa-lg fa-fw',
            }, {}, {}, {}, {
                multipleSearch: true,
                showQuery: true,
            } ).jqGrid( 'navButtonAdd', '#users-grid-pager', {
                buttonicon: 'fa fa-columns fa-lg fa-fw',
                caption: '',
                onClickButton: function() {
                    _this.setColumns( {
                        width: 400,
                    } );
                    return false;
                }
            } ).jqGrid( 'navSeparatorAdd', '#users-grid-pager', {
            } ).jqGrid( 'navButtonAdd', '#users-grid-pager', {
                buttonicon: 'fa fa-envelope-o fa-lg fa-fw',
                caption: '',
                onClickButton: function() {
                    var selected_rows = _this.jqGrid( 'getGridParam', 'selarrrow' );
                    if ( selected_rows.length <= 0 ) {
                        return;
                    }

                    var _msg_dialog = $( '<div title="Message"><form method="post" action="' + _this.data( 'letterurl' ) + '"><div class="form-group"><input type="text" name="title" class="text" placeholder="Title" /></div><div class="form-group"><textarea class="textarea" name="letter" rows="5" placeholder="Message" /></div></form></div>' );
                    _msg_dialog.dialog( {
                        position: { my: "center", at: "center", of: ".ui-jqgrid" },
                        appendTo: '.ui-jqgrid',
                        resizable: false,
                        modal: true,
                        buttons: {
                            'Send' : function() {
                                $.ajax( {
                                    url : _this.data( 'letterurl' ),
                                    type : 'post',
                                    dataType : 'json',
                                    data : { 'title' : _msg_dialog.find( '[name="title"]' ).val(), 'letter' : _msg_dialog.find( '[name="letter"]' ).val(), 'to_id' : selected_rows  },
                                    cache : false,
                                    success : function( response_data ) {
                                        _msg_dialog.dialog( 'option', { 'buttons': {} } );
                                        _msg_dialog.find( '.ui-dialog-content' ).css( 'minHeight', '0' );
                                        if ( response_data.error == '' ) {
                                            _msg_dialog.html( response_data.message );
                                        } else {
                                            _msg_dialog.html( response_data.error );
                                        }
                                    }
                                } );
                            },
                            'Cancel' : function() {
                                $( this ).dialog( 'close' );
                            },
                        }
                    } );
                }
            } ) ;
        }
        // Hosts
        if ( $( '#hosts-table' ).length > 0 ) {
            var beforeDeleteCallback = function() {
            }
            var _this = $( '#hosts-table' );
            var _pager = $( '#hosts-grid-pager' );
            _this.jqGrid( {
                colModel: [
                    { label: 'ID', name: 'id', index: 'id', width: 50, key: true, align: 'center', search: false, },
                    { label: 'Email', name: 'email', index: 'email', width: 100 },
                    { label: 'Property Type', name: 'property_type', index: 'property_type', align: 'center', formatter: 'select', editoptions : { value: "1:Apartment/Flat; 2:Landed; 3:Walkup; 4:Other" }, width: 100 },
                    { label: 'Property Other', name: 'property_other', index: 'property_other', width: 100 },
                    { label: 'Yard Type', name: 'yard_type', index: 'yard_type', align: 'center', formatter: 'select', editoptions : { value: "1:Open; 0:Close" }, width: 80 },
                    { label: 'Resident Pets', name: 'resident_pets', index: 'resident_pets', align: 'center', formatter: 'select', editoptions : { value: "1:Yes; 0:No" }, width: 100 },
                    { label: 'Service Breeds', name: 'service_breeds', index: 'service_breeds', formatter: 'select', editoptions : { value: "1:Yes; 0:No" }, align: 'center', width: 150 },
                    { label: 'Not Restrictions', name: 'service_not_restrictions', index: 'service_not_restrictions', width: 150 },
                    { label: 'Cancellation', name: 'service_cancellation', index: 'service_cancellation', align: 'center', formatter: 'select', editoptions : { value: "1:1 Day; 2:2 Days; 3:3Days" }, width: 120 },
                    { label: 'Expreience', name: 'expreience', index: 'expreience', align: 'center', width: 100 },
                    { label: 'Able to administer oral medication', name: 'skills_1', index: 'skills_1', align: 'center', formatter: 'select', editoptions : { value: "1:Yes; 0:No" }, width: 120 },
                    { label: 'Able to administer injection medication', name: 'skills_2', index: 'skills_2', align: 'center', formatter: 'select', editoptions : { value: "1:Yes; 0:No" }, width: 120 },

                    { label: 'Country', name: 'country', index: 'country', align: 'center', formatter: 'select', editoptions : { value: "21:China; 65:Singapore" }, width: 100 },
                    { label: 'State', name: 'division_level_first', index: 'division_level_first', align: 'center', width: 100 },
                    { label: 'City', name: 'division_level_second', index: 'division_level_second', align: 'center', width: 100 },
                    { label: 'District', name: 'division_level_third', index: 'division_level_third', align: 'center', width: 100 },
                    { label: 'Street', name: 'street', index: 'street', width: 150 },
                    { label: 'Zip Code', name: 'zip_code', index: 'zip_code', align: 'center', width: 100 },
                    { label: 'Apartment or Housing or Building', name: 'area', index: 'area', width: 150 },

                    { label: 'Latitude', name: 'lat', index: 'lat', align: 'center', width: 150 },
                    { label: 'Longitude', name: 'lng', index: 'lng', align: 'center', width: 150 },

                    { label: 'Dog &lt; 10kg Boarding', name: 'rate_1_1_1', index: 'rate_1_1_1', align: 'center', width: 100 },
                    { label: 'Dog 10 ~ 20kg Boarding', name: 'rate_1_2_1', index: 'rate_1_2_1', align: 'center', width: 100 },
                    { label: 'Dog &gt; 20kg Boarding', name: 'rate_1_4_1', index: 'rate_1_4_1', align: 'center', width: 100 },
                    { label: 'Dog Meals', name: 'rate_1_0_128', index: 'rate_1_0_128', align: 'center', width: 100 },
                    { label: 'Cat Boarding', name: 'rate_2_0_1', index: 'rate_2_0_1', align: 'center', width: 100 },
                    { label: 'Cat Meals', name: 'rate_2_0_256', index: 'rate_2_0_256', align: 'center', width: 100 },
                    { label: 'Dog &lt; 10kg Sitting', name: 'rate_1_1_2', index: 'rate_1_1_2', align: 'center', width: 100 },
                    { label: 'Dog 10 ~ 20kg Sitting', name: 'rate_1_2_2', index: 'rate_1_2_2', align: 'center', width: 100 },
                    { label: 'Dog &gt; 20kg Sitting', name: 'rate_1_4_2', index: 'rate_1_4_2', align: 'center', width: 100 },
                    { label: 'Cat Sitting', name: 'rate_2_0_2', index: 'rate_2_0_2', align: 'center', width: 100 },
                    { label: 'Walking', name: 'rate_0_0_8', index: 'rate_0_0_8', align: 'center', width: 100 },
                    { label: 'Grooming', name: 'rate_0_0_16', index: 'rate_0_0_16', align: 'center', width: 100 },
                    { label: 'Bothing', name: 'rate_0_0_32', index: 'rate_0_0_32', align: 'center', width: 100 },
                    { label: 'Pick-up', name: 'rate_0_0_64', index: 'rate_0_0_64', align: 'center', width: 100 },
                    { label: 'Pick-up km', name: 'rate_0_0_64_0', index: 'rate_0_0_64_0', align: 'center', width: 100 },

                    { label: 'Paypal Email', name: 'paypal_email', index: 'paypal_email', align: 'center', width: 150 },
                    { label: 'Paypal Phone', name: 'paypal_phone', index: 'paypal_phone', align: 'center', width: 120 },
                ],
                url: _this.data( 'url' ),
                datatype: "json",
                jsonReader : {
                    root: 'rows',
                    page: 'page',
                    total: 'total',
                    records: "records",
                    id: "id",
                },
                mtype: 'POST',

                editurl: _this.data( 'editurl' ),
                edit: {
                    closeAfterEdit: true,
                    closeOnEscape: true,
                },

                height: 500,

                pager : _pager,
                rowNum: 20,
                viewrecords: true,

                multiselect: true,
                multiboxonly: true,
                rownumbers: false,

                loadComplete: function ( data ) {
                    console.log( data );
                },
            } );
            _this.jqGrid( 'navGrid', '#hosts-grid-pager', { 
                edit: false,
                // editicon: 'fa fa-pencil fa-lg fa-fw',
                add: false, 
                del: false,
                // delicon: 'fa fa-times fa-lg fa-fw',
                search: true,
                searchicon: 'fa fa-search fa-lg fa-fw',
                refresh: true,
                refreshicon: 'fa fa-refresh fa-lg fa-fw',
                view: true,
                viewicon: 'fa fa-search-plus fa-lg fa-fw',
            }, {}, {}, {}, {
                multipleSearch: true,
                showQuery: true,
            } ).jqGrid( 'navButtonAdd', '#hosts-grid-pager', {
                buttonicon: 'fa fa-columns fa-lg fa-fw',
                caption: '',
                onClickButton: function() {
                    _this.setColumns( {
                        width: 400,
                    } );
                    return false;
                }
            } ) ;
        }

        // Transaction
        if ( $( '#transaction-table' ).length > 0 ) {
            var beforeDeleteCallback = function() {
            }
            var _this = $( '#transaction-table' );
            var _pager = $( '#transaction-grid-pager' );
            _this.jqGrid( {
                colModel: [
                    { label: 'ID', name: 'id', index: 'id', width: 50, key: true, search: false, },
                    { label: 'Order ID', name: 'order_id', index: 'order_id', width: 120, },
                    { label: 'Pay ID', name: 'pay_id', index: 'pay_id', width: 120, },
                    { label: 'Seller Email', name: 'seller_email', index: 'seller_email', align: 'center', width: 180 },
                    { label: 'Buyer Email', name: 'buyer_email', index: 'buyer_email', align: 'center', width: 180 },
                    { label: 'Payment Type', name: 'pay_type', index: 'pay_type', formatter: 'select', align: 'center', editoptions: { value: "1:PayPal" }, width: 120 },
                    { label: 'Total', name: 'pay_total', index: 'pay_total', align: 'center', width: 100 },
                    { label: 'Currency', name: 'pay_currency', index: 'pay_currency', formatter: 'select', align: 'center', editoptions: { value: "1:SGD" }, width: 80 },
                    { label: 'Counter Fee', name: 'commission', index: 'commission', align: 'center', width: 120 },
                    { label: 'Payment Status', name: 'pay_status', index: 'pay_status', formatter: 'select', editoptions: { value: "1:Payment Created; 2:Payment Paid; 3:Processing; 4:Pending Settlement; 5:Settlement Successfully; 6:Pending Refund; 7:Refund Successfully;" }, align: 'center', width: 120 },
                    { label: 'Order Status', name: 'service_status', index: 'service_status', align: 'center', formatter: 'select', editoptions: { value: "1:Booking Created; 2:In-service; 3:Service Completed; 4:Service Cancelled; 6: Host Accepted / Booking Completed; 7: Compensation; 8: Request Cancellation;" }, width: 100 },
                    { label: 'Created Time', name: 'submit_time', index: 'submit_time', align: 'center', width: 150 },
                    { label: 'Cancellation Time', name: 'cancel_time', index: 'cancel_time', align: 'center', width: 150 },
                    { label: 'Canceller', name: 'canceller', index: 'canceller', formatter: 'select', align: 'center', editoptions: { value: "1:User; 2:Host;" }, width: 80, },

                    { label: 'Order Start Date', name: 'start_date', index: 'start_date', align: 'center', width: 120 },
                    { label: 'Order End Date', name: 'end_date', index: 'end_date', align: 'center', width: 120 },
                ],
                url: _this.data( 'url' ),
                datatype: "json",
                jsonReader : {
                    root: 'rows',
                    page: 'page',
                    total: 'total',
                    records: "records",
                    id: "id",
                },
                mtype: 'POST',

                editurl: _this.data( 'editurl' ),
                
                height: 500,

                pager : _pager,
                rowNum: 20,
                viewrecords: true,
                sortname:'id',
                sortorder:'desc',
                multiselect: true,
                multiboxonly: true,
                rownumbers: false,

                loadComplete: function () {
                },
            } );
            _this.jqGrid( 'navGrid', '#transaction-grid-pager', { 
                edit: false,
                add: false, 
                del: false,
                search: true,
                searchicon: 'fa fa-search fa-lg fa-fw',
                refresh: true,
                refreshicon: 'fa fa-refresh fa-lg fa-fw',
                view: true,
                viewicon: 'fa fa-search-plus fa-lg fa-fw',
            }, {}, {}, {}, {
                multipleSearch: true,
                showQuery: true,
            } ).jqGrid( 'navButtonAdd', '#transaction-grid-pager', {
                buttonicon: 'fa fa-columns fa-lg fa-fw',
                caption: '',
                onClickButton: function() {
                    _this.setColumns( {
                        width: 400,
                    } );
                    return false;
                }
            } ).jqGrid( 'navSeparatorAdd', '#transaction-grid-pager', {
            } ).jqGrid( 'navButtonAdd', '#transaction-grid-pager', {
                id: 'settlement_btn',
                buttonicon: 'fa fa-usd fa-lg fa-fw',
                caption: '',
                onClickButton: function() {
                    var selected_rows = _this.jqGrid( 'getGridParam', 'selarrrow' );
                    if ( selected_rows.length <= 0 ) {
                        var _notice_dialog = $( '<div title="Warning">Please select at least one item</div>' );
                        _notice_dialog.dialog( {
                            position: { my: "center", at: "center", of: '.ui-jqgrid' },
                            appendTo: '.ui-jqgrid',
                            resizable: false,
                            modal: true,
                            minHeight: 80,
                        } );
                        return;
                    }
                    var filted_selected_rows = [];

                    $( selected_rows ).each( function( k, v ) {
                        var row = _this.jqGrid( 'getRowData', this );
                        filted_selected_rows.push( row.id );
                    } );

                    $( '#settlement_dialog' ).dialog( "close" );
                    $( '#gbox_transaction-table' ).loading();

                    $.ajax( {
                        data : { 'ids': filted_selected_rows.join( ',' ), 'service_compensation': $( '#service_compensation' ).val() },
                        dataType : 'json',
                        type: 'post',
                        url : _this.data( 'preview' ),
                        cache: false,
                        success: function( response_data ) {
                            $( '#settlement_dialog' ).remove();
                            $( '#gbox_transaction-table' ).loaded();

                            if ( response_data.message ) {
                                $( response_data.message ).dialog( {
                                    position: { my: "center", at: "center", of: '.ui-jqgrid' },
                                    appendTo: '.ui-jqgrid',
                                    resizable: false,
                                    modal: true,
                                    minHeight: 80,
                                    width: 520,
                                    buttons: {
                                        'Settlement' : function() {
                                            $( '#settlement_dialog' ).dialog( "close" );
                                            $( '#gbox_transaction-table' ).loading();

                                            $.ajax( {
                                                data : { 'ids': filted_selected_rows.join( ',' ), 'service_compensation': $( '#service_compensation' ).val() },
                                                dataType : 'json',
                                                type: 'post',
                                                url : _this.data( 'process' ),
                                                success: function( response_data ) {
                                                    $( '#settlement_dialog' ).remove();
                                                    $( '#gbox_transaction-table' ).loaded();

                                                    if ( response_data.message ) {
                                                        $( response_data.message ).dialog( {
                                                            position: { my: "center", at: "center", of: '.ui-jqgrid' },
                                                            appendTo: '.ui-jqgrid',
                                                            resizable: false,
                                                            modal: true,
                                                            minHeight: 80,
                                                        } );
                                                    } else if ( response_data.error ) {
                                                        $( response_data.error ).dialog( {
                                                            position: { my: "center", at: "center", of: '.ui-jqgrid' },
                                                            appendTo: '.ui-jqgrid',
                                                            resizable: false,
                                                            modal: true,
                                                            minHeight: 80,
                                                        } );
                                                    }
                                                }
                                            } );
                                        }
                                    },
                                } );
                            } else if ( response_data.error ) {
                                $( response_data.error ).dialog( {
                                    position: { my: "center", at: "center", of: '.ui-jqgrid' },
                                    appendTo: '.ui-jqgrid',
                                    resizable: false,
                                    modal: true,
                                    minHeight: 80,
                                } );
                            }
                        }
                    } );
                }
            } );
        }

        // Orders
        if ( $( '#orders-table' ).length > 0 ) {
            var beforeDeleteCallback = function() {
            }
            var _this = $( '#orders-table' );
            var _pager = $( '#orders-grid-pager' );
            _this.jqGrid( {
                colModel: [
                    { label: 'ID', name: 'id', index: 'id', width: 50, key: true, search: false, },
                    { label: 'Order Status', name: 'service_status', index: 'service_status', align: 'center', formatter: 'select', editoptions: { value: "1:Booking Created; 2:In-service; 3:Service Completed; 4:Service Cancelled; 6: Host Accepted / Booking Completed; 7: Compensation; 8: Request Cancellation; 9: Service Previous;" }, width: 100 },
                    {label:'Pay Status',name:'pay_status_label',index:'pay_status',width:120,search:false},
                    { label: 'Order ID', name: 'order_id', index: 'order_id', width: 120, },
                    { label: 'Pay ID', name: 'pay_id', index: 'pay_id', width: 120, },
                    { label: 'Seller Email', name: 'seller_email', index: 'seller_email', align: 'center', width: 180 },
                    { label: 'Buyer Email', name: 'buyer_email', index: 'buyer_email', align: 'center', width: 180 },
                    { label: 'Payment Status', name: 'pay_status', index: 'pay_status', formatter: 'select', editoptions: { value: "1:Payment Created; 2:Payment Paid; 3:Processing; 4:Pending Settlement; 5:Settlement Successfully; 6:Pending Refund; 7:Refund Successfully;" }, align: 'center', width: 120 },
                    { label: 'Cost', name: 'cost', index: 'cost', align: 'center', width: 100 },
                    { label: 'Start Date', name: 'start_date', index: 'start_date', align: 'center', width: 120 },
                    { label: 'End Date', name: 'end_date', index: 'end_date', align: 'center', width: 120 },
                    { label: 'Cancellation Time', name: 'cancel_time', index: 'cancel_time', align: 'center', width: 150 },
                    { label: 'Canceller', name: 'canceller', index: 'canceller', formatter: 'select', align: 'center', editoptions: { value: "1:User; 2:Host;" }, width: 80, },
                    { label: 'commission', name: 'commission', index: 'commission', align: 'center', width: 120 },

                    { label: 'Dog &lt; 10kg Boarding(Night/Total)', name: 'detail_1_1_1', index: 'detail_1_1_1', align: 'center', width: 180 },
                    { label: 'Dog 10 ~ 20kg Boarding(Night/Total)', name: 'detail_1_2_1', index: 'detail_1_2_1', align: 'center', width: 180 },
                    { label: 'Dog &gt; 20kg Boarding(Night/Total)', name: 'detail_1_4_1', index: 'detail_1_4_1', align: 'center', width: 180 },
                    { label: 'Dog Meals(Night/Total)', name: 'detail_1_0_128', index: 'detail_1_0_128', align: 'center', width: 180 },
                    { label: 'Cat Boarding(Night/Total)', name: 'detail_2_0_1', index: 'detail_2_0_1', align: 'center', width: 180 },
                    { label: 'Cat Meals(Night/Total)', name: 'detail_2_0_256', index: 'detail_2_0_256', align: 'center', width: 180 },
                    { label: 'Dog &lt; 10kg Sitting(Night/Total)', name: 'detail_1_1_2', index: 'detail_1_1_2', align: 'center', width: 180 },
                    { label: 'Dog 10 ~ 20kg Sitting(Night/Total)', name: 'detail_1_2_2', index: 'detail_1_2_2', align: 'center', width: 180 },
                    { label: 'Dog &gt; 20kg Sitting(Night/Total)', name: 'detail_1_4_2', index: 'detail_1_4_2', align: 'center', width: 180 },
                    { label: 'Cat Sitting(Night/Total)', name: 'detail_2_0_2', index: 'detail_2_0_2', align: 'center', width: 180 },
                    { label: 'Walking(Tipe/Total)', name: 'detail_0_0_8', index: 'detail_0_0_8', align: 'center', width: 180 },
                    { label: 'Grooming(Tipe/Total)', name: 'detail_0_0_16', index: 'detail_0_0_16', align: 'center', width: 180 },
                    { label: 'Bothing(Tipe/Total)', name: 'detail_0_0_32', index: 'detail_0_0_32', align: 'center', width: 180 },
                    { label: 'Pick-up(Tipe/Total)', name: 'detail_0_0_64', index: 'detail_0_0_64', align: 'center', width: 180 },
                    { label: 'Counter Fee', name: 'detail_0_0_1024', index: 'detail_0_0_1024', align: 'center', width: 180 },

                    { label: 'Pay Type', name: 'pay_type', index: 'pay_type', align: 'center', formatter: 'select', editoptions : { value: "1:PayPal" }, width: 100 },
                    { label: 'Pay Total', name: 'pay_total', index: 'pay_total', align: 'center', width: 100 },
                ],
                url: _this.data( 'url' ),
                datatype: "json",
                jsonReader : {
                    root: 'rows',
                    page: 'page',
                    total: 'total',
                    records: "records",
                    id: "id",
                },
                mtype: 'POST',
                
                editurl: _this.data( 'editurl' ),
                edit: {
                    closeAfterEdit: true,
                    closeOnEscape: true,
                },

                height: 500,

                pager : _pager,
                rowNum: 20,
                viewrecords: true,
                sortname:'id',
                sortorder:'desc',
                multiselect: true,
                multiboxonly: true,
                rownumbers: false,

                loadComplete: function ( data ) {
                    //console.log( data );
                    // get all rows data
                    var rowDatas=_this.jqGrid('getRowData');
                    console.log(rowDatas);
                    for(var i=0;i<rowDatas.length;i++){
                    	if(6==parseInt(rowDatas[i].pay_status)){
                    		_this.find('tr').eq(i+1).css({'background-color':'#FF00FF',color:'white'});
                    	}
                    }
                },
            } );
            _this.jqGrid( 'navGrid', '#orders-grid-pager', { 
                edit: false,
                // editicon: 'fa fa-pencil fa-lg fa-fw',
                add: false, 
                del: false,
                // delicon: 'fa fa-times fa-lg fa-fw',
                search: true,
                searchicon: 'fa fa-search fa-lg fa-fw',
                refresh: true,
                refreshicon: 'fa fa-refresh fa-lg fa-fw',
                view: true,
                viewicon: 'fa fa-search-plus fa-lg fa-fw',
            }, {}, {}, {}, {
                multipleSearch: true,
                showQuery: true,
            } ).jqGrid( 'navButtonAdd', '#orders-grid-pager', {
                buttonicon: 'fa fa-columns fa-lg fa-fw',
                caption: '',
                onClickButton: function() {
                    _this.setColumns( {
                        width: 400,
                    } );
                    return false;
                }
            } ).jqGrid( 'navButtonAdd', '#orders-grid-pager', {
                id: 'settlement_btn',
                buttonicon: 'fa fa-usd fa-lg fa-fw',
                caption: '',
                onClickButton: function() {
                    var selected_rows = _this.jqGrid( 'getGridParam', 'selarrrow' );
                    if ( selected_rows.length <= 0 ) {
                        var _notice_dialog = $( '<div title="Warning">Please select at least one item</div>' );
                        _notice_dialog.dialog( {
                            position: { my: "center", at: "center", of: '.ui-jqgrid' },
                            appendTo: '.ui-jqgrid',
                            resizable: false,
                            modal: true,
                            minHeight: 80,
                        } );
                        return;
                    }
                    var filted_selected_rows = [];

                    $( selected_rows ).each( function( k, v ) {
                        var row = _this.jqGrid( 'getRowData', this );
                        filted_selected_rows.push( row.id );
                    } );

                    $( '#settlement_dialog' ).dialog( "close" );
                    $( '#gbox_transaction-table' ).loading();

                    $.ajax( {
                        data : { 'ids': filted_selected_rows.join( ',' ), 'service_compensation': $( '#service_compensation' ).val() },
                        dataType : 'json',
                        type: 'post',
                        url : _this.data( 'preview' ),
                        cache: false,
                        error:function(response_data){
                        	console.log(response_data);
                        },
                        success: function( response_data ) {
                            $( '#settlement_dialog' ).remove();
                            $( '#gbox_transaction-table' ).loaded();

                            if ( response_data.message ) {
                                $( response_data.message ).dialog( {
                                    position: { my: "center", at: "center", of: '.ui-jqgrid' },
                                    appendTo: '.ui-jqgrid',
                                    resizable: false,
                                    modal: true,
                                    minHeight: 80,
                                    width: 520,
                                    buttons: {
                                        'Settlement' : function() {
                                            $( '#settlement_dialog' ).dialog( "close" );
                                            $( '#gbox_transaction-table' ).loading();

                                            $.ajax( {
                                                data : { 'ids': filted_selected_rows.join( ',' ), 'service_compensation': $( '#service_compensation' ).val() },
                                                dataType : 'json',
                                                type: 'post',
                                                url : _this.data( 'process' ),
                                                error:function(response_data){
                                                	console.log(response_data);
                                                },
                                                success: function( response_data ) {console.log(response_data)
                                                    $( '#settlement_dialog' ).remove();
                                                    $( '#gbox_transaction-table' ).loaded();

                                                    if ( response_data.message ) {
                                                        $( response_data.message ).dialog( {
                                                            position: { my: "center", at: "center", of: '.ui-jqgrid' },
                                                            appendTo: '.ui-jqgrid',
                                                            resizable: false,
                                                            modal: true,
                                                            minHeight: 80,
                                                        } );
                                                        location.reload();
                                                    } else if ( response_data.error ) {
                                                        $( response_data.error ).dialog( {
                                                            position: { my: "center", at: "center", of: '.ui-jqgrid' },
                                                            appendTo: '.ui-jqgrid',
                                                            resizable: false,
                                                            modal: true,
                                                            minHeight: 80,
                                                        } );
                                                    }
                                                }
                                            } );
                                        }
                                    },
                                } );
                            } else if ( response_data.error ) {
                                $( response_data.error ).dialog( {
                                    position: { my: "center", at: "center", of: '.ui-jqgrid' },
                                    appendTo: '.ui-jqgrid',
                                    resizable: false,
                                    modal: true,
                                    minHeight: 80,
                                } );
                            }
                        }
                    } );
                }
            } ); ;
        }
        
    } );
    
} )( jQuery );
