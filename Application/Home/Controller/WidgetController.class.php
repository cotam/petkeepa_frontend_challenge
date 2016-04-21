<?php

namespace Home\Controller;
use Think\Controller;
use Base\Controller as BaseController;

class WidgetController extends BaseController\WidgetController {
    public function __construct() {
        parent::__construct();
    }

    public function search_filter() {
        global 
             $pet_property_type_enum
            ,$pet_service_provided_enum
            ,$pet_dog_size_accepted_enum
            ,$pet_service_type_enum
            ,$pet_slots_needed_enum
            ,$pet_skill_enum
            ;
        
        $this->assign( 'pet_property_type_enum', $pet_property_type_enum );
        $this->assign( 'pet_service_provided_enum', $pet_service_provided_enum );
        $this->assign( 'pet_dog_size_accepted_enum', $pet_dog_size_accepted_enum );
        $this->assign( 'pet_service_type_enum', $pet_service_type_enum );
        $this->assign( 'pet_slots_needed_enum', $pet_slots_needed_enum );
        $this->assign( 'pet_skill_enum', $pet_skill_enum );

        $this->assign( 'search_info', I( 'get.' ) );

        $this->assign( '_search_filter', $this->fetch( T( 'Home@Widget/search_filter' ) ) );
    }
}
