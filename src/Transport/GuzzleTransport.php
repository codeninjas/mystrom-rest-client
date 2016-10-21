<?php

namespace Codeninjas\API\MyStrom\REST\Transport;

use Codeninjas\API\MyStrom\REST\TransportInterface;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzleTransport implements TransportInterface
{
    const JSON_DECODE_ASSOC = true;

    /** @var ClientInterface */
    protected $httpClient;

    /** @var  string */
    protected $apiKey;

    /**
     * Transport constructor.
     * @param ClientInterface $httpClient
     * @param string $apiKey
     */
    public function __construct(ClientInterface $httpClient, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }


    /**
     * @param string $method
     * @param string $url
     * @param array $payload
     * @return Response
     */
    public function dispatch(string $method, string $url, array $payload = null) : Response
    {
        $transportType = 'form_params';
        if ($method === 'GET') {
            $transportType = 'query';
        }

        $enforcedPayload = [];

        $rawResponse = null;

        $options = [
            $transportType => array_merge($payload, $enforcedPayload),
            'headers' => ['Accept' => 'application/json'],
        ];

        $rawResponse = $this->httpClient->request($method, $url, $options);
        return $this->psrResponseToResponse($rawResponse);
    }

    /**
     * @param ResponseInterface $rawResponse
     * @return Response
     */
    private function psrResponseToResponse(ResponseInterface $rawResponse) : Response
    {
//        $contentTypes = $rawResponse->getHeader('Content-Type');
        switch (current($rawResponse->getHeader('Content-Type'))) {
            case 'application/json' :
                $response = new JsonResponse();
                break;
            default:
                $response = new Response();
                break;
        }

        $response->setStatusCode($rawResponse->getStatusCode());

        if ($response instanceof JsonResponse) {
            $response->setPayload(json_decode($rawResponse->getBody()->getContents(), true));
        }

        // TODO: Map GuzzleResponse to
        return $response;
    }
}
