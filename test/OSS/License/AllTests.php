<?php

require_once( dirname( __FILE__ ) . '/../../bootstrap.php' );

require 'MD5Test.php';

class OSS_License_AllTests
{

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite( 'OSS_License' );

        $suite->addTestSuite( 'OSS_License_MD5Test' );

        return $suite;
    }

}

