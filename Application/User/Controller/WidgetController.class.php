<?php

namespace User\Controller;
use Think\Controller;
use Base\Controller as BaseController;

class WidgetController extends BaseController\WidgetController {
    public function __construct() {
        parent::__construct();
        $this->_urls = array (
            _( 'Dashboard' ) => array (
                'icon' => 'fa-tachometer',
                'url' => U( 'User/Home/index' ),
            ),
            _( 'Message Notification' ) => array (
                'index' => U( 'User/Letter/letter_box' ),
                'icon' => 'fa-comments-o',
                'User' => array (
                    _( 'Inbox' ) => array( 
                        'icon' => '',
                        'url' => U( 'User/Letter/letter_box' ),
                    ),
                	_( 'My Meet & Greet Request' )=>array(
                    	'icon'=>'',
                		'url' => U('User/Letter/meet_request_sent')
                    ),
                    /*_( 'Sent' ) => array( 
                        'icon' => '',
                        'url' => U( 'User/Letter/sent' ),
                    ),*/
                	_( 'My Booking Request' ) => array(
                		'icon'=>'',
                		'url' => U('User/Letter/book_request')
                	),
                    _( 'Archive' ) => array( 
                        'icon' => '',
                        'url' => U( 'User/Letter/archive' ),
                    ),
                ),
            	'Host' => array(
                    _( 'Booking Enquiries' ) => array(
            			'icon'=>'',
                    	'url' => U('User/Letter/book_response')
            		),
					_( 'Requested Meet & Greet' ) => array( 
                        'icon' => '',
                        'url' => U( 'User/Letter/meet_request' ),
                    )
                )
            ),
            _( 'Booking' ) => array (
                'index' => U( 'User/Booking/booking' ),
                'icon' => 'fa-bookmark-o',
                'User' => array (
                    _( 'Current Booking' ) => array( 
                        'icon' => '',
                        'url' => U( 'User/Booking/booking' ),
                    ),
                    _( 'Previous Booking' ) => array(
                        'icon' => '',
                        'url' => U( 'User/Booking/previous' ),
                    ),
                    _( 'Saved Providers' ) => array( 
                        'icon' => '',
                        'url' => U( 'User/Letter/new_letter' ),
                    ),
                ),
                'Host' => array (
                   /* _( 'Current Service' ) => array( 
                        'icon' => '',
                        'url' => U( 'User/Booking/current_service' ),
                    ),*/
                    _( 'Booked Service' ) => array( 
                        'icon' => '',
                        'url' => U( 'User/Booking/booking_service' ),
                    ),
                    _( 'Previous Service' ) => array( 
                        'icon' => '',
                        'url' => U( 'User/Booking/previous_service' ),
                    ),
                ),
            ),
            _( 'Account' ) => array (
                'index' => U( 'User/Account/account_records' ),
                'icon' => 'fa-credit-card',
                'User' => array (
                    _( 'My Order Records' ) => array( 
                        'icon' => '',
                        'url' => U( 'User/Account/account_records' ),
                    ),
                ),
                'Host' => array (
                    _( 'My Revenue Records' ) => array( 
                        'icon' => '',
                        'url' => U( 'User/Account/host_records' ),
                    ),
                	'Request Withdrawal'=>array(
                    	'icon'=>'',
                		'url'=>U('User/Account/withdraw')
                    ),
                    _( 'Account Setting' ) => array( 
                        'icon' => '',
                        'url' => U( 'User/Account/setting' ),
                    )
                ),
            ),
            _( 'Profile' ) => array (
                'index' => U( 'User/Profile/index' ),
                'icon' => 'fa-pencil-square-o',
                'User' => array (
                    _( 'Profile' ) => array( 
                        'icon' => '',
                        'url' => U( 'User/Profile/index' ),
                    ),
                ),
                'Host' => array (
                    _( 'Services Provided' ) => array( 
                        'icon' => '',
                        'url' => U( 'User/Host/provided' ),
                    ),
                    _( 'Your Listing' ) => array( 
                        'icon' => '',
                        'url' => U( 'User/Host/listing' ),
                    ),
                    _( 'Preview' ) => array (
                        'icon' => '',
                        'url' => U( 'User/Host/view' ),
                    ),
                ),
            ),
        );

        $this->assign( '_current_url', __SELF__ );
    }

    /**
     * User Global URLs, contains all user accessible URLs
     */
    public $_urls;

    /**
     * Add ACTION URLs in service
     */
    public function _add_current_service() {
        // Press link to header
        $this->_urls[ _( 'Booking' ) ]['index'] = U( 'User/Booking/current' );
        $t_arr = array_reverse( $this->_urls[ _( 'Booking' ) ]['User'], true ); 
        $t_arr[ _( 'Current' ) ] = array( 'icon' => '', 'url' => U( 'User/Booking/current' ) );
        $this->_urls[ _( 'Booking' ) ]['User'] = array_reverse( $t_arr, true );
    }

    public function _add_my_calendar() {
        $this->_urls[ _( 'My calendar' ) ] = array( 
            'icon' => 'fa-calendar',
            'url' => U( 'User/Booking/calendar' ),
        );
    }

    /**
     * Add pop-up box
     */
    public function dialog() {
        $this->assign( '_dialog', $this->fetch( T( 'User@Widget/dialog' ) ) );
    }

    /**
     * User navigation
     */
    public function user_navigation() {

        // have serve
        /*if ( $this->_current_exist() ) {
            $this->_add_current_service();
        }*/
        if ( $this->host_exist() ) {
            $this->_add_my_calendar();
        }

        if ( CONTROLLER_NAME == "Letter" && ACTION_NAME == "archive" ) {
            $this->_archive_tags();
        }
		$meet_request_reply_count = D( 'Letter' )->get_meet_request_reply_count( array( 'usr_login_id' => get_session_id() ) );
		$this->assign( 'meet_request_reply_count', $meet_request_reply_count );
        $unresponded_letter_count = D( 'Letter' )->get_unrespond_letters_count( array( 'usr_login_id' => get_session_id() ) );
        $this->assign( 'unresponded_letter_count', $unresponded_letter_count );
        $this->assign( '_urls', $this->_urls );
        $this->assign( '_user_navigation', $this->fetch( T( 'User@Widget/navigation' ) ) );
    }

    /**
     * Users breadcrumbs
     */
    public function breadcrumb_navigation() {
        $breadcrumbs = array();
        array_push( $breadcrumbs, array( 'name' => _( 'My PetKeepa' ), 'url' => U( '/User/Home/index' ) ) );
        foreach ( $this->_urls as $key => $urls ) {
            if ( rec_in_array( __SELF__, $urls, true ) ) {
                array_push( $breadcrumbs, array( 'name' => $key, 'url' => ( isset( $urls['index'] ) ? $urls['index'] : $urls['url'] ) ) );

                if ( isset( $urls['User'] ) ) {
                    foreach( $urls['User'] as $sub_key => $sub_url ) {
                        if ( rec_in_array( __SELF__, $sub_url, true ) ) {
                            array_push( $breadcrumbs, array( 'name' => $sub_key, 'url' => $sub_url['url'] ) );
                        }
                    }
                }
                
                if ( isset( $urls['Host'] ) ) {
                    foreach( $urls['Host'] as $sub_key => $sub_url ) {
                        if ( rec_in_array( __SELF__, $sub_url, true ) ) {
                            array_push( $breadcrumbs, array( 'name' => $sub_key, 'url' => $sub_url['url'] ) );
                        }
                    }
                }
            }
        }
        $this->assign( '_breadcrumbs', $breadcrumbs );
        $this->assign( '_breadcrumb_navigation', $this->fetch( T( 'User@Widget/breadcrumb' ) ) );
    }

    /**
     * New Host navigation
     */
    public function new_host_navigation() {
        $_host_navigation = '';

        // Completed editing of required content?
        if ( $this->host_exist() ) {
            $_host_navigation = $this->fetch( T( 'User@Widget/new_host_navigation' ) );
        }

        $this->assign( '_new_host_navigation', $_host_navigation );
    }

    /**
     * HOST navigation
     */
    public function user_host_navigation() {
        /*if ( $this->_current_exist() ) {
            $this->_add_current_service();
        }*/

        $this->assign( '_urls', $this->_urls );

        // become a host
        if ( $this->host_exist() ) {
            $_host_navigation = $this->fetch( T( 'User@Widget/host_navigation' ) );
        } else {
            $_host_navigation = $this->fetch( T( 'User@Widget/be_host' ) );
        }
        $this->assign( '_user_host_navigation', $_host_navigation );
    }

    /**
     * User-level menu
     */
    public function user_menu() {
        // have serve
        /*if ( $this->_current_exist() ) {
            $this->_add_current_service();
        }*/

        $this->assign( '_urls', $this->_urls );
        $this->assign( '_user_menu', $this->fetch( T( 'User@Widget/menu' ) ) );
    }

    /**
     * Mail archive level 3 menu
     */
    private function _archive_tags() {
        $tags = D( 'User/User' )->get_user_info( array( 'usr_login_id' => get_session_id() ) );

        $tag_urls = array();
        foreach( $tags['archive_tags'] as $v ) {
            $tag_urls[ $v ] = U( '/User/Letter/archive?tag=' . $v );
        }

        $this->_urls[ _( 'Message Notification' ) ]['User'][ _( 'Archive' ) ]['urls'] = $tag_urls;
    }

    /**
     * Verify if user is HOST
     */
    public function host_exist() {
        return D( 'User/Host' )->host_exist_verifition( array( 'usr_login_id' => get_session_id() ) );
    }

    public function host_completion() {
         
        $d_host = D( 'User/Host' );
        $user_id = get_session_id();

        $host = $d_host->get_host( array( 'usr_login_id' => $user_id ) );

        if ( ! empty( $host ) ) {
            $complete = 100;
            $host_field = array (
                'property_type',
                'title',
                'pics',
                'self_description',
                'additional',
                'service_provided',
                'service_size_accepted',
                'service_cancellation',
                'service_types',
                'country',
                'division_level_first',
                'division_level_second',
                'zip_code',
                'street',
                'lat',
                'lng',
            );
            foreach( $host_field as $field ) {
                if ( empty( $host[ $field ] ) ) {
                    $complete -= ( 100 / count( $host_field ) );
                }
            }
            return ( int )$complete > 0 ? ( int )$complete : 0;
        }

        return false;
    }

    public function info_completion() {
        
        $d_user = D( 'User/User' );
        $user_id = get_session_id();

        $info = $d_user->get_user_info( array( 'usr_login_id' => $user_id ) );

        $complete = 100;
        // complete profile
        $info_field = array(
            'first_name',
            'last_name',
            'gender',
            'country_code',
            'mobile',
            'head_img_url',
            'emergency_name',
            'emergency_mobile',
            'emergency_country_code',
        );
        foreach( $info_field as $field ) {
            if ( empty( $info[ $field ] ) ) {
                $complete -= ( 100 / count( $info_field ) );
            }
        }
        return ( int )$complete > 0 ? ( int )$complete : 0;
    }

    public function user_info_complete() {
        $user = D( 'User/User' )->get_user( array( 'id' => get_session_id() ) );
        $user_info = D( 'User/User' )->get_user_info( array( 'usr_login_id' => get_session_id() ) );
        if ( ! empty( $user ) && empty( $user_info ) ) {
            $this->error( 'Please take a moment to complete your basic profile details.', U( '/Home/User/information' ) );
            exit();
        }
    }

    /**
     * Verify if user has booked service OR has service in-progress
     */
    private function _current_exist() {
        return D( 'Service' )->service_exist_verifition( array( 'usr_login_id_buyer' => ( get_session_id() ), 'service_status' => array( '2' ) ) );
    }
}
