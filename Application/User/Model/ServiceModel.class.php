<?php

namespace User\Model;
use \Think\Model as Model;
use \Base\Model as BaseModel;

class ServiceModel extends BaseModel\BaseViewModel {

    public $viewFields = array(
        'service' => array(
            'id' => 'service_id',
            'usr_login_id_seller',
            'usr_login_id_buyer',
            'pet_services',
            'order_id',
            'service_status',
            'cost',
            'meet',
            'start_date', 
            'end_date',
            'pics',
            'canceller',
            'remark',
            'commission',
            '_type' => 'LEFT'
        ),
        'service_payment' => array( 
            'pay_type', 
            'pay_id', 
            'pay_total', 
            'pay_currency', 
            'pay_status', 
        	'payer_id',
			'pay_sale',
            '_on' => 'service.id=service_payment.service_id',
            '_type' => 'LEFT',
        ),
        'seller_info' => array( 
            'first_name' => 'seller_first_name',
            'country_code' => 'seller_country_code',
            'mobile' => 'seller_mobile',
            '_on' => 'service.usr_login_id_seller=seller_info.usr_login_id',
            '_type' => 'LEFT',
            '_table' => 'pet_usr_info'
        ),
        'seller_login' => array (
            'email' => 'seller_email',
            '_on' => 'seller_info.usr_login_id = seller_login.id',
            '_type' => 'LEFT',
            '_table' => 'pet_usr_login',
        ),
        'seller_basiness' => array( 
            'country',
            'division_level_first',
            'division_level_second',
            'division_level_third',
            'service_cancellation',
            'street',
            'area',
            '_on' => 'service.usr_login_id_seller=seller_basiness.usr_login_id',
            '_type' => 'LEFT',
            '_table' => 'pet_usr_basiness'
        ),
        'seller_img' => array( 
            'url' => 'seller_image_url',
            '_on' => 'seller_info.head_img=seller_img.id',
            '_type' => 'LEFT',
            '_table' => 'pet_attachments',
        ),
        'buyer_info' => array (
            'first_name' => 'buyer_first_name',
            'country_code' => 'buyer_country_code',
            'mobile' => 'buyer_mobile',
            'address' => 'buyer_address',
            '_on' => 'service.usr_login_id_buyer = buyer_info.usr_login_id',
            '_type' => 'LEFT',
            '_table' => 'pet_usr_info',
        ),
        'buyer_img' => array( 
            'url' => 'buyer_image_url',
            '_on' => 'buyer_info.head_img = buyer_img.id',
            '_type' => 'LEFT',
            '_table' => 'pet_attachments',
        ),
        'buyer_login' => array (
            'email' => 'buyer_email',
            '_on' => 'buyer_info.usr_login_id = buyer_login.id',
            '_type' => 'LEFT',
            '_table' => 'pet_usr_login',
        ),
        'letter_session' => array (
            'title',
            '_on' => 'service.id = letter_session.service_id',
            '_type' => 'LEFT',
        ),
        'letter_station' => array (
            'letter',
            '_on' => 'letter_session.id = letter_station.session_id',
        ),
    );

    /**
     * Add service record
     */
    public function add_service( $request_data ) {

        $m_service = M( 'service' );
        $m_calendar = M( 'calendar' );
        $m_service_detail = M( 'service_detail' );

        $start_date = 0;
        $end_date = 0;

        $service_id = 0;

        // Basic services
        $base_service = array();
        // Other services
        $other_service = array();
        // Procedures
        $fee_service = array();
        if ( isset( $request_data['base_service'] ) && is_array( $request_data['base_service'] ) ) {
            $base_service = $request_data['base_service'];
            unset( $request_data['base_service'] );
        }
        if ( isset( $request_data['other_service'] ) && is_array( $request_data['other_service'] ) ) {
            $other_service = $request_data['other_service'];
            unset( $request_data['other_service'] );
        }
        if ( isset( $request_data['fee_service'] ) && is_array( $request_data['fee_service'] ) ) {
            $fee_service = $request_data['fee_service'];
            unset( $request_data['fee_service'] );
        }

        if ( isset( $request_data['pics'] ) && is_array( $request_data['pics'] ) ) {
            $request_data['pics'] = serialize( $request_data['pics'] );
        }

        if ( isset( $request_data['start_date'] ) || isset( $request_data['end_date'] ) ) {
            $start_date = strtotime( date( 'Ymd', $request_data['start_date'] ) );
            $end_date = strtotime( date( 'Ymd', $request_data['end_date'] ) );
        }

        // Create new service entry
        if( ! $m_service->create( $request_data ) ) {
            return false;
        } else {
            $service_id = $m_service->add();
        }

        // Store service date List
        if ( 0 !== $service_id && 0 !== $start_date && 0 !== $end_date ) {
            do {
                // Store basic service entry
                if ( $m_calendar->create( array(
                    'service_id' => $service_id,
                    'year' => date( 'Y', $start_date ),
                    'month' => date( 'm', $start_date ),
                    'day' => date( 'd', $start_date ),
                ) ) ) {
                    $m_calendar->add();
                } else {
                    // todo: rollback
                }

                $start_date = strtotime( '+1 day', $start_date );
            } while ( $start_date < $end_date );
        }

        // Store basic service entry
        foreach( $base_service as $service ) {
            $service['service_id'] = $service_id;
            if ( $m_service_detail->create( $service ) ) {
                $m_service_detail->add();
            }
        }
        // Store additional service entry
        foreach( $other_service as $service ) {
            $service['service_id'] = $service_id;
            if ( $m_service_detail->create( $service ) ) {
                $m_service_detail->add();
            }
        }
        // Store handling fee service entry
        if ( ! empty( $fee_service ) ) {
            $fee_service['service_id'] = $service_id;
            if ( $m_service_detail->create( $fee_service ) ) {
                $m_service_detail->add();
            }
        }

        return $service_id;
    }

    /**
     * Verify service existence
     */
    public function service_exist_verifition ( $request_data ) {
        $m_service = M( 'service' );

        $where = array();
        if ( isset( $request_data['usr_login_id_seller'] ) ) {
            $where['usr_login_id_seller'] = $request_data['usr_login_id_seller'];
        }
        if ( isset( $request_data['usr_login_id_buyer'] ) ) {
            $where['usr_login_id_buyer'] = $request_data['usr_login_id_buyer'];
        }
        if ( isset( $request_data['service_status'] ) ) {
            $where['service_status'] = is_array( $request_data['service_status'] ) ? array( 'in', $request_data['service_status'] ) : $request_data['service_status'];
        }

        if ( empty ( $where ) ) {
            return false;
        }

        $where['status'] = 0;

        return $m_service->where( $where )->count() > 0;
    }

    /**
     * Update service
     */
    public function update_service( $request_data ) {
        $m_service = M( 'service' );

        if ( isset( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
            unset( $request_data['id'] );
        } else {
            return false;
        }

        if ( isset( $request_data['pics'] ) && is_array( $request_data['pics'] ) ) {
            $request_data['pics'] = serialize( $request_data['pics'] );
        }

        if ( isset( $request_data['cost_detail'] ) && is_array( $request_data['cost_detail'] ) ) {
            $request_data['cost_detail'] = serialize( $request_data['cost_detail'] );
        }

        return $m_service->where( $where )->save( $request_data );
    }

    /**
     * Get date-time schedule
     */
    public function get_service_calendar( $request_data ) {
        $m_model = new \Think\Model();

        if ( ! isset( $request_data['usr_login_id_seller'] ) || ! isset( $request_data['start_date'] ) || ! isset( $request_data['end_date'] ) ) {
            return false;
        }

        $service_status = "";
        if ( isset( $request_data['service_status'] ) ) {
            $service_status = "AND `pet_service`.`service_status` = '{$request_data['service_status']}'";
        }

        $group = "`date`";
        if ( isset( $request_data['group'] ) ) {
            $group = "`{$request_data['group']}`";
        }

        $sql = "
            SELECT 
                CONCAT( `pet_calendar`.`year`, LPAD( `pet_calendar`.`month`, 2, '0' ), LPAD( `pet_calendar`.`day`, 2, '0' ) ) as `date`,
                `pet_service`.`service_status` as `service_status`,
                `pet_calendar`.`id` as `id`,
                `pet_service`.`id` as `service_id`,
                `pet_service`.`pet_services` as `pet_services`,
                count(*) as `count`
            FROM
                `pet_service`
            INNER JOIN
                `pet_calendar`
            ON
                `pet_service`.`id` = `pet_calendar`.`service_id`
		    /*INNER JOIN*/
			LEFT OUTER JOIN
				`pet_service_detail`
			ON
				`pet_service`.`id` = `pet_service_detail`.`service_id`
				AND
                `pet_service_detail`.`service_type` = '1'
            WHERE
                `pet_service`.`usr_login_id_seller` = '%1\$s'
            AND
                `pet_service`.`service_status` NOT IN ( '0','4', '7' )
            /*AND
                `pet_service_detail`.`service_type` = '1'*/
            AND
                `pet_calendar`.`status` = '0'
                %2\$s
            GROUP BY
                %5\$s
            HAVING
                `date` >= '%3\$s'
            AND
                `date` < '%4\$s'
            ";

        $sql = sprintf( $sql,
            $request_data['usr_login_id_seller'], 
            $service_status,
            date( 'Ymd', $request_data['start_date'] ), 
            date( 'Ymd', $request_data['end_date'] ),
            $group
        );
        $result = $m_model->query( $sql );

        return $result;
    }

    function get_service_detail( $request_data ) {
        $m_detail = M( 'service_detail' );

        $where = array();

        if ( isset( $request_data['service_id'] ) ) {
            $where['service_id'] = $request_data['service_id'];
        }
        if ( isset( $request_data['service_type'] ) ) {
            $where['service_type'] = $request_data['service_type'];
        }

        if ( empty( $where ) ) {
            return false;
        }

        $where['status'] = '0';

        return $m_detail->where( $where )->select();
    }

    /**
     * Bank transfer column return to service detailed info
     */
    function get_service_detail_columns( $request_data ) {
        $m_detail = M( 'service_detail' );

        $sql = "
            SELECT 
                `service_id`,
                Max( CASE WHEN `service_provided` = '1' AND `pet_size_accepted` = '1' AND `service_type` = '1' THEN `cost` ELSE 0 END ) AS `cost_1_1_1`,
                Max( CASE WHEN `service_provided` = '1' AND `pet_size_accepted` = '2' AND `service_type` = '1' THEN `cost` ELSE 0 END ) AS `cost_1_2_1`,
                Max( CASE WHEN `service_provided` = '1' AND `pet_size_accepted` = '4' AND `service_type` = '1' THEN `cost` ELSE 0 END ) AS `cost_1_4_1`,
                Max( CASE WHEN `service_provided` = '2' AND `pet_size_accepted` = '0' AND `service_type` = '1' THEN `cost` ELSE 0 END ) AS `cost_2_0_1`,

                Max( CASE WHEN `service_provided` = '1' AND `pet_size_accepted` = '1' AND `service_type` = '2' THEN `cost` ELSE 0 END ) AS `cost_1_1_2`,
                Max( CASE WHEN `service_provided` = '1' AND `pet_size_accepted` = '2' AND `service_type` = '2' THEN `cost` ELSE 0 END ) AS `cost_1_2_2`,
                Max( CASE WHEN `service_provided` = '1' AND `pet_size_accepted` = '4' AND `service_type` = '2' THEN `cost` ELSE 0 END ) AS `cost_1_4_2`,
                Max( CASE WHEN `service_provided` = '2' AND `pet_size_accepted` = '0' AND `service_type` = '2' THEN `cost` ELSE 0 END ) AS `cost_2_0_2`,

                Max( CASE WHEN `service_provided` = '1' AND `service_type` = '128' THEN `cost` ELSE 0 END ) AS `cost_128`,
                Max( CASE WHEN `service_provided` = '2' AND `service_type` = '256' THEN `cost` ELSE 0 END ) AS `cost_256`,

                Max( CASE WHEN `service_type` = '8' THEN `cost` ELSE 0 END ) AS `cost_8`,
                Max( CASE WHEN `service_type` = '16' THEN `cost` ELSE 0 END ) AS `cost_16`,
                Max( CASE WHEN `service_type` = '32' THEN `cost` ELSE 0 END ) AS `cost_32`,
                Max( CASE WHEN `service_type` = '64' THEN `cost` ELSE 0 END ) AS `cost_64`,

                Max( CASE WHEN `service_type` = '1024' THEN `cost` ELSE 0 END ) AS `cost_1024`,

                Max( CASE WHEN `service_provided` = '1' AND `pet_size_accepted` = '1' AND `service_type` = '1' THEN `amount` ELSE 0 END ) AS `amount_1_1_1`,
                Max( CASE WHEN `service_provided` = '1' AND `pet_size_accepted` = '2' AND `service_type` = '1' THEN `amount` ELSE 0 END ) AS `amount_1_2_1`,
                Max( CASE WHEN `service_provided` = '1' AND `pet_size_accepted` = '4' AND `service_type` = '1' THEN `amount` ELSE 0 END ) AS `amount_1_4_1`,
                Max( CASE WHEN `service_provided` = '2' AND `pet_size_accepted` = '0' AND `service_type` = '1' THEN `amount` ELSE 0 END ) AS `amount_2_0_1`,

                Max( CASE WHEN `service_provided` = '1' AND `pet_size_accepted` = '1' AND `service_type` = '2' THEN `amount` ELSE 0 END ) AS `amount_1_1_2`,
                Max( CASE WHEN `service_provided` = '1' AND `pet_size_accepted` = '2' AND `service_type` = '2' THEN `amount` ELSE 0 END ) AS `amount_1_2_2`,
                Max( CASE WHEN `service_provided` = '1' AND `pet_size_accepted` = '4' AND `service_type` = '2' THEN `amount` ELSE 0 END ) AS `amount_1_4_2`,
                Max( CASE WHEN `service_provided` = '2' AND `pet_size_accepted` = '0' AND `service_type` = '2' THEN `amount` ELSE 0 END ) AS `amount_2_0_2`,

                Max( CASE WHEN `service_provided` = '1' AND `service_type` = '128' THEN `amount` ELSE 0 END ) AS `amount_128`,
                Max( CASE WHEN `service_provided` = '2' AND `service_type` = '256' THEN `amount` ELSE 0 END ) AS `amount_256`,

                Max( CASE WHEN `service_type` = '8' THEN `amount` ELSE 0 END ) AS `amount_8`,
                Max( CASE WHEN `service_type` = '16' THEN `amount` ELSE 0 END ) AS `amount_16`,
                Max( CASE WHEN `service_type` = '32' THEN `amount` ELSE 0 END ) AS `amount_32`,
                Max( CASE WHEN `service_type` = '64' THEN `amount` ELSE 0 END ) AS `amount_64`
            FROM
                `pet_service_detail`
            WHERE
                %s
            GROUP BY 
                `service_id`;
            ";

        $where = '';

        if ( isset( $request_data['ids'] ) ) {
            $where .= 'service_id in (' . implode( ',', $request_data['ids'] ) . ')';
        } else if ( isset( $request_data['id'] ) ) {
            $where .= "service_id = '{$request_data['id']}'";
        }

        if ( empty( $where ) ) {
            return false;
        }

        $sql = sprintf( $sql, $where );

        return $m_detail->query( $sql );
    }

    public function get_last_orders() {
        $time_start = date( 'Y-m-d 00:00:00' );
        $end_start = date( 'Y-m-d 23:59:59' );

        $sql = "SELECT count(*) as `count` FROM `pet_service` WHERE `submit_time` BETWEEN '{$time_start}' AND '{$end_start}'";

        $res = $this->query( $sql );
        return $res[0]['count'];
    }

    /**
     * Get service record
     */
    public function get_service( $request_data ) {
        $where = array();

        if ( isset( $request_data['usr_login_id_seller'] ) ) {
            $where['service.usr_login_id_seller'] = $request_data['usr_login_id_seller'];
        }

        if ( isset( $request_data['usr_login_id_buyer'] ) ) {
            $where['service.usr_login_id_buyer'] = $request_data['usr_login_id_buyer'];
        }

        if ( isset( $request_data['service_status'] ) ) {
            if ( is_array( $request_data['service_status'] ) ) {
                $where['service.service_status'] = array( 'in', $request_data['service_status'] );
            } else {
                $where['service.service_status'] = $request_data['service_status'];
            }
        }

        if ( isset( $request_data['id'] ) ) {
            $where['service.id'] = $request_data['id'];
        }

        if ( empty( $where ) ) {
            return false;
        }

        $where['service.status'] = '0';

        $service = $this->where( $where )->group( 'service_id' )->find();

        if ( ! empty( $services ) ) {
            foreach( $services as $key => $service ) {
                if ( ! empty( $service['pics'] ) ) {
                    $services[ $key ]['pics'] = unserialize( $service['pics'] );
                }
                if ( ! empty( $service ) && ! empty( $service['cost_detail'] ) ) {
                    $services[ $key ]['cost_detail'] = unserialize( $service['cost_detail'] );
                }
            }
        }
        
        if ( ! empty( $service ) && ! empty( $service['pics'] ) ) {
            $service['pics'] = unserialize( $service['pics'] );
        }

        return $service;
    }

    /**
     * Get service record list
     */
    public function get_services( $request_data ) {
        $where = array();

        if ( isset( $request_data['usr_login_id_seller'] ) ) {
            $where['service.usr_login_id_seller'] = $request_data['usr_login_id_seller'];
        }

        if ( isset( $request_data['usr_login_id_buyer'] ) ) {
            $where['service.usr_login_id_buyer'] = $request_data['usr_login_id_buyer'];
        }

        if ( isset( $request_data['service_status'] ) ) {
            if ( is_array( $request_data['service_status'] ) ) {
                $where['service.service_status'] = array( 'in', $request_data['service_status'] );
            } else {
                $where['service.service_status'] = $request_data['service_status'];
            }
        }
        
        if ( isset( $request_data['pay_status'] ) ) {
            if ( is_array( $request_data['pay_status'] ) ) {
                $where['service_payment.pay_status'] = array( 'in', $request_data['pay_status'] );
            } else {
                $where['service_payment.pay_status'] = $request_data['pay_status'];
            }
        }

        // Conditions for start time OR end time to to be within current range
        if ( isset( $request_data['start_date'] ) && isset( $request_data['start_date'] ) ) {
            $w['service.start_date'] = array( 'between', array( $request_data['start_date'], $request_data['end_date'] ) );
            $w['service.end_date'] = array( 'between', array( $request_data['start_date'], $request_data['end_date'] ) );
            $w['_logic'] = 'or';
            $where['_complex'] = $w;
        }

        if ( isset( $request_data['id'] ) ) {
            $where['service.id'] = $request_data['id'];
        }

        if ( isset( $request_data['ids'] ) ) {
            $where['service.id'] = array ( 'in', $request_data['id'] );
        }

        if ( empty( $where ) ) {
            return false;
        }

        $where['service.status'] = '0';
		
        $services = $this->where( $where )->group( 'service_id' )->order( 'service.submit_time desc' )->limit( ( ! empty( $request_data['paged'] ) ? ( $request_data['paged'] - 1 ) * C( 'PAGED' ) : 0 ), C( 'PAGED' ) )->select();

        if ( ! empty( $services ) ) {
            foreach( $services as $key => $service ) {
                if ( ! empty( $service['pics'] ) ) {
                    $services[ $key ]['pics'] = unserialize( $service['pics'] );
                }
                if ( ! empty( $service ) && ! empty( $service['cost_detail'] ) ) {
                    $services[ $key ]['cost_detail'] = unserialize( $service['cost_detail'] );
                }
            }
        }

        return $services;
    }
	
	/**
     * Get counts of bookings that the host has yet to take action on.
     */
    public function get_newbooking_count( $request_data ) {
        $where = array();

        if ( isset( $request_data['usr_login_id_seller'] ) ) {
            $where['service.usr_login_id_seller'] = $request_data['usr_login_id_seller'];
        }
		
        $where['service.service_status'] = '1';
		$where['service.start_date'] > strtotime( date( 'Ymd'));

        if ( empty( $where ) ) {
            return false;
        }

        $services = $this->where( $where )->count();

        return $services;
    }

    
    /**
     * Get records count on service record list
     */
    public function get_services_count( $request_data ) {
        $where = array();

        if ( isset( $request_data['usr_login_id_seller'] ) ) {
            $where['service.usr_login_id_seller'] = $request_data['usr_login_id_seller'];
        }

        if ( isset( $request_data['usr_login_id_buyer'] ) ) {
            $where['service.usr_login_id_buyer'] = $request_data['usr_login_id_buyer'];
        }

        if ( isset( $request_data['service_status'] ) ) {
            if ( is_array( $request_data['service_status'] ) ) {
                $where['service.service_status'] = array( 'in', $request_data['service_status'] );
            } else {
                $where['service.service_status'] = $request_data['service_status'];
            }
        }
         
        if ( isset( $request_data['pay_status'] ) ) {
            if ( is_array( $request_data['pay_status'] ) ) {
                $where['service_payment.pay_status'] = array( 'in', $request_data['pay_status'] );
            } else {
                $where['service_payment.pay_status'] = $request_data['pay_status'];
            }
        }


        // Conditions for start time OR end time to to be within current range
        if ( isset( $request_data['start_date'] ) && isset( $request_data['start_date'] ) ) {
            $w['service.start_date'] = array( 'between', array( $request_data['start_date'], $request_data['end_date'] ) );
            $w['service.end_date'] = array( 'between', array( $request_data['start_date'], $request_data['end_date'] ) );
            $w['_logic'] = 'or';
            $where['_complex'] = $w;
        }

        if ( isset( $request_data['id'] ) ) {
            $where['service.id'] = $request_data['id'];
        }

        if ( isset( $request_data['ids'] ) ) {
            $where['service.id'] = array ( 'in', $request_data['id'] );
        }

        if ( empty( $where ) ) {
            return false;
        }

        $where['service.status'] = '0';

        $services = $this->where( $where )->group( 'service_id' )->count();

        return $services;
    }

    /**
     * Delete service record
     */
    function del_service( $request_data ) {
        $m_service = M( 'service' );
        $m_detail = M( 'service_detail' );
        $m_calendar = M( 'calendar' );

        if ( isset( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
            $calendar_where = array( 'service_id' => $request_data['id'] );
            $detail_where = array( 'service_id' => $request_data['id'] );
        } else {
            return false;
        }
        $m_service->where( $where )->save( array( 'status' => '1' ) );
        $m_calendar->where( $calendar_where )->save( array( 'status' => '1' ) );
        $m_detail->where( $detail_where )->save( array( 'status' => '1' ) );

        return ;
    }

    /**
     * Clear all service entries with calendar is empty OR service details is empty
     */
    function clean_service( $request_data ) {
        $m_model = new \Think\Model();

        if ( ! isset( $request_data['usr_login_id_seller'] ) ) {
            return false;
        }
        $sql = "
            UPDATE 
                `pet_service`
            SET
                `status` = '1' 
            WHERE
            (
                SELECT 
                    count( * ) 
                FROM 
                    `pet_calendar` 
                WHERE 
                    `pet_service`.`id` = `pet_calendar`.`service_id`
                AND
                    `pet_calendar`.`status` = '0'
            ) = '0'
            AND
                `status` = '0'
            AND
                `usr_login_id_seller` = '{$request_data['usr_login_id_seller']}'
            ";

        return $m_model->execute( $sql );
    }

    /**
     * Delete calendar
     */
    function del_calendar( $request_data ) {
        $m_calendar = M( 'calendar' );

        if ( isset( $request_data['ids'] ) ) {
            $where = array( 'id' => array( 'in', $request_data['ids'] ) );
        } else {
            return false;
        }

        $m_calendar->where( $where )->save( array( 'status' => '1' ) );
    }
    
    /**
     * Deal Expire
     */
    function deal_expire($lists=array()){
    	if($lists==array()){
    		return false;
    	}
    	foreach($lists as $key=>$list){
    		$expire=false;
    		switch($list['service_status']){
    			case 8:
    				if($list['end_date']<time()){
    					$expire=true;
    					$service_status=9;
    				}
    				break;
    		}
    		if($expire){
    			$m_service = M( 'service' );
    			$this->update_service(array(
    					'id'=>$list['service_id'],
    					'service_status'=>$service_status
    			));
    			unset($lists[$key]);
    		}
    	}
    	return $lists;
    }
}
