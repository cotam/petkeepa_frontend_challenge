<?php

/**
 * Set bit
 */
function set_enum( $enum, &$value ) {
    $enum = (int)$enum;
    $value = (int)$value;
    return $value |= $enum;
}

/**
 * Reset bit
 */
function clean_enum( $enum, &$value ) {
    $enum = (int)$enum;
    $value = (int)$value;
    return $value &= ( ~$enum );
}

/**
 * Merge bits
 */
function union_enum( array $enums ) {
    $value = 0;
    foreach( $enums as $enum ) {
        $value |= (int)$enum;
    }
    return $value;
}

/**
 * Bit set or not
 */
function is_set( $enum, $value ) {
    $enum = (int)$enum;
    $value = (int)$value;
    return $value & $enum;
}
