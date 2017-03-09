<?php
namespace Kaz231\FbLikedPagesFetcher\Test\Unit\Facebook;

use Facebook\Facebook;
use Facebook\FacebookResponse;
use Facebook\GraphNodes\GraphEdge;
use Facebook\GraphNodes\GraphNode;
use Kaz231\FbLikedPagesFetcher\Facebook\GraphClient;
use PHPUnit\Framework\TestCase;

/**
 * Class GraphClientTest
 * @package Kaz231\FbLikedPagesFetcher\Test\Unit\Facebook
 */
class GraphClientTest extends TestCase
{
    /** @var array */
    private $pages;

    /** @var string */
    private $accessToken;

    /** @var array */
    private $likedPages;

    /** @var int */
    private $counter = -1;

    public function testGettingOfLikedPagesWhenOnlyOnePageIsAvailable()
    {
        $this->givenIHavePageOfLikedPages([
            [
                'name' => 'TestPage1',
                'id' => '12345678',
                'created_time' => [
                    'date' => '2012-03-19 07:53:18.000000',
                    'timezone_type' => '1',
                    'timezone' => '+00:00'
                ]
            ]
        ]);
        $this->givenIHaveAccessToken('X12345');

        $this->whenIGetLikedPages();

        $this->thenListOfFetchedLikedPagesShouldBeEqual([
            [
                'name' => 'TestPage1',
                'id' => '12345678',
                'created_time' => [
                    'date' => '2012-03-19 07:53:18.000000',
                    'timezone_type' => '1',
                    'timezone' => '+00:00'
                ]
            ]
        ]);
    }

    public function testGettingOfLikedPagesWhenThreePagesAreAvailable()
    {
        $this->givenIHavePageOfLikedPages([
            [
                'name' => 'TestPage1',
                'id' => '12345678',
                'created_time' => [
                    'date' => '2012-03-19 07:53:18.000000',
                    'timezone_type' => '1',
                    'timezone' => '+00:00'
                ]
            ]
        ]);
        $this->givenIHavePageOfLikedPages([
            [
                'name' => 'TestPage2',
                'id' => '12345678',
                'created_time' => [
                    'date' => '2012-03-19 07:53:18.000000',
                    'timezone_type' => '1',
                    'timezone' => '+00:00'
                ]
            ]
        ]);
        $this->givenIHavePageOfLikedPages([
            [
                'name' => 'TestPage3',
                'id' => '12345678',
                'created_time' => [
                    'date' => '2012-03-19 07:53:18.000000',
                    'timezone_type' => '1',
                    'timezone' => '+00:00'
                ]
            ]
        ]);
        $this->givenIHaveAccessToken('X12345');

        $this->whenIGetLikedPages();

        $this->thenListOfFetchedLikedPagesShouldBeEqual([
            [
                'name' => 'TestPage1',
                'id' => '12345678',
                'created_time' => [
                    'date' => '2012-03-19 07:53:18.000000',
                    'timezone_type' => '1',
                    'timezone' => '+00:00'
                ]
            ],
            [
                'name' => 'TestPage2',
                'id' => '12345678',
                'created_time' => [
                    'date' => '2012-03-19 07:53:18.000000',
                    'timezone_type' => '1',
                    'timezone' => '+00:00'
                ]
            ],
            [
                'name' => 'TestPage3',
                'id' => '12345678',
                'created_time' => [
                    'date' => '2012-03-19 07:53:18.000000',
                    'timezone_type' => '1',
                    'timezone' => '+00:00'
                ]
            ]
        ]);
    }

    public function testGettingOfLikedPagesWhenNoneIsAvailable()
    {
        $this->givenIHavePageOfLikedPages([]);
        $this->givenIHaveAccessToken('X12345');

        $this->whenIGetLikedPages();

        $this->thenListOfFetchedLikedPagesShouldBeEqual([]);
    }

    private function givenIHavePageOfLikedPages(array $likedPages)
    {
        $this->pages[] = $likedPages;
    }

    private function givenIHaveAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    private function whenIGetLikedPages()
    {
        $client = new GraphClient(
            $this->getFacebook(),
            $this->accessToken
        );

        $this->likedPages = $client->getLikedPages();
    }

    private function thenListOfFetchedLikedPagesShouldBeEqual(array $expectedLikedPages)
    {
        self::assertEquals($expectedLikedPages, $this->likedPages);
    }

    private function getFacebook(): Facebook
    {
        $mock = $this->getMockBuilder(Facebook::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mock
            ->method('get')
            ->willReturn($this->getFacebookResponse());

        $mock
            ->method('next')
            ->willReturnCallback(function () {
                return $this->getGraphEdgeForNextPage();
            });

        return $mock;
    }

    private function getFacebookResponse()
    {
        $mock = $this->getMockBuilder(FacebookResponse::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mock
            ->method('getGraphEdge')
            ->willReturn($this->getGraphEdgeForNextPage());

        return $mock;
    }

    private function getGraphEdgeForNextPage()
    {
        $this->counter++;

        if ($this->counter === count($this->pages)) {
            return null;
        }

        $likedPages = array_map(function (array $likedPage) {
            return $this->getGraphNode($likedPage);
        }, $this->pages[$this->counter]);

        $mock = $this->getMockBuilder(GraphEdge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mock
            ->method('getIterator')
            ->willReturn(new \ArrayIterator($likedPages));

        return $mock;
    }

    private function getGraphNode(array $likedPage)
    {
        $mock = $this->getMockBuilder(GraphNode::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mock
            ->method('asArray')
            ->willReturn($likedPage);

        return $mock;
    }
}
