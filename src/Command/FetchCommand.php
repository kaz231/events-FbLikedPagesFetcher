<?php
namespace Kaz231\FbLikedPagesFetcher\Command;

use Kaz231\FbLikedPagesFetcher\Configuration\Environment;
use Kaz231\FbLikedPagesFetcher\Configuration\Environments;
use Kaz231\FbLikedPagesFetcher\Configuration\ServiceConfiguration;
use Kaz231\FbLikedPagesFetcher\Facebook\ClientFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FetchCommand
 * @package Kaz231\FbLikedPagesFetcher\Command
 */
class FetchCommand extends Command
{
    const FB_AUTH_TOKEN_ARG = 'fb-auth-token';
    const ENV_OPTION = 'env';

    /** @var ServiceConfiguration */
    private $config;

    /** @inheritdoc */
    public function __construct($name = null)
    {
        $this->config = ServiceConfiguration::fromEnvironmentVariables();

        parent::__construct($name);
    }

    /** @inheritdoc */
    protected function configure()
    {
        parent::configure();

        $availableEnvironments = implode(', ', Environments::all());

        $this
            ->setName('fb:likes:fetch')
            ->setDescription('Fetches all liked FB pages for given auth token')
            ->addArgument(self::FB_AUTH_TOKEN_ARG, InputArgument::REQUIRED, 'FB auth token')
            ->addOption(
                self::ENV_OPTION,
                null,
                InputOption::VALUE_OPTIONAL,
                sprintf('Service environment that should be used (available: %s)', $availableEnvironments),
                (string) $this->config->environment()
            );
    }

    /** @inheritdoc */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $environment = new Environment($input->getOption(self::ENV_OPTION));
        $clientFactory = new ClientFactory(
            $environment,
            $this->config->facebookAppId(),
            $this->config->facebookAppSecret()
        );
        $client = $clientFactory->create($input->getArgument(self::FB_AUTH_TOKEN_ARG));

        $output->write(json_encode($client->getLikedPages()));
    }
}
