<?php

namespace Cuongmits\AdminPermissions\AdminRoles;

use Magento\Authorization\Model\Acl\Role\Group as RoleGroup;
use Magento\Authorization\Model\RoleFactory;
use Magento\Authorization\Model\RulesFactory;
use Magento\Authorization\Model\UserContextInterface;

abstract class AbstractAdminRole
{
    /** @var RoleFactory */
    private $roleFactory;

    /** @var RulesFactory */
    private $rulesFactory;

    public function __construct(RoleFactory $roleFactory, RulesFactory $rulesFactory)
    {
        $this->roleFactory = $roleFactory;
        $this->rulesFactory = $rulesFactory;
    }

    public function create(): int
    {
        $role = $this->roleFactory->create();
        $role->setName($this->getRoleName())
            ->setPid(0)
            ->setRoleType(RoleGroup::ROLE_TYPE)
            ->setUserType(UserContextInterface::USER_TYPE_ADMIN);
        $role->save();

        $this->rulesFactory->create()->setRoleId($role->getId())->setResources($this->getResource())->saveRel();

        return (int) $role->getId();
    }

    abstract protected function getRoleName(): string;
    abstract protected function getResource(): array;
}
