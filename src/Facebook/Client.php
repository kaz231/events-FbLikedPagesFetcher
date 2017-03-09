<?php
namespace Kaz231\FbLikedPagesFetcher\Facebook;

/**
 * Interface Client
 * @package Kaz231\FbLikedPagesFetcher\Facebook
 */
interface Client
{
    public function getLikedPages(): array;
}
