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
 * A davical API via direct database manipulation.
 *
 * @see http://davical.org/
 *
 * @category   OSS
 * @package    OSS_API
 * @copyright  Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 */
class OSS_API_Davical
{
    // use DBAL connections for database manipulation
    use OSS_Doctrine2_DBAL_Connection;

    
    public function __construct( $dbparams )
    {
        $this->getDBAL( $dbparams );
    }
    
    const PRIVILEGES_RW   = '000000001111111011100111';
    const PRIVILEGES_RO   = '000000001110110011000110';
    const PRIVILEGES_NONE = '000000000000000000000000';
    
    const PRINCIPAL_TYPE_PERSON     = 1;
    const PRINCIPAL_TYPE_RESOURCE   = 2;
    const PRINCIPAL_TYPE_GROUP      = 3;
    
    const COLLECTION_TYPE_CALENDAR    = 'calendar';
    const COLLECTION_TYPE_ADDRESSBOOK = 'addressbook';
    
    const PASSWORD_HASH_SSHA  = "hash";
    const PASSWORD_HASH_MD5   = "md5";
    const PASSWORD_HASH_PLAIN = "plain";
    
    /**
     * Get all users registered in the database as an array.
     *
     * Returns:
     *
     *     array (size=n)
     *         0 =>
     *            'user_no' => int 1
     *            'active' => boolean true
     *            'email_ok' => string '2012-12-07 00:00:00+00' (length=22)
     *            'joined' => string '2012-12-07 11:49:55.231231+00' (length=29)
     *            'updated' => string '2012-12-07 13:27:31.698669+00' (length=29)
     *            'last_used' => string '2012-12-11 10:01:29.831451+00' (length=29)
     *            'username' => string 'usrname' (length=7)
     *            'password' => string 'encrypted' (length=9)
     *            'fullname' => string 'Name susrname' (length=13)
     *            'email' => string 'example@example.ie' (length=18)
     *            'config_data' => null
     *            'date_format_type' => string 'E' (length=1)
     *            'locale' => string 'en' (length=2)
     *         1 =>
     *             ...
     *
     * @return array  All users registered in the database
     */
    public function getAllUsers()
    {
        return $this->getDBAL()->fetchAll( "SELECT * FROM principal" );
    }
    
    /**
     * Create user.
     *
     * params:
     *     array
     *            'active' => boolean
     *            'email_ok' => string date time   e.g.'2012-12-07 00:00:00+00'
     *            'joined' => string date time     e.g.'2012-12-07 00:00:00+00'
     *            'updated' => string date time    e.g.'2012-12-07 00:00:00+00'
     *            'last_used' => string date time  e.g.'2012-12-07 00:00:00+00'
     *            'username' => string             mandatory
     *            'password' => string 
     *            'fullname' => string 
     *            'email' => string 
     *            'config_data' => null
     *            'date_format_type' => string     e.g. 'E' 
     *            'locale' => string               e.g. 'en'
     *
     * return:
     *      array
     *            'user_no' => int 1
     *            'active' => boolean true
     *            'email_ok' => string '2012-12-07 00:00:00+00' (length=22)
     *            'joined' => string '2012-12-07 11:49:55.231231+00' (length=29)
     *            'updated' => string '2012-12-07 13:27:31.698669+00' (length=29)
     *            'last_used' => string '2012-12-11 10:01:29.831451+00' (length=29)
     *            'username' => string 'usrname' (length=7)
     *            'password' => string 'encrypted' (length=9)
     *            'fullname' => string 'Name susrname' (length=13)
     *            'email' => string 'example@example.ie' (length=18)
     *            'config_data' => null
     *            'date_format_type' => string 'E' (length=1)
     *            'locale' => string 'en' (length=2)
     *
     * @param array $params User parameters
     * @return array  of user details
     */
    public function createUser( $params )
    {   
        $this->getDBAL()->insert( 'usr', $params );
        return $this->getDBAL()->fetchAssoc( "SELECT * FROM usr WHERE username = '{$params['username']}'" );
    }
    
    /**
     * Creates principal and dreturns principles data.
     *
     * return array:
     *      array (size=5)
     *          'principal_id' => int 1
     *          'type_id' => int 1
     *          'user_no' => int 1
     *          'displayname' => string 'DAViCal Administrator' (length=21)
     *          'default_privileges' => string '000000000000000000000000' (length=24)
     *
     *
     * @param array $user Array of user details.
     * @param int $type Principal Type id, by default principal type is person.
     * @pram string $privileges Default prinicpals privileges by default is read/write.
     * @return array of prinicpal details
     */
    public function createPrincipal( $user, $type, $privileges = self::PRIVILEGES_NONE )
    {            
        $params = [ 
            'type_id'            => $type,
            'user_no'            => $user[ 'user_no' ],
            'displayname'        => $user[ 'fullname' ],
            'default_privileges' => $privileges
        ];
        
        $this->getDBAL()->insert( 'principal', $params );
        return $this->getDBAL()->fetchAssoc( "SELECT * FROM principal WHERE user_no = '{$user['user_no']}'" );
    }
    
    /**
     * Creates calendar and returns calendar data.
     *
     * Return array:
     *  array (size=17)
     *      'user_no' => int 1024
     *      'parent_container' => string '/nbdavical/' (length=11)
     *      'dav_name' => string '/nbdavical/calendar/' (length=20)
     *      'dav_etag' => string '-1' (length=2)
     *      'dav_displayname' => string 'Davical User calendar' (length=21)
     *      'is_calendar' => boolean true
     *      'created' => string '2012-12-13 11:39:07.767205+00' (length=29)
     *      'modified' => string '2012-12-13 11:39:07.767205+00' (length=29)
     *      'public_events_only' => boolean false
     *      'publicly_readable' => boolean false
     *      'collection_id' => int 1034
     *      'default_privileges' => null
     *      'is_addressbook' => boolean false
     *      'resourcetypes' => string '<DAV::collection/><urn:ietf:params:xml:ns:carddav:calendar/>' (length=60)
     *      'schedule_transp' => string 'opaque' (length=6)
     *      'timezone' => null
     *      'description' => string '' (length=0)
     *
     * @param array $user Davical user data
     * @param string $name Name of the calendar
     * @param string|null $privileges Default privileges to access calendar
     * @param bool $public_events_only Flag to define if calenda contains only public event
     * @param bool $publicly_readable ??????????????????
     * @param int|null $timezone Time zone id.
     * @param string $description Calendar description.
     * @return array
     * @see createCollection()
     */
    public function createCalendar( $user, $name = null, $privileges = null, $public_events_only = false, $publicly_readable = false, $timezone = null, $description = "" )
    {
        return $this->createCollection( $user, self::COLLECTION_TYPE_CALENDAR, $name, $privileges, $public_events_only, $publicly_readable, $timezone, $description );
    }
    
    
    /**
     * Creates colenction and returns it data.
     *
     * Return array:
     *  array (size=17)
     *      'user_no' => int 1024
     *      'parent_container' => string '/nbdavical/' (length=11)
     *      'dav_name' => string '/nbdavical/calendar/' (length=20)
     *      'dav_etag' => string '-1' (length=2)
     *      'dav_displayname' => string 'Davical User calendar' (length=21)
     *      'is_calendar' => boolean true
     *      'created' => string '2012-12-13 11:39:07.767205+00' (length=29)
     *      'modified' => string '2012-12-13 11:39:07.767205+00' (length=29)
     *      'public_events_only' => boolean false
     *      'publicly_readable' => boolean false
     *      'collection_id' => int 1034
     *      'default_privileges' => null
     *      'is_addressbook' => boolean false
     *      'resourcetypes' => string '<DAV::collection/><urn:ietf:params:xml:ns:carddav:calendar/>' (length=60)
     *      'schedule_transp' => string 'opaque' (length=6)
     *      'timezone' => null
     *      'description' => string '' (length=0)
     *
     * @param array $user Davical user data
     * @param string $type Collection type
     * @param string $name Calendars name
     * @param string|null $privileges Default privileges to access calendar
     * @param bool $public_events_only Flag to define if calenda contains only public event
     * @param bool $publicly_readable ??????????????????
     * @param int|null $timezone Time zone id.
     * @param string $description Calendar description.
     * @return array
     */
    public function createCollection( $user, $type, $name= null, $privileges = null, $public_events_only = false, $publicly_readable = false, $timezone = null, $description = "" )
    {            
        if( $type == self::COLLECTION_TYPE_CALENDAR )
            $calendar = true;
        else if( $type == self::COLLECTION_TYPE_ADDRESSBOOK )
            $calendar = false;
        else throw new OSS_Exception( "Unknown collection type." );
            
        if( !$name ) 
            $name = $calendar ? $user[ "fullname" ] . " calendar" : $user[ "fullname" ] . " addressbook";
            
        if( $calendar )
            $last = $this->getDBAL()->fetchColumn( "SELECT dav_name FROM collection WHERE user_no = {$user[ 'user_no' ]} AND is_calendar = TRUE ORDER BY collection_id DESC LIMIT 1" );
        else       
            $last = $this->getDBAL()->fetchColumn( "SELECT dav_name FROM collection WHERE user_no = {$user[ 'user_no' ]} AND is_addressbook = TRUE ORDER BY collection_id DESC LIMIT 1" );
            
        if( $last )
        {
            $last = explode( "/", $last );
            $last = (int) OSS_Filter_Float::filter( $last[2] ) + 1;
        }
        else
            $last = "";
        
             
        $params = [ 
            'user_no'            => $user[ 'user_no' ],
            'parent_container'   => "/{$user[ 'username' ]}/",
            'dav_etag'           => -1,
            'dav_name'           => sprintf( "/%s/%s%s/", $user[ 'username' ], $calendar? "calendar" : "addressbook", $last ),
            'dav_displayname'    => $name,
            'is_calendar'        => $calendar ? 1 : 0,
            'created'            => 'now()',
            'modified'           => 'now()',
            'public_events_only' => $public_events_only ? 1 : 0,
            'publicly_readable'  => $publicly_readable ? 1 : 0,
            'default_privileges' => $privileges,
            'is_addressbook'     => !$calendar ? 1 : 0,
            'resourcetypes'      => sprintf( "<DAV::collection/><urn:ietf:params:xml:ns:carddav:%s/>'", $calendar ? "calendar": "addressbook" ),
            'timezone'           => $timezone,
            'description'        => $description
        ];
        
        if( $this->getDBAL()->insert( 'collection', $params ) )
            return $this->getDBAL()->fetchAssoc( "SELECT * FROM collection WHERE user_no = '{$user['user_no']}' AND dav_name = '{$params['dav_name']}'" );
        else
            return false;
    }
    
    
    /**
     * Creates user, principal and calendar. 
     * 
     * Takes same parameters as $this->createUser();
     * Returns an array wich contains user, principal and calendar collection data.
     *  array [
     *       'user'      => array users data,
     *       'principal' => array principals data,
     *       'calendar'  => array calendar collection data       
     * 
     * @param array $params Sames as creatUser parameters.
     * @param string $cname Calendar name
     * @param int $type Principle type id
     * @return array Array wit data of user, principal and calendar collection.
     * 
     * @see createUser()
     * @see createPrincipal()
     * @see createCalendar()
     */
    public function createCalendarUser( $params, $cname = null, $type = self::PRINCIPAL_TYPE_PERSON )
    {
        $this->getDBAL()->beginTransaction();
        try
        {
            $user = $this->createUser( $params );
            $principal = $this->createPrincipal( $user, $type );
            $calendar = $this->createCalendar( $user, $cname );
            
            $this->getDBAL()->commit();
        }
        catch( Exception $e )
        {
            $this->getDBAL()->rollback();
            throw $e;
        }
        
        return [ "user" => $user, "principal" => $principal, "calendar" => $calendar ];
    }     
    
    /**
     * Hash password for davical user.
     * 
     * It hashes three davical supported types hash:
     *  * First and most unsecured hash is plain it just add two start infont of password.
     *  * Second is md5 result is *<salt>* (where <salt> is a random series of characters not including '*') 
     *       then the rest of the string is a hash of (password + salt), i.e. a salted hash. 
     *  * Third  is SSHA result is is "*<salt>*<LDAP compatible SSHA password>" and the <LDAP compatible SSHA password> 
     *       is "{SSHA}<SHA-1 salted hash>". Read the code in /usr/share/awl/inc/AWLUtilities.php if you want to 
     *       understand that format more deeply! 
     *
     * @param string $password  Users password to login.
     * @param string $method Hash method
     * @return string return hashed string.
     */
    public static function hashPassword( $password, $method )
    {
        $salt = OSS_String::salt( 9 );
        if( $method == self::PASSWORD_HASH_PLAIN )
            return "**" . $password;
        else if( $method == self::PASSWORD_HASH_MD5 )
            return sprintf( "*%s*%s", $salt, md5( $password . $salt ) );    
        else if( $method == self::PASSWORD_HASH_SSHA )
            return sprintf( "*%s*{SSHA}%s", $salt, base64_encode( sha1( $password . $salt, true ) . $salt ) );
        else throw new OSS_Exception( 'Hash password method is unknown' );
    }
    
    public function getUserById( $user_id )
    {
        return $this->getDBAL()->fetchAssoc( "SELECT * FROM usr WHERE user_no = {$user_id}" );
    }
    
    public function getUserByUsername( $username )
    {
        return $this->getDBAL()->fetchAssoc( "SELECT * FROM usr WHERE username = '{$username}'" );
    }
    
    public function getPrincipalById( $principal_id )
    {
        return $this->getDBAL()->fetchAssoc( "SELECT * FROM principal WHERE principal_id = {$principal_id}" );
    }
    
    public function getCalendarById( $collection_id )
    {
        return $this->getDBAL()->fetchAssoc( "SELECT * FROM collection WHERE collection_id = {$collection_id}" );
    }
    
    public function getCalendarsByUserNo( $user_no )
    {
        return $this->getDBAL()->fetchAll( "SELECT * FROM collection WHERE user_no = {$user_no} AND is_calendar = TRUE" );
    }
    
    public function removeCalendar( $collection_id )
    {
        return $this->getDBAL()->delete( 'collection', array( 'collection_id' => $collection_id ) );
    }
    
    public function removeUser( $user_id )
    {
        return $this->getDBAL()->delete( 'usr', array( 'user_no' => $user_id ) );
    }
}
