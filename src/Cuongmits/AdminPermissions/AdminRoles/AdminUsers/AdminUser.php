<?php

namespace Cuongmits\AdminPermissions\AdminRoles\AdminUsers;

use Magento\User\Model\UserFactory;

class AdminUser
{
    /** @var UserFactory */
    private $userFactory;

    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    public function create(int $roleId, array $adminInfo): void
    {
        $userModel = $this->userFactory->create();
        $userModel->setData($adminInfo);
        $userModel->setRoleId($roleId);

        $userModel->save();
    }
}
