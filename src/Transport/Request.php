<?php

namespace Codeninjas\API\MyStrom\REST\Transport;

class Request
{
    /* @var array */
    protected $payload;

    /* @var string */
    protected $targetURI;

    /* @var string */
    protected $method;

    /**
     * @param string $targetURI
     * @param null|array $payload
     * @param string $method
     */
    public function __construct($targetURI, $payload = null, $method = 'POST')
    {
        $this->targetURI = $targetURI;
        $this->payload = $payload;
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getTargetURI()
    {
        return $this->targetURI;
    }

    /**
     * @param string $targetURI
     * @return Request
     */
    public function setTargetURI($targetURI)
    {
        $this->targetURI = $targetURI;
        return $this;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     * @return Request
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return Request
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }
}
