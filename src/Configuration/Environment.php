<?php
namespace Kaz231\FbLikedPagesFetcher\Configuration;

/**
 * Class Environment
 * @package Kaz231\FbLikedPagesFetcher\Configuration
 */
class Environment
{
    /** @var string */
    private $environment;

    public function __construct(string $environment)
    {
        if (!in_array($environment, Environments::all())) {
            throw new NotSupportedEnvironmentException($environment);
        }

        $this->environment = $environment;
    }

    public function isProd(): bool
    {
        return $this->environment === Environments::PROD;
    }

    public function isDev(): bool
    {
        return $this->environment === Environments::DEV;
    }

    public function isTest(): bool
    {
        return $this->environment === Environments::TEST;
    }

    public function __toString(): string
    {
        return $this->environment;
    }
}
