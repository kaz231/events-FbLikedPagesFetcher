<?php
namespace Kaz231\FbLikedPagesFetcher\Facebook;

/**
 * Class FakeClient
 * @package Kaz231\FbLikedPagesFetcher\Facebook
 */
class FakeClient implements Client
{
    /** @var array */
    private static $likedPages = [];

    public static function setLikedPages(array $likedPages = [])
    {
        FakeClient::$likedPages = $likedPages;
    }

    public function getLikedPages(): array
    {
        return FakeClient::$likedPages;
    }
}
