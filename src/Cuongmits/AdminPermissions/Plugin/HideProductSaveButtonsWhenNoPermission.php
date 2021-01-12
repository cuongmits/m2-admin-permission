<?php

namespace Cuongmits\AdminPermissions\Plugin;

use Magento\Framework\AuthorizationInterface;
use Magento\ConfigurableProduct\Block\Adminhtml\Product\Edit\Button\Save;
use Cuongmits\AdminPermissions\Controller\Adminhtml\Product\Save as SaveAction;

class HideProductSaveButtonsWhenNoPermission
{
    /** @var AuthorizationInterface  */
    private $authorization;

    public function __construct(AuthorizationInterface $authorization)
    {
        $this->authorization = $authorization;
    }

    public function afterGetButtonData(Save $subject, array $result): array
    {
        if (!$this->authorization->isAllowed(SaveAction::ADMIN_RESOURCE)) {
            return [];
        }

        return $result;
    }
}
