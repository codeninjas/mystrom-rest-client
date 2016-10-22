<?php

namespace Codeninjas\API\MyStrom\RESTTest;

use Codeninjas\API\MyStrom\REST\Client;
use Codeninjas\API\MyStrom\RESTTest\Transport\RecorderTransport;

class ClientIntegrationTest extends Base\TestBase
{
    /** @var  RecorderTransport */
    protected $transport;
    /** @var  Client */
    protected $client;

    public function testStatus()
    {
        $status = $this->client->getStatus();

        $this->assertNotEmpty($status->getPower());
        $this->assertNotEmpty($status->getRelay());
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

    protected function setUp()
    {
        $guzzleTransport = $this->setupGuzzleTransport();

        $this->transport = new RecorderTransport($guzzleTransport);
        $this->client = new Client($this->transport);
    }
}
