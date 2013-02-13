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
 * Filter FileSize tests.
 *
 * @category   OSS_Tests
 * @package    OSS_Tests_Filter
 * @copyright  Copyright (c) 2007 - 2013, Open Source Solutions Limited, Dublin, Ireland
 * @license    http://www.opensolutions.ie/licenses/new-bsd New BSD License
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @author     The Skilled Team of PHP Developers at Open Solutions <info@opensolutions.ie>
 */

class OSS_Filter_FileSizeTest extends PHPUnit_Framework_TestCase
{
	private $_filter;
	
    public function setUp()
    {
    	$this->_filter = new OSS_Filter_FileSize();
    }

    public function testFilterKB()
    {
    	$this->_filter->setMultiplier( OSS_Filter_FileSize::SIZE_KILOBYTES );
    	
    	$this->assertEquals( 10    * OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_KILOBYTES ], $this->_filter->filter( "10KB" ) );
    	$this->assertEquals( 20    * OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_KILOBYTES ], $this->_filter->filter( "20Kb" ) );
    	$this->assertEquals( 4.654 * OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_KILOBYTES ], $this->_filter->filter( "4.654k"  ) );
    	$this->assertEquals( 10.89 * OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_KILOBYTES ], $this->_filter->filter( "10.89kb" ) );
    	$this->assertEquals( 11    * OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_KILOBYTES ], $this->_filter->filter( "11K"  ) );
    }
    
    public function testUnfilterKB()
    {
    	$this->_filter->setMultiplier( OSS_Filter_FileSize::SIZE_KILOBYTES );
    	
    	$this->assertEquals( "10.5KB",  $this->_filter->unfilter( 10.5 *  OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_KILOBYTES ] ) );
    	$this->assertEquals( "10KB",    $this->_filter->unfilter( 10 *    OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_KILOBYTES ] ) );
    	$this->assertEquals( "1.5KB",   $this->_filter->unfilter( 1.5 *   OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_KILOBYTES ] ) );
      	$this->assertEquals( "37.63KB", $this->_filter->unfilter( 37.63 * OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_KILOBYTES ] ) );
    }
    
    public function testFilterMB()
    {
    	$this->_filter->setMultiplier( OSS_Filter_FileSize::SIZE_MEGABYTES );
    	
    	$this->assertEquals( 10 * OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_MEGABYTES ], $this->_filter->filter( "10MB" ) );
    	$this->assertEquals( 10 * OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_MEGABYTES ], $this->_filter->filter( "10Mb" ) );
    	$this->assertEquals( 10 * OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_MEGABYTES ], $this->_filter->filter( "10mb" ) );
    	$this->assertEquals( 10 * OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_MEGABYTES ], $this->_filter->filter( "10m"  ) );
    	$this->assertEquals( 10 * OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_MEGABYTES ], $this->_filter->filter( "10M"  ) );
    }
    
    public function testUnfilterMB()
    {
    	$this->_filter->setMultiplier( OSS_Filter_FileSize::SIZE_MEGABYTES );
    	
    	$this->assertEquals( "10.5MB",  $this->_filter->unfilter( 10.5 * OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_MEGABYTES ] ) );
    	$this->assertEquals( "10MB",    $this->_filter->unfilter( 10 * OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_MEGABYTES ] ) );
    	$this->assertEquals( "1.5MB",   $this->_filter->unfilter( 1.5 * OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_MEGABYTES ] ) );
      	$this->assertEquals( "37.63MB", $this->_filter->unfilter( 37.63 * OSS_Filter_FileSize::$SIZE_MULTIPLIERS[ OSS_Filter_FileSize::SIZE_MEGABYTES ] ) );
    }
    
}

