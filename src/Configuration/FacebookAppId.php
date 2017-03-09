<?php
namespace Kaz231\FbLikedPagesFetcher\Configuration;

/**
 * Class FacebookAppId
 * @package Kaz231\FbLikedPagesFetcher\Configuration
 */
class FacebookAppId
{
    /** @var string */
    private $id;

    public function __construct(string $id)
    {
        if (empty($id)) {
            throw new \UnexpectedValueException('FacebookAppId can\'t be null.');
        }

        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
