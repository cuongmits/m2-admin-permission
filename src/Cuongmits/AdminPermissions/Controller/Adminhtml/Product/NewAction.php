<?php

namespace Cuongmits\AdminPermissions\Controller\Adminhtml\Product;

use Magento\Catalog\Controller\Adminhtml\Product\NewAction as BasicNewAction;

class NewAction extends BasicNewAction
{
    public const ADMIN_RESOURCE = 'Magento_AdminPermissions::new_product';

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
