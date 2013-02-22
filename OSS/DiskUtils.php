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
 * @category   OSS
 * @package    OSS_Utils
 * @copyright  Copyright (c) 2007 - 2013, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 * @link       http://www.opensolutions.ie/ Open Source Solutions Limited
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @author     The Skilled Team of PHP Developers at Open Solutions <info@opensolutions.ie>
 */

/**
 * @category   OSS
 * @package    OSS_DiskUtils
 * @copyright  Copyright (c) 2007 - 2013, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 */
class OSS_DiskUtils
{

    /**
     * Summarize disk usage of each FILE, recursively for directories.
     *
     * It is also configurable (via Zend_Application config and assuming 'options' is
     * available in Zend_Registry as it would be from OSS_Controller_Action).
     *
     * You can configure the du application path by setting config: disk_utils.binary.du
     *
     * If folder not exists on given path function return false. If summarize is set to
     * true than it function return folder size in bytes, else it returns array with with folder
     * size in bytes and folder path.
     *
     * @param string $path      Path to folder for size checking
     * @param bool   $summarize If it set to true then displays only a total for each argument.
     * @return mixed
     */
    public static function du( $path, $summarize = true )
    {
        if( !is_dir( $path ) )
            return false;

        $options = Zend_Registry::get( 'options' );

        if( isset( $options['binary']['path']['du'] ) )
            $du = $options['binary']['path']['du'];
        else
            $du = "/usr/bin/du";

        if( $summarize )
        {
            $command = sprintf( "%s -s %s 2>&1", $du, $path );
            exec( $command, $output, $result );
            $output = explode( "\t", $output[0] );
            return (int) $output[0] * 1024;
        }
        else
        {
            $command = sprintf( "%s -s %s 2>&1", $du, $path );
            exec( $command, $output, $result );
            foreach( $output as $key => $line )
            {
                $row = explode( "\t", $output[$key] );
                $row[0] = (int) $row[0] * 1024;
                $output[$key] = $row;
            }
            return $ouput;
        }
    }

}