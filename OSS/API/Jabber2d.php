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


    /**
     * Holds a Doctrine2 DBAL object. Because the plugin works on different databases other than ViMbAdmin's, we have to
     * make sure we don't just switch the application's main DB connection to a Jabber2 database, and then leave it there.
     * Luckily DBAL accepts a name for connections, which is 'default' for the application's main connection.
     *
     * @var object $_dbal
     * @access private
     */
    private $_dbal = null;


    /**
     * The constructor. Creates a new DBAL connection, gives it a name ( I use the database name ), and stores the object in $this->_dbal.
     *
     * @param array $dbparams
     * @return void
     */
    public function __construct( $dbparams )
    {
        $this->_dbal = $this->getDBAL( $dbparams, $dbparams['dbname'] );
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
     * @param void
     * @return array All users registered in the database
     * @access public
     */
    public function getAllUsers()
    {
        return $this->_dbal->fetchAll( 'select * from authreg' );
    }


    /**
     * Returns with a user's authreg entry as an assciative array, or with false if it wasn't found.
     *
     * @param string $username
     * @param string $realm
     * @return array|boolean
     * @access public
     */
    public function getAuthReg( $username, $realm )
    {
        return $this->_dbal->fetchAssoc( 'select * from authreg where username = ? and realm = ?', array( $username, $realm ) );
    }


    /**
     * Adds an authreg entry.
     *
     * @param string $username
     * @param string $realm
     * @param string $password
     * @return int
     * @access public
     */
    public function addAuthReg( $username, $realm, $password )
    {
        return $this->_dbal->insert( 'authreg', array( 'username' => $username, 'realm' => $realm, 'password' => $password ) );
    }


    /**
     * Updates an authreg entry.
     *
     * @param string $username
     * @param string $realm
     * @param string $password
     * @return int
     * @access public
     */
    public function updateAuthReg( $username, $realm, $password )
    {
        return $this->_dbal->update( 'authreg', array( 'password' => $password ), array( 'username' => $username, 'realm' => $realm ) );
    }


    /**
     * Deletes a user's authreg entry, and all related entries. Encapsulates all the delete statements in one transaction.
     *
     * @param string $username
     * @param string $realm
     * @return void
     * @access public
     */
    public function deleteAuthReg( $username, $realm )
    {
        $co = "{$username}@{$realm}";

        $this->_dbal->beginTransaction();
        $this->_dbal->delete( 'active', array( '`collection-owner`' => $co ) );
        $this->_dbal->delete( '`disco-items`', array( '`collection-owner`' => $co ) );
        $this->_dbal->delete( 'logout', array( '`collection-owner`' => $co ) );
        $this->_dbal->delete( '`motd-message`', array( '`collection-owner`' => $co ) );
        $this->_dbal->delete( '`motd-times`', array( '`collection-owner`' => $co ) );
        $this->_dbal->delete( '`privacy-default`', array( '`collection-owner`' => $co ) );
        $this->_dbal->delete( '`privacy-items`', array( '`collection-owner`' => $co ) );
        $this->_dbal->delete( 'private', array( '`collection-owner`' => $co ) );
        $this->_dbal->delete( 'queue', array( '`collection-owner`' => $co ) );
        $this->_dbal->delete( '`roster-groups`', array( '`collection-owner`' => $co ) );
        $this->_dbal->delete( '`roster-items`', array( '`collection-owner`' => $co ) );
        $this->_dbal->delete( 'status', array( '`collection-owner`' => $co ) );
        $this->_dbal->delete( '`vacation-settings`', array( '`collection-owner`' => $co ) );
        $this->_dbal->delete( 'vcard', array( '`collection-owner`' => $co ) );
        $this->_dbal->delete( 'authreg', array( 'username' => $username, 'realm' => $realm ) );
        $this->_dbal->commit();
    }

}
