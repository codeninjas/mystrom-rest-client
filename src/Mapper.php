<?php

namespace Codeninjas\API\MyStrom\REST;

use Codeninjas\API\MyStrom\REST\Model\Info;
use Codeninjas\API\MyStrom\REST\Model\RelayStatus;
use Codeninjas\API\MyStrom\REST\Model\Status;

class Mapper
{
    use LoggerTrait;

    public function mapResponseToStatus(array $payload, Status $status = null): Status
    {
        if ($status === null) {
            $status = new Status();
        }

        if (empty($payload)) {
            return $status;
        }

        if (isset($payload['power'])) {
            $status->setPower($payload['power']);
        }

        if (isset($payload['relay'])) {
            $status->setRelay($payload['relay']);
        }

        return $status;
    }

    public function mapResponseToRelayStatus(array $payload, RelayStatus $status = null): RelayStatus
    {
        if ($status === null) {
            $status = new RelayStatus();
        }

        if (empty($payload)) {
            return $status;
        }

        if (isset($payload['relay'])) {
            $status->setPower($payload['relay']);
        }

        return $status;
    }


    /**
     * @param \DateTime|null $dateTime
     * @return string
     */
    public function formatDateTime(\DateTime $dateTime = null) : string
    {
        if ($dateTime === null) {
            return null;
        }

        return $dateTime->format(\DateTime::ATOM);
    }

    public function mapResponseToInfo(array $payload, Info $result = null): Info
    {
        if ($result === null) {
            $result = new Info();
        }

        if (isset($payload['version'])) {
            $result->setVersion($payload['version']);
        }

        if (isset($payload['mac'])) {
            $result->setMac($payload['mac']);
        }

        if (isset($payload['ssid'])) {
            $result->setSsid($payload['ssid']);
        }

        if (isset($payload['ip'])) {
            $result->setIp($payload['ip']);
        }

        if (isset($payload['mask'])) {
            $result->setMask($payload['mask']);
        }

        if (isset($payload['gateway'])) {
            $result->setGateway($payload['gateway']);
        }

        if (isset($payload['dns'])) {
            $result->setDns($payload['dns']);
        }

        if (isset($payload['static'])) {
            $result->setStatic($payload['static']);
        }

        if (isset($payload['connected'])) {
            $result->setConnected(boolval($payload['connected']));
        }

        return $result;
    }
}
