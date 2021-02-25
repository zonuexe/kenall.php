<?php

declare(strict_types=1);

namespace zonuexe\Kenall;

use DomainException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface as HttpClient;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use zonuexe\Kenall\Response\PostalCodeResponse;
use function getenv;

function create_client(
    string $api_key,
    ?HttpClient $http_client = null,
    ?RequestFactoryInterface $request_factory = null,
    ?UriFactoryInterface $uri_factory = null
): KenallClient {
    return new KenallClient(
        $api_key,
        $http_client ?? Psr18ClientDiscovery::find(),
        $request_factory ?? Psr17FactoryDiscovery::findRequestFactory(),
        $uri_factory ?? Psr17FactoryDiscovery::findUriFactory()
    );
}

function find(string $postal_code): PostalCodeResponse
{
    static $client;

    if ($client === null) {
        $authorization_token = getenv('KENALL_AUTHORIZATION_TOKEN');
        if ($authorization_token === false) {
            throw new DomainException('Environment variable "KENALL_AUTHORIZATION_TOKEN" is not set');
        }

        $client = create_client($authorization_token);
    }

    return $client->findPostalCode($postal_code);
}
