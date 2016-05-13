<?php

namespace Springbot\Main\Console\Command;

use Magento\Framework\App\State;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface as StoreManager;
use Springbot\Main\Model\StoreConfiguration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Springbot\Main\Model\Register as Register;
use Symfony\Component\Console\Input\InputArgument;
use Zend\Text\Table\Table as TextTable;

/**
 * Class RegisterStoresCommand
 *
 * @package Springbot\Main\Console\Command
 */
class RegisterStoresCommand extends Command
{

    const EMAIL_ARGUMENT = '<springbot_email>';
    const PASSWORD_ARGUMENT = '<springbot_password>';

    private $_storeManager;
    private $_storeConfig;

    /**
     * @param State $state
     * @param StoreManager $storeManager
     * @param Register $register
     * @param StoreConfiguration $storeConfig
     */
    public function __construct(
        State $state,
        StoreManager $storeManager,
        Register $register,
        StoreConfiguration $storeConfig
    ) {
        $state->setAreaCode('adminhtml');
        $this->_register = $register;
        $this->_storeManager = $storeManager;
        $this->_storeConfig = $storeConfig;
        parent::__construct();
    }

    /**
     * Sets config for cli command
     */
    protected function configure()
    {
        $this->setName('springbot:stores:register')
            ->setDescription('Register all stores with Springbot')
            ->addArgument(self::EMAIL_ARGUMENT, InputArgument::REQUIRED)
            ->addArgument(self::PASSWORD_ARGUMENT, InputArgument::REQUIRED);
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
            'columnWidths' => [25, 10, 20, 42],
            'decorator' => 'ascii',
            'AutoSeparate' => TextTable::AUTO_SEPARATE_HEADER,
            'padding' => 1
        ]);

        $table->appendRow(['store_name', 'store_id', 'springbot_store_id', 'action']);
        $storesToRegister = [];

        // Iterate all stores and output them if they're registered, otherwise set them to be registered
        foreach ($this->_storeManager->getStores() as $store) {
            $registered = $this->_addToTable($table, $store, 'Already registered, no action taken');
            if (!$registered) {
                $storesToRegister[] = $store;
            }
        }

        // Register any stores that were not already
        if ($storesToRegister) {
            $successful = $this->_register->registerStores(
                $input->getArgument(self::EMAIL_ARGUMENT),
                $input->getArgument(self::PASSWORD_ARGUMENT),
                $storesToRegister
            );

            if ($successful) {
                $message = 'Store registered successfully!';
            }
            else {
                $message = 'Failed to register store.';
            }

            foreach ($storesToRegister as $store) {
                $this->_addToTable($table, $store, $message, true);
            }
        }

        // Render and output the table
        $output->writeln($table->render());
    }

    /**
     * @param TextTable $table
     * @param StoreInterface $store
     * @param $message
     * @param bool|false $appendIfUnregistered
     * @return bool
     */
    private function _addToTable(TextTable $table, StoreInterface $store, $message, $appendIfUnregistered = false)
    {
        $springbotStoreId = $this->_storeConfig->getSpringbotStoreId($store->getId());
        $springbotGuid = strtolower($this->_storeConfig->getGuid($store->getId()));
        if (($springbotStoreId && $springbotGuid) || $appendIfUnregistered) {
            $table->appendRow([substr($store->getName(), 0, 23), $store->getId(), $springbotStoreId, $message]);
            return true;
        }
        return false;
    }

}
