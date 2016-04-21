<?php

namespace Home\Controller;
use Think\Controller as Controller;
use Base\Controller as BaseController;

/**
 * Homepage and single-page controller
 */
class IndexController extends BaseController\BaseController {
   
    public function index() {
        $this->display();
    }

    public function FAQ_host() {
        $this->display();
    }

    public function FAQ_user() {
        $this->display();
    }
    
    public function about() {
        $this->display();
    }

    public function become_host() {
        $this->display();
    }

    public function privacy_policy() {
        $this->display();
    }

    public function terms_conditions() {
        $this->display();
    }

    public function how_it_works() {
        $this->display();
    }
}
