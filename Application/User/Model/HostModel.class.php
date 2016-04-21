<?php

namespace User\Model;
use Think\Model as Model;
use Base\Model as BaseModel;

class HostModel extends BaseModel\BaseViewModel {

    public $viewFields = array (
        'usr_basiness' => array (
            '`usr_login_id`',
            '`property_type`',
            '`property_other`',
            '`yard_type`',
            '`resident_pets`',
            '`title`',
            '`pics`',
            '`self_description`',
            '`additional`',
            '`service_provided`',
            '`service_size_accepted`',
            '`service_breeds`',
            '`service_not_restrictions`',
            '`service_cancellation`',
            '`service_additional`',
            '`expreience`',
            '`skills`',
            '`service_types`',
            '`score`',
            '`comments`',
            '`minimum_price`',
            '`country`',
            '`division_level_first`',
            '`division_level_second`',
            '`division_level_third`',
            '`zip_code`',
            '`street`',
            '`area`',
            '`lat`',
            '`lng`',

            '`response`',
            '`response_time`',

            '`submit_time`',
            '_type' => 'left',
        ),
        'usr_info' => array (
            '`first_name`' => '`first_name`',
            '`last_name`' => '`last_name`',
            '`gender`' => '`gender`',
            '`country_code`' => '`country_code`',
            '`mobile`' => '`mobile`',
			'pet_name' => 'pet_name',
			'pet_gender' => 'pet_gender',
			'pet_age' => 'pet_age',
			'pet_is_neutered' => 'pet_is_neutered',
			'pet_head_img' => 'pet_head_img',
            '_type' => 'left',
            '_on' => 'usr_basiness.`usr_login_id` = usr_info.`usr_login_id`',
        ),
        'usr_login' => array (
            '`email`' => '`email`',
            '`latest_date`' => '`latest_date`',
            '_type' => 'left',
            '_on' => 'usr_login.`id` = usr_basiness.`usr_login_id`',
        ),
        'attachments' => array (
            '`url`' => '`head_img_url`',
            '_on' => 'usr_info.`head_img` = attachments.`id`',
        ),
    );

    /**
     * HOST existence verification
     */
    public function host_exist_verifition( $request_data ) {
        $m_host = M( 'usr_basiness' );
        if ( isset( $request_data['usr_login_id'] ) ) {
            $where = array( 'usr_login_id' => $request_data['usr_login_id'] );
        } else if ( isset( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
        } else {
            return false;
        }

        $where['status'] = 0;

        return $m_host->where( $where )->count() > 0;
    }

    /**
     * Add host
     */
    public function host_add( $request_data ) {
        $m_host = M( 'usr_basiness' );

        if ( ! empty( $request_data['pics'] ) ) {
            $request_data['pics'] = serialize( $request_data['pics'] );
        }

        if ( ! $m_host->create( $request_data ) ) {
            return false;
        } else {
            return $m_host->add();
        }
    }

    /**
     * Update host
     */
    public function host_update( $request_data ) {
        $m_host = M( 'usr_basiness' );

        if ( isset( $request_data['usr_login_id'] ) ) {
            $where = array( 'usr_login_id' => $request_data['usr_login_id'] );
            unset( $request_data[ 'usr_login_id' ] );
        } else if ( isset( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
            unset( $request_data[ 'id' ] );
        } else {
            return false;
        }

        if ( ! empty( $request_data['pics'] ) ) {
            $request_data['pics'] = serialize( $request_data['pics'] );
        }

        $where['status'] = 0;

        return $m_host->where( $where )->save( $request_data );
    }

    /**
     * Get host
     */
    public function get_host( $request_data ) {
        $where = array();

        if ( isset ( $request_data['id'] ) ) {
            array_push( $where, "`usr_basiness`.`id` = '{$request_data['id']}'" );
        }
        if ( isset( $request_data['usr_login_id'] ) ) {
            array_push( $where, "`usr_basiness`.`usr_login_id` = '{$request_data['usr_login_id']}'" );
        }

        if ( empty( $where ) ) {
            return false;
        }

        array_push( $where, "`usr_basiness`.`status` = '0'" );
        $where = implode( ' AND ', $where );
        $host = $this->where( $where )->find();

        if ( ! empty( $host ) && ! empty ( $host['pics'] ) ) {
            $host['pics'] = unserialize( $host['pics'] );
        }
        
        return $host;
    }

    /**
     * Get host list
     */
    public function get_hosts( $request_data ) {
        $where = array();

        if ( isset ( $request_data['id'] ) ) {
            array_push( $where, "`usr_basiness`.`id` = '{$request_data['id']}'" );
        }
        if ( isset( $request_data['usr_login_id'] ) ) {
            array_push( $where, "`usr_basiness`.`usr_login_id` = '{$request_data['usr_login_id']}'" );
        } 
        if ( isset( $request_data['ids'] ) ) {
            array_push( $where, "`usr_basiness`.`usr_login_id` IN ( " . implode( ',', $request_data['ids'] ) . " )" );
        } 
        if ( empty( $where ) ) {
            return false;
        }

        array_push( $where, "`usr_basiness`.`status` = '0'" );

        $hosts = $this->where( $where )->limit( ( ! empty( $request_data['paged'] ) ? ( $request_data['paged'] - 1 ) * C( 'PAGED' ) : 0 ), C( 'PAGED' ) )->select();

        return $hosts;
    }
    
    /**
     * Get HOST list total
     */
    public function get_hosts_count( $request_data ) {
        $where = array();

        if ( isset ( $request_data['id'] ) ) {
            array_push( $where, "`usr_basiness`.`id` = '{$request_data['id']}'" );
        }
        if ( isset( $request_data['usr_login_id'] ) ) {
            array_push( $where, "`usr_basiness`.`usr_login_id` = '{$request_data['usr_login_id']}'" );
        } 
        if ( isset( $request_data['ids'] ) ) {
            array_push( $where, "`usr_basiness`.`usr_login_id` IN ( " . implode( ',', $request_data['ids'] ) . " )" );
        } 
        if ( empty( $where ) ) {
            return false;
        }

        array_push( $where, "`usr_basiness`.`status` = '0'" );

        $hosts = $this->where( $where )->count();

        return $hosts;
    }
}
