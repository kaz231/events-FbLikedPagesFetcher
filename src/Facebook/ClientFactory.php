<?php
namespace Kaz231\FbLikedPagesFetcher\Facebook;

use Facebook\Facebook;
use Kaz231\FbLikedPagesFetcher\Configuration\Environment;
use Kaz231\FbLikedPagesFetcher\Configuration\FacebookAppId;
use Kaz231\FbLikedPagesFetcher\Configuration\FacebookAppSecret;
use Kaz231\FbLikedPagesFetcher\Facebook\Response\JsonResponseResolver;

/**
 * Class ClientFactory
 * @package Kaz231\FbLikedPagesFetcher\Facebook
 */
class ClientFactory
{
    /** @var Environment */
    private $environment;

    /** @var FacebookAppId */
    private $facebookAppId;

    /** @var FacebookAppSecret */
    private $facebookAppSecret;

    public function __construct(
        Environment $environment,
        FacebookAppId $facebookAppId,
        FacebookAppSecret $facebookAppSecret
    ) {
        $this->environment = $environment;
        $this->facebookAppId = $facebookAppId;
        $this->facebookAppSecret = $facebookAppSecret;
    }

    public function create(string $accessToken): Client
    {
        if ($this->environment->isProd()) {
            return new GraphClient(
                $this->getFacebook(),
                $accessToken,
                new JsonResponseResolver()
            );
        }

        return new FakeClient();
    }

    private function getFacebook(): Facebook
    {
        return new Facebook([
            'app_id' => (string) $this->facebookAppId,
            'app_secret' => (string) $this->facebookAppSecret
        ]);
    }
}
