<?php

namespace Cuongmits\AdminPermissions\Controller\Adminhtml\Product;

use Magento\Catalog\Controller\Adminhtml\Product\Edit as BasicEdit;

class Edit extends BasicEdit
{
    public const ADMIN_RESOURCE = 'Magento_AdminPermissions::edit_product';

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
