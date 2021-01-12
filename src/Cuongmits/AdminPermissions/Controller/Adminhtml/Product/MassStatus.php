<?php

namespace Cuongmits\AdminPermissions\Controller\Adminhtml\Product;

use Magento\Catalog\Controller\Adminhtml\Product\MassStatus as BasicMassStatus;

class MassStatus extends BasicMassStatus
{
    public const ADMIN_RESOURCE = 'Magento_PricePermissions::edit_product_status';

    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
