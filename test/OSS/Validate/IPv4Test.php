<?php

/**
 * OSS Framework
 *
 * This file is part of the "OSS Framework" - a library of tools, utilities and
 * extensions to the Zend Framework V1.x used for PHP application development.
 *
 * Copyright (c) 2007 - 2013, Open Source Solutions Limited, Dublin, Ireland
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
 * @package    OSS_Tests_Filter
 * @copyright  Copyright (c) 2007 - 2013, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 * @link       http://www.opensolutions.ie/ Open Source Solutions Limited
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @author     The Skilled Team of PHP Developers at Open Solutions <info@opensolutions.ie>
 */


/**
 * Validate IPv4 test.
 *
 * @category   OSS_Tests
 * @package    OSS_Tests_Filter
 * @copyright  Copyright (c) 2007 - 2013, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @author     The Skilled Team of PHP Developers at Open Solutions <info@opensolutions.ie>
 */

require_once( dirname( __FILE__ ) . '/../../bootstrap.php' );

class OSS_Validate_IPv4Test extends PHPUnit_Framework_TestCase
{
    private $_validator;

    public function setUp()
    {
        $this->_validator = new OSS_Validate_OSSIPv4();
    }

    public function testValidAddress()
    {
        $this->assertTrue( $this->_validator->isValid( '127.0.0.1' ) );
        $this->assertTrue( $this->_validator->isValid( '192.168.1.18' ) );
        $this->assertTrue( $this->_validator->isValid( '35.110.254.1' ) );
    }

    public function testInvalidAddress()
    {
        $this->assertFalse( $this->_validator->isValid( '1270.0.0.1' ) );
        $this->assertFalse( $this->_validator->isValid( '192.168.1' ) );
        $this->assertFalse( $this->_validator->isValid( '350.110.254.1' ) );
        $this->assertFalse( $this->_validator->isValid( '192.168.1.2.3' ) );
    }
}

