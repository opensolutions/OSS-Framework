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
 * @package    OSS_Filter
 * @copyright  Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 * @link       http://www.opensolutions.ie/ Open Source Solutions Limited
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @author     The Skilled Team of PHP Developers at Open Solutions <info@opensolutions.ie>
 */

/**
 * @category   OSS
 * @package    OSS_Filter
 * @copyright  Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 */
class OSS_Filter_FileSize implements Zend_Filter_Interface
{
    const SIZE_BYTES     = "B";
    const SIZE_KILOBYTES = "KB";
    const SIZE_MEGABYTES = "MB";
    const SIZE_GIGABYTES = "GB";

    public static $SIZE_MULTIPLIERS = [
        self::SIZE_BYTES => 1,
        self::SIZE_KILOBYTES => 1024,
        self::SIZE_MEGABYTES => 1048576,
        self::SIZE_GIGABYTES => 1073741824
    ];

    /**
     * Corresponds to default multiplier
     *
     * @var string
     */
    protected $_multiplier = self::SIZE_BYTES;

    /**
     * Constructor
     *
     * Sets filter options
     * Valid multiplier options: B, KB, MB, GB. Where case is not sensitive.
     *
     * @param string $multiplier Sets default multiplier it's not set in value.
     * @return void
     * @throws OSS_Exception If multiplier is not one of $SIZE_MULTIPLIERS KEY.
     */
    public function __construct( $multiplier = null )
    {
        if( $multiplier )
        {
            if( array_key_exists( strtoupper( $multiplier ), self::$SIZE_MULTIPLIERS ) )
                $this->_multiplier = strtoupper( $multiplier );
            else
                throw new OSS_Exception( "Trying to set unknown multiplier for FileSize filter." );
        }

    }

    /**
     * Takes string input and returns size in bytes. 
     * 
     *  10KB, 10Kb, 10kb, 10k input will return 10240 value.
     *  1000 KB, 1000K, 0.98MB input will return 1024000
     *  0.9MB, 0.9m, 0.9mb, 0.9 MB input will return 943718.
     *  2B, 2b, 2 B input will return b.
     *  0.978GSM, 0.8S7M input will return false;
     *  20 will look for parameter defaults.quota.multiplier in application.ini and use as subfix.
     *     else it will return 20.
     *
     * @param string $value String to parse size in bytes
     * @return int|bool
     */
    public function filter( $value )
    {   
        $debug = debug_backtrace();
        
        if( $debug[5]['function'] == "render" || $debug[3]['function'] == "render" )
        {
            if( is_numeric( $value ) )
                return self::unfilter( $value );
            else
                return $value;
        }
        
        $value = str_replace( " ", "", $value );
        
        if( substr_count( $value, "." ) > 1 )
            return false;

        $fsize = preg_replace( "/[^0123456789\.\-]/", '', (string) $value );
        
        if( $fsize == "" ||  $fsize == 0 )
            return 0;
        
        $subfix = false;
        if( strlen( $value ) == strlen( $fsize ) )
            $subfix = $this->_multiplier;
        else if( strlen( $value ) - strlen( $fsize ) == 2 )
            $subfix = strtoupper( substr( $value, -2 ) );
        else if( strlen( $value ) - strlen( $fsize ) == 1 )
        {
            $subfix = strtoupper( substr( $value, -1 ) );
            if( $subfix != self::SIZE_BYTES )
                $subfix .= self::SIZE_BYTES;
        }
        else
            return false;

        
        if( isset( self::$SIZE_MULTIPLIERS[ $subfix ] ) )
            $fsize = $fsize * self::$SIZE_MULTIPLIERS[ $subfix ];
        else 
            return false;
        
        return floor( $fsize );
    }

    /**
     * Takes size input and returns formatted string. 
     * 
     *  10240 input will return 100.00KB value.
     *  1024000 input will return 0.98MB value.
     *  943718 input will 0.90MB return .
     *  20 input will return 20B. 
     *
     * @param int $value String to parse size in bytes
     * @return string
     */
    public static function unfilter( $value )
    {   
        if( !$value )
            return $value;

        if( $value / self::$SIZE_MULTIPLIERS[ self::SIZE_KILOBYTES ] < 0.1 )
            return $value . self::SIZE_BYTES;
        elseif( $value / self::$SIZE_MULTIPLIERS[ self::SIZE_KILOBYTES ] >= 0.1 && $value / self::$SIZE_MULTIPLIERS[ self::SIZE_KILOBYTES ] < 900 )
            return sprintf( "%0.2f%s", $value / self::$SIZE_MULTIPLIERS[ self::SIZE_KILOBYTES ], self::SIZE_KILOBYTES );
        elseif( $value / self::$SIZE_MULTIPLIERS[ self::SIZE_MEGABYTES ] >= 0.1 && $value / self::$SIZE_MULTIPLIERS[ self::SIZE_MEGABYTES ] < 900 )
            return sprintf( "%0.2f%s", $value / self::$SIZE_MULTIPLIERS[ self::SIZE_MEGABYTES ], self::SIZE_MEGABYTES );
        elseif( $value / self::$SIZE_MULTIPLIERS[ self::SIZE_GIGABYTES ] >= 0.1 && $value / self::$SIZE_MULTIPLIERS[ self::SIZE_GIGABYTES ] < 900 )
            return sprintf( "%0.2f%s", $value / self::$SIZE_MULTIPLIERS[ self::SIZE_GIGABYTES ], self::SIZE_GIGABYTES );
    }

}
