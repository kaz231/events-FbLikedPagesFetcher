<?php
namespace Kaz231\FbLikedPagesFetcher\Configuration;

/**
 * Class ServiceConfiguration
 * @package Kaz231\FbLikedPagesFetcher\Configuration
 */
class ServiceConfiguration
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

    public function environment(): Environment
    {
        return $this->environment;
    }

    public function facebookAppId(): FacebookAppId
    {
        return $this->facebookAppId;
    }

    public function facebookAppSecret(): FacebookAppSecret
    {
        return $this->facebookAppSecret;
    }

    public static function fromEnvironmentVariables(): self
    {
        $environment = getenv(EnvironmentVariables::SERVICE_ENVIRONMENT);

        return new self(
            new Environment(empty($environment) ? Environments::DEV : $environment),
            new FacebookAppId(getenv(EnvironmentVariables::FACEBOOK_APP_ID)),
            new FacebookAppSecret(getenv(EnvironmentVariables::FACEBOOK_APP_SECRET))
        );
    }
}
