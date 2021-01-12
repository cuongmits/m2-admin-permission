<?php

namespace Cuongmits\AdminPermissions\AdminRoles;

class OperationsAdminRole extends AbstractAdminRole
{
    public const ROLE_KEY = 'operations';

    protected function getRoleName(): string
    {
        return 'Operations Admin';
    }

    protected function getResource(): array
    {
        return [
            'Magento_Sales::sales',
            'Magento_Sales::sales_operation',
            'Magento_Sales::sales_order',
            'Magento_Sales::actions',
            'Magento_Sales::actions_view',
            'Magento_SalesArchive::archive',
            'Magento_SalesArchive::invoices',
            'Magento_SalesArchive::shipments',
            'Magento_SalesArchive::creditmemos',
            'Magento_Catalog::catalog',
            'Magento_Catalog::catalog_inventory',
            'Magento_Catalog::products',
            'Magento_PricePermissions::read_product_price',
        ];
    }
}
