<?php
namespace Kaz231\FbLikedPagesFetcher\Configuration;

/**
 * Class NotSupportedEnvironmentException
 * @package Kaz231\FbLikedPagesFetcher\Configuration
 */
class NotSupportedEnvironmentException extends \RuntimeException
{
    const MSG_TEMPLATE = 'Given environment "%s" is not supported (%s)';

    public function __construct(string $givenEnvironment)
    {
        parent::__construct(sprintf(self::MSG_TEMPLATE, $givenEnvironment, implode(', ', Environments::all())));
    }
}
