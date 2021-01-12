<?php

namespace Cuongmits\AdminPermissions\Controller\Adminhtml\Product;

use Magento\Catalog\Controller\Adminhtml\Product\MassDelete as BasicMassDelete;

class MassDelete extends BasicMassDelete
{
    public const ADMIN_RESOURCE = 'Magento_AdminPermissions::delete_product';

    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
