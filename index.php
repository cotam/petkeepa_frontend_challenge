<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// Application index file

// Detect PHP environment
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// Initiate debug mode, recommended for development stage, may set comments to “FALSE” for deployment stage
define('APP_DEBUG',True);

// Custom applications directory
define('APP_PATH','./Application/');

// Import ThinkPHP index file
require './ThinkPHP/ThinkPHP.php';

