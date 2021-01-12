<?php

namespace Cuongmits\AdminPermissions\Plugin;

use Magento\Catalog\Block\Adminhtml\Product;
use Magento\Backend\Block\Widget\Button\Item;
use Magento\Framework\AuthorizationInterface;

class ModifyAddProductButtonVisibility
{
    /** @var AuthorizationInterface  */
    private $authorization;

    public function __construct(AuthorizationInterface $authorization)
    {
        $this->authorization = $authorization;
    }

    public function aroundCanRender(Product $subject, callable $proceed, Item $item): bool
    {
        return !$item->isDeleted()
            && $this->authorization->isAllowed('Magento_AdminPermissions::new_product')
            && $this->authorization->isAllowed('Magento_AdminPermissions::save_product');
    }
}
