<?php

namespace Cuongmits\AdminPermissions\AdminRoles;

class MarketingAdminRole extends AbstractAdminRole
{
    public const ROLE_KEY = 'marketing';

    protected function getRoleName(): string
    {
        return 'Marketing Admin';
    }

    protected function getResource(): array
    {
        return [
            'Magento_Backend::marketing',
            'Magento_CatalogRule::promo',
            'Magento_SalesRule::quote',
            'Magento_PromotionPermissions::quote_edit',
            'Magento_Backend::stores',
            'Magento_Backend::stores_settings',
            'Magento_Config::config',
            'Cuongmits_Baumarkt::config',
            'Cuongmits_Offer::config'
        ];
    }
}
