<?php

namespace User\Model;
use Think\Model as Model;
use Base\Model as BaseModel;


class CommentModel extends BaseModel\BaseViewModel {
    public $viewFields = array (
        'usr_comments' => array (
            '`id`',
            '`usr_login_id_from`',
            '`usr_login_id_to`',
            //'`group`',
            '`comment`',
            '`reply`',
            '`score`',
            '`submit_time`',
            '_type' => 'left',
        ),
        'usr_from' => array (
            '`first_name`' => '`from_first_name`',
            '`last_name`' => '`from_last_name`',
            '_table' => 'pet_usr_info',
            '_type' => 'left',
            '_on' => 'usr_comments.`usr_login_id_from` = usr_from.`usr_login_id`',
        ),
        'usr_from_img' => array (
            '`url`' => '`from_head_img_url`',
            '_table' => 'pet_attachments',
            '_type' => 'left',
            '_on' => 'usr_from.`head_img` = usr_from_img.`id`',
        ),
        'usr_to' => array (
            '`first_name`' => '`to_first_name`',
            '`last_name`' => '`to_last_name`',
            '_table' => 'pet_usr_info',
            '_type' => 'left',
            '_on' => 'usr_comments.`usr_login_id_to` = usr_to.`usr_login_id`',
        ),
        'usr_to_img' => array (
            '`url`' => '`to_head_img_url`',
            '_table' => 'pet_attachments',
            '_type' => 'left',
            '_on' => 'usr_to.`head_img` = usr_to_img.`id`',
        ),
    );

    /**
     * Get largest group ID
     */
    public function get_max_group_id() {
        $m_model = new \Think\Model();
        $sql = "
            SELECT MAX( `group` ) as `max_group` FROM `pet_usr_comments`
            ";

        $res = $m_model->query( $sql );
        return $res[0]['max_group'];
    }

    /**
     * Get all comments
     */
    public function get_comments( $request_data ) {
        $where = array();

        if ( isset( $request_data['usr_login_id_to'] ) ) {
            array_push( $where, "`usr_comments`.`usr_login_id_to` = '{$request_data['usr_login_id_to']}'" );
        }

        if ( empty( $where ) ) {
            return false;
        }

        array_push( $where, "`usr_comments`.`status` = '0'" );
        $where = implode( ' AND ', $where );

        return $this->where( $where )->select();
    }

    public function add_comment( $request_data ) {
        $m_comment = M( 'usr_comments' );

        if( ! $m_comment->create( $request_data ) ) {
            return false;
        } else {
            return $m_comment->add();
        }
    }
}
