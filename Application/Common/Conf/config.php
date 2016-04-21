<?php

define( 'PET' ) or define( 'PET', 'pet' );

// Website user-defined system constants
define( 'PET_ROOT' ) or define( 'PET_ROOT', __DIR__ . '/../../' );
define( 'PET_COMMON' ) or define( 'PET_COMMON', PET_ROOT . 'Common/' );
define( 'PET_VENDOR' ) or define( 'PET_VENDOR', PET_ROOT . 'vendor/' );
define( 'PET_PUBLIC' ) or define( 'PET_PUBLIC', PET_ROOT . 'Public/' );
define( 'PET_UPLOAD' ) or define( 'PET_UPLOAD', PET_ROOT . 'Uploads/' );
define( 'PET_I18N' ) or define( 'PET_I18N', PET_ROOT . '../i18n' );

define( 'PET_DOMAIN' ) or define( 'PET_DOMAIN', '127.0.0.1' );
define( 'PET_ROOT_URL' ) or define( 'PET_ROOT_URL', '/Application/' );
define( 'PET_COMMON_URL' ) or define( 'PET_COMMON_URL', PET_ROOT_URL . 'Common/' );
define( 'PET_PUBLIC_URL' ) or define( 'PET_PUBLIC_URL', PET_ROOT_URL . 'Public/' );
define( 'PET_UPLOAD_URL' ) or define( 'PET_UPLOAD_URL', PET_ROOT_URL . 'Uploads/' );


include_once PET_COMMON . 'Data/enum.php';
include_once PET_COMMON . 'Data/plugin.php';
include_once PET_COMMON . 'Data/email.php';

include_once PET_COMMON . 'Inc/function.php';
include_once PET_COMMON . 'Inc/autoloader.php';
include_once PET_COMMON . 'Inc/bit_operation.php';
include_once PET_COMMON . 'Inc/log_operation.php';
include_once PET_COMMON . 'Inc/time_operation.php';
include_once PET_COMMON . 'Inc/file_operation.php';
include_once PET_COMMON . 'Inc/array_operation.php';
include_once PET_COMMON . 'Inc/image_operation.php';
include_once PET_COMMON . 'Inc/string_operation.php';

include_once PET_COMMON . 'Inc/Payment/paypal.php';
include_once PET_VENDOR . 'autoload.php';

/*
Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('9c482py93hwswq5d');
Braintree_Configuration::publicKey('7s4kzv8v9g6rhkd7');
Braintree_Configuration::privateKey('9bca1f3450a02085f50a8c07ff3da9f1');
*/

return array(
    /***** system *****/

    // Configuration files, DO NOT allow user to edit
    'PLUGINS_CONFIG_XML' => PET_COMMON . 'Data/plugin.xml', // Static file configuration path
    'CUSTOM_CONFIG_XML' => PET_COMMON . 'Conf/config.xml',  // User configuration file path

    'TMPL_ACTION_ERROR' => '../../Base/View/Notice/error',      // Default error jump to template file
    'TMPL_ACTION_SUCCESS' => '../../Base/View/Notice/success',  // Default success jump to template file
    'TMPL_TEMPLATE_SUFFIX' => '.php',

    // Database configuration information
    'DB_TYPE'   => 'mysql',     // Database type
    'DB_HOST'   => '', // Server address
    'DB_NAME'   => 'pet',       // Database name
    'DB_USER'   => 'root',      // User name
    'DB_PWD'    => '',          // Password
    'DB_PORT'   => 3306,        // Port
    'DB_PREFIX' => 'pet_',      // Database table prefix
    'DB_CHARSET'=> 'utf8',      // Charset
    'DB_DEBUG'  =>  TRUE,       // Debug module

    // Website mailbox system configuration
    'MAIL_HOST' => 'smtp.qq.com',
    'MAIL_SMTPAUTH' => true,
    'MAIL_SMTPSECURE' => 'ssl',
    'MAIL_USERNAME' => 'z@kbdsbx.com',
    'MAIL_PASSWORD' => 'mtzk9b',
    'MAIL_PORT' => '465',

    'MAIL_ADMIN_MAIL' => 'z@kbdsbx.com',
    'MAIL_ADMIN_NAME' => 'Administrator',


    /***** web *****/

    'PET_UPLOAD_PATH' => PET_PUBLIC,    // Upload file directory
    'PET_UPLOAD_URL' => PET_PUBLIC_URL, // Upload file directory URL
    'PET_UPLOAD_IMAGE_FILTER' => array (// Upload picture acceptable format
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
    ),

    'DATE_FORMAT' => 'M d',             // Default date format
    'DATE_LONG_FORMAT' => 'M d Y',      // Default long date format
    'TIME_FORMAT' => 'H:i:s',           // Default time format
    'DATE_TIME_FORMAT' => 'Y-m-d H:i:s',// Default date and time format

    'MAP_DEFAULT_LAT' => 1.352083,      // Default display latitude (Singapore)
    'MAP_DEFAULT_LNG' => 103.819836,    // Default display longitude (Singapore)
    'MAP_DEFAULT_ZOOM' => 9,            // Search geographical default map display level
    'MAP_DEFAULT_HOME_ZOOM' => 9,       // Default map display level user location

    'DEFAULT_HEAD_IMG' => PET_PUBLIC_URL . 'images/content/user.jpg',   // User default avatar URL
    'DEFAULT_ADMIN_HEAD_IMG' => PET_PUBLIC_URL . 'images/content/admin.jpg',   // System default avatar URL
    'HEAD_IMG_WIDTH' => 200,
    'HEAD_IMG_HEIGHT' => 200,

    // Transaction configuration
    'SERVICE_FEE' => '13',         // Service commission percentage
	'PLATFORM_FEE' => '40',         // PLatform fee percentage
    'PET_CURRENCY' => 'SGD',       // Current currency unit used
    'PET_SYMBOL' => '$',           // Current currency symbol used

    'PAYPAL_BASE_URL' => 'https://api.sandbox.paypal.com/v1',
    'PAYPAL_TOKEN_USER' => 'ARXny0C6dWEfFC9e-QrE56HUmBEmoyalDYWL9YzGJWYrNuLLfggSWRIQqRFZv4O8RDjFmkzFhtpH9cW-',
    'PAYPAL_TOKEN_PWD' => 'EEe7xbVbt6HTz66IAWkYfOjNzpyvuadtCc45ZtVOHbqXIjMmGykOoPTqdFZxV3iBCRYgAVjw0hxHXY1z',

    // Third party login 
    'FACEBOOK_APP_ID' => '1564374820485383',    // Facebook App id
    
    'PAGED' => '20',               // Number of sub-pages
    'INTERCEPT_BASE' => 100,       // Extract character/symbol 

    'LOG_GRANULARITY' => 3,


    // Company
    'COMPANY_PHONE' => '+400 800 8888',

    // Default message for booking
    'DEFAULT_BOOKING_TITTLE' => 'This is default title.',
    'DEFAULT_BOOKING_LETTER' => 'This is default letter.',

    'DEFAULT_LANG' => 'en_SG',


    'SERVICE_COMPENSATION' => 50,
);

