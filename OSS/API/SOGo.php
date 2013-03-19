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
 * @package    OSS_API
 * @copyright  Copyright (c) 2007 - 2012, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 * @link       http://www.opensolutions.ie/ Open Source Solutions Limited
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @author     The Skilled Team of PHP Developers at Open Solutions <info@opensolutions.ie>
 */


/**
 * A SOGo API via direct database manipulation.
 *
 * @category   OSS
 * @package    OSS_API
 * @copyright  Copyright (c) 2007 - 2013, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 */
class OSS_API_SOGo
{
    // use DBAL connections for database manipulation
    use OSS_Doctrine2_DBAL_Connection;

    /**
     * Constructor - creates a new DBAL connection.
     *
     * @param array $dbparams
     * @return void
     */
    public function __construct( $dbparams )
    {
        $this->getDBAL( $dbparams );
    }


    /**
     * Get all exiting users profiles form SOGo database as an array.
     *
     * NOTICE: c_defaults and c_settings in database is stored as json array
     *
     * @param void
     * @return array All users profiles existing in the database
     * @access public
     */
    public function getAllUsersProfiles()
    {
        $profiles =  $this->getDBAL()->fetchAll( 'SELECT * FROM sogo_user_profile' );

        if( !$profiles )
            return false;

        foreach( $profiles as $idx => $profile )
        {
            if( $profile['c_defaults'] )
                $profiles[ $idx ]['c_defaults'] = json_decode( $profile['c_defaults'], true );

            if( $profile['c_settings'] )
                $profiles[ $idx ]['c_settings'] = json_decode( $profile['c_settings'], true );
        }

        return $profiles;
    }


    /**
     * Get user's profile from the SOGo database as an array.
     *
     * NOTICE: c_defaults and c_settings in database is stored as json array
     *
     * @param strint $uid User id ( usrname )
     * @return array|bool
     * @access public
     */
    public function getUserProfile( $uid )
    {
        $profile = $this->getDBAL()->fetchAssoc( 'SELECT * FROM sogo_user_profile WHERE c_uid = ?',
            [ $uid ]
        );

        if( !$profile )
            return false;

        if( $profile['c_defaults'] )
            $profile['c_defaults'] = json_decode( $profile['c_defaults'], true );

        if( $profile['c_settings'] )
            $profile['c_settings'] = json_decode( $profile['c_settings'], true );

        return $profile;
    }

    /**
     * Adds user profile to SOGo's database
     *
     * NOTICE: c_defaults and c_settings in database is stored as JSON array
     *
     * @param strint     $uid       New users id ( username )
     * @param bool|array $defaults  Users profile defaults. If it false it will not be added.
     * @param bool|array $settings  Users profile settings. If it false it will not be added.
     * @return bool
     * @access public
     */
    public function addUserProfile( $uid, $defaults = false, $settings = false )
    {
        $params = [ 'c_uid' => $uid ];

        if( $defaults )
            $params['c_defaults'] = json_encode( $defaults );

        if( $settings )
            $params['c_settings'] = json_encode( $settings );

        return $this->getDBAL()->insert( 'sogo_user_profile', $params );
    }

    /**
     * Updates SOGo users profile
     *
     * To  reset defaults or settings pass empty array. If defaults and settings will be false function will return
     * false without even trying to process sql query.
     *
     * NOTICE: c_defaults and c_settings in database is stored as JSON array
     *
     * @param strint     $uid       Users id to edit ( username )
     * @param bool|array $defaults  Users profile defaults. If it false it will not be updated to null it will leave es it is.
     * @param bool|array $settings  Users profile settings. If it false it will not be updated to null it will leave es it is.
     * @return bool
     * @access public
     */
    public function updateUserProfile( $uid, $defaults = false, $settings = false  )
    {
        if( $defaults === false && $settings === false )
            return false;

        $params = [];
        if( $defaults )
            $params['c_defaults'] = json_encode( $defaults );

        if( $settings )
            $params['c_settings'] = json_encode( $settings );

        return $this->getDBAL()->update( 'sogo_user_profile', $params,
            [ 'c_uid' => $uid ]
        );
    }
}
