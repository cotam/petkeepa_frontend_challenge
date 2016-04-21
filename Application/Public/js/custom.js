// Avoid `console` errors in browsers that lack a console.
    "use strict";

    /*
    for (var a, e = function() {
    }, b = "assert clear count debug dir dirxml error exception group groupCollapsed groupEnd info log markTimeline profile profileEnd table time timeEnd timeStamp trace warn".split(" "), c = b.length, d = window.console = window.console || {}; c--; )
        a = b[c], d[a] || (d[a] = e);

        */

// it need be used in page.

/*$(document).ready(function() {
    $('#example').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "../../Adminstrator/Users/all.php",
        "columns": [
            { "data": "email" }
        ]
    } );
} );*/

if ($("#braintreeClientToken").length > 0){
    var clientToken = $("#braintreeClientToken").val();
    braintree.setup(clientToken, "dropin", {
      container: "payment-form",
      dataCollector: {
        kount: {environment: 'sandbox'}
      },
      onReady: function (braintreeInstance) {
        var form = document.getElementById('payment-form');
        var deviceDataInput = form['device_data'];
        if (deviceDataInput == null) {
          deviceDataInput = document.createElement('input');
          deviceDataInput.name = 'device_data';
          deviceDataInput.hidden = true;
          form.appendChild(deviceDataInput);
        }
        deviceDataInput.value = braintreeInstance.deviceData;
      }
    }); 
}


if ($.browser.mozilla || $.browser.msie) {
 $("#main-menu").attr("id","main-menu-ie");
}

if ($('#js-search-summary-bar').length > 0)
{
	if ($('#js-search-summary-bar').is(':visible'))
	{
		if ($('#filter-search').is(':visible'))
			$('#filter-search').attr('style','display:none');
		else
			$('#filter-search').attr('style','display:block');
	}		
}

if ($('#booking_type_select_mob').length > 0) {
    if ($('#booking_type_select_mob').is(':visible'))
        $('#online-chat-div').attr("style", "margin-top:1%");
    else
        $('#online-chat-div').attr("style", "margin-top:0px");
}

if ($('#greet-meet-btn').length > 0){
    $('#greet-meet-btn').click(function() {
        $('#online-chat').collapse('hide');
        if ($('#greet-meet').attr('aria-expanded') == undefined || $('#greet-meet').attr('aria-expanded') == 'false')
            $('#greet-meet-btn').removeClass('white');
        else if ($('#greet-meet').attr('aria-expanded') == 'true')
            $('#greet-meet-btn').addClass('white');
        $('#online-chat-btn').addClass('white');
    });
}

if ($('#online-chat-btn').length > 0){
    $('#online-chat-btn').click(function() {
        $('#greet-meet').collapse('hide');
        if ($('#online-chat').attr('aria-expanded') == undefined || $('#online-chat').attr('aria-expanded') == 'false')
            $('#online-chat-btn').removeClass('white');
        else if ($('#online-chat').attr('aria-expanded') == 'true')
            $('#online-chat-btn').addClass('white');
        $('#greet-meet-btn').addClass('white');
    });
}


if ($('#btnSearchIcon').length > 0)
{
	$('#btnSearchIcon').click(function() {
		if ($('#filter-search').length > 0)
		{
			if ($('#filter-search').is(':visible'))
			{
				$('#filter-search').attr('style','display:none');
				if ($('#search-sort-box').length > 0)
				{
					$('#search-sort-box').attr('style','top:75px');
				}
				if ($('#search-result-box').length > 0)
				{
					$('#search-result-box').attr('style','top:80px');
				}
			}
			else
			{
				$('#filter-search').attr('style','display:block');
				if ($('#search-sort-box').length > 0)
				{
					$('#search-sort-box').attr('style','top:188px');
				}
				if ($('#search-result-box').length > 0)
				{
					$('#search-result-box').attr('style','top:188px');
				}
			}
		}
	});
}

if ($('#country').length > 0)
{
	if(!$('#country.select').is(':visible'))
		$('#country.select').attr('name','country-xs');
}

if ($('#js-search-summary-bar').length > 0 )
{
	if ($('#js-search-summary-bar').is (':visible'))
	{
		if ($('#search-sort-box').length > 0)
		{
			$('#search-sort-box').attr('style','top:75px');
		}
		if ($('#search-result-box').length > 0)
		{
			$('#search-result-box').attr('style','top:80px');
		}
	}
}

if ($('#sidebar').length > 0)
{
	if(!$('#sidebar').is(':visible'))
	{
		$('#previewTag').removeClass('modalPreview').addClass('modalPreviewXS');
	}
}

if ($('#mailpref').length > 0)
{
	if(!$('#mailpref.select').is(':visible'))
		$('#mailpref.select').attr('name','mailpref-xs');
	else
	{
		$('#mailpref.chosen-select').attr('id','mailpref-lg');
		$('#mailpref.select').removeClass('inbox').addClass('inbox-xs');
		if ($(".letter-content").length > 0)
		{
			$(".letter-content").each(function(){
				$(this).removeClass('letter-content').addClass('letter-content-xs');
			});
		}
	}
}

if ($(".letter-content").length > 0)
{
	$(".letter-content").each(function(){
		$(this).removeClass('letter-content').addClass('letter-content-xs');
	});
}


function add_center_marker( map, $about_el ) {
    var _lat = $about_el.data( 'lat' );
    var _lng = $about_el.data( 'lng' );
    var _title = $about_el.data( 'title' );
    var _address = $about_el.data( 'address' );
    var _autoshow = $about_el.data( 'autoshow' );

    if ( _lat && _lng ) {

        var center_marker = new google.maps.Marker ( {
            position: new google.maps.LatLng( _lat, _lng ),
            map : map,
            icon : _public_url + 'images/location-home.png'
        } );

        var center_window = new google.maps.InfoWindow( {
            content: ( _title ? '<h3>' + _title + '</h3>' : '' ) + ( _address ? _address : '' ),
            maxWidth: 300
        } );

        if ( _title || _address ) {
            if ( _autoshow == true ) {
                center_window.open( map, center_marker );
            }

            google.maps.event.addListener( center_marker, 'click', function () {
                center_window.open( map, center_marker );
            } );
        }

        $about_el.data( 'marker', center_marker );
        $about_el.data( 'infoWindow', center_window );
    }
}

function remove_center_marker( map, $about_el ) {
    if ( $about_el.data( 'marker' ) ) {
        $about_el.data( 'marker' ).setMap( null );
    }
    if ( $about_el.data( 'infoWindow' ) ) {
        $about_el.data( 'infoWindow' ).close();
    }
}

// Add HOST unknown label to map 
function add_marker( map, $result_rows ) {
    $result_rows.each( function() {
		var _this = $( this );
        var _basiness_id = _this.attr( 'id' );
        var marker = new google.maps.Marker( {
            position : new google.maps.LatLng( _this.data( 'lat' ), _this.data( 'lng' ) ),
            map : map,
            icon : _public_url + 'images/location.png'
        } );
        google.maps.event.addListener( marker, 'click', function() {
			$('.row').removeClass("explain-blue");
			$('#search-result-box').scrollTop(0);
            var to_top = $( '#' + _basiness_id ).position()['top'];
			$( '#' + _basiness_id ).addClass("explain-blue");
            // Scroll to the specified location
            $('#search-result-box').animate({
                scrollTop: to_top
            }, 300 );
        } );
        _this.on( 'mouseover', function() {
            marker.setIcon( _public_url + 'images/location-hover.png' );
        } );
        _this.on( 'mouseout', function() {
            marker.setIcon( _public_url + 'images/location.png' );
        } );
        _this.data( 'marker', marker );
    } );
}

function remove_marker( map, $result_rows ) {
    $result_rows.each( function() {
        var _this = $( this );
        if ( _this.data( 'marker' ) ) {
            _this.data( 'marker' ).setMap( null );
        }
    } );
}

var ajax_from_submitting = false;

var ajax_form_submit = function() {
    var _this = $( this );

    if ( ajax_from_submitting ) {
        return false;
    }

    if ( $( '#filter-more' ).hasClass( 'in' ) ) {
        $( '#filter-more' ).collapse( 'hide' );
    }

    if ( $( '.result-content' ) .length > 0 ) {
        var _o = {};
        $.each( _this.serializeArray(), function() {
            if ( _o[ this.name ] != undefined ) {
                if ( ! _o[ this.name ].push ) {
                    _o[ this.name ] = [ _o[ this.name ] ];
                }
                _o[ this.name ].push( this.value || '' );
            } else {
                _o[ this.name ] = this.value || '';
            }
        } );

        $( '.result-content' ).loading();

        ajax_from_submitting = true;
        $.ajax( {
            url : _this.action || location.href,
            type : _this.method || 'get',
            data : _o,
            dataType : 'json',
            success : function( response_data ) {
                // Clear marker
                var map = $( '#map_canvas' ).data( 'map' );
                remove_marker( map.map, $( '.result-content' ).find( '.ajax-search-result' ) );

                $( '.result-content' ).find( '.ajax-search-result' ).remove();
                $( '.result-content' ).find( '.ajax-search-paged' ).remove();
                $( '.result-content' ).append( response_data.html );
                // Reset marker
                if ( map ) {
                    add_marker( map, $( '.result-content' ).find( '.ajax-search-result' ) );
                }
                ajax_from_submitting = false;
                $( '.result-content' ).loaded();
            },
            error : function() {
                ajax_from_submitting = false;
                $( '.result-content' ).loaded();
            }
        } );
    }

    if ( $( '.map_moved' ).length > 0 && $( '.map_close' ).length > 0 ) {
        $( '.map_moved' ).show();
        $( '.map_close' ).hide();
    }
}

var star_init = function() {
    var _this = $( this );
    var _readonly = _this.data( 'readonly' ) != false;
    var _starOn, _starOff
    if ( _this.hasClass( 'big' ) ) {
        _starOn =  _public_url + 'images/star-big-on.png';
        _starOff =  _public_url + 'images/star-big-off.png';
    } else {
        _starOn =  _public_url + 'images/star-on.png';
        _starOff =  _public_url + 'images/star-off.png';
    }
    _this.raty({
        space: false,
        starOn: _starOn,
        starOff: _starOff,
        readOnly : _readonly,
        score: function() {
            return _this.attr('data-score');
        }
    });
}

function booking_change() {
    var _total_night = parseInt( $( '#date-total-input' ).html() );
    var _base_service_value = $( '[name="base_service"]:checked' ).val();           // Basic services

    var _base_service_prices = {};
    var _pets = parseInt( $( '[name="pets"]' ).val() );

    for ( var i = 1; i <= _pets; i++ ) {
        var _service_provided_value = $( '[name="service_provided_' + i + '"]:checked' ).val();   // pet type
        var _pet_size_accepted = $( '[name="pet_size_accepted_' + i + '"]' ).val();               // pet size
        var _service_provided = $( '[name="service_provided_' + i + '"]:checked' ).val();

        // Dog meals id=128
        // Cat meals id=256
        var _service_type_128 = $( '[name="service_type_128_' + i + '"]:checked' ).val();
        var _service_type_256 = $( '[name="service_type_256_' + i + '"]:checked' ).val();

        var _base_service_input = '';
        var _base_service_date_input = '';
        var _base_meals_input = '';
        var _base_service_name = 'Services';

        var _base_service_price = 0;
        var _base_meals_price = 0;

        if ( _base_service_value == 0 ) {
            $( '.base_service_panel' ).slideUp( 300 );
        } else {
            $( '.base_service_panel' ).slideDown( 300 );
        }

        if ( _service_provided == 1 ) {
            if ( $( '[name="service_type_256_' + i + '"]' ).val() ) {
                $( '[name="service_type_256_' + i + '"]' ).removeAttr( 'checked' );
                $( '[name="service_type_256_' + i + '"]' ).parent().css( 'backgroundPosition', '0px 0px' );
            }
        } else if ( _service_provided == 2 ) {
            if ( $( '[name="service_type_128_' + i + '"]' ).val() ) {
                $( '[name="service_type_128_' + i + '"]' ).removeAttr( 'checked' );
                $( '[name="service_type_128_' + i + '"]' ).parent().css( 'backgroundPosition', '0px 0px' );
            }
        }

        if ( _base_service_value == 0 ) {
            _base_service_input = 'No need Basic Service.'
        } else if ( _base_service_value && _service_provided_value && _total_night ) {
            switch ( _service_provided_value ) {
            case '1' :
                _base_service_input += 'Dog ';
                if ( _service_type_128 ) {
                    _base_meals_input = ' ( meals )';
                    _base_meals_price = parseInt( $( '.price_service_type_128.price_service_provided_' + _service_provided_value ).val() );
                }
                break;
            case '2' :
                _base_service_input += 'Cat ';
                if ( _service_type_256 ) {
                    _base_meals_input = ' ( meals )';
                    _base_meals_price = parseInt( $( '.price_service_type_256.price_service_provided_' + _service_provided_value ).val() );
                }
                _pet_size_accepted = 0; // Set Cat Level to 0
                break;
            }

            switch( _base_service_value ) {
            case '1' :
                _base_service_input += 'Boarding';
                break;
            case '2' :
                _base_service_input += 'Sitting';
                break;
            }

            _base_service_date_input += '<span class="pull-right">' + 'x' + _total_night + '</span>';
            // Calculate price of basic services
            _base_service_price += parseInt( $( '.price_base_service_' + _base_service_value + '.price_service_provided_' + _service_provided_value + '.price_pet_size_accepted_' + _pet_size_accepted ).val() );
            // $( '#base_service_show_' + _service_provided_value + '_' + i ).html( _base_service_price );
            _base_service_price += _base_meals_price; // Pet meals
            _base_service_price *= parseInt( _total_night ); // Multiply by number of days
        } else {
            if ( ! _total_night ) {
                _base_service_input += 'Please select DATE.';
            } else if ( ! _base_service_value ) {
                _base_service_input += 'Please select Basic Service.';
            } else if ( ! _service_provided_value ) {
                _base_service_input += 'Please select Dog or Cat.';
            }
        }
        
        if ( _base_service_value ) {
            var _view_pet_size_accepted = $( '[name="pet_size_accepted_' + i + '"]' ).val();               // Pet size
            var _show_base_service_price = parseInt( $( '.price_base_service_' + _base_service_value + '.price_service_provided_1' + '.price_pet_size_accepted_' + _view_pet_size_accepted ).val() );
            $( '#base_service_show_1_' + i ).html( _show_base_service_price );

            _show_base_service_price = parseInt( $( '.price_base_service_' + _base_service_value + '.price_service_provided_2' + '.price_pet_size_accepted_0' ).val() );
            $( '#base_service_show_2_' + i ).html( _show_base_service_price );
        }

        if ( '1' == _base_service_value ) {
            _base_service_name = 'Boarding';
        } else if ( '2' == _base_service_value ) {
            _base_service_name = 'Sitting';
        }

        _base_service_prices[ i ] = _base_service_price;

        // Modify content of basic services
        $( '#base_service_input_' + i ).html( _base_service_input + _base_meals_input + _base_service_date_input );
        $( '#base_service_price_' + i ).html( _base_service_price );
        $( '.base_service_name' ).html( _base_service_name );
    }


    // Grooming id=8
    // Bathing id=16
    // Walking id=32
    // Pick-up id=64
    var _other_service_type = [ 8, 16, 32, 64 ];
    var _service_type_values = {};
    // Get all additional service selected values
    $.each( _other_service_type, function() {
        _service_type_values[ this ] = $( '[name="service_type_' + this + '"]' ).val() || 0;
    } );

    var _service_type_prices = {};

    $.each( _other_service_type, function() {
        if ( _service_type_values[ this ] != 0 ) {
            // Calculate additional service prices
            _service_type_prices[ this ] = parseInt( $( '.price_service_type_' + this ).val() || 0 ) * parseInt( _service_type_values[ this ] );
            // Modify content of additional services
            $( '#service_type_' + this ).show();
            $( '#service_type_' + this + '_price' ).html( _service_type_prices[ this ] );
            $( '#service_type_' + this + '_input' ).html( 'x' + _service_type_values[ this ] );
        } else {
            $( '#service_type_' + this ).hide();
        }
    } );

    var _total_price = 0;
    $.each( _base_service_prices, function() {
        _total_price += this;
    } );
    $.each( _service_type_prices, function() {
        _total_price += this;
    } );

    $( '#sub_total_price' ).html( _total_price.toFixed( 2 ) );

    var _service_fee = _total_price * ( parseInt( $( '.service_fee' ).val() ) / 100 );
    _total_price += _service_fee;

    $( '#service_fee' ).html( _service_fee.toFixed( 2 ) );
    $( '.total_price' ).html( _total_price.toFixed( 2 ) );
}

jQuery.fn.loading = function() {
    var _this = $( this );

    if ( _this.css( 'position' ) == 'static' ) {
        _this.css( 'position', 'relative' );
    }
    $( '<div class="shade"></div>' )
        .css( {
            display : 'block',
            position : 'absolute',
            top : 0,
            left : 0,
            width : '100%',
            height: '100%',
            backgroundColor : 'white',
            zIndex : 1,
            opacity : 0.7,
            filter : 'alpha( opacity=70 )',
            textAlign : 'center',
            color : '#00AEC1',
            lineHeight : _this.height() + 'px'
        } )
        .html( '<i class="fa fa-spinner fa-pulse fa-2x"></i>' )
        .appendTo( _this );

}

jQuery.fn.loaded = function() {
    var _this = $( this );
    _this.find( '.shade' ).remove();
}

jQuery.fn.adjust_img = function() {
    $( this ).each( function() {
        var _this = $( this );
        var _self = this;
        if ( _this.is( 'img' ) ) {

            var _adjust = function() {
                var _pw = _this.parent().width();
                var _ph = _this.parent().height();
                var _sw = _self.naturalWidth;
                var _sh = _self.naturalHeight;
                var _pp = _pw / _ph;
                var _sp = _sw / _sh;

                var _h, _w, _top, _left;

                if ( _ph > _sh && _pw > _sw ) {
                    _h = _sh;
                    _w = _sw;
                    _left = ( _pw - _w ) / 2;
                    _top = ( _ph - _h ) / 2;
                } else if ( _pp > _sp ) {
                    _h = _ph;
                    _w = _ph * _sp;
                    _left = ( _pw - _w ) / 2;
                    _top = 0;
                } else if ( _pp < _sp ) {
                    _w = _pw;
                    _h = _pw / _sp;
                    _top = ( _ph - _h ) / 2;
                    _left = 0;
                } else {
                    _h = _sh;
                    _w = _sw;
                    _top = 0;
                    _left = 0;
                }
				if (_sw > _sh)
				{
					_this.css( {
						'width' : '1140px',//_w + 'px',
						'height' : '700px'//_h + 'px',
						//'position' : 'relative',
						//'top' : _top,
						//'left' : _left
					} );
				}
            }

            if ( _self.complete ) {
                _adjust();
            } else {
                _this.on( 'load', function() {
                    _adjust();
                } );
            }

        }
    } );
}

jQuery(window).ready(function($) {
    
    // Resize window

    /** 
     * Handle window resizieng on the fly
     * ======================================= */


    var wi = $(window).width();
    var hi = $(window).height();

    var resize_event_function = function() {
        var wi = $(window).width();
        var hi = $(window).height();

        // Page set map height
        if ( $( '#search-page' ).length > 0 ) {
            $( '#search-page' ).height( hi - $( '#header' ).height() );
            $( '.search-map' ).height( hi - $( '#header' ).height() );
            $( '#filter-more' ).css( 'maxHeight', hi - $( '#header' ).height() - $( '#search-filter-box' ).height() - 15 );
            $( '#search-result-box' ).css( 'maxHeight', hi - $( '#header' ).height() - $( '#search-filter-box' ).height() - $( '#search-sort-box' ).height() );
        }

        if ( $( '#screen_width' ).length > 0 ) {
            $( '#screen_width' ).val( wi );
        }

        if ( $( '.host-detail-gallery-item' ).length > 0 ) {
            if ( wi < 998 ) {
                $( '.host-detail-gallery-item' ).width( wi - 70 ).height( 0.618 * ( wi - 70 ) );
            }
        }
        if ( $( '#host_detail_gallery_item' ).length > 0 ) {
            if ( wi < 998 ) {
                $( '#host_detail_gallery_item' ).width( wi - 70 ).height( 0.618 * ( wi - 70 ) );
            }
        }
    }
    $( window ).on( 'resize', resize_event_function );
    resize_event_function();

    // Close search hotel from in featured section
    $('.open-close-btn').click(function() {
        if ($('.featured-overlay').hasClass('closed')) {//open it
            $('.opener-area').css('left', '-100px');
            /*
            setTimeout(function() {
                $('.featured-overlay').css('left', '0').removeClass('closed');
            }, 300);
            */
        } else {//close it
            $('.featured-overlay').css('left', '-50%').addClass('closed');
            /*
            setTimeout(function() {
                $('.opener-area').css('left', '0px');

            }, 300);
            */
        }
    });

    /**
     * Use script to jump
     */
    $( '[data-href]' ).on( 'click', function() {
        var _this = $( this );
        if ( _this.attr( 'data-href-target' ) == '_blank' ) {
            window.open( _this.attr( 'data-href' ) );
        } else {
            location.href = _this.attr( 'data-href' );
        }
    } );

    // Static window

    var first1 = '#special-offers';
    var second1 = '#mi-slider img';
    var window_width = $(window).width();
    if (window_width < 9999) {
        $(first1).height() > $(second1).height() ? $(second1).height($(first1).height()) : $(first1).height($(second1).height());
    }

    /**
     * Bootstrap
     *****************************/

    // Prompt controller
    $( '[data-toggle="tooltip"], [data-tooltip]' ).tooltip();

    // Switch tab
    if ( '' != location.hash ) {
        var hash = location.hash;
        if ( $( hash ).length > 0 && $( hash ).is( '.tab-pane' ) ) {
            $( "[href='" + hash + "']" ).tab( 'show' );
        }
    }

    // Move triggers user drop-down list
    if ( $( '#logined' ).length > 0 ) {
        $( '#logined' ).on( 'mouseover', function() {
            // $( this ).dropdown( 'toggle' );
            $( '.user-menu-box' ).addClass( 'open' );
        } ).on( 'mouseleave', function() {
            $( '.user-menu-box' ).removeClass( 'open' );
        } );
        $( '#user-menu' ).on( 'click', function() {
            event.stopPropagation();
        } );
    }

    if ( $( '#login_before' ).length > 0 ) {
        $( '#login_before' ).on( 'click', function() {
            if ( $( this ).is( '.open' ) ) {
                $( this ).removeClass( 'open' );
            } else {
                $( this ).addClass( 'open' );
            }
        } );
    }

    // Auto scroll to info end
    if ( $( '.letter-session .inner' ).length > 0 ) {
        $( '.letter-session .inner' ).scrollTop( $( '.letter-session .inner' ).height() );
    }

function DateFmt(fstr) {
  this.formatString = fstr

  var mthNames = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
  var dayNames = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
  var zeroPad = function(number) {
     return ("0"+number).substr(-2,2);
  }

  var dateMarkers = {
    d:['getDate',function(v) { return zeroPad(v)}],
    m:['getMonth',function(v) { return zeroPad(v+1)}],
    n:['getMonth',function(v) { return mthNames[v]; }],
    w:['getDay',function(v) { return dayNames[v]; }],
    y:['getFullYear'],
    H:['getHours',function(v) { return zeroPad(v)}],
    M:['getMinutes',function(v) { return zeroPad(v)}],
    S:['getSeconds',function(v) { return zeroPad(v)}],
    i:['toISOString']
  };

  this.format = function(date) {
    var dateTxt = this.formatString.replace(/%(.)/g, function(m, p) {
      var rv = date[(dateMarkers[p])[0]]()

      if ( dateMarkers[p][1] != null ) rv = dateMarkers[p][1](rv)

      return rv

    });
    return dateTxt
  }
}

    
    // Date controller general method
    if ( $( '.datetimepicker' ).length > 0 ) {
        $( '.datetimepicker' ).each( function() {
            var _this = $( this );
            var _today = new Date();
            var _endDate = null;
            if ($('#pet_dob').length > 0) {
                _today = null;
                _endDate = new Date();
            }
            _this.datetimepicker( {
                format: _this.data( 'format' ) || 'dd M yyyy',
                autoclose: true,
                todayBtn: true,
                minView: _this.data( 'minView' ) || 'month',
                startDate: _this.data( 'startDate' ) || _today,
                endDate: _this.data( 'endDate' ) || _endDate
            } )
            .on( 'changeDate', function ( ev ) {
                var _in_date, _out_date;
                if ( _this.data( 'outSelector' ) ) {
                    // Calculate number of days
                    _in_date = _this.datetimepicker( 'getDate' );
                    _out_date = $( _this.data( 'outSelector' ) ).datetimepicker( 'getDate' );

                    if ( ! $( _this.data( 'outSelector' ) ).val() ) {
                        $( _this.data( 'outSelector' ) ).datetimepicker( 'show' );
                    }
                }
                if ( _this.data( 'inSelector' ) ) {
                    // Calculate number of days
                    _in_date = $( _this.data( 'inSelector' ) ).datetimepicker( 'getDate' );
                    _out_date = _this.datetimepicker( 'getDate' );
                }
                // Corresponding booking page event
               /* if ( _this.data( 'input' ) ) {
                    var _date = new Date( _this.datetimepicker( 'getDate' ) );
                    var df = new DateFmt( '%n %d %y' );
                    $( _this.data( 'input' ) ).html( df.format( _date ) );
                }*/
				if (_this[0].id == 'check-in-date-other')
				{
					$('input#other_nights').val(_this.datetimepicker( 'getDate' ));
					caculate_other_services_price();
				}
                if ( /*$( '#date-total-input' ).length > 0 &&*/ _in_date && _out_date ) {
                    var _d = Date.parse( new Date( _out_date.toDateString() ) ) - Date.parse( new Date( _in_date.toDateString() ) );
                    _d = ( _d < 0 ? 0 : _d == 0 ? 1 : Math.ceil( _d / 86400000 ) );
					if (_this[0].id == 'check-out-date' || _this[0].id == 'check-in-date')
					{
						$('input#boarding_nights').val(_d);
						calculate_boarding_price();
					}
					else if (_this[0].id == 'check-out-date-sitting' || _this[0].id == 'check-in-date-sitting')
					{
						$('input#sitting_nights').val(_d);
						calculate_sitting_price();
					}
					
                    //$( '#date-total-input' ).html( _d + ( ( _d > 1 ) ? '  Nights' : '  Night' ) );
                }
                // Corresponding booking page event
                /*if ( $( '.search-booking-contents' ).length > 0 ) {
                    booking_change();
                }*/
            } );
        } );
    }
	

	/* Setting the iframe height dynamic to the content within */
	$('iframe').load(function() {
    this.style.height =
    this.contentWindow.document.body.offsetHeight + 'px';
	});

    if ( $( '.calendar' ).length > 0 ) {
        $( '.calendar' ).each( function () {
            var _this = $( this );
            var _date = new Date();

            _this.fullCalendar( {
                header: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                defaultDate: _this.data( 'default' ) || moment(),
                editable: _this.data( 'editable' ) || false,
                selectable : _this.data( 'selectable' ) || false,
                select : function ( start, end, allDay, view ) {
                    if ( ( _this.data( 'selectable' ) || false ) && bootbox != undefined ) {
                        var _form = $("<form class='form-inline'><label>Are you avaliable today? You can mark your calendar as available or unavailabe with notes by clicking on the day you'd like to select.</label></form>");
                        bootbox.dialog( {
                            message: _form,
                            title : "What options do you want?",
                            buttons: {
                                "enable" : {
                                    "label" : "Available",
                                    "className" : "btn-sm btn-success",
                                    "callback" : function () {
                                        _this.loading();
                                        $.ajax({
                                            url : _this.data( 'url' ) || location.href,
                                            type : 'post',
                                            dataType: 'json',
                                            data : { 'start' : start.unix(), 'end' : end.unix(), 'option' : 'enable' },
                                            success : function ( response_data ) {
                                                console.log( response_data );
                                                if ( 'ok' == response_data.status ) {
                                                    $.each( response_data.ids, function() {
                                                        var _id = this;
                                                        _this.fullCalendar('removeEvents' , function(ev){
                                                            return ( ev._id == _id );
                                                        } )
                                                    } );
                                                }
                                                _this.loaded();
                                            },
                                            error : function( e ) {
                                                console.log( e );
                                                _this.loaded();
                                            }
                                        });
                                    }
                                },
                                "disabled" : {
                                    "label" : "Unavailable select",
                                    "className" : "btn-sm btn-danger",
                                    "callback": function() {
                                        _this.loading();
                                        $.ajax({
                                            url : _this.data( 'url' ) || location.href,
                                            type : 'post',
                                            dataType: 'json',
                                            data : { 'start' : start.unix(), 'end' : end.unix(), 'option' : 'disable' },
                                            success : function ( response_data ) {
                                                console.log( response_data );
                                                if ( 'ok' == response_data.status ) {
                                                    $.each( response_data.services, function() {
                                                        var _this_service = this;
                                                        _this.fullCalendar('renderEvent',
                                                            {
                                                                start: _this_service.start,
                                                                end: _this_service.end,
                                                                allDay: allDay,
                                                                color: _this_service.color,
                                                                overlap: false,
                                                                rendering: 'background',
                                                                id : _this_service.id
                                                            },
                                                            true // make the event "stick"
                                                        );
                                                    } );
                                                }
                                                _this.loaded();
                                            },
                                            error : function( e ) {
                                                console.log( e );
                                                _this.loaded();
                                            }
                                        });
                                    }
                                },
                                "close" : {
                                    "label" : "<i class='icon-remove'></i> Close",
                                    "className" : "btn-sm"
                                } 
                            }
                        } );
                    }
                },
                eventClick: function(calEvent, jsEvent, view) {
                    if ( ! calEvent['editable'] ) {
                        return ;
                    }
                    if ( ( _this.data( 'selectable' ) || false ) && bootbox != undefined ) {
                        var _form = $("<form class='form-inline'><label></label></form>");
                        _form.append("<input class='bootbox-input form-control' autocomplete='off' type='text' value='" + calEvent.title + "' >");
                        bootbox.dialog( {
                            message: _form,
                            title : "Change event &nbsp;",
                            buttons: {
                                "save" : {
                                    "label" : "Save",
                                    "className" : "btn-sm btn-success",
                                    "callback" : function () {
                                        var _title = _form.find("input[type=text]").val();
                                        _this.loading();
                                        $.ajax({
                                            url : _this.data( 'url' ) || location.href,
                                            type : 'post',
                                            dataType: 'json',
                                            data : { 'id' : calEvent.id, 'option' : 'change', 'title' : _title },
                                            success : function ( response_data ) {
                                                calEvent.title = _title;
                                                _this.fullCalendar('updateEvent', calEvent);
                                                _div.modal("hide");
                                                _this.loaded();
                                            },
                                            error : function( e ) {
                                                console.log( e );
                                                _this.loaded();
                                            }
                                        });
                                    }
                                },
                                "delete" : {
                                    "label" : "Delete Event",
                                    "className" : "btn-sm btn-danger",
                                    "callback": function() {
                                        _this.loaded();
                                        $.ajax({
                                            url : _this.data( 'url' ) || location.href,
                                            type : 'post',
                                            dataType: 'json',
                                            data : { 'id' : calEvent.id, 'option' : 'delete' },
                                            success : function ( response_data ) {
                                                _this.fullCalendar('removeEvents' , function(ev){
                                                    return ( ev._id == calEvent._id );
                                                })
                                                _this.loaded();
                                            },
                                            error : function( e ) {
                                                console.log( e );
                                                _this.loaded();
                                            }
                                        });
                                    }
                                } ,
                                "close" : {
                                    "label" : "<i class='icon-remove'></i> Close",
                                    "className" : "btn-sm"
                                } 
                            }
                        });
                    }
                },
                events: function ( start, end, timezone, callback ) {
                    _this.loading();
                    $.ajax( {
                        url : _this.data( 'url' ) || location.href,
                        type : 'post',
                        dataType : 'json',
                        data : { 'start' : start.unix(), 'end' : end.unix(), 'id' : _this.data( 'id' ) || '0' },
                        success : function( response_data ) {
                            var events = [];
                            $( response_data ).each(function() {
                                events.push( {
                                    start: $( this ).attr( 'start' ), // will be parsed
                                    end : $( this ).attr( 'end' ),
                                    overlap: false,
                                    rendering: 'background',
                                    color: $( this ).attr( 'color' ),
                                    editable : $( this ).attr( 'editable' ),
                                    id : $( this ).attr( 'id' ),
                                } );
                            } );
                            callback( events );
                            _this.loaded();
                        },
                        error : function( e ) {
                            console.log( e );
                            _this.loaded();
                        }
                    } );
                },
                eventDurationEditable: false,
                eventStartEditable: false
            } );
        } );
        if ($('#sidebar').length > 0){
            if(!$('#sidebar').is(':visible'))
                $('.calendar').fullCalendar('option', 'contentHeight', 360); 
        }
    }

    // Analyse auto submission method, prohibit submission WHEN search prompt box is NOT closed
    if ( $( '.stop-auto-submit' ).length > 0 ) {
        $( '.stop-auto-submit' ).on( 'keydown', function( e ) {
            if ( e.keyCode == 13 && ! $( '.pac-container' ).is( ':hidden' ) ) {
                return false;
            }
        } );
    }

    if ( $( '#filter-search' ).length > 0 ) {
        // Ajax request method
			var _ajax_form = $( '#filter-search' );
			_ajax_form.on( 'submit', function() { 
			if ($('#js-search-summary-bar').is(':visible'))
			{
				$('#filter-search').attr('style','display:none');
				$('#search-sort-box').attr('style','top:75px');
				$('#search-result-box').attr('style','top:80px');
				if ($('#places_input').val() != '')
					$('#country_chosen').text($('#places_input').val());
				if ($('#check-in-date').val() != '')
					$('.travellers').text($('#check-in-date').val());
				if ($('#check-out-date').val() != '')
					$('#checkout').text($('#check-out-date').val());
			}
            ajax_form_submit.call( _ajax_form );

            return false;
        } );
        
        // Search results page click operation method
        if ( $( '.search-paged a' ).length > 0 ) {
            $( '.search-paged a' ).on( 'click', function () {
                var _this = $( this );
                if ( _this.data( 'paged' ) && $( '#paged' ).length > 0 ) {
                    $( '#paged' ).val( _this.data( 'paged' ) );
                    ajax_form_submit.call( _ajax_form );
                }
            } );
        }

        var _ajax_result_clear = function() {
            var _this = $( this );
			if (_this.attr( 'data-name' ) == "service_types[]" || _this.attr( 'data-name' ) == "service_provided[]" || _this.attr( 'data-name' ) == "service_size_accepted[]" || _this.attr( 'data-name' ) == "property_type[]" || _this.attr( 'data-name' ) == "skills[]")
			{
				if (_this.attr( 'data-name' ) == "service_types[]")
				{
					for (var i=1; i <= 64; i++)
					{
						var _result = _ajax_form.find( '[name="service_types[]"][value="'+ i + '"]' );
						_result.removeAttr( 'checked' );
						_result.parent().css( 'background-position', '0px 0px' );
					}
				}
				if (_this.attr( 'data-name' ) == "service_provided[]")
				{
					for (var i=1; i <= 2; i++)
					{
						var _result = _ajax_form.find( '[name="service_provided[]"][value="'+ i + '"]' );
						_result.removeAttr( 'checked' );
						_result.parent().css( 'background-position', '0px 0px' );
					}
				}
				if (_this.attr( 'data-name' ) == "service_size_accepted[]")
				{
					for (var i=1; i <= 3; i++)
					{
						var _result = _ajax_form.find( '[name="service_size_accepted[]"][value="'+ i + '"]' );
						_result.removeAttr( 'checked' );
						_result.parent().css( 'background-position', '0px 0px' );
					}
				}
				if (_this.attr( 'data-name' ) == "property_type[]")
				{
					for (var i=1; i <= 4; i++)
					{
						var _result = _ajax_form.find( '[name="property_type[]"][value="'+ i + '"]' );
						_result.removeAttr( 'checked' );
						_result.parent().css( 'background-position', '0px 0px' );
					}
				}
				if (_this.attr( 'data-name' ) == "skills[]")
				{
					for (var i=1; i <= 2; i++)
					{
						var _result = _ajax_form.find( '[name="skills[]"][value="'+ i + '"]' );
						_result.removeAttr( 'checked' );
						_result.parent().css( 'background-position', '0px 0px' );
					}
				}
				_this.remove();
			}
			else
			{
				var _result = _ajax_form.find( '[name="' + _this.attr( 'data-name' ) + '"][value="' + _this.attr( 'data-value' ) + '"]' );

				if ( _result.is( ':input:checkbox, :input:radio' ) ) {
					_result.removeAttr( 'checked' );
					_result.parent().css( 'background-position', '0px 0px' );
				} else if ( _result.is( ':input:hidden' ) ) {
					_result.val( 0 );
					_result.parents( 'ul:eq(0)' ).find( '.box_slider' ).slider( 'value', 0 );
				}
				_this.remove();
			}
        }

        // Add Remove search item method
        _ajax_form.find( 'input[type="checkbox"], input[type="radio"]' ).on( 'change', function() {
            var _this = $( this );
            if ( _this.is( ':checked' ) ) {
                if ( $( '#search-filter-result-box [data-name="' + _this.attr( 'name' ) + '"][data-value="' + _this.attr( 'value' ) + '"]' ).length == 0 ) {
					var proceed = true;
					var tobeAdded = _this.parents( 'li:eq(1)' ).find( 'h3' ).html();
					if (tobeAdded.indexOf('Service') >= 0 || tobeAdded.indexOf('Type of Pet') >= 0 || tobeAdded.indexOf('Dog Size') >= 0 || tobeAdded.indexOf('Type of Residence') >= 0 || tobeAdded.indexOf('Specific Skills') >= 0)
					{
						if (tobeAdded.indexOf('Service') >= 0)
							$('#service').val(parseInt($('#service').val()) + 1);
						if (tobeAdded.indexOf('Type of Pet') >= 0)
							$('#pet_type').val(parseInt($('#pet_type').val()) + 1);
						if (tobeAdded.indexOf('Dog Size') >= 0)
							$('#dog_size').val(parseInt($('#dog_size').val()) + 1);
						if (tobeAdded.indexOf('Type of Residence') >= 0)
							$('#residence').val(parseInt($('#residence').val()) + 1);
						if (tobeAdded.indexOf('Specific Skills') >= 0)
							$('#skills').val(parseInt($('#skills').val()) + 1);
						$('#search-filter-result-box').children('button').each(function () {
							var btnText = ($(this).html()); 
							if ((tobeAdded.indexOf('Service') >= 0 && btnText.indexOf('Service') >= 0) || (tobeAdded.indexOf('Type of Pet') >= 0 && btnText.indexOf('Type of Pet') >= 0) || (tobeAdded.indexOf('Dog Size') >= 0 && btnText.indexOf('Dog Size') >= 0) || (tobeAdded.indexOf('Type of Residence') >= 0 && btnText.indexOf('Type of Residence') >= 0) || (tobeAdded.indexOf('Specific Skills') >= 0 && btnText.indexOf('Specific Skills') >= 0))
							{
								proceed = false;
								if (tobeAdded.indexOf('Service') >= 0)
									$(this).html('<i class="fa fa-times fa-fw"></i><b>Service</b>');
								if (tobeAdded.indexOf('Type of Pet') >= 0)
									$(this).html('<i class="fa fa-times fa-fw"></i><b>Type of Pet</b>');
								if (tobeAdded.indexOf('Dog Size') >= 0)
									$(this).html('<i class="fa fa-times fa-fw"></i><b>Dog Size</b>');
								if (tobeAdded.indexOf('Type of Residence') >= 0)
									$(this).html('<i class="fa fa-times fa-fw"></i><b>Type of Residence</b>');
								if (tobeAdded.indexOf('Specific Skills') >= 0)
									$(this).html('<i class="fa fa-times fa-fw"></i><b>Specific Skills</b>');
							}
						});
					}
					if (proceed)
					{
						$( '<button></button>' )
								.addClass( 'button mini brown right-space' )
								.attr( 'type', 'button' )
								.attr( 'data-name', _this.attr( 'name' ) )
								.attr( 'data-value', _this.attr( 'value' ) )
								.html( '<i class="fa fa-times fa-fw"></i>' + _this.parents( 'li:eq(1)' ).find( 'h3' ).html() + ': ' + _this.parents( 'li:first' ).find( 'label' ).html() )
								.on( 'click', _ajax_result_clear )
								.appendTo( $( '#search-filter-result-box' ) );
					}
                }
            } else {
				if (_this.attr( 'name' ) == "service_types[]" || _this.attr( 'name' ) == "service_provided[]" || _this.attr( 'name' ) == "service_size_accepted[]" || _this.attr( 'name' ) == "property_type[]" || _this.attr( 'name' ) == "skills[]")
				{
					if (_this.attr( 'name' ) == "service_types[]")
					{
						$('#service').val(parseInt($('#service').val()) - 1);
						if ($('#service').val() == 1)
							$( '#search-filter-result-box' ).find( '[data-name="' + _this.attr( 'name' ) + '"]' ).html( '<i class="fa fa-times fa-fw"></i>' + $("input[name='service_types[]']:checked").parents( 'li:eq(1)' ).find( 'h3' ).html() + ': ' + $("input[name='service_types[]']:checked").parents( 'li:first' ).find( 'label' ).html() );
						if ($('#service').val() == 0)
							$( '#search-filter-result-box' ).find( '[data-name="' + _this.attr( 'name' ) + '"]' ).remove();
					}
					if (_this.attr( 'name' ) == "service_provided[]")
					{
						$('#pet_type').val(parseInt($('#pet_type').val()) - 1);
						if ($('#pet_type').val() == 1)
							$( '#search-filter-result-box' ).find( '[data-name="' + _this.attr( 'name' ) + '"]' ).html( '<i class="fa fa-times fa-fw"></i>' + $("input[name='service_provided[]']:checked").parents( 'li:eq(1)' ).find( 'h3' ).html() + ': ' + $("input[name='service_provided[]']:checked").parents( 'li:first' ).find( 'label' ).html() );
						if ($('#pet_type').val() == 0)
							$( '#search-filter-result-box' ).find( '[data-name="' + _this.attr( 'name' ) + '"]' ).remove();
					}
					if (_this.attr( 'name' ) == "service_size_accepted[]")
					{
						$('#dog_size').val(parseInt($('#dog_size').val()) - 1);
						if ($('#dog_size').val() == 1)
							$( '#search-filter-result-box' ).find( '[data-name="' + _this.attr( 'name' ) + '"]' ).html( '<i class="fa fa-times fa-fw"></i>' + $("input[name='service_size_accepted[]']:checked").parents( 'li:eq(1)' ).find( 'h3' ).html() + ': ' + $("input[name='service_size_accepted[]']:checked").parents( 'li:first' ).find( 'label' ).html() );
						if ($('#dog_size').val() == 0)
							$( '#search-filter-result-box' ).find( '[data-name="' + _this.attr( 'name' ) + '"]' ).remove();
					}
					if (_this.attr( 'name' ) == "property_type[]")
					{
						$('#residence').val(parseInt($('#residence').val()) - 1);
						if ($('#residence').val() == 1)
							$( '#search-filter-result-box' ).find( '[data-name="' + _this.attr( 'name' ) + '"]' ).html( '<i class="fa fa-times fa-fw"></i>' + $("input[name='property_type[]']:checked").parents( 'li:eq(1)' ).find( 'h3' ).html() + ': ' + $("input[name='property_type[]']:checked").parents( 'li:first' ).find( 'label' ).html() );
						if ($('#residence').val() == 0)
							$( '#search-filter-result-box' ).find( '[data-name="' + _this.attr( 'name' ) + '"]' ).remove();
					}
					if (_this.attr( 'name' ) == "skills[]")
					{
						$('#skills').val(parseInt($('#skills').val()) - 1);
						if ($('#skills').val() == 1)
							$( '#search-filter-result-box' ).find( '[data-name="' + _this.attr( 'name' ) + '"]' ).html( '<i class="fa fa-times fa-fw"></i>' + $("input[name='skills[]']:checked").parents( 'li:eq(1)' ).find( 'h3' ).html() + ': ' + $("input[name='skills[]']:checked").parents( 'li:first' ).find( 'label' ).html() );
						if ($('#skills').val() == 0)
							$( '#search-filter-result-box' ).find( '[data-name="' + _this.attr( 'name' ) + '"]' ).remove();
					}
				}
				else
				{
					$( '#search-filter-result-box' ).find( '[data-name="' + _this.attr( 'name' ) + '"][data-value="' + _this.attr( 'value' ) + '"]' ).remove();
				}
            }
        } );
    }

    if ( $( '#slider_search_box' ).length > 0 ) {
        $( '#slider_search_box select' ).on( 'change', function() {
            $( '#sort_order' ).val( $( this ).val() );
            ajax_form_submit.call( $( '#filter-search' ) );
        } );
    }
	
	if ( $( '#mailpref' ).length > 0 ) {
        $( '#mailpref' ).on( 'change', function() {
           if ($( this ).val()  == 'MGR')
			location.href = "/index.php/User/Letter/meet_request_sent.html";
		   else if ($( this ).val()  == 'Inbox')
            location.href = "/index.php/User/Letter/letter_box.html";
		   else if ($( this ).val()  == 'Sent')
            location.href = "/index.php/User/Letter/sent.html";
		   else if ($( this ).val()  == 'Archive')
            location.href = "/index.php/User/Letter/archive.html";
		   else if ($( this ).val()  == 'MBR')
            location.href = "/index.php/User/Letter/book_request.html";
		   else if ($( this ).val()  == 'Booking')
            location.href = "/index.php/User/Letter/book_response.html";
		   else if ($( this ).val()  == 'RMGR')
            location.href = "/index.php/User/Letter/meet_request.html";
        } );
    }
	
	if ( $( '#bookpref' ).length > 0 ) {
        $( '#bookpref' ).on( 'change', function() {
           if ($( this ).val()  == 'CB')
			location.href = "/index.php/User/Booking/booking.html";
		   else if ($( this ).val()  == 'PB')
            location.href = "/index.php/User/Booking/previous.html";
		   else if ($( this ).val()  == 'SP')
            location.href = "/index.php/User/Letter/new_letter.html";
		   else if ($( this ).val()  == 'BS')
            location.href = "/index.php/User/Booking/booking_service.html";
		   else if ($( this ).val()  == 'PS')
            location.href = "/index.php/User/Booking/previous_service.html";
        } );
    }
	
	if ( $( '#accpref' ).length > 0 ) {
        $( '#accpref' ).on( 'change', function() {
           if ($( this ).val()  == 'CR')
			location.href = "/index.php/User/Account/account_records.html";
		   else if ($( this ).val()  == 'RR')
            location.href = "/index.php/User/Account/host_records.html";
		   else if ($( this ).val()  == 'RW')
            location.href = "/index.php/User/Account/withdraw.html";
		   else if ($( this ).val()  == 'AS')
            location.href = "/index.php/User/Account/setting.html";
        } );
    }

    // Slider general method
    if ( $( '.box_slider' ).length > 0 ) {
        $( '.box_slider' ).each( function () {
            var _this = $( this );
            _this.slider( {
                range: "min",
                value : _this.data( 'value' ),
                min: _this.data( 'min' ) || 1,
                max: _this.data( 'max' ),
                step : _this.data ( 'step' ) || 1,
                slide : function ( e, u ) {
                    $( _this.data( 'label' ) ).html( ( _this.data( 'pre' ) || '' ) + u.value );
                    $( _this.data( 'hide' ) ).val( u.value );
                },
                change : function () {
                    var _hide = $( _this.data( 'hide' ) );
                    if ( 0 != _hide.val() ) {
                        if ( $( '#search-filter-result-box [data-name="' + _hide.attr( 'name' ) + '"]' ).length == 0 ) {
                            $( '<button></button>' )
                                .addClass( 'button mini brown right-space' )
                                .attr( 'type', 'button' )
                                .attr( 'data-name', _hide.attr( 'name' ) )
                                .attr( 'data-value', _hide.attr( 'value' ) )
                                .html( '<i class="fa fa-times fa-fw"></i>' + _this.parents( 'li:eq(1)' ).find( 'h3' ).html() + ' ' + $( _this.data( 'label' ) ).html() )
                                .on( 'click', _ajax_result_clear )
                                .appendTo( $( '#search-filter-result-box' ) );
                        } else {
                            $( '#search-filter-result-box [data-name="' + _hide.attr( 'name' ) + '"]' )
                                .attr( 'data-name', _hide.attr( 'name' ) )
                                .attr( 'data-value', _hide.attr( 'value' ) )
                                .html( '<i class="fa fa-times fa-fw"></i>' + _this.parents( 'li:eq(1)' ).find( 'h3' ).html() + ' ' + $( _this.data( 'label' ) ).html() );
                        }
                    } else {
                        $( '#search-filter-result-box' ).find( '[data-name="' + _this.attr( 'name' ) + '"][data-value="' + _this.attr( 'value' ) + '"]' ).remove();
                        $( _this.data( 'label' ) ).html( ( _this.data( 'pre' ) || '' ) + 0 );
                    }
                }
            } );
        } );
    }

    // Picker controller control method
    if ( $( '[data-select-hide]' ).length > 0 ) {
        var select_changed = function() {
            if ( $( this ).is( ':checked' ) ) {
                $( $( this ).data( 'select-hide' ) ).slideDown( 300 ); //collapse( 'show' );
            } else {
                $( $( this ).data( 'select-hide' ) ).slideUp( 300 ); //.collapse( 'hide' );
            }
        };
        $( '[data-select-hide]' ).each( select_changed ).on( 'change', select_changed );
    }

    // More filter conditions method
    if ( $( '#search-filter-button' ).length > 0 ) {
        $( '#search-filter-button' ).on( 'click', function() {
            if ( ! $( '#filter-more' ).hasClass( 'in' ) ) {
                $( '#filter-more' ).collapse( 'show' );
                $( this ).find( 'i.fa' ).addClass( 'fa-rotate-180' );
            } else {
                $( '#filter-more' ).collapse( 'hide' );
                $( this ).find( 'i.fa' ).removeClass( 'fa-rotate-180' );
            }
        } );
    }
	if ($('#carousel').length > 0) {
	$('#carousel').carouFredSel({
		responsive: true,
		items: {
			visible: 1,
			width: 900,
			height: 700
		},
		next: "#next",
        prev: "#prev",
		scroll: {
			duration: 250,
			timeoutDuration: 2500,
			fx: 'uncover-fade'
		},
		pagination: '#pager',
		auto: false,
		circular: true,
	});

	$(".next-btn").click(function(event) {
            event.preventDefault();
            $('#carousel').trigger("next", 1);
			$( '#carousel img' ).adjust_img();
        });
		$( '#carousel img' ).adjust_img();
	}
    if ($('#previewImg').length > 0) {
        if ($('#previewImg').attr('style').length > 0)
            $('#previewImg').attr('style','width:239px;height:72px;min-width:0;min-height:0');
    }

    var singlePSlider = null;
	
    if ($('.single-slider').length > 0) {

        $( window ).load( function() {

            // Slide Controller
            $( '.single-slider' ).each( function() {
                singlePSlider = $( this ).carouFredSel( {
					
                    auto: false
                });

                var _this = $( this );

                $( this ).parents( '.single-slider-holder' ).find( '.main-slide-nav .next-btn' ).click( function( event ) {
                    event.preventDefault();
                    _this.trigger( "next", 1 );
                } )
                $( this ).parents( '.single-slider-holder' ).find( '.main-slide-nav .prev-btn' ).click( function( event ) {
                    event.preventDefault();
                    _this.trigger( "prev", 1 );
                } )
            } );

            //$( '.host-detail-gallery-item img' ).adjust_img();

        });

    }

    // Slide Banner general method
    if ( $( '.flexslider' ).length > 0 ) {
        jQuery('.flexslider').flexslider({
            animation: "fade"
        });
    }
    // Slide Controller Slide Controls
    if ($('.single-slider-thumb-gallery').length > 0) {
        $('.single-slider-thumb-gallery ul').carouFredSel({
            auto: false,
            circular: true
        });

        /*
        $(".single-slider-thumb-gallery .next-btn").click(function(event) {
            event.preventDefault();
            $('.single-slider-thumb-gallery ul').trigger("next", 1);
        });


        $(".single-slider-thumb-gallery .prev-btn").click(function(event) {
            event.preventDefault();
            $('.single-slider-thumb-gallery ul').trigger("prev", 1);
        });
        */


        $(".single-slider-thumb-gallery .horizontal-gallery-item").click(function(event) {
            event.preventDefault();
            var tid = $(this).attr('href');
            var targetSlide = $(".single-slider " + tid);

            if ( singlePSlider != null ) {
                singlePSlider.trigger('slideTo', targetSlide);
            }
        });
    }

    // Rating Star activator
    // todo:
    if ($('.star').length > 0) {
        $( '.star' ).each( function() {
            star_init.call( this );
        } );
    }

    // Refresh search results according to map
    if ( $( '.map_close' ).length > 0 ) {
        $( '.map_close' ).on( 'click', function() {
            ajax_form_submit.call( $( '#filter-search' ) );
        } );
        
        if ( $( '.map_moved' ).length > 0 && $( '.map_close' ).length > 0 ) {
            $( '.map_moved' ).show();
            $( '.map_close' ).hide();
        }
    }

    // Mapping general method
    if ( $( '#map_canvas' ).length > 0 ) {
        $.each( $( '#map_canvas' ), function() {
            var _this = $( this );
			var _scrollwheel = _this.data( 'scrollwheel' );
            var _map_canvas = _this.get( 0 );
            var _lat = _this.data( 'lat' );
            var _lng = _this.data( 'lng' );
            var _zoom = _this.data( 'zoom' ) || 10;
            var _title = _this.data( 'title' );
            var _address = _this.data( 'address' );
            var _auto_show = _this.data( 'autoshow' );

            var _map_init = function() {

                var latlng = new google.maps.LatLng( _lat || 1.352083, _lng || 103.819836 );
                var map_options = {
                    zoom: _zoom,
					scrollwheel: _scrollwheel,
                    center: latlng
                };

                var map = new google.maps.Map( _map_canvas, map_options );

                if ( _title || _address || _auto_show ) {
                    remove_center_marker( map, _this );
                    add_center_marker( map, _this );
                }
               
                // Add all search results coordinate positions
                add_marker( map, $( '.result-content' ).find( '.ajax-search-result' ) );

                var default_center = null;
                if ( navigator.geolocation && ( ! _lat || ! _lng ) ) {
                    navigator.geolocation.getCurrentPosition( function( position ) {
                        _lat = position.coords.latitude;
                        _lng = position.coords.longitude;
                        map.setCenter( new google.maps.LatLng( _lat, _lng ) );
                    }, function( error ) {
                        console.error( error.message );
                    } );
                }

                google.maps.event.addListener( map, 'center_changed', function() {
                    var center = map.getCenter();
                    if ( _this.data( 'latInput' ) && _this.data( 'lngInput' ) ) {
                        $( _this.data( 'latInput' ) ).val( center.lat() );
                        $( _this.data( 'lngInput' ) ).val( center.lng() );
                    }
                } );

                google.maps.event.addListener( map, 'bounds_changed', function () {
                    var bounds = map.getBounds();
                    if ( _this.data( 'northEastLatInput' ) && 
                         _this.data( 'northEastLngInput' ) && 
                         _this.data( 'southWestLatInput' ) && 
                         _this.data( 'southWestLngInput' ) ) {
                        $( _this.data( 'northEastLatInput' ) ).val( bounds.getNorthEast().lat() );
                        $( _this.data( 'northEastLngInput' ) ).val( bounds.getNorthEast().lng() );
                        $( _this.data( 'southWestLatInput' ) ).val( bounds.getSouthWest().lat() );
                        $( _this.data( 'southWestLngInput' ) ).val( bounds.getSouthWest().lng() );
                    }

                    change_results();
                } );

                // Event of processing modifying viewable area on map
                function change_results () {
                    if ( $( '#auto_select' ).length > 0 ) {
                        if ( $( '#auto_select' ).is( ':checked' ) ) {
                            ajax_form_submit.call( $( '#filter-search' ) );
                        } else {
                            $( '.map_moved' ).hide();
                            $( '.map_close' ).show();
                        }
                    }
                }

                // Save to Data Properties
                _this.data( 'map', map );

                if ( _this.data( 'input' ) ) {
                    var input = $( _this.data( 'input' ) ).get( 0 );

                    var autocomplete = new google.maps.places.Autocomplete( input );
                    autocomplete.bindTo( 'bounds', map );

                    google.maps.event.addListener( autocomplete, 'place_changed', function() {
                        var place = autocomplete.getPlace();

                        remove_center_marker( map, _this );
                        _this.data( 'lat', place.geometry.location.lat() );
                        _this.data( 'lng', place.geometry.location.lng() );
                        _this.data( 'title', 'Location' );
                        _this.data( 'address', $( _this.data( 'input' ) ).val() );
                        add_center_marker( map, _this );

                        if ( _this.data( 'latInput' ) && _this.data( 'lngInput' ) ) {
                            $( _this.data( 'latInput' ) ).val( place.geometry.location.lat() );
                            $( _this.data( 'lngInput' ) ).val( place.geometry.location.lng() );
                        }

                        if ( ! place.geometry ) {
                            return;
                        }
                        if ( place.geometry.viewport ) {
                            map.fitBounds( place.geometry.viewport );
                        } else {
                            map.setCenter( place.geometry.location );
                            map.setZoom( 17 );  // Why 17? Because it looks good. -- by goolge
                        }
                    } );
                } else if ( _this.data( 'inputs' ) ) {
                    var inputs = _this.data( 'inputs' ).split( ' ' );

                    $( inputs ).each( function() {
                        $( this ).on( 'change', function () {
                            var texts = '';

                            // get values for inputs
                            $( inputs ).each( function () {
                                texts += $( this ).val() + " ";
                            } );

                            var service = new google.maps.places.PlacesService( map );
                            service.textSearch( {
                                query: texts
                            }, function( placeResult ) {
                                if ( placeResult[0] ) {
                                    map.setCenter( placeResult[0]['geometry']['location'] );
                                }
                            } );
                        } );
                    } );
                }
            }

            google.maps.event.addDomListener( window, 'load', _map_init );

            if ( $( 'a[href="#map"][data-toggle="tab"]:not(.map-reloaded)' ).length > 0 ) {
                $( 'a[href="#map"][data-toggle="tab"]' ).addClass( 'map-reloaded' );
                $( 'a[href="#map"][data-toggle="tab"]' ).on( 'shown.bs.tab', _map_init )
            }
        } );
    } else if ( $( '#places_input' ).length > 0 ) { // Separately create search service ONLY IF map DOES NOT exist for page AND IF location search box exists
        $.each( $( '#places_input' ), function() {
            var _this = $( this );
            var input = _this.get(0);
            var options = {};
            var autocomplete = new google.maps.places.Autocomplete(input, options);
            google.maps.event.addListener( autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                if ( ! place.geometry ) {
                    return;
                }
                if ( _this.data( 'latInput' ) && _this.data( 'lngInput' ) ) {
                    $( _this.data( 'latInput' ) ).val( place.geometry.location.lat() );
                    $( _this.data( 'lngInput' ) ).val( place.geometry.location.lng() );
                }
            } );
        } );
    }

    // Global checkbox style
    if ( $("input:checkbox").length > 0 && undefined != jQuery.fn.screwDefaultButtons ) {
        $("input:checkbox").screwDefaultButtons({
            image: 'url("' + _public_url + 'images/checkbox.png")',
            width: 16,
            height: 16
        });
    }
    
    // Global radio style
    if ( $("input:radio").length > 0 && undefined != jQuery.fn.screwDefaultButtons ) {
        $("input:radio").screwDefaultButtons({
            image: 'url("' + _public_url + 'images/checkbox.png")',
            width: 16,
            height: 16
        });
    }

    // Host Comments Reply function
    if ( $( ".comment-reply" ).length > 0 ) {
        $.each( $( '.comment-reply' ), function() {
            var _this = $( this );

            _this.on( 'click', function() {
                $( _this.attr( 'href' ) ).find( "input[name='reply']" ).val( _this.data( 'from' ) );
                $( _this.attr( 'href' ) ).find( "form textarea, form input, form button" ).removeAttr( 'disabled' );
                $( _this.attr( 'href' ) ).find( "form textarea" )[0].focus();
            } );
        } );
    }

    // Booking page specific script
    if ( $( '.search-booking-contents' ).length > 0 ) {

        $( '[name="base_service"]' ).on( 'change', function() {
            booking_change();
        } );
        var selector = [];
        for( var i = 1; i <= 3; i++ ) {
            selector.push( '[name="pet_size_accepted_' + i + '"]' );
            selector.push( '[name="service_provided_' + i + '"]' );
            selector.push( '[name="service_type_128_' + i + '"]' );
            selector.push( '[name="service_type_256_' + i + '"]' );
        }

        $( selector.join( ',' ) ).on( 'change', function() {
            booking_change();
        } );
       
        $( '[name="service_type_8"], [name="service_type_16"], [name="service_type_32"], [name="service_type_64"]' ).on( 'change', function() {
            booking_change();
        } );

        // Control for number of pets to service
        $( '.service_provided' ).hide();
        $( '.base_service' ).hide();

        var _pets = parseInt( $( '[name="pets"]' ).val() );
        if ( _pets > 0 ) {
            for ( var i = 1; i <= _pets; i++ ) {
                $( '.service_provided_' + i ).show();
                $( '.base_service_' + i ).show();
            }
        }
        // $( '#remove_pet' ).hide();
        $( '#add_pet' ).on( 'click', function() {
            for( var i = 1; i <= 3; i++ ) {
                if ( $( '.service_provided_' + i ).is( ':hidden' ) ) {
                    $( '.service_provided_' + i ).slideDown( 300 );
                    $( '.base_service_' + i ).slideDown( 300 );
                    // $( '#add_pet' ).attr( 'disabled', 'disabled' );

                    $( '[name="pets"]' ).val( i );

                    /*
                    if ( i == 2 ) {
                        $( '#remove_pet' ).show();
                    }
                    */

                    if ( i == 3 ) {
                        $( '#add_pet' ).hide();
                    }
                    break;
                }
            }

            /*
            if ( $( '.service_provided:visible' ).length > 1 ) {
                $( '#remove_pet' ).show();
            } else {
                $( '#remove_pet' ).hide();
            }
            if ( $( '.service_provided:hidden' ).length > 0 ) {
                $( '#add_pet' ).show();
            } else {
                $( '#add_pet' ).hide();
            }
            */

            booking_change();
        } );
        $( '.remove_pet' ).on( 'click', function() {
            for( var i = 1; i <= 3; i++ ) {
                if ( $( '.service_provided_' + ( i + 1 ) ).is( ':hidden' ) || $( '.service_provided_' + ( i + 1 ) ).length == 0 ) {
                    $( '.service_provided_' + i ).slideUp( 300 );
                    $( '.base_service_' + i ).slideUp( 300 );

                    $( '[name="pets"]' ).val( i - 1 );

                    if ( i == 3 ) {
                        $( '#add_pet' ).show();
                    }

                    /*
                    if ( i == 2 ) {
                        $( '#remove_pet' ).hide();
                    }
                    */
                    break;
                }
            }
            
            /*
            if ( $( '.service_provided:visible' ).length > 2 ) {
                $( '#remove_pet' ).show();
            } else {
                $( '#remove_pet' ).hide();
            }
            if ( $( '.service_provided:hidden' ).length > 0 ) {
                $( '#add_pet' ).show();
            } else {
                $( '#add_pet' ).hide();
            }

            $( '[name="pets"]' ).val( $( '.service_provided:visible' ).length );
            */

            booking_change();
        } );

        booking_change();
    }

    // Dave button	
    if ( $( '.collection_button' ).length > 0 ) {
        $( '.collection_button' ).on( 'click', function() {
            var _this = $( this );
            _this.loading();
            if ( _this.is( '.add_collection' ) ) {

                $.ajax( {
                    url : _this.data( 'addUrl' ),
                    dataType : 'json',
                    type : 'post',
                    data : {
                        'collection' : _this.data( 'collection' )
                    },
                    success : function( response_data ) {
                        // Login Jump
                        if ( response_data.url != undefined ) {
                            location.href = response_data.url + '?redirect_to=' + location.href;
                        }
                        if ( response_data.message ) {
                            _this.html( 'Remove Favourite From List' );
                            _this.removeClass( 'add_collection' ).addClass( 'remove_collection' );
                        }

                        _this.loaded();
                    }
                } );

            } else {
                $.ajax( {
                    url : _this.data( 'removeUrl' ),
                    dataType : 'json',
                    type : 'post',
                    data : {
                        'collection' : _this.data( 'collection' )
                    },
                    success : function ( response_data ) {
                        if ( $( '.notice' ).length > 0 ) {
                            $( '.notice' ).html( response_data.error + response_data.message );
                            _this.parents( '.collection_row' ).slideUp( function() {
                                this.remove();
                            } );
                        }
                        _this.html( 'Add To Favourite List' );
                        _this.removeClass( 'remove_collection' ).addClass( 'add_collection' );

                        _this.loaded();
                    }
                } );
            }
        } );
    }

    if ( $( '[data-collection]' ).length > 0 ) {
        $( '[data-collection]' ).on( 'click', function() {
            var _this = $( this );
            _this.parents( '.host-list-item' ).loading();
            $.ajax( {
                url : _this.data( 'url' ),
                data : { collection : _this.data( 'collection' ) },
                type : 'post',
                dataType : 'json',
                cache : false,
                success : function( response_data ) {
                    $( '.notice' ).html( response_data.message );
                    _this.parents( '.host-list-item' ).slideUp().remove();
                }
            } );
        } );
    }

    if ($(".chosen-select").length > 0) {
        $(".chosen-select").chosen({max_selected_options: 5, disable_search_threshold: 10}); //disable_search: true use this to disable all searches
    }
    
    // Menu after successful login
    $('.toggle-menu').click(function(e) {
        e.preventDefault();
        var el = $(this);
        el.toggleClass('active');
        if (el.hasClass('active')) {
            $('.toggle-menu-holder .menu-body').removeClass('closed').addClass('opened');
        } else {
            $('.toggle-menu-holder .menu-body').removeClass('opened').addClass('closed');
        }
    });
    
    $('#StyleSwitcher .switcher-btn').click(function () {

        'use strict';

        $('#StyleSwitcher').toggleClass('open');
        return false;
    });
    $('.color-switch').click(function () {

        'use strict';

        var title = jQuery(this).attr('title');
        jQuery('#color-switch').attr('href', 'css/colors/' + title + '.css');
        return false;
    });


    // Editable controller x-editable general method
    if ( $( '.edit-text' ).length > 0 ) {

        $( '.edit-text' ).each( function() {
            var _this = $( this );
            _this.editable( {
                type: 'text',
                pk: 1,

                url: _this.data( 'url' ) || location.href,
                params : function( params ) {
                    var data = $.extend( params, _this.data() );
                    for( var i in data ) {
                        if ( typeof data[i] === 'object' ) {
                            data[i] = undefined;
                        }
                    }

                    return data;
                },
                ajaxOptions : {
                    type: 'post',
                    dataType: 'json'
                },
                error: function(response, newValue) {
                    console.log( response );
                },
                success: function(response, newValue) {
                    console.log( response );
                    console.log( newValue );
                }
            } );
            _this.on( 'shown', function( e, editable ) {
                // Interaction with map
                if ( _this.data( 'map' ) ) {
                    var map = $( _this.data( 'map' ) ).data( 'map' );
                    var input = editable.input.$input.get(0);
                    var $input = editable.input.$input;

                    var autocomplete = new google.maps.places.Autocomplete( input );
                    autocomplete.bindTo( 'bounds', map );

                    google.maps.event.addListener( autocomplete, 'place_changed', function() {
                        var place = autocomplete.getPlace();
                        if ( ! place.geometry ) {
                            return;
                        }
                        if ( place.geometry.viewport ) {
                            map.fitBounds( place.geometry.viewport );
                        } else {
                            map.setCenter( place.geometry.location );
                            // map.setZoom( 17 );  // Why 17? Because it looks good. -- by goolge
                        }

                        // Save longitude and latitude

                        _this.data( 'lat', place.geometry.location.lat() );
                        _this.data( 'lng', place.geometry.location.lng() );

                        _this.data( 'option', 'change_address' );
                    } );
                }
            } );
        } );
    }

    // Warning message box
    if ( $( '#boot-dialog' ).length > 0 ) {
        $( '#boot-dialog' ).on( 'show.bs.modal', function( event ) {
            var _this = $( this );
            var _target = $( event.relatedTarget );
            if ( _target.data( 'submitdata' ) ) {
                var obj = _target.data( 'submitdata' );
                _this.find( '.modal-footer .hidden-field' ).remove();
                $.each( obj, function ( k, v ) {
                    _this.find( '.modal-footer' ).append( '<input type="hidden" class="hidden-field" name="' + k + '" value="' + v + '"/>' );
                } )
            }
            _this.find( '.modal-body span' ).html( _target.data( 'msg' ) );
            // _this.find( '.modal-footer a[data-agree]' ).attr( 'href', _target.data( 'url' ) );
        } );
    }

    // View Payment Details
    if ( $( '#payment-modal' ).length > 0 ) {
        $( '#payment-modal' ).on( 'show.bs.modal', function( event ) {
            var _this = $( this );
            _this.find( '.modal-content' ).loading();
            _this.find( 'ul' ).hide();
            _this.html( '' );

            $.ajax( {
                type: 'post',
                dataType: 'json',
                url: _this.data( 'url' ),
                data: { service_id : $( event.relatedTarget ).data( 'service_id' ),
						opt : $( event.relatedTarget ).data( 'opt' )},
                cache: true,
                success : function( response_data ) {
                    console.log( response_data );
                    _this.html( response_data );
                }
            } );
        } );
    }
	
	// View Booking Details
    if ( $( '#booking-detail-modal' ).length > 0 ) {
        $( '#booking-detail-modal' ).on( 'show.bs.modal', function( event ) {
            var _this = $( this );
            _this.find( '.modal-content' ).loading();
            _this.find( 'ul' ).hide();
            _this.html( '' );
				
            $.ajax( {
                type: 'post',
                dataType: 'json',
                url: _this.data( 'url' ),
                data: { service_id : $( event.relatedTarget ).data( 'service_id' ),
						opt : $( event.relatedTarget ).data( 'opt' )},
                cache: true,
                success : function( response_data ) {
                    console.log( response_data );
                    _this.html( response_data );
                }
            } );
        } );
    }
	
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip();
	})
	
	$(function () {
		calculate_boarding_price();
		calculate_sitting_price();
		caculate_other_services_price();
		if ($("#booking_type_select").val() == 'Pet_Boarding')
		{
			$(".pet-boarding").show();
			$(".pet-sitting").hide();
			$(".other-services").hide();
		}
		else if ($("#booking_type_select").val() == 'Pet_Sitting')
		{
			$(".pet-boarding").hide();
			$(".pet-sitting").show();
			$(".other-services").hide();
		}
		else
		{
			$(".pet-boarding").hide();
			$(".pet-sitting").hide();
			$(".other-services").show();
		}
	})
	
	$(function () {
		calculate_boarding_price();
		calculate_sitting_price();
		caculate_other_services_price();
		if ($("#booking_type_select_mob").val() == 'Pet_Boarding')
		{
			$(".pet-boarding").show();
			$(".pet-sitting").hide();
			$(".other-services").hide();
		}
		else if ($("#booking_type_select_mob").val() == 'Pet_Sitting')
		{
			$(".pet-boarding").hide();
			$(".pet-sitting").show();
			$(".other-services").hide();
		}
		else
		{
			$(".pet-boarding").hide();
			$(".pet-sitting").hide();
			$(".other-services").show();
		}
	})
	
	$("#big_dog_boarding").change(function(){
        calculate_boarding_price();
    });
	$("#big_dog_boarding_meal").change(function(){
        calculate_boarding_price();
    });
	$("#big_dog_boarding_qty").change(function(){
        calculate_boarding_price();
    });
	
	$("#medium_dog_boarding").change(function(){
        calculate_boarding_price();
    });
	$("#medium_dog_boarding_meal").change(function(){
        calculate_boarding_price();
    });
	$("#medium_dog_boarding_qty").change(function(){
        calculate_boarding_price();
    });
	
	$("#small_dog_boarding").change(function(){
        calculate_boarding_price();
    });
	$("#small_dog_boarding_meal").change(function(){
        calculate_boarding_price();
    });
	$("#small_dog_boarding_qty").change(function(){
        calculate_boarding_price();
    });
	
	$("#cat_boarding").change(function(){
        calculate_boarding_price();
    });
	$("#cat_boarding_meal").change(function(){
        calculate_boarding_price();
    });
	$("#cat_boarding_qty").change(function(){
        calculate_boarding_price();
    });
	
	$("#big_dog_sitting").change(function(){
        calculate_sitting_price();
    });
	$("#big_dog_sitting_meal").change(function(){
        calculate_sitting_price();
    });
	$("#big_dog_sitting_qty").change(function(){
        calculate_sitting_price();
    });
	
	$("#medium_dog_sitting").change(function(){
        calculate_sitting_price();
    });
	$("#medium_dog_sitting_meal").change(function(){
        calculate_sitting_price();
    });
	$("#medium_dog_sitting_qty").change(function(){
        calculate_sitting_price();
    });
	
	$("#small_dog_sitting").change(function(){
        calculate_sitting_price();
    });
	$("#small_dog_sitting_meal").change(function(){
        calculate_sitting_price();
    });
	$("#small_dog_sitting_qty").change(function(){
        calculate_sitting_price();
    });
	
	$("#cat_sitting").change(function(){
        calculate_sitting_price();
    });
	$("#cat_sitting_meal").change(function(){
        calculate_sitting_price();
    });
	$("#cat_sitting_qty").change(function(){
        calculate_sitting_price();
    });
	
	$("#day_care_qty").change(function(){
		caculate_other_services_price();
    });
	$("#home_visit_qty").change(function(){
		caculate_other_services_price();
    });
	$("#pet_walking_qty").change(function(){
        caculate_other_services_price();
    });
	$("#pet_grooming_qty").change(function(){
        caculate_other_services_price();
    });
	$("#pet_bathing_qty").change(function(){
        caculate_other_services_price();
    });
	$("#pickup_service_qty").change(function(){
        caculate_other_services_price();
    });
	
	function caculate_other_services_price()
	{
		var price = 0;
		var rate5 = $('input#day_care_rate').val();
		var qty5 = $('select#day_care_qty option:selected').val();
		if (isNaN(rate5)) {rate5 = 0; qty5 = 0;}
		var rate6 = $('input#home_visit_rate').val();
		var qty6 = $('select#home_visit_qty option:selected').val();
		if (isNaN(rate6)) {rate6 = 0; qty6 = 0;}
		var rate1 = $('input#pet_walking_rate').val();
		var qty1 = $('select#pet_walking_qty option:selected').val();
		if (isNaN(rate1)) {rate1 = 0; qty1 = 0;}
		var rate2 = $('input#pet_grooming_rate').val();
		var qty2 = $('select#pet_grooming_qty option:selected').val();
		if (isNaN(rate2)) {rate2 = 0; qty2 = 0;}
		var rate3 = $('input#pet_bathing_rate').val();
		var qty3 = $('select#pet_bathing_qty option:selected').val();
		if (isNaN(rate3)) {rate3 = 0; qty3 = 0;}
		var rate4 = $('input#pickup_service_rate').val();
		var qty4 = $('select#pickup_service_qty option:selected').val();
		if (isNaN(rate4)) {rate4 = 0; qty4 = 0;}
		var _d = $('input#other_nights').val();
		price = rate5 * qty5 + rate6 * qty6 + rate1 * qty1 + rate2 * qty2 + rate3 * qty3 + rate4 * qty4 ;
		if (price != 0 && _d != '')
		{
			$('#other_services_book_now').prop('value','Book Now ($' + price +')');
			$('#other_services_book_now').prop('disabled', false);
		}
		else{
			$('#other_services_book_now').prop('value','Book Now');
			$('#other_services_book_now').prop('disabled', true);
		}
	}
	
	function calculate_boarding_price()
	{
		var price = 0;
		var tot_qty = 0;
		if ($("#big_dog_boarding").is(':checked'))
		{
			var qty = $('select#big_dog_boarding_qty option:selected').val();
			var rate = $('input#big_dog_boarding_rate').val();
			var price = price + (qty * rate);
			tot_qty = tot_qty + parseInt(qty);
			if ($("#big_dog_boarding_meal").is(':checked'))
			{
				var meal_rate = $('input#big_dog_boarding_meal_rate').val();
				price = price + (qty * parseInt(meal_rate));
			}
		}
		if ($("#medium_dog_boarding").is(':checked'))
		{
			var qty = $('select#medium_dog_boarding_qty option:selected').val();
			var rate = $('input#medium_dog_boarding_rate').val();
			var price = price + (qty * rate);
			tot_qty = tot_qty + parseInt(qty);
			if ($("#medium_dog_boarding_meal").is(':checked'))
			{
				var meal_rate = $('input#medium_dog_boarding_meal_rate').val();
				price = price + (qty * parseInt(meal_rate));
			}
		}
		if ($("#small_dog_boarding").is(':checked'))
		{
			var qty = $('select#small_dog_boarding_qty option:selected').val();
			var rate = $('input#small_dog_boarding_rate').val();
			var price = price + (qty * rate);
			tot_qty = tot_qty + parseInt(qty);
			if ($("#small_dog_boarding_meal").is(':checked'))
			{
				var meal_rate = $('input#small_dog_boarding_meal_rate').val();
				price = price + (qty * parseInt(meal_rate));
			}
		}
		if ($("#cat_boarding").is(':checked'))
		{
			var qty = $('select#cat_boarding_qty option:selected').val();
			var rate = $('input#cat_boarding_rate').val();
			var price = price + (qty * rate);
			tot_qty = tot_qty + parseInt(qty);
			if ($("#cat_boarding_meal").is(':checked'))
			{
				var meal_rate = $('input#cat_boarding_meal_rate').val();
				price = price + (qty * parseInt(meal_rate));
			}
		}
		var _d = $('input#boarding_nights').val();
		if (price != 0 && _d != 0)
		{
			$('#pet-boarding-book-now').prop( 'value','Book Now ($' + (parseInt(price) * parseInt(_d)) +')');
			$('input#total_pets_boarding').val(tot_qty);
			$('#pet-boarding-book-now').prop('disabled', false);
		}
		else
		{
			$('input#total_pets_boarding').val(0);
			$('#pet-boarding-book-now').prop('value','Book Now');
			$('#pet-boarding-book-now').prop('disabled', true);
		}
	}
	
	function calculate_sitting_price()
	{
		var price = 0;
		var tot_qty = 0;
		if ($("#big_dog_sitting").is(':checked'))
		{
			var qty = $('select#big_dog_sitting_qty option:selected').val();
			var rate = $('input#big_dog_sitting_rate').val();
			tot_qty = tot_qty + parseInt(qty);
			var price = price + (qty * rate);
			if ($("#big_dog_sitting_meal").is(':checked'))
			{
				var meal_rate = $('input#big_dog_sitting_meal_rate').val();
				price = price + (qty * parseInt(meal_rate));
			}
		}
		if ($("#medium_dog_sitting").is(':checked'))
		{
			var qty = $('select#medium_dog_sitting_qty option:selected').val();
			var rate = $('input#medium_dog_sitting_rate').val();
			tot_qty = tot_qty + parseInt(qty);
			var price = price + (qty * rate);
			if ($("#medium_dog_sitting_meal").is(':checked'))
			{
				var meal_rate = $('input#medium_dog_sitting_meal_rate').val();
				price = price + (qty * parseInt(meal_rate));
			}
		}
		if ($("#small_dog_sitting").is(':checked'))
		{
			var qty = $('select#small_dog_sitting_qty option:selected').val();
			var rate = $('input#small_dog_sitting_rate').val();
			tot_qty = tot_qty + parseInt(qty);
			var price = price + (qty * rate);
			if ($("#small_dog_sitting_meal").is(':checked'))
			{
				var meal_rate = $('input#small_dog_sitting_meal_rate').val();
				price = price + (qty * parseInt(meal_rate));
			}
		}
		if ($("#cat_sitting").is(':checked'))
		{
			var qty = $('select#cat_sitting_qty option:selected').val();
			var rate = $('input#cat_sitting_rate').val();
			tot_qty = tot_qty + parseInt(qty);
			var price = price + (qty * rate);
			if ($("#cat_sitting_meal").is(':checked'))
			{
				var meal_rate = $('input#cat_sitting_meal_rate').val();
				price = price + (qty * parseInt(meal_rate));
			}
		}
		var _d = $('input#sitting_nights').val();
		if (price != 0 && _d != 0)
		{
			$('#pet_sitting_book_now').prop('value','Book Now ($' + (parseInt(price) * parseInt(_d)) +')');
			$('input#total_pets_sitting').val(tot_qty);
			$('#pet_sitting_book_now').prop('disabled', false);
		}
		else
		{
			$('input#total_pets_sitting').val(0);
			$('#pet_sitting_book_now').prop('value','Book Now');
			$('#pet_sitting_book_now').prop('disabled', true);
		}
	}
	
	$("#booking_type_select").change(function() {
		if ($("#booking_type_select").val() == 'Pet_Boarding')
		{
			$(".pet-boarding").show();
			$(".pet-sitting").hide();
			$(".other-services").hide();
		}
		else if ($("#booking_type_select").val() == 'Pet_Sitting')
		{
			$(".pet-boarding").hide();
			$(".pet-sitting").show();
			$(".other-services").hide();
		}
		else
		{
			$(".pet-boarding").hide();
			$(".pet-sitting").hide();
			$(".other-services").show();
		}
	});
	
	$("#booking_type_select_mob").change(function() {
		if ($("#booking_type_select_mob").val() == 'Pet_Boarding')
		{
			$(".pet-boarding").show();
			$(".pet-sitting").hide();
			$(".other-services").hide();
		}
		else if ($("#booking_type_select_mob").val() == 'Pet_Sitting')
		{
			$(".pet-boarding").hide();
			$(".pet-sitting").show();
			$(".other-services").hide();
		}
		else
		{
			$(".pet-boarding").hide();
			$(".pet-sitting").hide();
			$(".other-services").show();
		}
	});
	
	/*$(".js-gig-boarding-sticky").click(function() {
		if ($(".js-pet-boarding").hasClass("active-click"))
			$(".js-pet-boarding").removeClass("active-click");
		else
			$(".js-pet-boarding").addClass("active-click");
	});
	
	$(".js-pet-boarding").hover(function() {
		if (!$(".js-pet-boarding").hasClass("active-click"))
		{
		$(".js-pet-boarding").addClass("active-hover after-transition");
	}}, function() {
		if (!$(".js-pet-boarding").hasClass("active-click"))
		{
		$(".js-pet-boarding").removeClass("active-hover after-transition");
	}});
	
	$(".js-btn-boarding").hover(function() {
		if (!$(".js-pet-boarding").hasClass("active-click"))
		{
		$(".js-pet-boarding").addClass("active-hover after-transition");
	}}, function() {
		if (!$(".js-pet-boarding").hasClass("active-click"))
		{
		$(".js-pet-boarding").removeClass("active-hover after-transition");
	}});
	
	$(".js-gig-extras-sticky").click(function() {
		if ($(".js-other-services").hasClass("active-click"))
			$(".js-other-services").removeClass("active-click");
		else
			$(".js-other-services").addClass("active-click");
	});
	
	$(".js-other-services").hover(function() {
		if (!$(".js-other-services").hasClass("active-click"))
		{
		$(".js-other-services").addClass("active-hover after-transition");
	}}, function() {
		if (!$(".js-other-services").hasClass("active-click"))
		{
		$(".js-other-services").removeClass("active-hover after-transition");
	}});
	
	$(".js-btn-other-services").hover(function() {
		if (!$(".js-other-services").hasClass("active-click"))
		{
		$(".js-other-services").addClass("active-hover after-transition");
	}}, function() {
		if (!$(".js-other-services").hasClass("active-click"))
		{
		$(".js-other-services").removeClass("active-hover after-transition");
	}});*/
	
	
    // Editable controller x-editable generic method
    if ( $( '.edit-select' ).length > 0 ) {
        $( '.edit-select' ).each( function() {
            var _this = $( this );
            _this.editable( {
                type: 'select',
                source: _this.data( 'source' ),
                pk: 1,

                url: _this.data( 'url' ) || location.href,
                params : function( params ) {
                    var data = $.extend( params, _this.data() );
                    for( var i in data ) {
                        if ( typeof data[i] === 'object' ) {
                            data[i] = undefined;
                        }
                    }
                    return data;
                },
                ajaxOptions : {
                    type: 'post',
                    dataType: ' '
                },
                error: function(response, newValue) {
                    console.log( response );
                },
                success: function(response, newValue) {
                    console.log( response );
                    console.log( newValue );
                }
            } );
        } );
    }

    // Add icon rotation effect when folding
    if ( $( '.contents .collapse' ).length > 0 ) {
        $( '.contents .collapse' ).on( 'show.bs.collapse', function() {
            $( '[href="#' + $( this ).attr( 'id' ) + '"] i' ).addClass( 'fa-rotate-180' );
        } );
        $( '.contents .collapse' ).on( 'hide.bs.collapse', function() {
            $( '[href="#' + $( this ).attr( 'id' ) + '"] i' ).removeClass( 'fa-rotate-180' );
        } );
    }

    // General method for marker
    if ( $( '.tags' ).length > 0 ) {
        $( '.tags' ).each( function() {
            var _this = $( this );

            if ( ! _this.data( 'url' ) ) {
                return false;
            }

            $.ajax( {
                type : 'post',
                dataType : 'json',
                url : _this.data( 'url' ),
                data : {},
                cache : true,
                success : function( response_data ) {

                    var _self_tag = _this.tags( {
                        suggestions : response_data,
                        tagData: _this.data( 'tags-data' ) ? _this.data( 'tags-data' ).split( ',' ) : [],
                        maxNumTags: 3,
                        afterAddingTag: function( tag ) {
                            $( '[name="' + _this.data( 'tags-name' ) + '"]' ).val( _self_tag.getTags().join( ',' ) );
                        },
                        afterDeletingTag: function( tag ) {
                            $( '[name="' + _this.data( 'tags-name' ) + '"]' ).val( _self_tag.getTags().join( ',' ) );
                        }
                    } );
                },
            } );
        } );
    }

    // Attachment upload controller dropzone general method
    if ( $( '.dropzone' ).length > 0 ) {
  
        var _remove_pic = function () {
            var _this = $( this );
            var _data = { 'option' : 'delete_attachment', 'id' : _this.data( 'pic-id' ), 's_id' : _this.data( 's-id' ) }
            var _url = _this.data( 'url' ) || location.href;
            $.ajax( {
                url: _url,
                type: 'post',
                dataType: 'json',
                data: _data,
                cache : false,
                success: function( request_data ) {
                }
            } );
        }

        $( '.dropzone' ).each( function() {
            var _this = $( this );
            var _url = _this.attr( 'action' ) || location.href;
          
            var _dropzone = _this.dropzone( {
                init : function() {
                    this.on( 'complete', function( file ) {
                        var xhr = $.parseJSON( file['xhr']['response'] );
                        $( file._removeLink ).data( 'pic-id', xhr['status'] );
                        $( file._removeLink ).data( 'url', _url );
                        _this.find( '.dz-add' ).appendTo( _this ).show();
                    } );
                    this.on( 'removedfile', function( file ) {
                        $( file._removeLink ).each( _remove_pic );
                    } );
                    this.on( 'sending', function( file ) {
                        _this.find( '.dz-add' ).hide();
                    } );
                },
                url : _url,
                method : "post",
                maxFiles : 10,
                paramName : "file",
                maxFilesize : 8, // MB
                addRemoveLinks : true,
                acceptedFiles : "image/*",
                dictResponseError: 'Error while uploading file!',
            } );
        } );
        $( '.dropzone' ).find( '.dz-add' ).on( 'click', function() {
            $( this ).parent().click();
        } );
        $( '.dropzone' ).find( '.dz-remove' ).on( 'click', function() {
            _remove_pic.call( this );
            $( this ).parents( '.dz-preview.dz-processing.dz-image-preview.dz-success' ).first().remove();
        } );
    }

    // Upload avatar special method
    if ( $( '#head-upload-form' ).length > 0 ) {
		
        var _upload = $( '#head-upload-form' );
        var _cut = $( '#head-cut-form' );
        var _progress = $( '#head-upload-form .progress' );
        var _bar = $( '#head-upload-form .progress .progress-bar' );
        var _sr = $( '#head-upload-form .progress .progress-bar .sr-only' );
        var _text = $( '#head-upload-form .head-img-square > span' );

        var _view_box = $( '#head-cut-form .new-head-img > span' );
        var _view_img = $( '#head-cut-form .new-head-img > img' );
        var _view_info = $( '#head-cut-form .cut-info' );

        var _view_img_square = $( '#head-upload-form .head-img-square img' );

        var _inline_view = function( ui ) {
            var _ts = ui.position.top / _view_img.height();
            var _ls = ui.position.left / _view_img.width();
            var _ws = _view_box.width() / _view_img.width();
            var _hs = _view_box.height() / _view_img.height();
            _view_img_square.css( {
                top: 180 / _hs * _ts * -1,
                left: 180 / _ws * _ls * -1,
                width: 180 / _ws,
                height: 180 / _hs
            } );
            _cut.find( '[name="ts"]' ).val( _ts );
            _cut.find( '[name="ls"]' ).val( _ls );
            _cut.find( '[name="ws"]' ).val( _ws );
            _cut.find( '[name="hs"]' ).val( _hs );
        }

        $( '#head-upload-form' ).ajaxForm( {
            dataType: 'json',
            beforeSend: function() {
				console.log('pro');
                _progress.show();
                _bar.width( '0%' );
                _sr.html( '0%' );
            },
            uploadProgress: function( event, position, total, percentComplete ) {
                _bar.width( percentComplete + '%' );
                _sr.html( percentComplete + '%' );
            },
            success: function() {
                _bar.width( '100%' );
                _sr.html( '100%' );
            },
            complete: function( xhr ) {
                _cut.find( '.new-head-img' ).show();
                var _load = function() {
                    if ( this.naturalWidth > this.naturalHeight ) {
                        $( this ).attr( 'width', this.naturalWidth / this.naturalHeight * 180 );
                        $( this ).attr( 'height', 'auto' );
                    } else {
                        $( this ).attr( 'height', this.naturalHeight / this.naturalWidth * 180 );
                        $( this ).attr( 'width', 'auto' );
                    }
                    _view_info.css( 'height', $( this ).height() + 'px' );
                    _text.hide();
                    _progress.hide();
					_cut.find( '[name="ws"]' ).val(180 / _view_img.width());
					_cut.find( '[name="hs"]' ).val(180 / _view_img.height());
                };
                _view_img.on( 'load', _load ).attr( 'src', location.protocol + '//' + location.hostname + xhr.responseJSON.url );
                _view_img_square.on( 'load', _load ).attr( 'src', location.protocol + '//' + location.hostname + xhr.responseJSON.url );
                _cut.find( '.new-head-area' ).resizable( {
                    minHeight: 60,
                    minWidth: 60,
                    containment: _view_img,
                    handles: 'all',
                    aspectRatio: 1,
                    resize: function( event, ui ) {
                        _inline_view( ui );
                    }
                } ).draggable( {
                    containment: _view_img,
                    scroll: false,
                    drag: function( event, ui ) { 
                        _inline_view( ui );
                    }
                } );
            }
        } );
        _view_img_square.on( 'click', function() {
            _upload.find( '#head-upload-input' ).on( 'change', function() {
                if ( '' != $( this ).val() ) {
                    _upload.submit();
                }
            } ).click();
        } );

    }
    
	//Upload pet avatar
	if ( $( '#pet-head-upload-form' ).length > 0 ) {
        var _pet_upload = $( '#pet-head-upload-form' );
        var _pet_cut = $( '#pet-head-cut-form' );
        var _pet_progress = $( '#pet-head-upload-form .progress' );
        var _pet_bar = $( '#pet-head-upload-form .progress .progress-bar' );
        var _pet_sr = $( '#pet-head-upload-form .progress .progress-bar .sr-only' );
        var _text = $( '#pet-head-upload-form .head-img-square > span' );

        var _pet_view_box = $( '#pet-head-cut-form .new-head-img > span' );
        var _pet_view_img = $( '#pet-head-cut-form .new-head-img > img' );
        var _pet_view_info = $( '#pet-head-cut-form .cut-info' );

        var _pet_view_img_square = $( '#pet-head-upload-form .head-img-square img' );

        var _pet_inline_view = function( ui ) {
            var _pet_ts = ui.position.top / _pet_view_img.height();
            var _pet_ls = ui.position.left / _pet_view_img.width();
            var _pet_ws = _pet_view_box.width() / _pet_view_img.width();
            var _pet_hs = _pet_view_box.height() / _pet_view_img.height();
            _pet_view_img_square.css( {
                top: 180 / _pet_hs * _pet_ts * -1,
                left: 180 / _pet_ws * _pet_ls * -1,
                width: 180 / _pet_ws,
                height: 180 / _pet_hs
            } );
            _pet_cut.find( '[name="ts"]' ).val( _pet_ts );
            _pet_cut.find( '[name="ls"]' ).val( _pet_ls );
            _pet_cut.find( '[name="ws"]' ).val( _pet_ws );
            _pet_cut.find( '[name="hs"]' ).val( _pet_hs );
        }

        $( '#pet-head-upload-form' ).ajaxForm( {
            dataType: 'json',
            beforeSend: function() {
                _pet_progress.show();
                _pet_bar.width( '0%' );
                _pet_sr.html( '0%' );
            },
            uploadProgress: function( event, position, total, percentComplete ) {
                _pet_bar.width( percentComplete + '%' );
                _pet_sr.html( percentComplete + '%' );
            },
            success: function() {
                _pet_bar.width( '100%' );
                _pet_sr.html( '100%' );
            },
            complete: function( xhr ) {
                _pet_cut.find( '.new-head-img' ).show();
                var _load = function() {
                    if ( this.naturalWidth > this.naturalHeight ) {
                        $( this ).attr( 'width', this.naturalWidth / this.naturalHeight * 180 );
                        $( this ).attr( 'height', 'auto' );
                    } else {
                        $( this ).attr( 'height', this.naturalHeight / this.naturalWidth * 180 );
                        $( this ).attr( 'width', 'auto' );
                    }
                    _pet_view_info.css( 'height', $( this ).height() + 'px' );
                    _pet_text.hide();
                    _pet_progress.hide();
					_pet_cut.find( '[name="ws"]' ).val(180 / _pet_view_img.width());
					_pet_cut.find( '[name="hs"]' ).val(180 / _pet_view_img.height());
                };
                _pet_view_img.on( 'load', _load ).attr( 'src', location.protocol + '//' + location.hostname + xhr.responseJSON.url );
                _pet_view_img_square.on( 'load', _load ).attr( 'src', location.protocol + '//' + location.hostname + xhr.responseJSON.url );
                _pet_cut.find( '.new-head-area' ).resizable( {
                    minHeight: 60,
                    minWidth: 60,
                    containment: _pet_view_img,
                    handles: 'all',
                    aspectRatio: 1,
                    resize: function( event, ui ) {
                        _pet_inline_view( ui );
                    }
                } ).draggable( {
                    containment: _pet_view_img,
                    scroll: false,
                    drag: function( event, ui ) { 
                        _pet_inline_view( ui );
                    }
                } );
            }
        } );
        _pet_view_img_square.on( 'click', function() {
            _pet_upload.find( '#pet-head-upload-input' ).on( 'change', function() {
                if ( '' != $( this ).val() ) {
                    _pet_upload.submit();
                }
            } ).click();
        } );

    }
	
	
    // Add Goto Top
    $('body').append('<a class="goto-top" href="#site"></a>');

    // Dynamic effect for every clicking to add anchor link 
    $( '.hash-move[href^="#"]' ).on( 'click', function( e ) {
        e.preventDefault();
        var _this = $( this );
        var _to = $( _this.attr( 'href' ) );
        console.log( _to.offset().top );
        if ( _to.length > 0 ) {
            $( 'body' ).animate( {
                scrollTop : _to.offset().top,
            }, 300 );
        }
    } );


    // Third party login with Facebook
    if ( $( '.facebook' ).length > 0 ) {
        $.each( $( '.facebook' ), function() {
            var _this = $( this );
            $.ajaxSetup( { cache: true } );
            $.getScript( '//connect.facebook.net/en_US/all.js', function() {
                FB.init( {
                    appId: _facebook_id,
                    cookie: true,
                    xfbml: true,
                    version: 'v2.2'
                } );
            } );

            var _connected = function( token ) {
                var _data = {};
                _data.token = token;

                FB.api( '/me', {
                    fields: 'first_name,gender,locale,last_name,email,location'
                }, function( response ) {
                    if ( response.error ) {
                        alert( response.error.message );
                        return;
                    }

                    _data.email = response.email;
                    _data.first_name = response.first_name;
                    _data.last_name = response.last_name;
                    _data.gender = response.gender;
                    _data.address = ( undefined == response.location ) ? '' : response.location.name;
                    _data.languages_spoken = response.locale

                    console.log( response );
                    FB.api( '/me/picture?width=200&height=200&redirect=false', function( response ) {
                        _data.head_img = response.data.url;
                        console.log( response.data.url );

                        // to login / register.
                        var form = $( '<form></form>' )
                            .attr( 'action', _this.data( 'url' ) )
                            .attr( 'method', 'post' );
                        $.each( _data, function( k, v ) {
                            form.append( '<input type="hidden" name="' + k + '" value="' + v + '">' );
                        } );

                        form.submit();

                    } );
                } );

            }

            _this.on( 'click', function() {
                FB.getLoginStatus( function( response ) {
                    if ( 'connected' === response.status ) {
                        _connected( response.authResponse.userID );
                    } else {
                        FB.login( function( response ) {
                            if ( 'connected' === response.status ) {
                                _connected( response.authResponse.userID );
                            } else {
                                console.log( 'login error.' );
                            }
                        }, { scope: 'public_profile,email,user_location' } );
                    }
                } );
            } );
        } );
    }


    // Archiving function
    /*if( $( '.achive' ).length > 0 ){
        $( '.achive' ).on( 'click', function() {
            var _id = $( this ).data( 'id' );
            $( '.achive-button-box-' + _id ).hide();
            $( '.achive-box-' + _id ).show();
            
            var _this = $( '.achive-box-' + _id ).find( '.lazy-tags' );
            if ( ! _this.data( 'url' ) ) {
                return false;
            }

            if ( _this.data( 'tags_loaded' ) ) {
                return true;
            }

            $( '.achive-box-' + _id ).loading();

            $.ajax( {
                type : 'post',
                dataType : 'json',
                url : _this.data( 'url' ),
                data : {},
                cache : true,
                success : function( response_data ) {
                    var _self_tag = _this.tags( {
                        suggestions : response_data,
                        tagData: _this.data( 'tags-data' ) ? _this.data( 'tags-data' ).split( ',' ) : [],
                        maxNumTags: 3,
                        afterAddingTag: function( tag ) {
                            $( '.achive-box-' + _id ).find( '[name="' + _this.data( 'tags-name' ) + '"]' ).val( _self_tag.getTags().join( ',' ) );
                        },
                        afterDeletingTag: function( tag ) {
                            $( '.achive-box-' + _id ).find( '[name="' + _this.data( 'tags-name' ) + '"]' ).val( _self_tag.getTags().join( ',' ) );
                        }
                    } );
                    _this.data( 'tags_loaded', true );
                    $( '.achive-box-' + _id ).loaded();
                },
            } );

        } );
        $( '.letter-achive-close' ).on( 'click', function() {
            var _id = $( this ).data( 'id' );
            $( '.achive-box-' + _id ).hide();
            $( '.achive-button-box-' + _id ).show();
        } );
    }*/

    // Remove marker function
    if ( $( '.tag-remove' ).length > 0 ) {
        $( '.tag-remove' ).on( 'click', function() {
        } );
    }

    // Submit listing special method
    if ( $( '[type="submit"][form]' ).length > 0 ) {
        $( '[type="submit"][form]' ).on( 'click', function() {
            $( '#' + $( this ).attr( 'form' ) ).submit();
        } );
    }
    /*
    	$('.achive').on('click',function(){
			var obj=$(this);
			var id=obj.attr('for');
			if(obj.hasClass('edit')){
				obj.parents('.col-md-3').before('<div class="col-md-3"><input type="text" name="tags" id="tags" style="width:100%;" /></div>');
				setTimeout(function(){
					obj.removeClass('edit').addClass('submit');
				},'1000');
			}
			if(obj.hasClass('submit')){
				$.ajax({
					url:location.href.replace('letter_box','file_archive'),
					async:false,
					type:'POST',
					data:{
						letter_id:id,
						tags:$('#tags').val()
					},
					dataType:'json',
					error:function(data){
						console.log(data);
					},
					success:function(data){console.log(data);
						if(data.status=='success'){
							location.reload();
						}
					}
				});
			}
		});
    }
    */
});

$(window).bind("load", function() {
    $( '#status' ).fadeOut(); // will first fade out the loading animation
    $( '#preloader' ).fadeOut( 300 ); // will fade out the white DIV that covers the website.
    $( 'body' ).css( { 'overflow-x': 'hidden', 'overflow-y': 'auto' } );
});

// Sticky Nav
$(window).scroll( function( nav_anchor ) {
     var nav_anchor = $("#hosts_box");
     var gotop = $(document);

    // Selection activity during page scrolling
    /*
    if ( $( '#filter-more' ).hasClass( 'in' ) && nav_anchor.css( 'top' ) == '0px' ) {
        $( '#filter-more' ).collapse( 'hide' );
        $( '#more_filter i.fa' ).removeClass( 'fa-rotate-180' );
    }
    */

    // Control for Return to top during page scrolling
    if ($(this).scrollTop() >= gotop.height()/2) {
        $('.goto-top').css({'opacity':1});
    } else if ($(this).scrollTop() < gotop.height()/2) {
        $('.goto-top').css({'opacity':0});
    }
    
    // Stick to top widget control during page scrolling
    if ($(this).scrollTop() >= 98 && nav_anchor.css('position') != 'fixed' && !nav_anchor.hasClass('fixed-menu')) {   
        nav_anchor.addClass( 'splited' );
    } else if ($(this).scrollTop() < 98 && nav_anchor.css('position') != 'relative' && !nav_anchor.hasClass('fixed-menu')){   
        nav_anchor.removeClass( 'splited' );
    }

    /*
    var b = $( '#slider_box' );
    b.affix( {
        offset : 
        {
            top : function ()
            {
                var c = b.offset().top, d = parseInt( b.children(0).css("margin-top"), 10 );
                return this.top = c - 45;
            },
            bottom: function()
            {
                return this.bottom = $("#footer-black").outerHeight(!0) + 60;
            }
        }
    } );
    */
});


// Become a host slide - not automatically cycle
$('.carousel').carousel({
  interval: false
})

if($('.m-payment li').length){
	$('.m-payment li').on('click',function(){
		check_payment_type();
	});
	check_payment_type();
}
function check_payment_type(){
	var content=$('.m-payment').find('.content');
	var radio=document.getElementsByName('payment_type');
	var value='';
	for(var i=0;i<radio.length;i++){
		if(radio[i].checked){
			value=radio[i].value;
		}
	}
	if('paypal'==value||!value){
		content.hide();
	}else{
		content.show();
	}
	/*if('paypal'==$('#payment_type1').val()||!$('#payment_type1').val()){
		content.hide();
	}else{
		content.show();
	}*/
}
