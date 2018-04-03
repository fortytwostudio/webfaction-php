<?php

namespace FortyTwoStudio\WebFactionPHP;

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

class WebfactionTest extends TestCase
{

    /**
     * @var WebFactionClient
     */
    protected static $wf;


    /**
     * @throws WebFactionException
     */
    public static function setUpBeforeClass()
    {

        $dotenv = new Dotenv(__DIR__ . '/../');
        $dotenv->load();
        $dotenv->required(['WEBFACTION_USER', 'WEBFACTION_PASSWORD', 'WEBFACTION_MACHINE', 'WEBFACTION_TEST_NAME'])->notEmpty();

        try
        {
            self::$wf = new WebFactionClient(getenv('WEBFACTION_USER'), getenv('WEBFACTION_PASSWORD'), getenv('WEBFACTION_MACHINE'));
        } catch (WebFactionException $e)
        {
            throw new WebFactionException("Have you entered your Webfaction credentials in the .env file?", 401);
        }
    }

    /**
     * @throws WebFactionException
     */
    public function testThrowsExceptionOnBadCredentials()
    {
        $this->expectException(WebFactionException::class);
        new WebFactionClient('bad-username', 'bad-password', 'bad-machine');
    }

    /**
     * @throws Exception
     */
    public function testCanGenerateARandomLengthPassword()
    {
        $passLength = rand(1, 100);
        $pass       = WebFactionClient::generatePassword($passLength);
        $this->assertEquals(strlen($pass), $passLength);
    }

    /**
     * @throws WebFactionException
     */
    public function testListDiskUsage()
    {
        $disk_usage = self::$wf->listDiskUsage();
        $this->assertArrayHasKey('home_directories', $disk_usage);
        $this->assertArrayHasKey('mailboxes', $disk_usage);
        $this->assertArrayHasKey('mysql_databases', $disk_usage);
        $this->assertArrayHasKey('postgresql_databases', $disk_usage);
        $this->assertArrayHasKey('total', $disk_usage);
        $this->assertArrayHasKey('quota', $disk_usage);
        $this->assertArrayHasKey('percentage', $disk_usage);
    }



}