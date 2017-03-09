<?php
namespace Kaz231\FbLikedPagesFetcher\Configuration;

/**
 * Class Environments
 * @package Kaz231\FbLikedPagesFetcher\Configuration
 */
class Environments
{
    const DEV = 'dev';
    const PROD = 'prod';
    const TEST = 'test';

    public static function all(): array
    {
        return [
            self::DEV,
            self::PROD,
            self::TEST
        ];
    }
}
