<?php

namespace Codeninjas\API\MyStrom\REST\Transport;

class Response
{
    /* @var string */
    protected $location;

    /* @var array */
    protected $payload;

    /* @var int */
    protected $statusCode;

    /**
     * @return array|string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param array|string $payload
     * @return Response
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return $this
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return Response
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}
