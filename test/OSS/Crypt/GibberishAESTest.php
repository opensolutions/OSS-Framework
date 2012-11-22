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
 * @package    OSS_Tests_Crypt
 * @copyright  Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 * @link       http://www.opensolutions.ie/ Open Source Solutions Limited
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @author     The Skilled Team of PHP Developers at Open Solutions <info@opensolutions.ie>
 */


/**
 * Gibberish AES encryption tools - tests.
 *
 * Based on https://github.com/mdp/gibberish-aes (MIT) and notes by
 * nbari at dalmp dot com on 15-Jan-2012 07:52 at
 * http://www.php.net/manual/en/function.openssl-decrypt.php
 *
 * @link https://github.com/mdp/gibberish-aes
 * @link http://www.php.net/manual/en/function.openssl-decrypt.php
 * @category   OSS_Tests
 * @package    OSS_Tests_Crypt
 * @copyright  Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 */
class OSS_Crypt_GibberishAESTest extends PHPUnit_Framework_TestCase
{
    
    /**
     * Ensure encryption / decryption actually works
     */
    public function testsEncryptDecrypt()
    {
        $plain    = OSS_String::random( 64 );
        $password = OSS_String::random( 12 );

        $encrypted = OSS_Crypt_GibberishAES::encrypt( $plain, $password );
        $decrypted = OSS_Crypt_GibberishAES::decrypt( $encrypted, $password );
        
        $this->assertTrue( $plain == $decrypted );
    }
    
    /**
     * Test that decryption with a bad password returns false
     */
    public function testsFailedEncryptDecrypt()
    {
        $plain     = OSS_String::random( 64 );
        $password  = OSS_String::random( 12 );
        
        while( ( $password2 = OSS_String::random( 12 ) ) == $password ){}
        
        $encrypted = OSS_Crypt_GibberishAES::encrypt( $plain, $password );
        $decrypted = OSS_Crypt_GibberishAES::decrypt( $encrypted, $password2 );
        
        $this->assertFalse( $decrypted );
    }
    
}

