<?php

namespace User\Model;
use Think\Model as Model;
use Base\Model as BaseModel;

class RateModel extends BaseModel\BaseModel {

    /**
     * RATE existence verification
     */
    public function rate_exist_verifition( $request_data ) {
        $m_rate = M( 'usr_rates' );

        // Primary
        if ( isset( $request_data['usr_login_id'] ) ) {
            $where = array( 'usr_login_id' => $request_data['usr_login_id'] );
        } else if ( isset( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
        } else {
            return false;
        }

        // Conditions

        if ( isset( $request_data['service_type'] ) ) {
            $where['service_type'] = $request_data['service_type'];
        }
        if ( isset( $request_data['pet_type'] ) ) {
            $where['pet_type'] = $request_data['pet_type'];
        }
        if ( isset( $request_data['pet_level'] ) ) {
            $where['pet_level'] = $request_data['pet_level'];
        }
        if ( isset( $request_data['time_slot'] ) ) {
            $where['time_slot'] = $request_data['time_slot'];
        }
        if ( isset( $request_data['duration'] ) ) {
            $where['duration'] = $request_data['duration'];
        }

        $where['status'] = 0;

        return $m_rate->where( $where )->count() > 0;
    }

    /**
     * Update RATE	
     */
    public function update_rate( $request_data ) {
        $m_rate = M( 'usr_rates' );
        
        // Primary
        if ( isset( $request_data['usr_login_id'] ) ) {
            $where = array( 'usr_login_id' => $request_data['usr_login_id'] );
        } else if ( isset( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
        } else {
            return false;
        }
        
        // Conditions
        if ( isset( $request_data['service_type'] ) ) {
            $where['service_type'] = $request_data['service_type'];
        }
        if ( isset( $request_data['pet_type'] ) ) {
            $where['pet_type'] = $request_data['pet_type'];
        }
        if ( isset( $request_data['pet_level'] ) ) {
            $where['pet_level'] = $request_data['pet_level'];
        }

        $where['status'] = 0;

        unset( $request_data[ 'usr_login_id' ] );
        unset( $request_data[ 'id' ] );

        return $m_rate->where( $where )->save( $request_data );
    }

    /**
     * Add RATE
     */
    public function add_rate( $request_data ) {
        $m_rate = M( 'usr_rates' );
		error_log('Here');
        if( ! $m_rate->create( $request_data ) ) {
            return $m_rate->getError();
        } else {
            return $m_rate->add();
        }
    }

    /**
     * Get all RATE
     */
    public function get_rates( $request_data ) {
        $m_rate = M( 'usr_rates' );

        if ( isset ( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
        } else if ( isset( $request_data['usr_login_id'] ) ) {
            $where = array( 'usr_login_id' => $request_data['usr_login_id'] );
        } else {
            return false;
        }

        $where[ 'status' ] = '0';

        return $m_rate->where( $where )->select();
    }

    /**
     * Set RATE opening and partial closing
     */
    public function enable_rates ( $request_data ) {
        $m_rate = M( 'usr_rates' );
        
        if ( isset ( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
        } else if ( isset( $request_data['usr_login_id'] ) ) {
            $where = array( 'usr_login_id' => $request_data['usr_login_id'] );
        } else {
            return false;
        }

        $where['service_type'] = array( 'in', $request_data['service_types'] );
        $m_rate->where( $where )->save( array( 'status' => 0 ) );

        $where['service_type'] = array( 'not in', $request_data['service_types'] );
        $m_rate->where( $where )->save( array( 'status' => 1 ) );

        return true;
    }
    
    /**
     * Get min price
     */
    public function get_minimum_price( $request_data ) {
        $m_rate = M( 'usr_rates' );

        $where = array();
        if ( isset ( $request_data['usr_login_id'] ) ) {
            $where['usr_login_id'] = $request_data['usr_login_id'];
        }

        if ( isset ( $request_data['enabled'] ) ) {
            $where['service_type'] = array( 'exp', " & '{$request_data['enabled']}' != 0 " );
        }

        $where['status'] = '0';

        return $m_rate->where( $where )->order( 'service_type, pet_type, pet_level' )->getField( 'price' );
    }
}
