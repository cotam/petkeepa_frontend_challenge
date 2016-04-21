<?php

namespace Base\Model;
use Think\Model;

class LogModel extends BaseModel {
    public function add_log( $request_data ) {
        $m_log = M( 'log' );
        $m_log->data( $request_data )->add();
    }
}
