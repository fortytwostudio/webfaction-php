<?php
use FortyTwoStudio\WebFactionPHP\WebFactionClient;
use FortyTwoStudio\WebFactionPHP\WebFactionException;

class WebfactionTest extends PHPUnit_Framework_TestCase {

    public function testThrowsExceptionOnBadCredentials()
    {
        $this->expectException(WebFactionException::class);
        $wf = new WebFactionClient('junk-username', 'junk-password','junk-machine');
    }

    public function testCanGenerateARandomLengthPassword()
    {
        $passLength = rand(1,100);
        $pass = WebFactionClient::generatePassword($passLength);
        $this->assertEquals(strlen($pass), $passLength);
    }

}