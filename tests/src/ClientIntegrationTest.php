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

    protected function setUp()
    {
        $guzzleTransport = $this->setupGuzzleTransport();

        $this->transport = new RecorderTransport($guzzleTransport);
        $this->client = new Client($this->transport);
    }
}
