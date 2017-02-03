<?php

namespace Springbot\Main\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable('springbot_quote_redirect')
        )
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                11,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'ID'
            )
            ->addColumn(
                'redirect_string',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Cookie redirect string'
            )
            ->addColumn(
                'quote_id',
                Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Customer Quote ID'
            )
            ->setComment('Springbot Mongo ID Quote Redirect Table');
        $installer->getConnection()->createTable($table);
        $table = $installer->getConnection()->newTable(
            $installer->getTable('springbot_order_redirect')
        )
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                11,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'ID'
            )
            ->addColumn(
                'redirect_string',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Cookie redirect string'
            )
            ->addColumn(
                'order_id',
                Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Customer Order ID'
            )
            ->setComment('Springbot Mongo ID Order Redirect Table');
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}
