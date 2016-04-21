<?php

/**
 * Convert time to intuitive time prompt string
 *
 * @string/timestamp Time string or time stamp
 * @return Intuitive time prompt
 */
function to_time( $time, $suffix = false ) {
    if ( ! is_numeric( $time ) ) {
        $time = strtotime( $time );
    }

    if ( 0 == $time ) {
        return false;
    }

    if ( false === $suffix ) {
        $difference = time() - $time;
        $suffix = $difference > 0 ? _( ' ago' ) : _( ' later' );
    } else {
        $difference = $time;
    }

    $difference = abs( $difference );

    if ( $difference < 60 ) {
        $str_time = _( "A moment" );
    } else if ( $difference < 3600 ) {
        $min = (int)( $difference / 60 );
        $str_time = ( $min == 1 ? _( 'A minute' ) : $min . _( ' minutes' ) );
    } else if ( $difference < 86400 ) {
        $hr = (int)( $difference / 3600 );
        $str_time = ( $hr == 1 ? _( 'A hour' ) : $hr . _( ' hours' ) );
    } else if ( $difference < 2592000 ) {
        $day = (int)( $difference / 86400 );
        $str_time = ( $day == 1 ? _( 'A day' ) : $day . _( ' days' ) );
    } else if ( $difference < 31536000 ) {
        $month = (int)( $difference / 2592000 );
        $str_time = ( $month == 1 ? _( 'A month' ) : $month . _( ' months' ) );
    } else {
        $year = (int)( $difference / 31536000 );
        $str_time = ( $year == 1 ? _( 'A year' ) : $year. _( ' years' ) );
    }

    return $str_time . $suffix;
}

/**
 * Convert time to intuitive time prompt string
 *
 * @string/timestamp Time string or time stamp
 * @return Intuitive time prompt
 */
function to_response_time( $time, $suffix = false ) {
    if ( ! is_numeric( $time ) ) {
        $time = strtotime( $time );
    }

    if ( 0 == $time ) {
        return false;
    }

    if ( false === $suffix ) {
        $difference = time() - $time;
        $suffix = $difference > 0 ? _( ' ago' ) : _( ' later' );
    } else {
        $difference = $time;
    }

    $difference = abs( $difference );

    if ( $difference <= 3600 ) {
        $min = (int)( $difference / 60 );
        $str_time = 'Within an Hour';
    } else if ( $difference <= 7200) {
        $str_time = 'Within 2 Hours';
    }else if ( $difference <= 86400 ) {
        $str_time = 'Within a Day';
    } else if ( $difference <= 172800 ) {
        $str_time = 'Within 2 Days';
    }else if ( $difference <= 604800 ) {
        $str_time = 'Within the Week';
    }else if ( $difference < 31536000 ) {
        $month = (int)( $difference / 2592000 );
        $str_time = ( $month == 1 ? _( 'A month' ) : $month . _( ' months' ) );
    } else {
        $year = (int)( $difference / 31536000 );
        $str_time = ( $year == 1 ? _( 'A year' ) : $year. _( ' years' ) );
    }
	if (strpos($str_time,'month') !== false || strpos($str_time,'year') !== false) {
		return $str_time . $suffix;
	}
	else{
		return $str_time;
	}
    
}

/**
 * Convert time to age
 *
 * @string/timestamp Time string or time stamp
 * @return Intuitive age
 */
function to_age( $time ) {
    if ( ! is_numeric( $time ) ) {
        $time = strtotime( $time );
    }

    if ( 0 == $time ) {
        return 'Just Born';
    }

    
    $difference = time() - $time;
    if ($difference < 0) 
        return 'Not yet Born';
    

    $difference = abs( $difference );

    if ( $difference < 60 ) {
        $str_time = _( "A moment" );
    } else if ( $difference < 3600 ) {
        $min = (int)( $difference / 60 );
        $str_time = ( $min == 1 ? _( 'A minute' ) : $min . _( ' minutes' ) );
    } else if ( $difference < 86400 ) {
        $hr = (int)( $difference / 3600 );
        $str_time = ( $hr == 1 ? _( 'A hour' ) : $hr . _( ' hours' ) );
    } else if ( $difference < 2592000 ) {
        $day = (int)( $difference / 86400 );
        $str_time = ( $day == 1 ? _( 'A day' ) : $day . _( ' days' ) );
    } else if ( $difference < 31536000 ) {
        $month = (int)( $difference / 2592000 );
        $str_time = ( $month == 1 ? _( 'A month' ) : $month . _( ' months' ) );
    } else {
        $year = (int)( $difference / 31536000 );
        $str_time = ( $year == 1 ? _( 'A year' ) : $year. _( ' years' ) );
        $difference = $difference - ($year * 31536000);
        if ($difference > 259200) {
            $month = (int)( $difference / 2592000 );
            $calc_time = ( $month == 1 ? _( ' and a month' ) : _(' and ') . $month . _( ' months' ) );
            $str_time = $str_time . $calc_time;
        }
    }

    return $str_time;
}