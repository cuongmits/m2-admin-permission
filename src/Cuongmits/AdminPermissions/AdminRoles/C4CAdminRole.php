<?php

namespace Cuongmits\AdminPermissions\AdminRoles;

class C4CAdminRole extends AbstractAdminRole
{
    public const ROLE_KEY = 'c4c';

    protected function getRoleName(): string
    {
        return 'C4C Admin';
    }

    protected function getResource(): array
    {
        return [
            'Magento_Customer::customer',
            'Magento_Customer::manage',
            'Magento_Customer::actions',
            'Magento_Customer::delete',
            'Magento_Customer::reset_password',
            'Magento_Customer::invalidate_tokens',
            'Magento_Backend::marketing',
            'Magento_CatalogRule::promo',
            'Magento_SalesRule::quote',
            'Magento_PromotionPermissions::quote_edit'
        ];
    }
}
