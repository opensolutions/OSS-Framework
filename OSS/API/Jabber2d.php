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
 * @package    OSS_API
 * @copyright  Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 * @link       http://www.opensolutions.ie/ Open Source Solutions Limited
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @author     The Skilled Team of PHP Developers at Open Solutions <info@opensolutions.ie>
 */


/**
 * A Jabber2d API via direct database manipulation.
 *
 * @see http://jabberd2.org/
 *
 * @category   OSS
 * @package    OSS_API
 * @copyright  Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 */
class OSS_API_Jabber2d
{
    // use DBAL connections for database manipulation
    use OSS_Doctrine2_DBAL_Connection;

    
    public function __construct( $dbparams )
    {
        $this->getDBAL( $dbparams );
    }
    
    
    /**
     * Get all users registered in the database as an array.
     *
     * Returns:
     *
     *     array (size=n)
     *         0 =>
     *             array (size=3)
     *                 'username' => string 'johndoe' (length=5)
     *                 'realm' => string 'example.com' (length=16)
     *                 'password' => string 'soopersecret' (length=9)
     *         1 =>
     *             ...
     *
     * @return array  All users registered in the database
     */
    public function getAllUsers()
    {
        return $this->getDBAL()->fetchAll( "SELECT * FROM authreg" );
    }
    
}
