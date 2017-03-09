<?php
namespace Kaz231\FbLikedPagesFetcher\Test\Integration\Facebook;

use Facebook\Facebook;
use Facebook\FacebookResponse;
use Kaz231\FbLikedPagesFetcher\Facebook\GraphClient;
use Kaz231\FbLikedPagesFetcher\Facebook\Response\JsonResponseResolver;
use Kaz231\FbLikedPagesFetcher\Facebook\Response\ResponseResolver;
use PHPUnit\Framework\TestCase;

/**
 * Class GraphClientTest
 * @package Kaz231\FbLikedPagesFetcher\Test\Integration\Facebook
 */
class GraphClientTest extends TestCase
{
    /** @var ResponseResolver */
    private $responseResolver;

    /** @var Facebook */
    private $facebook;

    /** @var string */
    private $accessToken;

    /** @var array */
    private $likedPages;

    public function testReturningOfLikedPagesFromFacebookResponse()
    {
        $this->givenIHaveResponseResolver(new JsonResponseResolver());
        $this->givenIHaveFacebookResponse('valid_fb_graph_response.json');
        $this->givenIHaveAccessToken('1234555');

        $this->whenIGetListOfLikedPages();

        $this->thenReturnedListShouldContainsTwoEntries();
    }

    private function givenIHaveResponseResolver(ResponseResolver $resolver)
    {
        $this->responseResolver = $resolver;
    }

    private function givenIHaveFacebookResponse(string $responsePath)
    {
        $jsonResponse = file_get_contents(sprintf('%s/../../Fixture/%s', __DIR__, $responsePath));

        $facebookResponse = $this->getMockBuilder(FacebookResponse::class)
            ->disableOriginalConstructor()
            ->getMock();

        $facebookResponse
            ->method('getBody')
            ->willReturn($jsonResponse);

        $this->facebook = $this->getMockBuilder(Facebook::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facebook
            ->method('get')
            ->willReturn($facebookResponse);
    }

    private function givenIHaveAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    private function whenIGetListOfLikedPages()
    {
        $client = new GraphClient($this->facebook, $this->accessToken, $this->responseResolver);

        $this->likedPages = $client->getLikedPages();
    }

    private function thenReturnedListShouldContainsTwoEntries()
    {
        self::assertCount(2, $this->likedPages);
    }
}
