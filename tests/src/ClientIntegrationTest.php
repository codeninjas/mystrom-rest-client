<?php

namespace Codeninjas\API\MyStrom\RESTTest;

use Codeninjas\API\MyStrom\REST\Client;

class ClientIntegrationTest extends Base\TestBase
{
    /** @var  Client */
    protected $client;

    public function testStatus()
    {
        $status = $this->client->getStatus();

        $this->assertNotNull($status->getPower());
        $this->assertNotNull($status->getRelay());
    }

    public function testPowerOn()
    {
        $power = $this->client->powerOn();
        $this->assertTrue($power);
    }

    public function testPowerOff()
    {
        $power = $this->client->powerOff();
        $this->assertTrue($power);
    }

    public function testPowerToggle()
    {
        $power = $this->client->powerToggle();
        $this->assertNotEmpty($power->getPower());
    }

    public function testGetInfo()
    {
        $result = $this->client->getInfo();
        $this->assertNotEmpty($result->getVersion());
        $this->assertNotEmpty($result->getMac());
        $this->assertNotEmpty($result->getSsid());
        $this->assertNotEmpty($result->isConnected());
    }

    protected function setUp()
    {
        $config = $this->getConfig();
        $this->client = new Client($config['url']);
    }
}
