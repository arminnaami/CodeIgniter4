<?php namespace CodeIgniter\HTTP;

final class cookieHelperTest extends \CIUnitTestCase
{

    private $name;
    private $value;
    private $expire;

    private $skipped;

    public function setUp()
    {
        //Output buffering? ob_start();
        //Mock builders? Services::injectMock();
        
        $this->name   = 'greetings';
        $this->value  = 'hello world';
        $this->expire = 9999;

        $this->skipped = 'Need to solve "Cannot modify header information - headers already sent" issue.';

        helper('cookie');
    }

    //--------------------------------------------------------------------

    public function testSetCookieByDiscreteParameters()
    {
        $this->markTestSkipped($this->skipped);

        set_cookie($this->name, $this->value, $this->expire);

        $this->assertEquals(get_cookie($this->name), $this->value);

        //Delete cookie to give way for other tests.
        delete_cookie($this->name);
    }

    //--------------------------------------------------------------------

    public function testSetCookieByArrayParameters()
    {
        $this->markTestSkipped($this->skipped);

        $cookieAttr = array
        (
            'name'   => $this->name, 
            'value'  => $this->value, 
            'expire' => $this->expire
        );
        set_cookie($cookieAttr);

        $this->assertEquals(get_cookie($this->name), $this->value);

        //Delete cookie to give way for other tests.
        delete_cookie($this->name);
    }

    //--------------------------------------------------------------------

    public function testGetCookie()
    {
        $this->markTestSkipped($this->skipped);

        $unsecuredScript = "Hello, I try to <script>alert('Hack');</script> your site";
        $securedScript   = "Hello, I try to [removed]alert&#40;'Hack'&#41;;[removed] your site";
        $unsecured       = 'unsecured';
        $secured         = 'secured';

        set_cookie($unsecured, $unsecuredScript, $this->expire);
        set_cookie($secured,   $securedScript,   $this->expire);

        $this->assertEquals($unsecuredScript, get_cookie($unsecured, false));
        $this->assertEquals($securedScript,   get_cookie($secured,   true));

        //Delete cookies to give way for other tests.
        delete_cookie($unsecured);
        delete_cookie($secured);
    }

    //--------------------------------------------------------------------

    public function testDeleteCookie()
    {
        $this->markTestSkipped($this->skipped);

        set_cookie($this->name, $this->value, $this->expire);
        
        delete_cookie($this->name);
        
        $this->assertEquals(get_cookie($this->name), '');
    }

}