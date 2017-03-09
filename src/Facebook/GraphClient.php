<?php
namespace Kaz231\FbLikedPagesFetcher\Facebook;

use Facebook\Facebook;
use Facebook\GraphNodes\GraphNode;
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

    public function __construct(Facebook $fb, string $accessToken)
    {
        $this->fb = $fb;
        $this->accessToken = $accessToken;
    }

    public function getLikedPages(): array
    {
        $graphEdge = null;
        $likedPages = [];

        do {
            if ($graphEdge === null) {
                $response = $this->fb->get('/me/likes', $this->accessToken);
                $graphEdge = $response->getGraphEdge();
            }

            foreach ($graphEdge->getIterator() as $likedPage) {
                /** @var GraphNode $likedPage */
                $likedPages[] = $likedPage->asArray();
            }
        } while(null !== ($graphEdge = $this->fb->next($graphEdge)));

        return $likedPages;
    }
}
