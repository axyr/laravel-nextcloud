<?php

namespace Axyr\Nextcloud\Concerns;

use Axyr\Nextcloud\Exception\NextCloudApiException;
use Axyr\Nextcloud\Parsers\WebDavXmlParser;
use Axyr\Nextcloud\ValueObjects\InvalidRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Str;

trait HandlesNextcloudExceptions
{
    protected function throwExceptionIfNotOk(Response $response): void
    {
        if ( ! $this->isOk($response)) {
            if ($this->isXmlResponse($response)) {
                $message = WebDavXmlParser::parseErrorMessage($response->body());
                throw new NextCloudApiException($message, $response->getStatusCode());
            }

            $message = new InvalidRequest($response->json('ocs.meta'));
            throw new NextCloudApiException($message->message(), $message->statuscode());
        }
    }

    protected function isOk(Response $response): bool
    {
        return $response->status() >= 200 && $response->status() < 300;
    }

    protected function isXmlResponse(Response $response): bool
    {
        return Str::contains($response->header('Content-Type'), 'application/xml');
    }
}
