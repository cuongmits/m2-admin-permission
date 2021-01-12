<?php

namespace Cuongmits\AdminPermissions\Plugin;

use Magento\Framework\AuthorizationInterface;
use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\AddAttribute;

class HideAddAttributeButtonWhenNoPermission
{
    public const ADMIN_RESOURCE = 'Magento_Catalog::attributes_attributes';

    /** @var AuthorizationInterface  */
    private $authorization;

    public function __construct(AuthorizationInterface $authorization)
    {
        $this->authorization = $authorization;
    }

    public function afterGetButtonData(AddAttribute $subject, array $result): array
    {
        if (!$this->authorization->isAllowed(self::ADMIN_RESOURCE)) {
            return [];
        }

        return $result;
    }
}
