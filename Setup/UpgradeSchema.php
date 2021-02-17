<?php

namespace Springbot\Main\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /**
        *  Drop old tables that are no longer used SB3-243
        */
        $connection = $setup->getConnection();
        $connection->dropTable($connection->getTableName('springbot_trackable'));
        $connection->dropTable($connection->getTableName('springbot_marketplaces_remote_order'));

        $setup->endSetup();
    }

}
