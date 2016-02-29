<?php

namespace Springbot\Queue\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Springbot\Main\Helper\QueueProductChanges;

/**
 * Class ProcessQueue
 *
 * @package Springbot\Queue\Console\Command
 */
class ProcessQueue extends Command
{
    /**
     * Springbot Helper
     *
     * @var QueueProductChanges
     */
    private $springbotHelper;

    /**
     * @param QueueProductChanges $data
     */
    public function __construct(
        \Magento\Framework\App\State $state,
        QueueProductChanges $data)
    {
        $state->setAreaCode('frontend');
        $this->springbotHelper = $data;
        parent::__construct();
    }

    /**
     * Sets config for cli command
     */
    protected function configure()
    {
        $this->setName('springbot:process:queue')
            ->setDescription('Process Queue');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return string
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->springbotHelper->updateProduct(1, 1, ["sku", "price", "name"]);
            $output->writeln("Queue Processed.");
        } catch (\Exception $e) {
            $output->writeln("Could not do the thing: " . $e->getMessage());
        }
    }
}
