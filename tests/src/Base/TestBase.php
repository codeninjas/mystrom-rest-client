<?php

namespace Codeninjas\API\MyStrom\RESTTest\Base;

use Codeninjas\API\MyStrom\REST\Transport\GuzzleTransport;
use GuzzleHttp\Client;

class TestBase extends \PHPUnit_Framework_TestCase
{
    protected $config;

    protected function setupGuzzleTransport() : GuzzleTransport
    {
        $phpUnitConfig = $this->getConfig();
        return new GuzzleTransport($this->setupGuzzleClient(), $phpUnitConfig['apiKey']);
    }

    public function getConfig() : array
    {
        if (null === $this->config) {
            $this->initConfig();
        }

        return $this->config;
    }

    protected function initConfig()
    {
        $distConfig = include(__DIR__ . '/../../config.dist.php');
        $priorConfigPath = __DIR__ . '/../../config.php';
        $priorConfig = [];
        if (file_exists($priorConfigPath)) {
            /** @noinspection PhpIncludeInspection */
            $priorConfig = include($priorConfigPath);
        }

        $this->config = array_merge($distConfig, $priorConfig);
    }

    protected function setupGuzzleClient() : Client
    {
        $phpUnitConfig = $this->getConfig();
        $guzzleConfig = ['base_uri' => $phpUnitConfig['url']];

        $proxyConfig = $phpUnitConfig['proxy'];
        if ($proxyConfig['enabled'] === true) {
            $guzzleConfig['verify'] = $proxyConfig['verify-tls'];
            $guzzleConfig['proxy'] = sprintf('http://%s:%s', $proxyConfig['host'], $proxyConfig['post']);
        }

        return new Client($guzzleConfig);
    }
}
