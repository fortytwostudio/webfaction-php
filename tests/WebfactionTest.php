<?php

use FortyTwoStudio\WebFactionPHP\WebFactionClient;
use FortyTwoStudio\WebFactionPHP\WebFactionException;
use PHPUnit\Framework\TestCase;

class WebfactionTest extends TestCase {

    public function testThrowsExceptionOnBadCredentials()
    {
        $this->expectException(WebFactionException::class);
        new WebFactionClient('junk-username', 'junk-password','junk-machine');
    }

    public function testCanGenerateARandomLengthPassword()
    {
        $passLength = rand(1,100);
        $pass = WebFactionClient::generatePassword($passLength);
        $this->assertEquals(strlen($pass), $passLength);
    }

}