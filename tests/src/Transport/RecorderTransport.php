<?php

namespace Codeninjas\API\MyStrom\RESTTest\Transport;

use Codeninjas\API\MyStrom\REST\Transport\Response;
use Codeninjas\API\MyStrom\REST\TransportInterface;

class RecorderTransport implements TransportInterface
{
    /** @var  TransportInterface */
    protected $transport;

    /** @var  string */
    protected $lastMethod;
    /** @var  string */
    protected $lastUrl;
    /** @var  string */
    protected $lastPayload;

    /** @var  Response */
    protected $lastResponse;

    /**
     * RecorderTransport constructor.
     * @param TransportInterface $transport
     */
    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public function dispatch(string $method, string $url, array $payload = null) : Response
    {
        $this->lastMethod = $method;
        $this->lastUrl = $url;
        $this->lastPayload = $payload;

        $lastResponse = $this->transport->dispatch($method, $url, $payload);

        return $lastResponse;
    }


    //-------------------------------------------------[GETTER & SETTER]------------------------------------------------
    /**
     * @return TransportInterface
     */
    public function getTransport(): TransportInterface
    {
        return $this->transport;
    }

    /**
     * @param TransportInterface $transport
     */
    public function setTransport(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @return string
     */
    public function getLastMethod(): string
    {
        return $this->lastMethod;
    }

    /**
     * @param string $lastMethod
     */
    public function setLastMethod(string $lastMethod)
    {
        $this->lastMethod = $lastMethod;
    }

    /**
     * @return string
     */
    public function getLastUrl(): string
    {
        return $this->lastUrl;
    }

    /**
     * @param string $lastUrl
     */
    public function setLastUrl(string $lastUrl)
    {
        $this->lastUrl = $lastUrl;
    }

    /**
     * @return string
     */
    public function getLastPayload(): string
    {
        return $this->lastPayload;
    }

    /**
     * @param string $lastPayload
     */
    public function setLastPayload(string $lastPayload)
    {
        $this->lastPayload = $lastPayload;
    }

    /**
     * @return Response
     */
    public function getLastResponse(): Response
    {
        return $this->lastResponse;
    }

    /**
     * @param Response $lastResponse
     */
    public function setLastResponse(Response $lastResponse)
    {
        $this->lastResponse = $lastResponse;
    }
}
