<?php

/**
 * OSS Framework
 *
 * This file is part of the "OSS Framework" - a library of tools, utilities and
 * extensions to the Zend Framework V1.x used for PHP application development.
 *
 * Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * All rights reserved.
 *
 * Open Source Solutions Limited is a company registered in Dublin,
 * Ireland with the Companies Registration Office (#438231). We
 * trade as Open Solutions with registered business name (#329120).
 *
 * Contact: Barry O'Donovan - info (at) opensolutions (dot) ie
 *          http://www.opensolutions.ie/
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * It is also available through the world-wide-web at this URL:
 *     http://www.opensolutions.ie/licenses/new-bsd
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@opensolutions.ie so we can send you a copy immediately.
 *
 * @category   OSS_Tests
 * @package    OSS_Tests_License
 * @copyright  Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 * @link       http://www.opensolutions.ie/ Open Source Solutions Limited
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @author     The Skilled Team of PHP Developers at Open Solutions <info@opensolutions.ie>
 */


/**
 * License MD5 tests.
 *
 * @link https://github.com/mdp/gibberish-aes
 * @link http://www.php.net/manual/en/function.openssl-decrypt.php
 * @category   OSS_Tests
 * @package    OSS_Tests_License
 * @copyright  Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @author     The Skilled Team of PHP Developers at Open Solutions <info@opensolutions.ie>
 */

class OSS_License_MD5Test extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    private function _genLicense( $expires )
    {
        $l = new OSS_License_MD5();
        
        for( $i = 0; $i < 10; $i++ )
            $l->setParam( "P{$i}", OSS_String::random( 20 ) );
            
        $l->setParam( "Expires", $expires );
        
        return new OSS_License_MD5( parse_ini_string( $l->generate() ) );
    }
                                            
    public function testsLicenseValidates()
    {
        $company = 'Open Source Solutions Limited';
        
        $l = new OSS_License_MD5();
        $l->setParam( 'Company', $company );
        $l->setParam( 'IssuedTo', 'barry@opensolutions.ie' );

        $l = new OSS_License_MD5( parse_ini_string( $l->generate() ) );
        $this->assertTrue( $l->verify() );
        $this->assertTrue( $l->getParam( 'Company' ) === $company );
    }
    
    public function testsLicenseExpiresFuture()
    {
        $l = $this->_genLicense( '2999-01-01' );
        $this->assertTrue( $l->verify() );
    }
    
    /**
     * @expectedException OSS_License_ExpiredException
     */
    public function testsLicenseExpired()
    {
        $l = $this->_genLicense( '2012-01-01' );
        $this->assertTrue( $l->verify() );
    }
    
    public function testsLicenseExpiresToday()
    {
        $l = $this->_genLicense( date( 'Y-m-d' ) );
        $this->assertTrue( $l->verify() );
    }


    public function testsLicenseReallyValidates()
    {
        $company = 'Telcom Limited';
        
        $l = new OSS_License_MD5();
        $l->setParam( 'Company', $company );
        $l->setParam( 'IssuedTo', 'leightonbrennan@telcom.ie' );
        $l->setParam( 'Expires', '2013-12-31' );
        $l->setParam( 'Issued', '2012-12-01' );
        $l->setParam( 'PrimaryModule', 'Call-Recorder' );

        die( $l->generate() );
    }
  
}

