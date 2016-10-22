<?php

namespace Codeninjas\API\MyStrom\REST;

use Codeninjas\API\MyStrom\REST\Model\RelayStatus;
use Codeninjas\API\MyStrom\REST\Model\Status;
use Codeninjas\API\MyStrom\REST\Transport\JsonResponse;

class Mapper
{
    use LoggerTrait;

    public function mapResponseToStatus(JsonResponse $response, Status $status = null): Status
    {
        $payload = $response->getPayload();

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

    public function mapResponseToRelayStatus(JsonResponse $response, RelayStatus $status = null): RelayStatus
    {
        $payload = $response->getPayload();

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
}
