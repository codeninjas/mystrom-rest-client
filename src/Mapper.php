<?php

namespace Codeninjas\API\MyStrom\REST;

use Codeninjas\API\MyStrom\REST\Model\Status;
use Codeninjas\API\MyStrom\REST\Transport\JsonResponse;

class Mapper
{
    use LoggerTrait;

    public function mapResponseToStatus(JsonResponse $response, Status $status = null)
    {
        $payload = $response->getPayload();

        if ($status === null) {
            $status = new Status();
        }

        if (!empty($payload)) {
            $status->setPower($payload['power']);
        }

        if (!empty($payload)) {
            $status->setRelay($payload['relay']);
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
