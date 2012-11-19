<?php 
class OSS_License_MD5Test extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    private function _genLicense( $expires )
    {
        $l = new OSS_License_MD5();
        
        for( $i = 0; $i < 10; $i++ )
            $l->setParam( "P{$i}", OSS_String::random( 20 ) );
            
        $l->setParam( "Expires", $expires );
        
        return new OSS_License_MD5( parse_ini_string( $l->generate() ) );
    }
                                            
    public function testsLicenseValidates()
    {
        $company = 'Open Source Solutions Limited';
        
        $l = new OSS_License_MD5();
        $l->setParam( 'Company', $company );
        $l->setParam( 'IssuedTo', 'barry@opensolutions.ie' );

        $l = new OSS_License_MD5( parse_ini_string( $l->generate() ) );
        $this->assertTrue( $l->verify() );
        $this->assertTrue( $l->getParam( 'Company' ) === $company );
    }
    
    public function testsLicenseExpiresFuture()
    {
        $l = $this->_genLicense( '2999-01-01' );
        $this->assertTrue( $l->verify() );
    }
    
    /**
     * @expectedException OSS_License_ExpiredException
     */
    public function testsLicenseExpired()
    {        
        $l = $this->_genLicense( '2012-01-01' );
        $this->assertTrue( $l->verify() );
    }
    
    public function testsLicenseExpiresToday()
    {        
        $l = $this->_genLicense( date( 'Y-m-d' ) );
        $this->assertTrue( $l->verify() );
    }


/*    public function testsLicenseReallyValidates()
    {
        $company = 'Open Source Solutions Limited';
        
        $l = new OSS_License_MD5();
        $l->setParam( 'Company', $company );
        $l->setParam( 'IssuedTo', 'barry@opensolutions.ie' );
        $l->setParam( 'Expires', '2012-12-31' );
        $l->setParam( 'Issued', '2012-07-25' );        
        $l->setParam( 'PrimaryModule', 'Call-Recorder' );

        die( $l->generate() );
    }
  */  
}

