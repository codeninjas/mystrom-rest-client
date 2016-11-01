<?php

namespace Codeninjas\API\MyStrom\REST;

use Codeninjas\API\MyStrom\REST\Model\Info;
use Codeninjas\API\MyStrom\REST\Model\Status;
use Codeninjas\API\MyStrom\REST\Transport\JsonResponse;
use Psr\Log\LoggerInterface;

class Client
{
    use LoggerTrait;

    const ROUTES_INFO = '/info';
    const ROUTES_NETWORKS = '/networks';
    const ROUTES_HIDDEN = '/hidden';
    const ROUTES_WPS = '/wps';
    const ROUTES_CONNECT = '/connect';
    const ROUTES_COMMIT = '/commit.phtml';
    const ROUTES_MAC = '/mac';
    const ROUTES_REPORT = '/report';
    const ROUTES_TOGGLE = '/toggle';
    const ROUTES_RELAY = '/relay';
    const ROUTES_REST = '/rest';
    const ROUTES_PANEL = '/panel';
    const ROUTES_IP = '/ip';
    const ROUTES_LOAD = '/load';

    /** @var  TransportInterface */
    protected $transport;

    /** @var  Mapper */
    protected $mapper;

    /**
     * Client constructor.
     * @param TransportInterface $transport
     * @param Mapper $mapper
     * @param LoggerInterface $logger
     */
    public function __construct(TransportInterface $transport, Mapper $mapper = null, LoggerInterface $logger = null)
    {
        $this->setLogger($logger);

        $this->transport = $transport;

        $this->mapper = $mapper;
        if (null === $this->mapper) {
            $this->mapper = new Mapper();
            $this->mapper->setLogger($this->getLogger());
        }
    }

    public function getInfo() : Info
    {
        $method = 'GET';
        $url = self::ROUTES_INFO;
        $payload = [];

        $response = $this->transport->dispatch($method, $url, $payload);
        if (!$response instanceof JsonResponse) {
            throw new \Exception('Expected json response, got ' . get_class($response));
        }

        return $this->mapper->mapResponseToInfo($response->getPayload());
    }

    public function getStatus() : Status
    {
        $method = 'GET';
        $url = self::ROUTES_REPORT;
        $payload = [];

        $response = $this->transport->dispatch($method, $url, $payload);
        if (!$response instanceof JsonResponse) {
            throw new \Exception('Expected json response, got ' . get_class($response));
        }

        return $this->mapper->mapResponseToStatus($response->getPayload());
    }

    public function powerOn()
    {
        return $this->setPower(true);
    }

    public function powerOff()
    {
        return $this->setPower(false);
    }

    protected function setPower(bool $powerOn)
    {
        $method = 'GET';
        $url = self::ROUTES_RELAY;
        $payload = [
            'state' => (int)$powerOn
        ];

        $response = $this->transport->dispatch($method, $url, $payload);
        return $response->getStatusCode() == 200;
    }

    public function powerToggle()
    {
        $method = 'GET';
        $url = self::ROUTES_TOGGLE;
        $payload = [];

        $response = $this->transport->dispatch($method, $url, $payload);
        if (!$response instanceof JsonResponse) {
            throw new \Exception('Expected json response, got ' . get_class($response));
        }

        return $this->mapper->mapResponseToRelayStatus($response->getPayload());
    }

    //--------------------------------------------[GETTER & SETTER]--------------------------------------------
    /**
     * @return TransportInterface
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param TransportInterface $transport
     * @return $this
     */
    public function setTransport(TransportInterface $transport)
    {
        $this->transport = $transport;
        return $this;
    }

    /**
     * @return Mapper
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * @param Mapper $mapper
     * @return $this
     */
    public function setMapper(Mapper $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }
}
