<?php

namespace Home\Controller;
use Think\Controller;
use Base\Controller as BaseController;

class HomeBaseController extends BaseController\BaseController {
     public function __construct() {
        parent::__construct();

        $this->_widget();
    }

    /**
     * User widget set
     */
    public $_widget;
    /**
     * Basic user parts
     */
    private $_base_widgets = array (
    );

    /**
     * Add Widgets
     */
    public function _widget() {
        $widgets = $this->_widget;
        if ( empty ( $widgets ) )
            $widgets = array();

        $widgets = array_merge_recursive( $widgets, $this->_base_widgets );
        $a_widget = A( 'Home/Widget' );
        foreach ( $widgets as $widget ) {
            if ( is_callable( array( $a_widget, $widget ) ) ) {
                call_user_func( array( $a_widget, $widget ) );
            }
        }
    }
}


