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

        if (version_compare($context->getVersion(), '1.2.0', '<')) {
            $this->addTrackableTable($setup);
            $this->createMarketplacesRemoteOrderTable($setup);
        }

        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     * @return void
     */
    protected function addTrackableTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()->newTable(
            $setup->getTable('springbot_trackable'))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                11,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'ID')
            ->addColumn(
                'quote_id',
                Table::TYPE_INTEGER,
                11,
                ['nullable' => true],
                'Quote Id')
            ->addColumn(
                'customer_id',
                Table::TYPE_INTEGER,
                11,
                ['nullable' => true],
                'Customer Id')
            ->addColumn(
                'order_id',
                Table::TYPE_INTEGER,
                11,
                ['nullable' => true],
                'Order Id')
            ->addColumn(
                'type',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Trackable type')
            ->addColumn(
                'value',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Trackable value')
            ->setComment('Springbot Trackables Table');

        $setup->getConnection()->createTable($table);
    }


    protected function createMarketplacesRemoteOrderTable(SchemaSetupInterface $setup)
    {
        $tableName = 'springbot_marketplaces_remote_order';
        // Check if the table already exists
        if ($setup->getConnection()->isTableExists($tableName) == false) {
            $table = $setup->getConnection()->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    11,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'ID')
                ->addColumn(
                    'order_id',
                    Table::TYPE_INTEGER,
                    11,
                    ['nullable' => false],
                    'Customer Order ID')
                ->addColumn(
                    'increment_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    32,
                    [],
                    'Magento Order Increment Id')
                ->addColumn(
                    'remote_order_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    32,
                    [],
                    'Order ID in Remote Marketplace')
                ->addColumn(
                    'marketplace_type',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    32,
                    [],
                    'Marketplace of Origin')
                ->setComment('Springbot join table for remote orders')
                ->addIndex(
                    $setup->getIdxName($tableName, ['remote_order_id']),
                    ['remote_order_id'],
                    ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE])
                ->addIndex(
                    $setup->getIdxName($tableName, ['increment_id']),
                    ['increment_id'],
                    ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]);
            $setup->getConnection()->createTable($table);
        }
    }
}
