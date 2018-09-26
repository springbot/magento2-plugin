<?php

namespace Springbot\Main\Console\Command;

use Magento\Framework\App\State;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface as StoreManager;
use Springbot\Main\Model\Register as Register;
use Springbot\Main\Model\StoreConfiguration;
use Springbot\Main\Helper\Data as SpringbotHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zend\Text\Table\Table as TextTable;

/**
 * Class RegisterStoresCommand
 *
 * @package Springbot\Main\Console\Command
 */
class RegisterStoresCommand extends Command
{

    const email_argument = '<springbot_email>';
    const password_argument = '<springbot_password>';

    private $storeManager;
    private $storeConfig;
    private $register;

    protected $springbotHelper;

    /**
     * @param StoreManager       $storeManager
     * @param Register           $register
     * @param StoreConfiguration $storeConfig
     * @param SpringbotHelper    $springbotHelper
     */
    public function __construct(
        StoreManager $storeManager,
        Register $register,
        StoreConfiguration $storeConfig,
        SpringbotHelper $springbotHelper
    ) {
        $this->register = $register;
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
        $this->setName('springbot:stores:register')
            ->setDescription('Register all stores with Springbot')
            ->addArgument(self::email_argument, InputArgument::REQUIRED)
            ->addArgument(self::password_argument, InputArgument::REQUIRED);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new TextTable(
            [
            'columnWidths' => [25, 10, 20, 42],
            'decorator'    => 'ascii',
            'AutoSeparate' => TextTable::AUTO_SEPARATE_HEADER,
            'padding'      => 1
            ]
        );

        $table->appendRow(['store_name', 'store_id', 'springbot_store_id', 'action']);
        $storesToRegister = [];
        // Iterate all stores and output them if they're registered, otherwise set them to be registered

        foreach ($this->storeManager->getStores() as $store) {
            /* @var \Magento\Store\Model\Store\Interceptor $store */
            $registered = $this->addToTable($table, $store, 'Already registered, no action taken');
            if (! $registered) {
                $storesToRegister[] = $store;
            }
        }

        // Register any stores that were not already
        if ($storesToRegister) {
            $successful = $this->register->registerStores(
                $input->getArgument(self::email_argument),
                $input->getArgument(self::password_argument),
                $storesToRegister
            );

            if ($successful) {
                $message = 'Store registered successfully!';
            } else {
                $message = 'Failed to register store.';
            }

            foreach ($storesToRegister as $store) {
                $this->addToTable($table, $store, $message, true);
            }
        }

        // Render and output the table
        $output->writeln($table->render());
    }

    /**
     * @param TextTable      $table
     * @param StoreInterface $store
     * @param                $message
     * @param bool|false     $appendIfUnregistered
     * @return bool
     */
    private function addToTable(TextTable $table, StoreInterface $store, $message, $appendIfUnregistered = false)
    {
        $springbotStoreId = $this->storeConfig->getSpringbotStoreId($store->getId());

        $springbotGuid = str_replace('-', '', strtolower($this->springbotHelper->getStoreGuid($store->getId())));

        if (($springbotStoreId && $springbotGuid) || $appendIfUnregistered) {
            $table->appendRow([substr($store->getName(), 0, 23), $store->getId(), $springbotStoreId, $message]);

            return true;
        }

        return false;
    }
}
