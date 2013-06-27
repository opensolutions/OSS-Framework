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
 * @category   OSS
 * @package    OSS_Form
 * @copyright  Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 * @link       http://www.opensolutions.ie/ Open Source Solutions Limited
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @author     The Skilled Team of PHP Developers at Open Solutions <info@opensolutions.ie>
 */


/**
 * Utility methods to IPv4 addresses
 *
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @author     The Skilled Team of PHP Developers at Open Solutions <info@opensolutions.ie>
 * @category   OSS
 * @package    OSS_Form
 * @copyright  Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 */
class OSS_Net_IPv4
{
   
    /**
     * Converts IPv4 address to ARPA name.
     *
     * E.g. IPv4 address like 1.2.3.4 will be converted
     * to 4.3.2.1.in-addr.arpa, 
     *
     * @param string $ip IP address to convert
     * @return string
     * @throws OSS_Execption Invalid IPv4 address
     */
    public static function ipv4ToARPA( $ip )
    {
        $long = ip2long( $ip );    
        if( $long == -1 || $long === false )
            throw new OSS_Exception( "Invalid IPv4 address" );

        $parts = explode( '.', $ip );
        return sprintf( '%s.%s.%s.%s.in-addr.arpa', $parts[3], $parts[2], $parts[1], $parts[0] );
    }
    
    
}
