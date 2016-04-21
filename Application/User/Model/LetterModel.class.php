<?php

namespace User\Model;
use Think\Model as Model;
use Base\Model as BaseModel;

class LetterModel extends BaseModel\BaseModel {

    /**
     * Add chat session
     */
    public function add_letter_session( $request_data ) {
        $m_letter = M( 'letter_session' );

        if ( ! $m_letter->create( $request_data ) ) {
            return false;
        } else {
            return $m_letter->add();
        }
    }

    /**
     * Add new Message
     */
    public function add_letter( $request_data ) {
        $m_letter = M( 'letter_station' );

        if( ! $m_letter->create( $request_data ) ) {
            return false;
        } else {
            return $m_letter->add();
        }
    }

    /**
     * Update Message
     */
    public function update_letter( $request_data ) {
        $m_letter = M( 'letter_station' );

        $where = array();
        if ( isset( $request_data['id'] ) ) {
            $where['id'] = $request_data['id'];
            unset( $request_data['id'] );
        }
        if ( isset ( $request_data['session_id'] ) ) {
            $where['session_id'] = $request_data['session_id'];
            unset( $request_data['session_id'] );
        }
        if ( isset( $request_data['usr_login_id_to'] ) ) {
            $where['usr_login_id_to'] = $request_data['usr_login_id_to'];
            unset( $request_data['usr_login_id_to'] );
        }
        if ( isset( $request_data['usr_login_id_from'] ) ) {
            $where['usr_login_id_from'] = $request_data['usr_login_id_from'];
            unset( $request_data['usr_login_id_from'] );
        }

        if ( empty ( $where ) ) {
            return false;
        }

        $where['status'] = '0';

        return $m_letter->where( $where )->save( $request_data );
    }

    /**
     * Update chat message
     */
    public function update_session( $request_data ) {
        $m_session = M( 'letter_session' );
        $where = array();

        if ( isset( $request_data['id'] ) ) {
            $where['id'] = $request_data['id'];
            unset( $request_data['id'] );
        }

        if ( isset( $request_data['usr_login_id'] ) ) {
            $where['_complex'] = array(
                'usr_login_id_session_to' => $request_data['usr_login_id'],
                'usr_login_id_session_from' => $request_data['usr_login_id'],
                '_logic' => 'or',
            );
            unset( $request_data['usr_login_id'] );
        }
        if ( isset( $request_data['usr_login_id_session_to'] ) ) {
            $where['usr_login_id_session_to'] = $request_data['usr_login_id_session_to'];
            unset( $request_data['usr_login_id_session_to'] );
        }
        if ( isset( $request_data['usr_login_id_session_from'] ) ) {
            $where['usr_login_id_session_from'] = $request_data['usr_login_id_session_from'];
            unset( $request_data['usr_login_id_session_from'] );
        }

        if ( empty ( $where ) ) {
            return false;
        }

        $where['status'] = '0';

        return $m_session->where( $where )->save( $request_data );
    }
	
	/**
     * Get booking message
     */
    public function get_booking_message( $request_data ) {
        $m_model = new \Think\Model();
        $sql = "
            SELECT 
                `letter_session`.`title` as `title`,
                `letter_station`.`letter` as `letter`
            FROM
                `pet_letter_session` as `letter_session`
            LEFT JOIN
                `pet_letter_station` as `letter_station`
            ON
                `letter_station`.`service_id` = `letter_session`.`service_id`

            %1\$s
            ";
        $where = array();

        if ( isset( $request_data['service_id'] ) ) {
            array_push( $where, " ( `letter_session`.`service_id` = '{$request_data['service_id']}' ) " );
        }
		
		if ( empty( $where ) ) {
            return false;
        }
		
		$where = ' WHERE ' .  implode( ' AND ', $where );
		$sql = sprintf( $sql, $where );
        $msg = $m_model->query( $sql );

		return $msg[0];
    }

    /**
     * Get chat message
     */
    public function get_session_letter( $request_data ) {
        $m_session = M( 'letter_session' );
        $where = array();

        if ( isset( $request_data['id'] ) ) {
            $where['id'] = $request_data['id'];
        }
        if ( isset( $request_data['usr_login_id_session_from'] ) ) {
            $where['usr_login_id_session_from'] = $request_data['usr_login_id_session_from'];
        }
        if ( isset( $request_data['usr_login_id_session_to'] ) ) {
            $where['usr_login_id_session_to'] = $request_data['usr_login_id_session_to'];
        }

        if ( empty( $where ) ) {
            return false;
        }

        return $m_session->where( $where )->find();
    }
	
	/**
     * Get Sent meet requests
     */
    public function meet_request_sent( $request_data ) {
        $m_model = new \Think\Model();
        $sql = "
            SELECT 
                SQL_CALC_FOUND_ROWS
                `letter_session`.`id` as `session_id`,
                `letter_session`.`usr_login_id_session_from` as `usr_login_id_session_from`,
                `letter_session`.`usr_login_id_session_to` as `usr_login_id_session_to`,
                `letter_session`.`title` as `title`,
                `letter_session`.`from_tags` as `from_tags`,
                `letter_session`.`to_tags` as `to_tags`,
                (
                    SELECT
                        count(*)
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                ) as `count`,
                (
                    SELECT
                        count(*)
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    AND
                        `usr_login_id_from` = '%4\$s'
                ) as `sent_count`,
                (
                    SELECT
                        `letter`
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    ORDER BY
                        `submit_time` DESC
                    LIMIT 1
                ) as `letter`,
                (
                    SELECT
                        `letter_status`
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    ORDER BY
                        `submit_time` DESC
                    LIMIT 1
                ) as `letter_status`,
                (
                    SELECT
                        `submit_time`
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    ORDER BY
                        `submit_time` DESC
                    LIMIT 1
                ) as `letter_submit_time`,
                (
                    SELECT
                        `usr_login_id_to`
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    ORDER BY
                        `submit_time` DESC
                    LIMIT 1
                ) as `usr_login_id_respond`,
                (
                    SELECT
                        `usr_login_id_from`
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    ORDER BY
                        `submit_time` DESC
                    LIMIT 1
                ) as `usr_login_id_sent`,

                `from`.`first_name` as `from_first_name`,
                `to`.`first_name` as `to_first_name`,

                `from_img`.`url` as `from_head_img_url`,
                `to_img`.`url` as `to_head_img_url`
            FROM
                `pet_letter_session` as `letter_session`
            LEFT JOIN
                `pet_usr_info` as `from`
            ON
                `from`.`usr_login_id` = `letter_session`.`usr_login_id_session_from`
            LEFT JOIN
                `pet_usr_info` as `to`
            ON
                `to`.`usr_login_id` = `letter_session`.`usr_login_id_session_to`
            LEFT JOIN
                `pet_attachments` as `from_img`
            ON
                `from_img`.`id` = `from`.`head_img`
            LEFT JOIN
                `pet_attachments` as `to_img`
            ON
                `to_img`.`id` = `to`.`head_img`

            %1\$s

            %2\$s
            ORDER BY
                `letter_submit_time` DESC
            %3\$s
            ";
        $where = array();

        if ( isset( $request_data['usr_login_id'] ) ) {
            array_push( $where, " ( `letter_session`.`usr_login_id_session_from` = '{$request_data['usr_login_id']}' AND `letter_session`.`from_tags` = 'MG' ) " );
        }
        if ( isset( $request_data['id'] ) ) {
            array_push( $where, "`letter_session`.`id` = '{$request_data['id']}'" );
        }
        if ( isset( $request_data['usr_login_id_session_from'] ) ) {
            array_push( $where, "`letter_session`.`usr_login_id_session_from` = '{$request_data['usr_login_id_session_from']}'" );
        }
        if ( isset( $request_data['usr_login_id_session_to'] ) ) {
            array_push( $where, "`letter_session`.`usr_login_id_session_to` = '{$request_data['usr_login_id_session_to']}'" );
        }
        if ( isset( $request_data['has_service_id'] ) ) {
            array_push( $where, "`letter_session`.`service_id` != ''" );
        }

        $having = array();
        /*if ( isset( $request_data['session_count'] ) ) {
            array_push( $having, "`count` = '{$request_data['session_count']}'" );
        }*/
        if ( isset( $request_data['usr_login_id_sent'] ) ) {
            array_push( $having, "`usr_login_id_sent` = '{$request_data['usr_login_id_sent']}'" );
        }
        if ( isset( $request_data['sent'] ) && false === $request_data['sent'] ) {
            array_push( $having, "`count` != `sent_count`" );
        }

        $limit = '';
        if ( isset( $request_data['paged'] ) ) {
            $limit = ' LIMIT ' . ( ! empty( $request_data['paged'] ) ? ( $request_data['paged'] - 1 ) * C( 'PAGED' ) : 0 ) . ',' . C( 'PAGED' );
        }

        $sql = sprintf(
            $sql,
            ( empty( $where ) ? "" : " WHERE " . implode( ' AND ', $where ) ),
            ( empty( $having ) ? "" : " HAVING " . implode( ' AND ', $having ) ),
            ( empty( $limit ) ? "" : $limit ),
            get_session_id()
        );

        $sessions = $m_model->query( $sql );
        foreach( $sessions as $k => $v ) {
            if ( '0' == $v['usr_login_id_session_from'] ) {
                $sessions[ $k ]['from_head_img_url'] = C( 'DEFAULT_ADMIN_HEAD_IMG' );
            }
        }

        return $sessions;
    }
	
	/**
     * Get received meet requests
     */
    public function meet_request( $request_data ) {
        $m_model = new \Think\Model();
        $sql = "
            SELECT 
                SQL_CALC_FOUND_ROWS
                `letter_session`.`id` as `session_id`,
                `letter_session`.`usr_login_id_session_from` as `usr_login_id_session_from`,
                `letter_session`.`usr_login_id_session_to` as `usr_login_id_session_to`,
                `letter_session`.`title` as `title`,
                `letter_session`.`from_tags` as `from_tags`,
                `letter_session`.`to_tags` as `to_tags`,
                (
                    SELECT
                        count(*)
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                ) as `count`,
                (
                    SELECT
                        count(*)
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    AND
                        `usr_login_id_from` = '%4\$s'
                ) as `sent_count`,
                (
                    SELECT
                        `letter`
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    ORDER BY
                        `submit_time` DESC
                    LIMIT 1
                ) as `letter`,
                (
                    SELECT
                        `letter_status`
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    ORDER BY
                        `submit_time` DESC
                    LIMIT 1
                ) as `letter_status`,
                (
                    SELECT
                        `submit_time`
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    ORDER BY
                        `submit_time` DESC
                    LIMIT 1
                ) as `letter_submit_time`,
                (
                    SELECT
                        `usr_login_id_to`
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    ORDER BY
                        `submit_time` DESC
                    LIMIT 1
                ) as `usr_login_id_respond`,
                (
                    SELECT
                        `usr_login_id_from`
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    ORDER BY
                        `submit_time` DESC
                    LIMIT 1
                ) as `usr_login_id_sent`,

                `from`.`first_name` as `from_first_name`,
                `to`.`first_name` as `to_first_name`,

                `from_img`.`url` as `from_head_img_url`,
                `to_img`.`url` as `to_head_img_url`
            FROM
                `pet_letter_session` as `letter_session`
            LEFT JOIN
                `pet_usr_info` as `from`
            ON
                `from`.`usr_login_id` = `letter_session`.`usr_login_id_session_from`
            LEFT JOIN
                `pet_usr_info` as `to`
            ON
                `to`.`usr_login_id` = `letter_session`.`usr_login_id_session_to`
            LEFT JOIN
                `pet_attachments` as `from_img`
            ON
                `from_img`.`id` = `from`.`head_img`
            LEFT JOIN
                `pet_attachments` as `to_img`
            ON
                `to_img`.`id` = `to`.`head_img`

            %1\$s

            %2\$s
            ORDER BY
                `letter_submit_time` DESC
            %3\$s
            ";
        $where = array();

        if ( isset( $request_data['usr_login_id'] ) ) {
            array_push( $where, " ( `letter_session`.`usr_login_id_session_to` = '{$request_data['usr_login_id']}' AND `letter_session`.`to_tags` = 'MG' ) " );
        }
        if ( isset( $request_data['id'] ) ) {
            array_push( $where, "`letter_session`.`id` = '{$request_data['id']}'" );
        }
        if ( isset( $request_data['usr_login_id_session_from'] ) ) {
            array_push( $where, "`letter_session`.`usr_login_id_session_from` = '{$request_data['usr_login_id_session_from']}'" );
        }
        if ( isset( $request_data['usr_login_id_session_to'] ) ) {
            array_push( $where, "`letter_session`.`usr_login_id_session_to` = '{$request_data['usr_login_id_session_to']}'" );
        }
        if ( isset( $request_data['has_service_id'] ) ) {
            array_push( $where, "`letter_session`.`service_id` != ''" );
        }

        $having = array();
		/*
        if ( isset( $request_data['session_count'] ) ) {
            array_push( $having, "`count` = '{$request_data['session_count']}'" );
        }
        if ( isset( $request_data['usr_login_id_sent'] ) ) {
            array_push( $having, "`usr_login_id_sent` = '{$request_data['usr_login_id_sent']}'" );
        }
        if ( isset( $request_data['usr_login_id_respond'] ) ) {
            array_push( $having, "`usr_login_id_respond` = '{$request_data['usr_login_id_respond']}'" );
        }
        if ( isset( $request_data['sent'] ) && false === $request_data['sent'] ) {
            array_push( $having, "`count` != `sent_count`" );
        }*/

        $limit = '';
        if ( isset( $request_data['paged'] ) ) {
            $limit = ' LIMIT ' . ( ! empty( $request_data['paged'] ) ? ( $request_data['paged'] - 1 ) * C( 'PAGED' ) : 0 ) . ',' . C( 'PAGED' );
        }

        $sql = sprintf(
            $sql,
            ( empty( $where ) ? "" : " WHERE " . implode( ' AND ', $where ) ),
            ( empty( $having ) ? "" : " HAVING " . implode( ' AND ', $having ) ),
            ( empty( $limit ) ? "" : $limit ),
            get_session_id()
        );

        $sessions = $m_model->query( $sql );
        foreach( $sessions as $k => $v ) {
            if ( '0' == $v['usr_login_id_session_from'] ) {
                $sessions[ $k ]['from_head_img_url'] = C( 'DEFAULT_ADMIN_HEAD_IMG' );
            }
        }

        return $sessions;
    }

    /**
     * Get chat message list
     */
    public function get_sessions( $request_data ) {
        $m_model = new \Think\Model();
        $sql = "
            SELECT 
                SQL_CALC_FOUND_ROWS
                `letter_session`.`id` as `session_id`,
                `letter_session`.`usr_login_id_session_from` as `usr_login_id_session_from`,
                `letter_session`.`usr_login_id_session_to` as `usr_login_id_session_to`,
                `letter_session`.`title` as `title`,
                `letter_session`.`from_tags` as `from_tags`,
                `letter_session`.`to_tags` as `to_tags`,
                (
                    SELECT
                        count(*)
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                ) as `count`,
                (
                    SELECT
                        count(*)
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    AND
                        `usr_login_id_from` = '%4\$s'
                ) as `sent_count`,
                (
                    SELECT
                        `letter`
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    ORDER BY
                        `submit_time` DESC
                    LIMIT 1
                ) as `letter`,
                (
                    SELECT
                        `letter_status`
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
						AND `usr_login_id_to` = '%4\$s'
                    ORDER BY
                        `submit_time` DESC
                    LIMIT 1
                ) as `letter_status`,
                (
                    SELECT
                        `submit_time`
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    ORDER BY
                        `submit_time` DESC
                    LIMIT 1
                ) as `letter_submit_time`,
                (
                    SELECT
                        `usr_login_id_to`
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    ORDER BY
                        `submit_time` DESC
                    LIMIT 1
                ) as `usr_login_id_respond`,
                (
                    SELECT
                        `usr_login_id_from`
                    FROM
                        `pet_letter_station`
                    WHERE
                        `session_id` = `letter_session`.`id`
                    ORDER BY
                        `submit_time` DESC
                    LIMIT 1
                ) as `usr_login_id_sent`,

                `from`.`first_name` as `from_first_name`,
                `to`.`first_name` as `to_first_name`,

                `from_img`.`url` as `from_head_img_url`,
                `to_img`.`url` as `to_head_img_url`
            FROM
                `pet_letter_session` as `letter_session`
            LEFT JOIN
                `pet_usr_info` as `from`
            ON
                `from`.`usr_login_id` = `letter_session`.`usr_login_id_session_from`
            LEFT JOIN
                `pet_usr_info` as `to`
            ON
                `to`.`usr_login_id` = `letter_session`.`usr_login_id_session_to`
            LEFT JOIN
                `pet_attachments` as `from_img`
            ON
                `from_img`.`id` = `from`.`head_img`
            LEFT JOIN
                `pet_attachments` as `to_img`
            ON
                `to_img`.`id` = `to`.`head_img`

            %1\$s

            %2\$s
            ORDER BY
                `letter_submit_time` DESC
            %3\$s
            ";
        $where = array();

        if ( isset( $request_data['usr_login_id'] ) ) {
            if ( isset( $request_data['tags'] ) ) {
                if ( false === $request_data['tags'] ) {
                    array_push( $where, "( ( `letter_session`.`usr_login_id_session_from` = '{$request_data['usr_login_id']}' AND `letter_session`.`from_tags` IS NULL ) OR ( `letter_session`.`usr_login_id_session_to` = '{$request_data['usr_login_id']}' AND `letter_session`.`to_tags` IS NULL ) )" );
                } else {
                    array_push( $where, "( ( `letter_session`.`usr_login_id_session_from` = '{$request_data['usr_login_id']}' AND `letter_session`.`from_tags` LIKE '%{$request_data['tags']}%' ) OR ( `letter_session`.`usr_login_id_session_to` = '{$request_data['usr_login_id']}' AND `letter_session`.`to_tags` LIKE '%{$request_data['tags']}%' ) )" );
                }
            } else {
                array_push( $where, "( `letter_session`.`usr_login_id_session_from` = '{$request_data['usr_login_id']}' OR `letter_session`.`usr_login_id_session_to` = '{$request_data['usr_login_id']}' )" );
            }
            // array_push( $where, "( `letter_session`.`usr_login_id_session_from` = '{$request_data['usr_login_id']}' OR `letter_session`.`usr_login_id_session_to` = '{$request_data['usr_login_id']}' )" );
        }
        if ( isset( $request_data['id'] ) ) {
            array_push( $where, "`letter_session`.`id` = '{$request_data['id']}'" );
        }
        if ( isset( $request_data['usr_login_id_session_from'] ) ) {
            array_push( $where, "`letter_session`.`usr_login_id_session_from` = '{$request_data['usr_login_id_session_from']}'" );
        }
        if ( isset( $request_data['usr_login_id_session_to'] ) ) {
            array_push( $where, "`letter_session`.`usr_login_id_session_to` = '{$request_data['usr_login_id_session_to']}'" );
        }
        if ( isset( $request_data['has_service_id'] ) ) {
            array_push( $where, "`letter_session`.`service_id` != ''" );
        }

        $having = array();
        if ( isset( $request_data['session_count'] ) ) {
            array_push( $having, "`count` = '{$request_data['session_count']}'" );
        }
        if ( isset( $request_data['usr_login_id_sent'] ) ) {
            array_push( $having, "`usr_login_id_sent` = '{$request_data['usr_login_id_sent']}'" );
        }
        if ( isset( $request_data['usr_login_id_respond'] ) ) {
            array_push( $having, "`usr_login_id_respond` = '{$request_data['usr_login_id_respond']}'" );
        }
        if ( isset( $request_data['sent'] ) && false === $request_data['sent'] ) {
            array_push( $having, "`count` != `sent_count`" );
        }

        $limit = '';
        if ( isset( $request_data['paged'] ) ) {
            $limit = ' LIMIT ' . ( ! empty( $request_data['paged'] ) ? ( $request_data['paged'] - 1 ) * C( 'PAGED' ) : 0 ) . ',' . C( 'PAGED' );
        }

        $sql = sprintf(
            $sql,
            ( empty( $where ) ? "" : " WHERE " . implode( ' AND ', $where ) ),
            ( empty( $having ) ? "" : " HAVING " . implode( ' AND ', $having ) ),
            ( empty( $limit ) ? "" : $limit ),
            get_session_id()
        );
        $sessions = $m_model->query( $sql );

        foreach( $sessions as $k => $v ) {
            if ( '0' == $v['usr_login_id_session_from'] ) {
                $sessions[ $k ]['from_head_img_url'] = C( 'DEFAULT_ADMIN_HEAD_IMG' );
            }
        }

        return $sessions;
    }

    /**
     * Get number of chat messages
     */
    public function get_sessions_count() {
        $m_model = new \Think\Model();

        return $m_model->query( 'SELECT FOUND_ROWS() as `count`;' )[0]['count'];
    }

    /**
     * Get chat message
     */
    public function get_session( $request_data ) {
        $m_session = M( 'letter_session' );
        $where = array();

        if ( isset( $request_data['id'] ) ) {
            $where['id'] = $request_data['id'];
        }
        if ( isset( $request_data['usr_login_id_session_from'] ) ) {
            $where['usr_login_id_session_from'] = $request_data['usr_login_id_session_from'];
        }
        if ( isset( $request_data['usr_login_id_session_to'] ) ) {
            $where['usr_login_id_session_to'] = $request_data['usr_login_id_session_to'];
        }

        if ( empty( $where ) ) {
            return false;
        }

        return $m_session->where( $where )->find();
    }

    public function get_groups_letter( $request_data ) {
        $m_model = new \Think\Model();

        $sql = "
            SELECT 
                COUNT(*) as `count`,
                `t`.`id` as `id`,
                `t`.`usr_login_id_from` as `usr_login_id_from`,
                `t`.`usr_login_id_to` as `usr_login_id_to`,
                `t`.`session_id` as `session_id`,
                `t`.`title` as `title`,
                `t`.`letter` as `letter`,
                `t`.`letter_status` as `letter_status`,
                `t`.`status` as `status`,
                `t`.`submit_time` as `submit_time`,

                `from`.`first_name` as `from_first_name`,
                `to`.`first_name` as `to_first_name`,

                `from_img`.`url` as `from_head_img_url`,
                `to_img`.`url` as `to_head_img_url`
            FROM
                (
                    SELECT
                        *
                    FROM 
                        `pet_letter_station`
                    %s
                    ORDER BY
                        `submit_time`
                    DESC
                ) `t`
            LEFT JOIN
                `pet_usr_info` as `from`
            ON
                `from`.`usr_login_id` = `t`.`usr_login_id_from`
            LEFT JOIN
                `pet_usr_info` as `to`
            ON
                `to`.`usr_login_id` = `t`.`usr_login_id_to`
            LEFT JOIN
                `pet_attachments` as `from_img`
            ON
                `from_img`.`id` = `from`.`head_img`
            LEFT JOIN
                `pet_attachments` as `to_img`
            ON
                `to_img`.`id` = `to`.`head_img`

            GROUP BY
                `session_id`
                %s
            ORDER BY
                `submit_time`
            DESC
            ";

        $where = array();
        if ( isset( $request_data['usr_login_id_from'] ) && isset( $request_data['usr_login_id_to'] ) ) {
            array_push( $where, "( `usr_login_id_from` = '{$request_data['usr_login_id_from']}' OR `usr_login_id_to` = '{$request_data['usr_login_id_to']} ' )" );
        }elseif(isset($request_data['usr_login_id_to'])){
        	array_push( $where, "( `usr_login_id_to` = '{$request_data['usr_login_id_to']} ' )" );
        }elseif(isset($request_data['usr_login_id_from'])){
        	array_push( $where, "( `usr_login_id_from` = '{$request_data['usr_login_id_from']} ' )" );
        }
        if(isset($request_data['not_usr_login_id_from'])){
        	array_push($where,"( `usr_login_id_from` != '{$request_data['not_usr_login_id_from']} ' )");
        }
        if ( isset( $request_data['letter_status'] ) ) {
            if ( is_array( $request_data['letter_status'] ) ) {
                array_push( $where, "`letter_status` IN ( " . implode( ',', $request_data['letter_status'] ) . " )" );
            } else {
                array_push( $where, "`letter_status` = '{$request_data['letter_status']}'" );
            }
        }
        if ( isset( $request_data['has_service_id'] ) ) {
            array_push( $where, "`service_id` != '0'" );
        }
        if ( empty( $where ) ) {
            return false;
        }

        array_push( $where, "`status` = '0'" );

        $where = ' WHERE ' .  implode( ' AND ', $where );

        $having = "";
        if ( isset( $request_data['session_count'] ) ) {
            $having .= "`count` = '{$request_data['session_count']}'";
        }

        $having = empty( $having ) ? "" : " HAVING " . $having;

        $sql = sprintf( $sql, $where, $having );

        $letters = $m_model->query( $sql );

        return $letters;
    }

    /**
     * Get number of unread messages
     */
    public function get_unread_letters_count( $request_data ) {
        $m_letter = M( 'letter_station' );

        $sql = "SELECT count(*) as `letter_count` FROM `pet_letter_station` WHERE %1\$s AND `usr_login_id_from` != '0' AND `letter_status` = '2' AND session_id IN ( SELECT id FROM `pet_letter_session` WHERE (`from_tags` is null OR `from_tags` != 'MG') and (`to_tags` is null OR `to_tags` != 'MG') )";
			

        $where = array();
        if ( isset( $request_data['usr_login_id_to'] ) ) {
            array_push( $where, "`usr_login_id_to` = '{$request_data['usr_login_id_to']}'" );
        }

        if ( empty( $where ) ) {
            return false;
        }

        //array_push( $where, "`usr_login_id_session_from` != '0'" );
        //array_push( $where, "`letter_status` = '2'" );

        $sql = sprintf( $sql, implode( ' AND ', $where ) );
		
        $res = $this->query( $sql );
        return empty( $res ) ? 0 : $res[0]['letter_count'];
    }

	/**
     * Get number of unread replies of meet requests
     */
    public function get_meet_request_reply_count( $request_data ) {
        $m_letter = M( 'letter_station' );

        $sql = "SELECT count(*) as `letter_count` FROM `pet_letter_station` WHERE %1\$s AND `usr_login_id_from` != '0' AND `letter_status` = '2' AND session_id IN ";
			

        $where = array();
        if ( isset( $request_data['usr_login_id'] ) ) {
            array_push( $where, "`usr_login_id_to` = '{$request_data['usr_login_id']}'" );
        }

        if ( empty( $where ) ) {
            return false;
        }

        //array_push( $where, "`usr_login_id_session_from` != '0'" );
        //array_push( $where, "`letter_status` = '2'" );

        $sql = sprintf( $sql, implode( ' AND ', $where ) );
		$sql .= "( SELECT id FROM `pet_letter_session` WHERE %1\$s AND `from_tags` = 'MG' )";
		$where = array();
		array_push( $where, "`usr_login_id_session_from` = '{$request_data['usr_login_id']}'" );
		$sql = sprintf( $sql, implode( ' AND ', $where ) );
        $res = $this->query( $sql );
        return empty( $res ) ? 0 : $res[0]['letter_count'];
    }
	
    /**
     * Get number of unanswered messages
     */
    public function get_unrespond_letters_count( $request_data ) {
        $m_letter = M( 'letter_station' );

        $sql = "SELECT count(*) as `letter_count` FROM `pet_letter_station` WHERE %1\$s AND `usr_login_id_from` != '0' AND `letter_status` = '2' AND session_id IN ";
			

        $where = array();
        if ( isset( $request_data['usr_login_id'] ) ) {
            array_push( $where, "`usr_login_id_to` = '{$request_data['usr_login_id']}'" );
        }

        if ( empty( $where ) ) {
            return false;
        }

        //array_push( $where, "`usr_login_id_session_from` != '0'" );
        //array_push( $where, "`letter_status` = '2'" );

        $sql = sprintf( $sql, implode( ' AND ', $where ) );
		$sql .= "( SELECT id FROM `pet_letter_session` WHERE %1\$s AND `to_tags` = 'MG' )";
		$where = array();
		array_push( $where, "`usr_login_id_session_to` = '{$request_data['usr_login_id']}'" );
		array_push( $where, "`usr_login_id_session_from` != '0'" );
		$sql = sprintf( $sql, implode( ' AND ', $where ) );
        $res = $this->query( $sql );
        return empty( $res ) ? 0 : $res[0]['letter_count'];
    }

    /**
     * Get number of messages
     */
    public function get_letters_count( $request_data ) {
        $m_letter = M( 'letter_station' );

        $sql = "
            SELECT count(*) as `letter_count` FROM 
            (
                SELECT count(*) as `count` FROM `pet_letter_station` WHERE %s GROUP BY `session_id`
            ) as `t`
            ";

        $where = array();
        if ( isset( $request_data['usr_login_id_to'] ) ) {
            array_push( $where, "`usr_login_id_to` = '{$request_data['usr_login_id_to']}'" );
        }

        if ( empty( $where ) ) {
            return false;
        }

        array_push( $where, "`usr_login_id_from` != '0'" );
        array_push( $where, "`status` = '0'" );

        $sql = sprintf( $sql, implode( ' AND ', $where ) );

        $res = $this->query( $sql );

        return empty( $res ) ? 0 : $res[0]['letter_count'];
    }

    /**
     * Get info of last reply
     */
    public function get_letters_last( $request_data ) {
        $m_letter = M( 'letter_station' );
        $where = array();

        if ( isset( $request_data['session_id'] ) ) {
            $where['session_id'] = $request_data['session_id'];
        }
        if ( isset( $request_data['usr_login_id_to'] ) ) {
            $where['usr_login_id_to'] = $request_data['usr_login_id_to'];
        }

        if ( empty( $where ) ) {
            return false;
        }

        return $m_letter->where( $where )->order( '`submit_time` desc' )->find();
    }

    /**
     * Get Message list
     */
    public function get_letters( $request_data ) {
        $m_model = new \Think\Model();

        $sql = "
            SELECT 
                `letter`.`id` as `id`,
                `letter`.`usr_login_id_from` as `usr_login_id_from`,
                `letter`.`usr_login_id_to` as `usr_login_id_to`,
                `letter`.`session_id` as `session_id`,
                `letter`.`letter` as `letter`,
                `letter`.`letter_status` as `letter_status`,
                `letter`.`status` as `status`,
                `letter`.`submit_time` as `submit_time`,

                `session`.`title` as `title`,
				`session`.`to_tags` as `to_tags`,
				`session`.`from_tags` as `from_tags`,

                `from`.`first_name` as `from_first_name`,
                `to`.`first_name` as `to_first_name`,

                `from_img`.`url` as `from_head_img_url`,
                `to_img`.`url` as `to_head_img_url`
            FROM
                `pet_letter_station` as `letter`
            LEFT JOIN
                `pet_usr_info` as `from`
            ON
                `from`.`usr_login_id` = `letter`.`usr_login_id_from`
            LEFT JOIN
                `pet_usr_info` as `to`
            ON
                `to`.`usr_login_id` = `letter`.`usr_login_id_to`
            LEFT JOIN
                `pet_attachments` as `from_img`
            ON
                `from_img`.`id` = `from`.`head_img`
            LEFT JOIN
                `pet_attachments` as `to_img`
            ON
                `to_img`.`id` = `to`.`head_img`
            INNER JOIN
                `pet_letter_session` as `session`
            ON
                `session`.`id` = `letter`.`session_id`

                %1\$s

            ORDER BY
                `submit_time`
            DESC
                %2\$s
            ";

        $where = array();
        if ( isset( $request_data['usr_login_id'] ) ) {
            array_push( $where, "( `letter`.`usr_login_id_from` = '{$request_data['usr_login_id']}' OR `letter`.`usr_login_id_to` = '{$request_data['usr_login_id']} ' )" );
        }
        if ( isset( $request_data['usr_login_id_to'] ) ) {
            array_push( $where, "`letter`.`usr_login_id_to` = '{$request_data['usr_login_id_to']}'" );
        }
        if ( isset( $request_data['usr_login_id_from'] ) ) {
            array_push( $where, "`letter`.`usr_login_id_from` = '{$request_data['usr_login_id_from']}'" );
        }
        if ( isset( $request_data['letter_status'] ) ) {
            if ( is_array( $request_data['letter_status'] ) ) {
                array_push( $where, "`letter`.`letter_status` IN ( " . implode( ',', $request_data['letter_status'] ) . " )" );
            } else {
                array_push( $where, "`letter`.`letter_status` = '{$request_data['letter_status']}'" );
            }
        }
        if ( isset( $request_data['session_id'] ) ) {
            array_push( $where, "( `session_id` = '{$request_data['session_id']}' )" );
        }
        if ( empty( $where ) ) {
            return false;
        }

        $limit = "";
        if ( isset( $request_data['limit'] ) ) {
            $limit = " LIMIT 0," . $request_data['limit'];
        }

        array_push( $where, "`letter`.`status` = '0'" );

        $where = ' WHERE ' .  implode( ' AND ', $where );

        $sql = sprintf( $sql, $where, $limit );

        $letters = $m_model->query( $sql );

        return $letters;
    }
    
    /**
     * Delete Message
     */
    public function remove($request_data){
    	$m_model = M( 'letter_station' );
    	
    	if(isset($request_data['id'])){
    		$where['id']=$request_data['id'];
    	}
    	if(isset($request_data['usr_login_id'])){
    		$usr_login_id=$request_data['usr_login_id'];
    		$where['_complex']=array(
    				'usr_login_id_from'=>$usr_login_id,
    				'usr_login_id_to'=>$usr_login_id,
    				'_logic'=>'or'
    		);
    	}
    	return $m_model->where($where)->save(array('letter_status'=>0));
    }
    
}
