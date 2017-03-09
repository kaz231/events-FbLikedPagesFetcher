<?php
namespace Kaz231\FbLikedPagesFetcher\Test\Unit\Facebook\Response;

use Kaz231\FbLikedPagesFetcher\Facebook\Response\InvalidJsonDocumentException;
use Kaz231\FbLikedPagesFetcher\Facebook\Response\JsonResponseResolver;
use PHPUnit\Framework\TestCase;

/**
 * Class JsonResponseResolverTest
 * @package Kaz231\FbLikedPagesFetcher\Test\Unit\Facebook\Response
 */
class JsonResponseResolverTest extends TestCase
{
    /** @var string */
    private $facebookResponse;

    /** @var array */
    private $arrayResponse;

    public function testReturningOfArrayForValidJsonResponseFromFb()
    {
        $this->givenIHaveResponseFromFacebook('valid_fb_graph_response.json');

        $this->whenIResolveResponseFromFacebook();

        $this->thenResponseShouldBeEqual([
            [
                'name' => 'TestPage',
                'id' => '12345',
                "created_time" => "2017-02-19T11:32:45+0000"
            ],
            [
                'name' => 'TestPage2',
                'id' => '12346',
                'created_time' => '2017-01-19T11:32:45+0000'
            ]
        ]);
    }

    public function testExceptionShouldBeThrewForInvalidJsonDocument()
    {
        $this->expectException(InvalidJsonDocumentException::class);

        $this->givenIHaveResponseFromFacebook('invalid_json_document.json');

        $this->whenIResolveResponseFromFacebook();
    }

    private function givenIHaveResponseFromFacebook(string $responsePath)
    {
        $this->facebookResponse = file_get_contents(sprintf('%s/../../../Fixture/%s', __DIR__, $responsePath));
    }

    private function whenIResolveResponseFromFacebook()
    {
        $resolver = new JsonResponseResolver();

        $this->arrayResponse = $resolver->fromBody($this->facebookResponse);
    }

    private function thenResponseShouldBeEqual(array $expectedArrayResponse)
    {
        $this->assertEquals($expectedArrayResponse, $this->arrayResponse);
    }
}
