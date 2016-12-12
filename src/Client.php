<?php

namespace Codeninjas\API\MyStrom\REST;

use Codeninjas\API\MyStrom\REST\Model\Info;
use Codeninjas\API\MyStrom\REST\Model\Status;
use Codeninjas\API\MyStrom\REST\Transport\JsonResponse;
use Codeninjas\API\MyStrom\REST\Transport\Response;
use Http\Client\Common\HttpMethodsClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\Authentication\Chain;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

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

    /** @var  Mapper */
    protected $mapper;

    /** @var HttpMethodsClient */
    protected $httpClient;

    /** @var \Http\Message\MessageFactory */
    protected $messageFactory;

    /** @var HttpMethodsClient */
    protected $httpMethodsClient;

    /** @var \Http\Message\Authentication */
    protected $authentication;

    /** @var  \Http\Message\UriFactory */
    protected $uriFactory;

    /** @var  UriInterface */
    protected $baseUri;

    /**
     * Client constructor.
     * @param string $baseUrl
     * @param \Http\Message\Authentication $authentication
     * @param \Http\Client\HttpClient $httpClient
     * @param \Http\Message\MessageFactory $messageFactory
     * @param \Http\Message\UriFactory $uriFactory
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        string $baseUrl,
        \Http\Message\Authentication $authentication = null,
        \Http\Client\HttpClient $httpClient = null,
        \Http\Message\MessageFactory $messageFactory = null,
        \Http\Message\UriFactory $uriFactory = null,
        \Psr\Log\LoggerInterface $logger = null
    ) {
        if (!isset($uriFactory)) {
            $uriFactory = $uriFactory ?: UriFactoryDiscovery::find();;
        }

        $this->baseUri = $uriFactory->createUri($baseUrl);

        if (!isset($authentication)) {
            // Use a Empty Chain as "NullAuthenticator"
            $this->authentication = new Chain();
        }
        if (!isset($httpClient)) {
            $this->httpClient = HttpClientDiscovery::find();
        }
        if (!isset($messageFactory)) {
            $this->messageFactory = MessageFactoryDiscovery::find();
        }

        $this->httpMethodsClient = new HttpMethodsClient(
            $this->httpClient,
            $this->messageFactory
        );

        $this->setLogger($logger);
        $this->mapper = new Mapper();
        $this->mapper->setLogger($this->getLogger());
    }

    public function getInfo() : Info
    {
        $method = 'GET';
        $url = self::ROUTES_INFO;
        $payload = [];

        $response = $this->dispatch($method, $url, $payload);
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

        $response = $this->dispatch($method, $url, $payload);
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

        $response = $this->dispatch($method, $url, $payload);
        return $response->getStatusCode() == 200;
    }

    public function powerToggle()
    {
        $method = 'GET';
        $url = self::ROUTES_TOGGLE;
        $payload = [];

        $response = $this->dispatch($method, $url, $payload);
        if (!$response instanceof JsonResponse) {
            throw new \Exception('Expected json response, got ' . get_class($response));
        }

        return $this->mapper->mapResponseToRelayStatus($response->getPayload());
    }

    protected function dispatch(string $method, string $url, array $payload = null) : Response
    {
        $query = http_build_query($payload);
        $body = '';
        $uri = $this->baseUri->withPath($url);
        if ($method === 'GET') {
            $uri = $uri->withQuery($query);
        } else {
            $body = $query;
        };

        $request = $this->messageFactory->createRequest($method, $uri, [], $body);
        $request = $this->authentication->authenticate($request);
        $psrResponse = $this->httpMethodsClient->sendRequest($request);
        $response = $this->psrResponseToResponse($psrResponse);
        return $response;
    }

    /**
     * @param ResponseInterface $rawResponse
     * @return Response
     */
    private function psrResponseToResponse(ResponseInterface $rawResponse) : Response
    {
        $body = $rawResponse->getBody()->getContents();
        $contentTypes = $rawResponse->getHeader('Content-Type');
        switch ($contentTypes[0]) {
            case 'application/json' :
                $response = new JsonResponse();
                break;
            default:
                $response = new Response();
                break;
        }

        $response->setStatusCode($rawResponse->getStatusCode());

        if ($response instanceof JsonResponse) {
            $response->setPayload(json_decode($body, true));
        }

        return $response;
    }
}
