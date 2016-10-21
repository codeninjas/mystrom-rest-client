<?php

namespace Codeninjas\API\MyStrom\REST;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

trait LoggerTrait
{
    protected $logger;

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        if ($this->logger != null) {
            return $this->logger;
        }

        return new NullLogger();
    }

    /**
     * @param LoggerInterface $logger
     * @return $this
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
        return $this;
    }
}
