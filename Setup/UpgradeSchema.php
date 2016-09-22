<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Springbot\Main\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $this->addTrackableTable($setup);
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

}
