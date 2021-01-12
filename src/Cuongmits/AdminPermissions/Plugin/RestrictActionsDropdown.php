<?php

namespace Cuongmits\AdminPermissions\Plugin;

use Magento\Framework\AuthorizationInterface;
use Magento\Catalog\Ui\Component\Product\MassAction;
use Cuongmits\AdminPermissions\Controller\Adminhtml\Product\MassDelete;
use Cuongmits\AdminPermissions\Controller\Adminhtml\Product\MassStatus;

class RestrictActionsDropdown
{
    public const ACTION_TYPE_DELETE = 'delete';
    public const ACTION_TYPE_STATUS = 'status';

    /** @var AuthorizationInterface  */
    private $authorization;

    public function __construct(AuthorizationInterface $authorization)
    {
        $this->authorization = $authorization;
    }

    public function afterPrepare(MassAction $subject): void
    {
        if (empty($subject->getConfiguration()['actions'])) {
            $subject->setData('config', null);
        }
    }

    public function afterIsActionAllowed(MassAction $subject, bool $result, string $actionType): bool
    {
        if ($actionType === self::ACTION_TYPE_DELETE) {
            $result = $this->authorization->isAllowed(MassDelete::ADMIN_RESOURCE);
        } elseif ($actionType === self::ACTION_TYPE_STATUS) {
            $result = $this->authorization->isAllowed(MassStatus::ADMIN_RESOURCE);
        }

        return $result;
    }
}
