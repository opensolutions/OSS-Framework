<?php

// Ensure the is in include_path
#set_include_path( implode( PATH_SEPARATOR, array( dirname( __FILE__ ) . '/..' , get_include_path() ) ) );

#require_once dirname( __FILE__ ) . "/../Zend/Loader/Autoloader.php";
require dirname( __FILE__ ) . "/../vendor/autoload.php";
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace( 'OSS' );

