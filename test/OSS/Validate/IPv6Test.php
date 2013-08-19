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
 * Validate IPv6 tests.
 *
 * @category   OSS_Tests
 * @package    OSS_Tests_Filter
 * @copyright  Copyright (c) 2007 - 2013, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @author     The Skilled Team of PHP Developers at Open Solutions <info@opensolutions.ie>
 */

class OSS_Validate_IPv6Test extends PHPUnit_Framework_TestCase
{
    private $_validator;

    public function setUp()
    {
        $this->_validator = new OSS_Validate_OSSIPv6();
    }

    public function testValidAddress()
    {
        $this->assertTrue( $this->_validator->isValid( '2001:db8:2::97' ) );
        $this->assertTrue( $this->_validator->isValid( '2001:0db8:0002::0097' ) );
        $this->assertTrue( $this->_validator->isValid( '2001:0db8:0002:0000:0000:0000:0000:0097' ) );
        $this->assertTrue( $this->_validator->isValid( '2001:DB8:2:0:0:0:0:97' ) );
        $this->assertTrue( $this->_validator->isValid( '2001:db8:2::127.5.68.45' ) );
    }

    public function testInvalidAddress()
    {
        $this->assertFalse( $this->_validator->isValid( '2001:db8:2::z97' ) );
        $this->assertFalse( $this->_validator->isValid( '2001:0db8:0002::000097' ) );
        $this->assertFalse( $this->_validator->isValid( '2001:0db8:0002:0000:0000:0000:0000:0000:0097' ) );
        $this->assertFalse( $this->_validator->isValid( '2001:DB8:2::0:0::97' ) );
    }
}

