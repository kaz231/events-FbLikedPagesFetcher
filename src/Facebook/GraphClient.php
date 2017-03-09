<?php
namespace Kaz231\FbLikedPagesFetcher\Facebook;

use Facebook\Facebook;
use Kaz231\FbLikedPagesFetcher\Facebook\Response\ResponseResolver;

/**
 * Class GraphClient
 * @package Kaz231\FbLikedPagesFetcher\Facebook
 */
class GraphClient implements Client
{
    /** @var Facebook */
    private $fb;

    /** @var string */
    private $accessToken;

    /** @var ResponseResolver */
    private $responseResolver;

    public function __construct(Facebook $fb, string $accessToken, ResponseResolver $responseResolver)
    {
        $this->fb = $fb;
        $this->accessToken = $accessToken;
        $this->responseResolver = $responseResolver;
    }

    public function getLikedPages(): array
    {
        $response = $this->fb->get('/me/likes', $this->accessToken);

        return $this->responseResolver->fromBody($response->getBody());
    }
}
