<?php

namespace Base\Controller;
use Think\Controller;

class WidgetController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function pagination() {
        $this->assign( 'pagination', $this->fetch( T( 'Base@Widget/pagination' ) ) );
    }
}
