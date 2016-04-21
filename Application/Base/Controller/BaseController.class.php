<?php

namespace Base\Controller;
use Think\Controller;

class BaseController extends Controller {
    public $_messages = array();
    public $_errors = array();
    public $_infos = array();

    public function __construct() {
        parent::__construct();

        $this->i18n();

        $this->_set_custom_config();

        $this->_header();
        $this->_navigation();
		$this->_navigation_alt();
        $this->_footer();
        $this->_simple_footer();
    }

    protected function add_error( $error ) {
        array_push( $this->_errors, $error );
        $this->assign( '_errors', $this->_errors );
    }

    protected function add_message( $message ) {
        array_push( $this->_messages, $message );
        $this->assign( '_messages', $this->_messages );
    }

    protected function add_info( $info ) {
        array_push( $this->_infos, $info );
        $this->assign( '_infos', $this->_infos );
    }

    protected function assign_message() {
        $message_content = $this->fetch( T( 'Base@Base/inline_message' ) );
        $this->assign( '_message', $message_content );
        return $message_content;
    }

    protected function assign_error() {
        $error_content = $this->fetch( T( 'Base@Base/inline_error' ) );
        $this->assign( '_error', $error_content );
        return $error_content;
    }

    protected function assign_info() {
        $info_content = $this->fetch( T( 'Base@Base/inline_info' ) );
        $this->assign( '_info', $info_content );
        return $info_content;
    }

    protected function has_error() {
        return count( $this->_errors ) > 0;
    }

    protected function i18n() {
        $lang = C( 'DEFAULT_LANG' );
        if ( $user_lang = $this->_get_user_lang() ) {
            $lang = $user_lang;
        }
        if ( I( 'request.lang' ) ) {
            $lang = I( 'request.lang' );
        }
        setlocale( LC_ALL, $lang );
        putenv( 'LANG=' . $lang );

        bindtextdomain( PET, PET_I18N );
        bind_textdomain_codeset( PET, 'UTF-8' );

        textdomain( PET );
    }

    private function _get_user_lang() {
        if ( $user_id = get_session_id() ) {
            $d_user = D( 'User/User' );
            $user = $d_user->get_user_info( array( 'usr_login_id' => $user_id ) );

            if ( ! empty( $user['languages_spoken'] ) ) {
                return $GLOBALS['pet_languages'][ $user['languages_spoken'] ];
            }
        }

        return false;
    }

    private function _get_plugins() {
        $xml_path = C( 'PLUGINS_CONFIG_XML' );
        $xml = new \SimpleXMLElement( $xml_path, 0, true );

        $module_name = strtolower( MODULE_NAME );
        $controller_name = strtolower( CONTROLLER_NAME );
        $action_name = strtolower( ACTION_NAME );
        $plugins = $xml->xpath( "/pet_plugins/modules/{$module_name}/controllers/{$controller_name}/actions/{$action_name}/plugins/*" );

        foreach ( $plugins as $key => $plugin ) {
            $plugins[ $key ] = $plugin->__toString();
        }

        return $plugins;
    }

    private function _header() {
        // Get header content by parsing template, DO NOT use ‘Include’ template
        $_plugins = $this->_get_plugins();
        $_plugins = $this->_set_base_plugin( $_plugins );

        $this->_css = $this->_set_css( $_plugins );
        $this->_base = $this->_set_css( array( '_base' ) ) . "\n" . $this->_set_js( array( '_base' ) );

        $this->assign( '_header_css', $this->_css );
        $this->assign( '_baser', $this->_base );

        $header_content = $this->fetch( T( 'Base@Base/header' ) );
        $this->assign( '_header', $header_content );
    }

    private function _navigation() {
        $login_user = D( 'User/User' )->get_user_login( array( 'id' => get_session_id() ) );
        $login_user_info = D( 'User/User' )->get_user_info( array( 'usr_login_id' => get_session_id() ) );
        $unread_letter_count = D( 'User/Letter' )->get_unread_letters_count( array( 'usr_login_id_to' => get_session_id() ) );
		$newbooking_count = D('User/Service')->get_newbooking_count(array( 'usr_login_id_seller' => get_session_id() ));
		$unread_sent_meet_greet_count = D( 'User/Letter' )->get_meet_request_reply_count( array( 'usr_login_id' => get_session_id() ) );
		$unread_received_meet_greet_count = D( 'User/Letter' )->get_unrespond_letters_count( array( 'usr_login_id' => get_session_id() ) );
		$total_unread_letters = $unread_letter_count + $unread_sent_meet_greet_count + $unread_received_meet_greet_count;
        $this->assign( '_self', __SELF__ );
        $this->assign( 'login_user', $login_user );
        $this->assign( 'login_user_info', $login_user_info );
        $this->assign( 'total_unread_letters', $total_unread_letters );
		$this->assign( 'unread_letter_count', $unread_letter_count );
		$this->assign('newbooking_count',$newbooking_count);
        $navigation_content = $this->fetch( T( 'Base@Base/navigation' ) );
        $this->assign( '_navigation', $navigation_content );
    }
	
	private function _navigation_alt() {
        $login_user = D( 'User/User' )->get_user_login( array( 'id' => get_session_id() ) );
        $login_user_info = D( 'User/User' )->get_user_info( array( 'usr_login_id' => get_session_id() ) );
        $unread_letter_count = D( 'User/Letter' )->get_unread_letters_count( array( 'usr_login_id_to' => get_session_id() ) );
		$newbooking_count = D('User/Service')->get_newbooking_count(array( 'usr_login_id_seller' => get_session_id() ));
		$unread_sent_meet_greet_count = D( 'User/Letter' )->get_meet_request_reply_count( array( 'usr_login_id' => get_session_id() ) );
		$unread_received_meet_greet_count = D( 'User/Letter' )->get_unrespond_letters_count( array( 'usr_login_id' => get_session_id() ) );
		$total_unread_letters = $unread_letter_count + $unread_sent_meet_greet_count + $unread_received_meet_greet_count;
        $this->assign( '_self', __SELF__ );
        $this->assign( 'login_user', $login_user );
        $this->assign( 'login_user_info', $login_user_info );
        $this->assign( 'total_unread_letters', $total_unread_letters );
		$this->assign( 'unread_letter_count', $unread_letter_count );
		$this->assign('newbooking_count',$newbooking_count);
        $navigation_content = $this->fetch( T( 'Base@Base/navigation_alt' ) );
        $this->assign( '_navigation_alt', $navigation_content );
    }

    private function _footer() {
        $_plugins = $this->_get_plugins();
        $_plugins = $this->_set_base_plugin( $_plugins );
        $this->_js = $this->_set_js( $_plugins );
        $this->assign( '_footer_js', $this->_js );

        $footer_content = $this->fetch( T( 'Base@Base/footer' ) );
        $this->assign( '_footer', $footer_content );
    }

    private function _simple_footer() {
        $_plugins = $this->_get_plugins();
        $_plugins = $this->_set_base_plugin( $_plugins );
        $this->_js = $this->_set_js( $_plugins );
        $this->assign( '_footer_js', $this->_js );

        $footer_content = $this->fetch( T( 'Base@Base/simple_footer' ) );
        $this->assign( '_simple_footer', $footer_content );
    }

    private function _set_base_plugin( $plugins ) {
        if ( ! is_array ( $plugins ) ) {
            $plugins = array();
        }
        if ( false === in_array( '_before', $plugins ) ) {
            array_unshift( $plugins, '_before' );
        }
        if ( false === in_array( '_after', $plugins ) ) {
            array_push( $plugins, '_after' );
        }

        return $plugins;
    }

    /**
     * Get current set of Request page CSS files
     */
    private function _set_css( $plugins ) {
        global $pet_plugin_files;
        $_css = '';
        foreach ( $plugins as $key ) {
            $_plugin = $pet_plugin_files[ $key ];
            $domain = isset( $_plugin['domain'] ) ? $_plugin['domain'] : PET_PUBLIC_URL;
            if ( ! empty( $_plugin['css'] ) ) {
                foreach( $_plugin['css'] as $c ) {
                    $c_p = $domain . $c;
                    $_css .= "<link rel='stylesheet' type='text/css' href='{$c_p}'>\n\r";
                }
            }
        }
        
        return $_css;
    }

    /**
     * Get current set of Request page JS files
     */
    private function _set_js( $plugins ) {
        global $pet_plugin_files;
        $_js = '';
        foreach ( $plugins as $key ) {
            $_plugin = $pet_plugin_files[ $key ];
            $domain = isset( $_plugin['domain'] ) ? $_plugin['domain'] : PET_PUBLIC_URL;
            if ( ! empty( $_plugin['js'] ) ) {
                foreach( $_plugin['js'] as $c ) {
                    $c_p = $domain . $c;
                    $_js .= "<script type='text/javascript' src='{$c_p}'></script>\n\r";
                }
            }
        }

        return $_js;
    }

    /**
     * Set up User Profile configuration
     */
    private function _set_custom_config() {
        if ( file_exists( C( 'CUSTOM_CONFIG_XML' ) ) ) {
            $xml = new \SimpleXMLElement( C( 'CUSTOM_CONFIG_XML' ), 0, true );

            $configs = $xml->xpath( '/config/*' );
            foreach( $configs as $config ) {
                if ( null !== C( strtoupper( $config->getName() ) ) ) {
                    $v = $config->__tostring();
                    if ( "true" === strtolower( $v ) ) {
                        $v = true;
                    }
                    if ( "false" === strtolower( $v ) ) {
                        $v = false;
                    }
                    C( strtoupper( $config->getName() ), $v );
                }
            }
        }
    }

    public function refresh_config() {
        $this->_set_custom_config();
    }

    /**
     * Get JSON of enumeration
     */
    public function enum_json() {
        $enum_name = 'pet_' . I( 'get.enum', 'false' ) . '_enum';
        global $$enum_name;
        if ( ! empty( $$enum_name ) ) {
            $this->ajaxReturn( $$enum_name );
        } else {
            $this->ajaxReturn( false );
        }
    }
}


