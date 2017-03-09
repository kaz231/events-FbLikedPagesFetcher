<?php
namespace Kaz231\FbLikedPagesFetcher\Configuration;

/**
 * Class FacebookAppSecret
 * @package Kaz231\FbLikedPagesFetcher\Configuration
 */
class FacebookAppSecret
{
    /** @var string */
    private $secret;

    public function __construct(string $secret)
    {
        if (empty($secret)) {
            throw new \UnexpectedValueException('FacebookSecretId can\'t be null.');
        }

        $this->secret = $secret;
    }

    public function __toString(): string
    {
        return $this->secret;
    }
}
