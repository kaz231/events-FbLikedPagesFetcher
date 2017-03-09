<?php
namespace Kaz231\FbLikedPagesFetcher\Facebook\Response;

/**
 * Interface ResponseResolver
 * @package Kaz231\FbLikedPagesFetcher\Facebook\Response
 */
interface ResponseResolver
{
    public function fromBody(string $body): array;
}
