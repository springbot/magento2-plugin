<?php

namespace Springbot\Main\Console\Command;

use Magento\Framework\App\State;
use Magento\Store\Model\StoreManagerInterface as StoreManager;
use Springbot\Main\Model\StoreConfiguration;
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

    private $_oauth;
    private $_state;
    private $_storeManager;
    private $_storeConfig;

    /**
     * @param Oauth $oauth
     * @param StoreManager $storeManager
     * @param StoreConfiguration $storeConfig
     */
    public function __construct(
        Oauth $oauth,
        StoreManager $storeManager,
        StoreConfiguration $storeConfig
    )
    {
        $this->_oauth = $oauth;
        $this->_storeManager = $storeManager;
        $this->_storeConfig = $storeConfig;
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
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return string
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new TextTable([
            'columnWidths' => [25, 10, 20, 36],
            'decorator' => 'ascii',
            'AutoSeparate' => TextTable::AUTO_SEPARATE_HEADER,
            'padding' => 1
        ]);

        $table->appendRow(['store_name', 'store_id', 'springbot_store_id', 'springbot_guid']);
        foreach ($this->_storeManager->getStores() as $store) {
            $springbotStoreId = $this->_storeConfig->getSpringbotStoreId($store->getId());
            $springbotGuid = strtolower($this->_storeConfig->getGuid($store->getId()));
            $table->appendRow([substr($store->getName(), 0, 23), $store->getId(), $springbotStoreId, $springbotGuid]);
        }

        $output->writeln($table->render());
    }
}
