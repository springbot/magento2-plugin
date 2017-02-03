<?php

namespace Springbot\Main\Console\Command;

use Magento\Store\Model\StoreManagerInterface as StoreManager;
use Springbot\Main\Model\StoreConfiguration;
use Springbot\Main\Helper\Data as SpringbotHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Springbot\Main\Model\Oauth;
use Zend\Text\Table\Table as TextTable;

/**
 * Class ListStoresCommand
 *
 * @package Springbot\Main\Console\Command
 */
class ListStoresCommand extends Command
{

    private $oauth;
    private $storeManager;
    private $storeConfig;

    protected $springbotHelper;

    /**
     * @param Oauth              $oauth
     * @param StoreManager       $storeManager
     * @param StoreConfiguration $storeConfig
     * @param SpringbotHelper    $springbotHelper
     */
    public function __construct(
        Oauth $oauth,
        StoreManager $storeManager,
        StoreConfiguration $storeConfig,
        SpringbotHelper $springbotHelper
    ) {
        $this->oauth = $oauth;
        $this->storeManager = $storeManager;
        $this->storeConfig = $storeConfig;
        $this->springbotHelper = $springbotHelper;
        parent::__construct();
    }

    /**
     * Sets config for cli command
     */
    protected function configure()
    {
        $this->setName('springbot:stores:list')
            ->setDescription('List all currently registered stores');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return string
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new TextTable(
            [
            'columnWidths' => [25, 10, 20, 36],
            'decorator' => 'ascii',
            'AutoSeparate' => TextTable::AUTO_SEPARATE_HEADER,
            'padding' => 1
            ]
        );

        $table->appendRow(['store_name', 'store_id', 'springbot_store_id', 'springbot_guid']);
        foreach ($this->storeManager->getStores() as $store) {
            $springbotStoreId = $this->storeConfig->getSpringbotStoreId($store->getId());
            $springbotGuid = str_replace('-', '', strtolower($this->springbotHelper->getStoreGuid($store->getId())));

            $table->appendRow([substr($store->getName(), 0, 23), $store->getId(), $springbotStoreId, $springbotGuid]);
        }

        $output->writeln($table->render());
    }
}
