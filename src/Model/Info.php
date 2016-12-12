<?php

namespace Codeninjas\API\MyStrom\REST\Model;

class Info
{
    /** @var  float */
    protected $version;

    /** @var  string */
    protected $mac;

    /** @var  string */
    protected $ssid;

    /** @var  string */
    protected $ip;

    /** @var  string */
    protected $mask;

    /** @var  string */
    protected $gateway;

    /** @var  string */
    protected $dns;

    /** @var  string */
    protected $static;

    /** @var  boolean */
    protected $connected;

    /**
     * @return float
     */
    public function getVersion(): float
    {
        return $this->version;
    }

    /**
     * @param float $version
     * @return self
     */
    public function setVersion(float $version): self
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string
     */
    public function getMac(): string
    {
        return $this->mac;
    }

    /**
     * @param string $mac
     * @return self
     */
    public function setMac(string $mac): self
    {
        $this->mac = $mac;
        return $this;
    }

    /**
     * @return string
     */
    public function getSsid(): string
    {
        return $this->ssid;
    }

    /**
     * @param string $ssid
     * @return self
     */
    public function setSsid(string $ssid): self
    {
        $this->ssid = $ssid;
        return $this;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     * @return self
     */
    public function setIp(string $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return string
     */
    public function getMask(): string
    {
        return $this->mask;
    }

    /**
     * @param string $mask
     * @return self
     */
    public function setMask(string $mask): self
    {
        $this->mask = $mask;
        return $this;
    }

    /**
     * @return string
     */
    public function getGateway(): string
    {
        return $this->gateway;
    }

    /**
     * @param string $gateway
     * @return self
     */
    public function setGateway(string $gateway): self
    {
        $this->gateway = $gateway;
        return $this;
    }

    /**
     * @return string
     */
    public function getDns(): string
    {
        return $this->dns;
    }

    /**
     * @param string $dns
     * @return self
     */
    public function setDns(string $dns): self
    {
        $this->dns = $dns;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatic(): string
    {
        return $this->static;
    }

    /**
     * @param string $static
     * @return self
     */
    public function setStatic(string $static): self
    {
        $this->static = $static;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isConnected(): bool
    {
        return $this->connected;
    }

    /**
     * @param boolean $connected
     * @return self
     */
    public function setConnected(bool $connected): self
    {
        $this->connected = $connected;
        return $this;
    }
}
