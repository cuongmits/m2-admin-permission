<?php

namespace Cuongmits\AdminPermissions\Controller\Adminhtml\Product;

use Magento\Catalog\Controller\Adminhtml\Product\Save as BasicSave;

class Save extends BasicSave
{
    public const ADMIN_RESOURCE = 'Magento_AdminPermissions::save_product';

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
