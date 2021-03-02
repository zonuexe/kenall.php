<?php

declare(strict_types=1);

namespace zonuexe\Kenall;

use Psr\Http\Client\ClientInterface as HttpClient;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use zonuexe\Kenall\Response\ApiResponseInterface;
use zonuexe\Kenall\Response\V1\AddressResolverResponse;

class KenallClient
{
    /** @var string */
    private $authorization_token;
    /** @var HttpClient */
    protected $http_client;
    /** @var RequestFactoryInterface */
    protected $request_factory;
    /** @var UriFactoryInterface */
    protected $uri_factory;

    public function __construct(
        string $authorization_token,
        HttpClient $http_client,
        RequestFactoryInterface $request_factory,
        UriFactoryInterface $uri_factory
    ) {
        $this->authorization_token = $authorization_token;
        $this->http_client = $http_client;
        $this->request_factory = $request_factory;
        $this->uri_factory = $uri_factory;
    }

    public function findPostalCode(string $postal_code): AddressResolverResponse
    {
        $uri = $this->buildUriString("postalcode/{$postal_code}");
        $request = $this->request_factory->createRequest('GET', $uri);

        return $this->request($request, AddressResolverResponse::class);
    }

    /**
     * @template T of ApiResponseInterface
     * @param class-string<T> $class
     * @return T
     */
    public function request(RequestInterface $request, string $class): ApiResponseInterface
    {
        return $class::fromHttpResponse($this->http_client->sendRequest(
            $request->withHeader('Authorization', "Token {$this->authorization_token}")
        ));
    }

    protected function getUriPrefix(): string
    {
        return 'https://api.kenall.jp/v1/';
    }

    protected function buildUriString(string $path): UriInterface
    {
        return $this->uri_factory->createUri($this->getUriPrefix() . $path);
    }
}
