<?php
namespace Kaz231\FbLikedPagesFetcher\Test\Integration\Command;

use Kaz231\FbLikedPagesFetcher\Command\FetchCommand;
use Kaz231\FbLikedPagesFetcher\Configuration\Environment;
use Kaz231\FbLikedPagesFetcher\Configuration\Environments;
use Kaz231\FbLikedPagesFetcher\Configuration\EnvironmentVariables;
use Kaz231\FbLikedPagesFetcher\Facebook\FakeClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class FetchCommandTest
 * @package Kaz231\FbLikedPagesFetcher\Test\Integration\Command
 */
class FetchCommandTest extends TestCase
{
    /** @var string */
    private $accessToken;

    /** @var string */
    private $commandOutput;

    /** @var int */
    private $statusCode;

    public function testFetchingOfLikedPages()
    {
        $this->givenLikedPages([
            [
                'name' => 'TestPage',
                'id' => '12345',
                'created_time' => '2017-02-19T11:32:45+0000'
            ]
        ]);
        $this->givenAccessToken('my_secret_token');
        $this->givenFacebookAppId('12345');
        $this->givenFacebookAppSecret('XYZ');

        $this->whenIFetchLikedPages();

        $this->thenStatusCodeShouldBeEqualZero();
        $this->thenListOfPagesShouldBeNotEmpty();
        $this->thenPageShouldBeFetched('12345');
    }

    private function thenStatusCodeShouldBeEqualZero()
    {
        $this->assertEquals(0, $this->statusCode);
    }

    private function givenLikedPages(array $likedPages)
    {
        FakeClient::setLikedPages($likedPages);
    }

    private function whenIFetchLikedPages()
    {
        $command = new FetchCommand();
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            FetchCommand::FB_AUTH_TOKEN_ARG => $this->accessToken,
            sprintf('--%s', FetchCommand::ENV_OPTION) => Environments::TEST
        ]);

        $this->statusCode = $commandTester->getStatusCode();
        $this->commandOutput = $commandTester->getDisplay();
    }

    private function givenAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    private function thenPageShouldBeFetched(string $pageId)
    {
        $pages = array_filter($this->commandOutputAsJson(), function ($page) use ($pageId) {
            return $page['id'] === $pageId;
        });

        $this->assertNotEmpty($pages);
    }

    private function thenListOfPagesShouldBeNotEmpty()
    {
        $this->assertNotEmpty($this->commandOutputAsJson());
    }

    private function commandOutputAsJson(): array
    {
        $json = json_decode($this->commandOutput, true);

        return is_array($json) ? $json : [];
    }

    private function givenFacebookAppId(string $facebookAppId)
    {
        putenv(sprintf('%s=%s', EnvironmentVariables::FACEBOOK_APP_ID, $facebookAppId));
    }

    private function givenFacebookAppSecret(string $facebookAppSecret)
    {
        putenv(sprintf('%s=%s', EnvironmentVariables::FACEBOOK_APP_SECRET, $facebookAppSecret));
    }
}
