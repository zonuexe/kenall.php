<?php

declare(strict_types=1);

namespace zonuexe\Kenall\Response;

use Psr\Http\Message\ResponseInterface;

interface ApiResponseInterface
{
    /**
     * @return static
     */
    public static function fromHttpResponse(ResponseInterface $response);
}
