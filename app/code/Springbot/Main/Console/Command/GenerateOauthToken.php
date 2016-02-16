<?php

namespace Springbot\Main\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Springbot\Main\Model\Oauth;

/**
 * Class GenerateOauthToken
 *
 * @package Springbot\Main\Console\Command
 */
class GenerateOauthToken extends Command
{
    /**
     * @var Oauth
     */
    private $_oauth;

    /**
     * @param Oauth $oauth
     */
    public function __construct(Oauth $oauth)
    {
        $this->_oauth = $oauth;
        parent::__construct();
    }

    /**
     * Sets config for cli command
     */
    protected function configure()
    {
        $this->setName('springbot:oauth:generate')
             ->setDescription('Creates Oauth token');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return string
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_oauth->create();
        $output->writeln("Oauth token successfully generated");
    }
}
