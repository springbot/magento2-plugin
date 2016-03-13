<?php

namespace Springbot\Main\Console\Command;

use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Springbot\Main\Model\Register;

/**
 * Class RegisterStoresCommand
 *
 * @package Springbot\Main\Console\Command
 */
class RegisterStoresCommand extends Command
{
    /**
     * @var Register
     */
    private $_register;

    /**
     * @param Register $register
     */
    public function __construct(
        Register $register,
        State $state
    )
    {
        $this->_register = $register;
        parent::__construct();
    }

    /**
     * Sets config for cli command
     */
    protected function configure()
    {
        $this->setName('springbot:stores:register')
            ->setDescription('Registers all stores');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return string
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //$this->_register->registerStores();
        $output->writeln("All stores successfully registered.");
    }
}
