<?php

namespace Home\Model;
use Think\Model as Model;
use Base\Model as BaseModel;

class SearchModel extends BaseModel\BaseModel {

    /**
     * search HOST
     */
    public function get_hosts( $search_data ) {
        $m_search = new \Think\Model();

        $weight = array();
        // Weight sort field
        // %1\$s
        if ( isset( $search_data['keywords'] ) ) {
            array_push( $weight, "( `usr_basiness`.`country` REGEXP '({$search_data['keywords']})' )" );
            array_push( $weight, "( `usr_basiness`.`division_level_first` REGEXP '({$search_data['keywords']})' )" );
            array_push( $weight, "( `usr_basiness`.`division_level_second` REGEXP '({$search_data['keywords']})' )" );
            array_push( $weight, "( `usr_basiness`.`division_level_third` REGEXP '({$search_data['keywords']})' )" );
            array_push( $weight, "( `usr_basiness`.`street` REGEXP '({$search_data['keywords']})' )" );
            array_push( $weight, "( `usr_basiness`.`area` REGEXP '({$search_data['keywords']})' )" );

            array_push( $weight, "( `usr_basiness`.`title` REGEXP '({$search_data['keywords']})' )" );
            array_push( $weight, "( `usr_basiness`.`self_description` REGEXP '({$search_data['keywords']})' )" );
        }
       
        $sql = "
            SELECT 
            SQL_CALC_FOUND_ROWS
                `usr_info`.`usr_login_id` as `usr_login_id`,
                `usr_info`.`first_name` as `first_name`,
                `usr_info`.`last_name` as `last_name`,

                `usr_login`.`latest_date` as `latest_date`,

                `attachments`.`url` as `head_img_url`,

                `usr_basiness`.`id` as `basiness_id`,
                `usr_basiness`.`title` as `title`,
                `usr_basiness`.`self_description` as `self_description`,
                `usr_basiness`.`minimum_price` as `minimum_price`,
                `usr_basiness`.`score` as `score`,
                `usr_basiness`.`comments` as `comments`,

                `usr_basiness`.`division_level_first` as `division_level_first`,
                `usr_basiness`.`division_level_second` as `division_level_second`,
                `usr_basiness`.`division_level_third` as `division_level_third`,
                `usr_basiness`.`street` as `street`,
                `usr_basiness`.`area` as `area`,

                `usr_basiness`.`lat` as `lat`,
                `usr_basiness`.`lng` as `lng`

                %1\$s

                %4\$s
            FROM
                `pet_usr_basiness` as `usr_basiness`
            LEFT JOIN
                `pet_usr_info` as `usr_info`
            ON
                `usr_basiness`.`usr_login_id` = `usr_info`.`usr_login_id`
            LEFT JOIN
                `pet_usr_login` as `usr_login`
            ON
                `usr_basiness`.`usr_login_id` = `usr_login`.`id`
            LEFT JOIN
                `pet_attachments` as `attachments`
            ON
                `usr_info`.`head_img` = `attachments`.`id`

            %2\$s

            %3\$s

            %6\$s

            %5\$s
            ";

        // Conditional field
        // %2\$s
        $where = array();
        
        if ( isset( $search_data['property_type'] ) ) {
             array_push( $where, "`usr_basiness`.`property_type`='{$search_data['property_type']}'" );
            //array_push( $where, "( ( `usr_basiness`.`property_type` & '{$search_data['property_type']}' ) != 0 )" );
        }
        if ( isset( $search_data['yard_type'] ) ) {
            array_push( $where, "`usr_basiness`.`yard_type`='{$search_data['yard_type']}'" );
        }
        if ( isset( $search_data['service_types'] ) ) {
            array_push( $where, "( ( `usr_basiness`.`service_types` & '{$search_data['service_types']}' )='{$search_data['service_types']}' )" );
        }
        if ( isset( $search_data['service_provided'] ) ) {
            array_push( $where, "( ( `usr_basiness`.`service_provided` & '{$search_data['service_provided']}' )='{$search_data['service_provided']}' )" );
        }
        if ( isset( $search_data['service_size_accepted'] ) ) {
            array_push( $where, "( ( `usr_basiness`.`service_size_accepted` & '{$search_data['service_size_accepted']}' )='{$search_data['service_size_accepted']}' )" );
        }
        if ( isset( $search_data['skills'] ) ) {
            array_push( $where, "( ( `usr_basiness`.`skills` & '{$search_data['skills']}' )='{$search_data['skills']}' )" );
        }

        if ( isset( $search_data['resident_pets'] ) ) {
            array_push( $where, "`usr_basiness`.`resident_pets`!='0'" );
        }
        if ( isset( $search_data['price'] ) ) {
            array_push( $where, "`usr_basiness`.`minimum_price`<='{$search_data['price']}'" );
        }
        if ( isset( $search_data['score'] ) ) {
            array_push( $where, "`usr_basiness`.`score`>='{$search_data['score']}'" );
        }
        if ( 
            isset( $search_data['north_east_lat'] ) && 
            isset( $search_data['north_east_lng'] ) && 
            isset( $search_data['south_west_lat'] ) && 
            isset( $search_data['south_west_lng'] ) ) {
            array_push( $where, "`usr_basiness`.`lat` < '{$search_data['north_east_lat']}' and `usr_basiness`.`lat` > '{$search_data['south_west_lat']}' and `usr_basiness`.`lng` < '{$search_data['north_east_lng']}' and `usr_basiness`.`lng` > '{$search_data['south_west_lng']}'" );
        }

        array_push( $where, "`usr_info`.`head_img` != '0'" );
        array_push( $where, "`usr_info`.`gender` != '0'" );
        array_push( $where, "`usr_info`.`first_name` != ''" );
        array_push( $where, "`usr_info`.`last_name` != ''" );
        array_push( $where, "`usr_info`.`country_code` != '0'" );
        array_push( $where, "`usr_info`.`mobile` != '0'" );

        array_push( $where, "( ( `usr_basiness`.`property_type` != '0' AND `usr_basiness`.`property_type` != '4' ) OR ( `usr_basiness`.`property_type` = '4' AND `usr_basiness`.`property_other` != '' ) )" );
        array_push( $where, "`usr_basiness`.`title` != ''" );
        array_push( $where, "`usr_basiness`.`pics` != ''" );
        array_push( $where, "`usr_basiness`.`self_description` != ''" );
        array_push( $where, "`usr_basiness`.`service_provided` != '0'" );
        array_push( $where, "( `usr_basiness`.`service_breeds` != '0' OR ( `usr_basiness`.`service_breeds` = '0' AND `usr_basiness`.`service_not_restrictions` != '' ) )" );
        array_push( $where, "`usr_basiness`.`service_cancellation` != '0'" );
        array_push( $where, "`usr_basiness`.`country` != '0'" );
        array_push( $where, "`usr_basiness`.`division_level_first` != ''" );
        array_push( $where, "`usr_basiness`.`division_level_second` != ''" );
        array_push( $where, "`usr_basiness`.`division_level_third` != ''" );
        array_push( $where, "`usr_basiness`.`zip_code` != ''" );
        array_push( $where, "`usr_basiness`.`street` != ''" );
        //array_push( $where, "`usr_basiness`.`area` != ''" );
        array_push( $where, "`usr_basiness`.`lat` != '0'" );
        array_push( $where, "`usr_basiness`.`lng` != '0'" );

        array_push( $where, "`usr_basiness`.`service_types` != '0'" );
        array_push( $where, "`usr_basiness`.`minimum_price` != '0'" );

        // Sort Field
        // %3\$s
        $order = array();

        if ( ! empty( $weight ) ) {
            array_push( $order, '`weight` DESC' );
        }

        if ( isset( $search_data['sort_order'] ) ) {
            switch( $search_data['sort_order'] ) {
            case 1:
                // Price high to low
                array_push( $order, '`usr_basiness`.`minimum_price` DESC' );
                break;
            case 2:
                // Price low to high
                array_push( $order, '`usr_basiness`.`minimum_price` ASC' );
                break;
            case 3:
                // Review score
                array_push( $order, '`usr_basiness`.`score` DESC' );
                break;
            case 4:
                // Response Time
                array_push( $order, '`usr_basiness`.`response_time` ASC' );
                break;
            }
        }

        // date choose
        // %4\$s
        $service_count = "";
        $days = 0;

        if ( isset( $search_data['checkin'] ) && isset( $search_data['checkout'] ) ) {
            $checkin = strtotime( $search_data['checkin'] );
            $checkout = strtotime( $search_data['checkout'] );
            $year = 0; $month = 0; $day = 0;

            $check_date = array();

            while ( $checkin <= $checkout ) {
                $year = date( 'Y', $checkin );
                $month = date( 'm', $checkin );
                $day = date( 'd', $checkin );

                array_push( $check_date, "( `calendar`.`year` = '{$year}' and `calendar`.`month` = '{$month}' and `calendar`.`day` = '{$day}' )" );
                $days++;

                $checkin = strtotime( '+1 day', $checkin );
            }
            $service_count = "
                , (
                    SELECT 
                        count( * )
                    FROM (
                        SELECT 
                            CONCAT( `calendar`.`year`, `calendar`.`month`, `calendar`.`day` ) `service_date`,
                            count( * ) as `count`,
                            `service`.`usr_login_id_seller` as `usr_login_id_seller`
                        FROM
                            `pet_service` as `service`
                        INNER JOIN
                            `pet_calendar` as `calendar`
                        ON
                            `service`.`id` = `calendar`.`service_id`
                        WHERE
                            `service`.`service_status` = '5'
                        %1\$s
                        GROUP BY
                            `service_date`
                        HAVING
                            `count` > '0'
                        ) as `t_table`
                    WHERE
                        `t_table`.`usr_login_id_seller` = `usr_basiness`.`usr_login_id`
                ) as `busy_days`
                , ( /* Calculate days for NON-onsite service for sitting of at least 1 pet */
                    SELECT 
                        ( %2\$s - count( * ) )
                    FROM (
                        SELECT 
                            CONCAT( `calendar`.`year`, `calendar`.`month`, `calendar`.`day` ) `service_date`,
                            count( * ) as `count`,
                            `service`.`usr_login_id_seller` as `usr_login_id_seller`
                        FROM
                            `pet_service` as `service`
                        INNER JOIN
                            `pet_calendar` as `calendar`
                        ON
                            `service`.`id` = `calendar`.`service_id`
                        WHERE
                            `service`.`service_status` IN ( '1', '2', '6' )
                        AND
                            ( ( `service`.`pet_services` & 2 ) = 0 )
                        %1\$s
                        GROUP BY
                            `service_date`
                        HAVING
                            `count` >= '3'
                        ) as `t_table`
                    WHERE
                        `t_table`.`usr_login_id_seller` = `usr_basiness`.`usr_login_id`
                ) as `one_slot`
                , ( /* Calculate days for onsite service for sitting of at least 1 pet */
                    SELECT 
                        ( %2\$s - count( * ) )
                    FROM (
                        SELECT 
                            CONCAT( `calendar`.`year`, `calendar`.`month`, `calendar`.`day` ) `service_date`,
                            count( * ) as `count`,
                            `service`.`usr_login_id_seller` as `usr_login_id_seller`
                        FROM
                            `pet_service` as `service`
                        INNER JOIN
                            `pet_calendar` as `calendar`
                        ON
                            `service`.`id` = `calendar`.`service_id`
                        WHERE
                            `service`.`service_status` IN ( '1', '2', '6' )
                        AND
                            ( ( `service`.`pet_services` & 2 ) != 0 )
                        %1\$s
                        GROUP BY
                            `service_date`
                        HAVING
                            `count` != '0'
                        ) as `t_table`
                    WHERE
                        `t_table`.`usr_login_id_seller` = `usr_basiness`.`usr_login_id`
                ) as `sitting_slot`
                , ( /* Calculate days for NON-onsite service for sitting of at least 2 pets */
                    SELECT 
                        ( %2\$s - count( * ) )
                    FROM (
                        SELECT 
                            CONCAT( `calendar`.`year`, `calendar`.`month`, `calendar`.`day` ) `service_date`,
                            count( * ) as `count`,
                            `service`.`usr_login_id_seller` as `usr_login_id_seller`
                        FROM
                            `pet_service` as `service`
                        INNER JOIN
                            `pet_calendar` as `calendar`
                        ON
                            `service`.`id` = `calendar`.`service_id`
                        WHERE
                            `service`.`service_status` IN ( '1', '2', '6' )
                        AND
                            ( ( `service`.`pet_services` & 2 ) = 0 )
                        %1\$s
                        GROUP BY
                            `service_date`
                        HAVING
                            `count` >= '2'
                        ) as `t_table`
                    WHERE
                        `t_table`.`usr_login_id_seller` = `usr_basiness`.`usr_login_id`
                ) as `tow_slots`
                , ( /* Calculate days for NON-onsite service for sitting of 3 pets */
                    SELECT
                        ( %2\$s - count( * ) )
                    FROM (
                        SELECT 
                            CONCAT( `calendar`.`year`, `calendar`.`month`, `calendar`.`day` ) `service_date`,
                            count( * ) as `count`,
                            `service`.`usr_login_id_seller` as `usr_login_id_seller`
                        FROM
                            `pet_service` as `service`
                        INNER JOIN
                            `pet_calendar` as `calendar`
                        ON
                            `service`.`id` = `calendar`.`service_id`
                        WHERE
                            `service`.`service_status` IN ( '1', '2', '6' )
                        AND
                            ( ( `service`.`pet_services` & 2 ) = 0 )
                        %1\$s
                        GROUP BY
                            `service_date`
                        HAVING
                            `count` >= '1'
                        ) as `t_table`
                    WHERE
                        `t_table`.`usr_login_id_seller` = `usr_basiness`.`usr_login_id`
                ) as `three_slots`
                ";
            $service_count = sprintf( $service_count, ' AND ( ' . implode( ' OR ', $check_date ) . ' )', $days );
        }

        // Group Filter
        // %6\$s
        $having = array();

        if ( isset( $search_data['slots_needed'] ) && isset( $search_data['checkin'] ) && isset( $search_data['checkout'] ) ) {
            switch ( $search_data['slots_needed'] ) {
            case '1':
                // Number of days with AT LEAST 1 slot EQUALS TO selected number of days AND Number of days of accepted onsite sitting EQUALS TO 0 
                array_push( $having, "`busy_days` = '0'" );
                array_push( $having, "`one_slot` = '{$days}'" );
                array_push( $having, "`sitting_slot` = '{$days}'" );
                break;
            case '2':
                // Number of days with AT LEAST 2 slots EQUALS TO selected number of days AND Number of days of accepted onsite sitting EQUALS TO 0
                array_push( $having, "`busy_days` = '0'" );
                array_push( $having, "`tow_slots` = '{$days}'" );
                array_push( $having, "`sitting_slot` = '{$days}'" );
                break;
            case '3':
                // Number of days with AT LEAST 3 slots EQUALS TO selected number of days AND Number of days of accepted onsite sitting EQUALS TO 0
                array_push( $having, "`busy_days` = '0'" );
                array_push( $having, "`three_slots` = '{$days}'" );
                array_push( $having, "`sitting_slot` = '{$days}'" );
                break;
            }
        }

        // Paging
        // %5\$s
        $paged = 'LIMIT %s, %s';
        $paged = sprintf( $paged, ( isset( $search_data['paged'] ) ? ( $search_data['paged'] - 1 ) * C( 'PAGED' ) : '0' ),  C( 'PAGED' ) );

        $sql = sprintf( $sql,
            ( empty( $weight ) ? "" : ", (" . implode( ' + ', $weight )  . ") as `weight`" ),
            ( empty( $where ) ? "" : " WHERE " . implode( ' AND ', $where ) ),
            ( empty( $order ) ? "" : " ORDER BY " . implode( ', ', $order ) ),
            $service_count,
            $paged,
            ( empty( $having ) ? "" : " HAVING " . implode( ' AND ', $having ) )
        );
        $result = $m_search->query( $sql );
        if ( ! empty( $result ) ) {
            foreach( $result as $key => $r ) {
                if ( empty( $r['head_img_url'] ) ) {
                    $result[ $key ]['head_img_url'] = C( 'DEFAULT_HEAD_IMG' );
                }
            }
        }

        return $result;
    }

    public function get_service_limited ( $request_data ) {
        $m_search = new \Think\Model();

        $where = array();
       
        $sql = "
            SELECT 
                %1\$s
            ";

        // Choose date
        // %1\$s
        $service_count = "";

        if ( isset( $request_data['checkin'] ) && isset( $request_data['checkout'] ) ) {
            $checkin = strtotime( date( 'Ymd', strtotime( $request_data['checkin'] ) ) );
            $checkout = strtotime( date( 'Ymd', strtotime( $request_data['checkout'] ) ) );
            $year = 0; $month = 0; $day = 0; $days = 0;

            $check_date = array();

            do {
                $year = date( 'Y', $checkin );
                $month = date( 'm', $checkin );
                $day = date( 'd', $checkin );

                array_push( $check_date, "( `calendar`.`year` = '{$year}' and `calendar`.`month` = '{$month}' and `calendar`.`day` = '{$day}' )" );
                $days++;

                $checkin = strtotime( '+1 day', $checkin );
            } while ( $checkin < $checkout );

            $service_count = "
                (
                    SELECT 
                        count( * )
                    FROM (
                        SELECT 
                            CONCAT( `calendar`.`year`, `calendar`.`month`, `calendar`.`day` ) `service_date`,
                            count( * ) as `count`,
                            `service`.`usr_login_id_seller` as `usr_login_id_seller`
                        FROM
                            `pet_service` as `service`
                        INNER JOIN
                            `pet_calendar` as `calendar`
                        ON
                            `service`.`id` = `calendar`.`service_id`
                        WHERE
                            `service`.`service_status` = '5'
                        %1\$s
                        GROUP BY
                            `service_date`
                        HAVING
                            `count` > '0'
                        ) as `t_table`
                    WHERE
                        `t_table`.`usr_login_id_seller` = %2\$s
                ) as `busy_days`
                , (
                    SELECT 
                        ( %3\$s - COUNT( * ) )
                    FROM (
                        SELECT 
                            CONCAT( `calendar`.`year`, `calendar`.`month`, `calendar`.`day` ) `service_date`,
                            count( * ) as `count`,
                            `service`.`usr_login_id_seller` as `usr_login_id_seller`
                        FROM
                            `pet_service` as `service`
                        INNER JOIN
                            `pet_calendar` as `calendar`
                        ON
                            `service`.`id` = `calendar`.`service_id`
                        INNER JOIN
                        	`pet_service_detail` as `detail`
                        ON 	
							`service`.`id` = `detail`.`service_id`
                        WHERE
                            `service`.`service_status` IN ( '1', '2', '6' )
						AND
							`detail`.`service_type` = 1
                        AND
                            ( ( `service`.`pet_services` & 2 ) = 0 )
                        %1\$s
                        GROUP BY
                            `service_date`
                        HAVING
                            `count` >= '3'
                        ) as `t_table`
                    WHERE
                        `t_table`.`usr_login_id_seller` = %2\$s
                ) as `one_slot`
                , (
                    SELECT 
                        ( %3\$s - COUNT( * ) )
                    FROM (
                        SELECT 
                            CONCAT( `calendar`.`year`, `calendar`.`month`, `calendar`.`day` ) `service_date`,
                            count( * ) as `count`,
                            `service`.`usr_login_id_seller` as `usr_login_id_seller`
                        FROM
                            `pet_service` as `service`
                        INNER JOIN
                            `pet_calendar` as `calendar`
                        ON
                            `service`.`id` = `calendar`.`service_id`
                        WHERE
                            `service`.`service_status` IN ( '1', '2', '6' )

                        %1\$s
                        GROUP BY
                            `service_date`
                        HAVING
                            `count` != '0'
                        ) as `t_table`
                    WHERE
                        `t_table`.`usr_login_id_seller` = %2\$s
                ) as `sitting_slot`
                , (
                    SELECT 
                        ( %3\$s - COUNT( * ) )
                    FROM (
                        SELECT 
                            CONCAT( `calendar`.`year`, `calendar`.`month`, `calendar`.`day` ) `service_date`,
                            count( * ) as `count`,
                            `service`.`usr_login_id_seller` as `usr_login_id_seller`
                        FROM
                            `pet_service` as `service`
                        INNER JOIN
                            `pet_calendar` as `calendar`
                        ON
                            `service`.`id` = `calendar`.`service_id`
                        INNER JOIN
                        	`pet_service_detail` as `detail`
                        ON 	
							`service`.`id` = `detail`.`service_id`
                        WHERE
                            `service`.`service_status` IN ( '1', '2', '6' )
						AND
							`detail`.`service_type` = 1
                        AND
                            ( ( `service`.`pet_services` & 2 ) = 0 )
                        %1\$s
                        GROUP BY
                            `service_date`
                        HAVING
                            `count` >= '2'
                        ) as `t_table`
                    WHERE
                        `t_table`.`usr_login_id_seller` = %2\$s
                ) as `tow_slots`
                , (
                    SELECT
                        ( %3\$s - COUNT( * ) )
                    FROM (
                        SELECT 
                            CONCAT( `calendar`.`year`, `calendar`.`month`, `calendar`.`day` ) `service_date`,
                            count( * ) as `count`,
                            `service`.`usr_login_id_seller` as `usr_login_id_seller`
                        FROM
                            `pet_service` as `service`
                        INNER JOIN
                            `pet_calendar` as `calendar`
                        ON
                            `service`.`id` = `calendar`.`service_id`
						INNER JOIN
                        	`pet_service_detail` as `detail`
                        ON 	
							`service`.`id` = `detail`.`service_id`
                        WHERE
                            `service`.`service_status` IN ( '1', '2', '6' )
						AND
							`detail`.`service_type` = 1
                        AND
                            ( ( `service`.`pet_services` & 2 ) = 0 )
                        %1\$s
                        GROUP BY
                            `service_date`
                        HAVING
                            `count` >= '1'
                        ) as `t_table`
                    WHERE
                        `t_table`.`usr_login_id_seller` = %2\$s
                ) as `three_slots`
                ";
            $service_count = sprintf( $service_count, ' AND ( ' . implode( ' OR ', $check_date ) . ' )', $request_data['usr_login_id_seller'], $days );
        }

        if ( isset( $request_data['usr_login_id_seller'] ) ) {
            array_push( $where, "`service`.`usr_login_id_seller` = '{$request_data['usr_login_id_seller']}'" );
        }

        if ( ! empty( $where ) ) {
            $where = " WHERE " . implode( ' AND ', $where );
        } else {
            $where = "";
        }

        $sql = sprintf( $sql, $service_count, $where );

        $result = $m_search->query( $sql );

        return empty( $result ) ? false : $result[0];
    }

    /**
     * Get total structure line count
     */
    public function get_host_count() {
        $m_search = new \Think\Model();

        $sql = 'SELECT FOUND_ROWS() as `rows`';

        $result = $m_search->query( $sql );

        return ( ! empty( $result ) ? $result[0]['rows'] : 0 );
    }

    /**
     * Get host 
     */
    public function get_host( $request_data ) {
        $m_host = M( 'usr_basiness' );
        $m_attachment = M( 'attachments' );

        if ( isset ( $request_data['usr_login_id'] ) ) {
            $where = array( 'usr_login_id' => $request_data['usr_login_id'] );
        } else {
            return false;
        }

        $where[ 'status' ] = '0';

        $host = $m_host->where( $where )->find();

        if ( ! empty( $host ) && ! empty ( $host['pics'] ) ) {
            $host['pics'] = unserialize( $host['pics'] );
            $host['pics'] = $m_attachment->where( array( 'id' => array( 'in', $host['pics'] ), 'status' => '0' ) )->select();
        }

        return $host;
    }

    /**
     * Get info
     */
    public function get_info( $request_data ) {
        $m_info = M( 'usr_info' );
        $m_attachment = M( 'attachments' );

        if ( isset( $request_data['usr_login_id'] ) ) {
            $where = array( 'usr_login_id' => $request_data['usr_login_id'] );
        } else {
            return false;
        }

        $where[ 'status'] = '0';

        $info = $m_info->where( $where )->find();

        if ( ! empty( $info ) && ! empty ( $info['head_img'] ) ) {
            $info['head_img_url'] = $m_attachment->where( array( 'id' => $info['head_img'] ) )->getField( 'url' );
        }

        return $info;
    }

    /**
     * Get all RATE
     */
    public function get_rates( $request_data ) {
        $m_rate = M( 'usr_rates' );

        if ( isset( $request_data['usr_login_id'] ) ) {
            $where = array( 'usr_login_id' => $request_data['usr_login_id'] );
        } else {
            return false;
        }

        $where[ 'status' ] = '0';

        return $m_rate->where( $where )->select();
    }

    /**
     * Get all comments
     */
    public function get_comments( $request_data ) {
        $m_comment = M( 'usr_comments' );

        $where = array();

        if ( isset( $request_data['usr_login_id_to'] ) && isset( $request_data['usr_login_id_from'] ) ) {
            $where['_complex'] = array(
                'usr_login_id_to' => array( 'eq', $request_data['usr_login_id_to'] ),
                'usr_login_id_from' => array( 'eq', $request_data['usr_login_id_from'] ),
                '_logic' => 'or',
            );
        }

        $where['status'] = 0;

        return $m_comment->where( $where )->select();
    }

    public function get_service_count( $request_data ) {
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

        if ( empty( $where ) ) {
            return false;
        }

        $where['status'] = 0;

        return $m_service->where( $where )->count();
    }
}
