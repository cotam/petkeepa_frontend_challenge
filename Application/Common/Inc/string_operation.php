<?php

/**
 * Extract string
 *
 * @string str String to be extracted
 * @interget base Min number of characters to reserve
 * @string char Skip reserved characters and truncate string using a mark
 *
 * @string Truncated string
 */
function intercept( $str, $base, $char = " ", $more = "..." ) {
    if ( is_array( $char ) ) {
        $preg_str = "/[" . implode( '|', $char ) . "]+?/";
    } else if ( is_string( $char ) ) {
        $preg_str = "/{$char}/";
    }
    $matches = array();
    $n = preg_match( $preg_str, $str, $matches, PREG_OFFSET_CAPTURE, $base );
    return ( ! $n ) ? $str : ( substr( $str, 0, ( isset( $matches[0] ) ? $matches[0][1] : strlen( $str ) ) ) . $more );
}

/**
 * Generates address
 *
 * @object obj usr_basiness Object
 * 
 * @string Generated address string
 */
function address( $obj ) {
    return $obj['division_level_first'] . ', ' . $obj['division_level_second'] . ', ' . ( empty( $obj['division_level_third'] ) ? '' : $obj['division_level_third'] ) /*. ', ' . $obj['street'] . ( empty( $obj['area'] ) ? '' : ' ( ' . $obj['area'] . ' )' )*/;
}

function address_short( $obj ) {
    return $obj['division_level_second'] . ( empty( $obj['division_level_third'] ) ? '' : ', ' .  $obj['division_level_third'] );
}

/**
 * Generate Avatar address
 *
 * @string img Avatar Image address
 *
 * @string Avatar address
 */
function head_img( $img ) {
    if ( is_numeric( $img ) ) {
        $attachment = D( 'User/Attachment' )->get_attachment( array( 'id' => $img ) );
        $img = empty( $attachment ) ? '' : $attachment['url'];
    }
    return empty( $img ) ? C( 'DEFAULT_HEAD_IMG' ) : $img;
}
