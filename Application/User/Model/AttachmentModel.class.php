<?php

namespace User\Model;
use Think\Model as Model;
use Base\Model as BaseModel;

class AttachmentModel extends BaseModel\BaseModel {

    /**
     * Add Attachment
     */
    public function add_attachment( $request_data ) {
        $m_attachment = M( 'attachments' );

        if( ! $m_attachment->create( $request_data ) ) {
            return false;
        } else {
            return $m_attachment->add();
        }
    }

    /**
     * Get attachment
     */
    public function get_attachment( $request_data ) {
        $m_attachment = M( 'attachments' );
        if ( isset( $request_data['usr_login_id'] ) ) {
            $where = array( 'usr_login_id' => $request_data['usr_login_id'] );
        } else if ( isset( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
        } else {
            return false;
        }

        $where['status'] = 0;

        return $m_attachment->where( $where )->find();
    }
    /**
     * Get attachments collection
     */
    public function get_attachments( $request_data ) {
        $m_attachment = M( 'attachments' );
        $where = array();
        if ( isset( $request_data['usr_login_id'] ) ) {
            $where['usr_login_id'] = $request_data['usr_login_id'];
        }

        if ( isset( $request_data['ids'] ) ) {
            $where['id'] = array( 'in', $request_data['ids'] );
        }

        if ( empty( $where ) ) {
            return false;
        }

        $where['status'] = 0;

        return $m_attachment->where( $where )->select();
    }

    /**
     * Update Attachment
     */
    public function update_attacuments ( $request_data ){
        $m_attachment = M( 'attachments' );

        if ( isset( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
            unset( $request_data[ 'id' ] );
        } else {
            return false;
        }

        $where['status'] = 0;

        return $m_attachment->where( $where )->save( $request_data );
    }

    /**
     * Delete Attachment
     */
    public function del_attachment( $request_data ) {
        $m_attachment = M( 'attachments' );
        $where = array();

        if ( isset( $request_data['usr_login_id'] ) ) {
            $where['usr_login_id'] = $request_data['usr_login_id'];
        }

        if ( isset( $request_data['id'] ) ) {
            $where['id'] = $request_data['id'];
        }

        if ( empty( $where ) ) {
            return false;
        }

        return $m_attachment->where( $where )->save( array( 'status' => '1' ) );
    }
}
