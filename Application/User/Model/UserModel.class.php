<?php

namespace User\Model;
use Think\Model as Model;
use Base\Model as BaseModel;

class UserModel extends BaseModel\BaseViewModel {

    public $viewFields = array (
        'usr_info' => array (
            '`first_name`' => '`first_name`',
            '`last_name`' => '`last_name`',
            '`head_img`' => '`head_img`',
            '`gender`' => '`gender`',
            '`country_code`' => '`country_code`',
            '`mobile`' => '`mobile`',
            '`address`' => '`address`',
            '`emergency_name`' => '`emergency_name`',
            '`emergency_mobile`' => '`emergency_mobile`',
            '`languages_spoken`' => '`languages_spoken`',
            '`emergency_country_code`' => '`emergency_country_code`',
			'pet_name' => 'pet_name',
			'pet_gender' => 'pet_gender',
			'pet_age' => 'pet_age',
			'pet_is_neutered' => 'pet_is_neutered',
			'pet_head_img' => 'pet_head_img',
            '`submit_time`' => '`submit_time`',
            '`lat`' => '`lat`',
            '`lng`' => '`lng`',
            '`archive_tags`' => '`archive_tags`',
            '_type' => 'left',
        ),
        'usr_login' => array (
            '`email`' => '`email`',
            '_type' => 'left',
            '_on' => 'usr_info.`usr_login_id` = usr_login.`id`',
        ),
        'attachments' => array (
            '`url`' => '`head_img_url`',
            '_on' => 'usr_info.`head_img` = attachments.`id`',
        ),
    );

    /**
     * Create basic info
     */
    public function user_add( $request_data ) {
        $m_login= M( 'usr_login' );
        if( ! $m_login->create( $request_data ) ) {
            return $m_login->getError();
        } else {
            return $m_login->add();
        }
    }

    /**
     * Get user's basic info
     */
    public function get_user_login( $request_data ) {
        $m_login = M( 'usr_login' );
        $where = array();

        if ( isset( $request_data['id'] ) ) {
            $where['id'] = $request_data['id'];
        }
        if ( isset( $request_data['third_party_token'] ) ) {
            $where['third_party_token'] = $request_data['third_party_token'];
        }

        if ( empty( $where ) ) {
            return false;
        }

        return $m_login->where( $where )->find();
    }

    public function update_user_login( $request_data ) {
        $m_login = M( 'usr_login' );
        $where = array();

        if ( isset( $request_data['id'] ) ) {
            $where['id'] = $request_data['id'];
            unset( $request_data['id'] );
        }

        if ( empty( $where ) ) {
            return false;
        }

        return $m_login->where( $where )->save( $request_data );
    }

    /**
     * Get logged in user
     */
    public function get_user( $request_data ) {
        $m_user = M( 'usr_login' );
        $where = array();

        if ( isset ( $request_data['id'] ) ) {
            $where['id'] = $request_data['id'];
        }
        if ( isset( $request_data['email'] ) ) {
            $where['email'] = $request_data['email'];
        }
        if ( isset( $request_data['verify_code'] ) ) {
            $where['verify_code'] = $request_data['verify_code'];
        }

        if ( empty( $where ) ) {
            return false;
        }
        $where[ 'status' ] = '0';

        return $m_user->where( $where )->find();
    }
    
    /**
     * Verify email existence
     */
    public function email_exist_verifition( $username ) {
        $m_user = M( 'usr_login' );
        return $m_user->where( array( 'email' => $username ) )->count() != 0;
    }

    /**
     * User login verification
     */
    public function user_login( $request_data ) {
        $m_user = M( 'usr_login' );
        $request_data[ 'status' ] = '0';
        $res = $m_user->where( $request_data )->find();
        return ( ! empty( $res ) ? $res['id'] : false );
    }
	
	 /**
     * Verify account verification
     */
    public function is_user_verified( $request_data ) {
        $m_user = M( 'usr_login' );
        $request_data[ 'status' ] = '1';
        $res = $m_user->where( $request_data )->find();
        return ( ! empty( $res ) ? $res['id'] : false );
    }
	
	/**
     * Get Verification Code
     */
    public function get_verification_code( $request_data ) {
        $m_user = M( 'usr_login' );
        $res = $m_user->where( $request_data )->find();
        return ( ! empty( $res ) ? $res['verify_code'] : false );
    }
	
	/**
     * Get Email
     */
    public function get_email( $request_data ) {
        $m_user = M( 'usr_login' );
        $res = $m_user->where( $request_data )->find();
        return ( ! empty( $res ) ? $res['email'] : false );
    }

    /**
     * Verify user existence
     */
    public function user_exist_verifition( $request_data ) {
        $m_user = M( 'usr_login' );

        if ( isset ( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
        } else if ( isset( $request_data['email'] ) ) {
            $where = array( 'email' => $request_data['email'] );
        } else {
            return false;
        }

        return $m_user->where( $where )->count() > 0;
    }

    /**
     * Verify user info existence
     */
    public function user_info_exist_verifition( $request_data ) {
        $m_info = M( 'usr_info' );

        if ( isset ( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
        } else if ( isset( $request_data['usr_login_id'] ) ) {
            $where = array( 'usr_login_id' => $request_data['usr_login_id'] );
        } else {
            return false;
        }

        $where['status'] = '0';
        
        return $m_info->where( $where )->count() > 0;
    }

    /**
     * Verify user password correctness
     */
    public function password_exist_verifition( $request_data ) {
        $m_login = M( 'usr_login' );
        $where = array();

        if ( isset( $request_data['id'] ) ) {
            $where['id'] = $request_data['id'];
        }
        if ( isset( $request_data['email'] ) ) {
            $where['email'] = $request_data['email'];
        }
        if ( isset( $request_data['password'] ) ) {
            $where['password'] = $request_data['password'];
        }

        if ( empty( $where ) ) {
            return false;
        }

        return $m_login->where( $where )->count() > 0;
    }
    
    /**
     * Create new message
     */
    public function user_info_add( $request_data ) {
        $m_user_info = M( 'usr_info' );
        if ( ! $m_user_info->create( $request_data ) ) {
            return false;
        } else {
            return $m_user_info->add();
        }
    }

    /**
     * Get user info
     */
    public function get_user_info( $request_data ) {
        $where = array();
        if ( isset ( $request_data['id'] ) ) {
            array_push( $where, "usr_info.`id` = '{$request_data['id']}'" );
        }
        if ( isset( $request_data['usr_login_id'] ) ) {
            array_push( $where, "usr_info.`usr_login_id` = '{$request_data['usr_login_id']}'" );
        }
        if ( empty( $where ) ) {
            return false;
        }

        array_push( $where, "usr_info.`status` = '0'" );
		
        $info = $this->where( implode( ' AND ', $where ) )->find();
		
        if ( ! empty( $info ) ) {
            $info['archive_tags'] = unserialize( $info['archive_tags'] );
        }

        return $info;
    }

    /**
     * Get user info List
     */
    public function get_users_info( $request_data ) {
        $m_user = M( 'usr_info' );
        $m_attachment = M( 'attachments' );

        if ( isset ( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
        } else if ( isset( $request_data['login_id'] ) ) {
            $where = array( 'usr_login_id' => $request_data['login_id'] );
        } else if ( isset( $request_data['usr_login_ids'] ) ) {
            $where = array( 'usr_login_id' => array( 'in', $request_data['usr_login_ids'] ) );
        } else {
            return false;
        }

        $where[ 'status' ] = '0';

        $infos = $m_user->where( $where )->select();

        foreach ( $infos as $key => $info ) {
            if ( ! empty( $info ) && ! empty ( $info['head_img'] ) ) {
                $infos[ $key ]['head_img_url'] = $m_attachment->where( array( 'id' => $info['head_img'] ) )->getField( 'url' );
                $infos[ $key ]['archive_tags'] = unserialize( $infos[ $key ]['archive_tags'] );
            }
        }

        return $infos;
    }

    /**
     * Verify user info existence
     */
    public function user_info_exists( $request_data ) {
        $m_user_info = M( 'usr_info' );

        if ( isset( $request_data['usr_login_id'] ) ) {
            $where = array( 'usr_login_id' => $request_data['usr_login_id'] );
        } else if ( isset( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
        } else {
            return false;
        }

        return $m_user_info->where( $where )->count() > 0;
    }

    /**
     * Update user info
     */
    public function update_user_info ( $request_data ) {
         $m_user = M( 'usr_info' );

        if ( isset ( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
            unset( $request_data['id'] );
        } else if ( isset( $request_data['usr_login_id'] ) ) {
            $where = array( 'usr_login_id' => $request_data['usr_login_id'] );
            unset( $request_data['usr_login_id'] );
        } else {
            return false;
        }

        $where[ 'status' ] = '0';

        if ( isset( $request_data['archive_tags'] ) && is_array( $request_data['archive_tags'] ) ) {
            $request_data['archive_tags'] = serialize( $request_data['archive_tags'] );
        }

        return $m_user->where( $where )->save( $request_data );
    }

    /**
     * Modify user password
     */
    public function change_password( $request_data ) {
        $m_user = M( 'usr_login' );
        
        if ( isset ( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
        } else if ( isset( $request_data['email'] ) ) {
            $where = array( 'email' => $request_data['email'] );
        } else {
            return false;
        }

        return $m_user->where( $where )->save( array( 'password' => $request_data['password'] ) );
    }

    /**
     * User modify email (username)
     */
    public function change_email( $request_data ) {
        $m_user = M( 'usr_login' );
        
        if ( isset ( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
        } else {
            return false;
        }

        return $m_user->where( $where )->save( array( 'email' => $request_data['email'], 'verify_code' => '' ) );
    }

    public function get_temp_email( $request_data ) {
        $m_user = M( 'usr_login' );

        if ( isset( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
        } else {
            return false;
        }

        return $m_user->where( $where )->getField( 'temp_email' );
    }

    /**
     * Add temporary EMAIL for user to modify 
     */
    public function add_temp_email( $request_data ) {
        $m_user = M( 'usr_login' );

        if ( isset( $request_data['id'] ) ) {
            $where = array( 'id' => $request_data['id'] );
        } else {
            return false;
        }

        return $m_user->where( $where )->save( array( 'temp_email' => $request_data['temp_email'], 'verify_code' => $request_data['verify_code'] ) );
    }
    
    /**
     * Get all users, AND set ID as key
     */
    public function get_users($request_data){
    	$m_user = M('usr_login');
    	
    	if(isset($request_data['status'])){
    		$where['status'] = $request_data['status'];
    	}
    	
    	if(!$where){
    		return false;
    	}
    	
    	$temp=$m_user->where($where)->select();
    	foreach ($temp as $k=>$v){
    		$users[$v['id']]=$v;
    	}
    	return $users;
    }
}
