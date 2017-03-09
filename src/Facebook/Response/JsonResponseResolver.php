<?php
namespace Kaz231\FbLikedPagesFetcher\Facebook\Response;

/**
 * Class JsonResponseResolver
 * @package Kaz231\FbLikedPagesFetcher\Facebook\Response
 */
class JsonResponseResolver implements ResponseResolver
{
    public function fromBody(string $body): array
    {
        $response = json_decode($body, true);

        if (empty($response)) {
            throw new InvalidJsonDocumentException(json_last_error_msg());
        }

        return $response['data'] ?? [];
    }
}
