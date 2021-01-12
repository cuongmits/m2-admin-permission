<?php

namespace spec\Cuongmits\AdminPermissions\AdminRoles;

use Magento\Authorization\Model\Acl\Role\Group;
use Magento\Authorization\Model\RoleFactory;
use Magento\Authorization\Model\RulesFactory;
use Magento\Authorization\Model\UserContextInterface;
use Cuongmits\AdminPermissions\AdminRoles\OperationsAdminRole;
use PhpSpec\ObjectBehavior;
use Cuongmits\AdminPermissions\AdminRoles\AbstractAdminRole;

final class OperationsAdminRoleSpec extends ObjectBehavior
{
    function let(RoleFactory $roleFactory, RulesFactory $rulesFactory)
    {
        $this->beConstructedWith($roleFactory, $rulesFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OperationsAdminRole::class);
    }

    function it_is_instance_of_base_class()
    {
        $this->shouldBeAnInstanceOf(AbstractAdminRole::class);
    }

    function it_should_create_new_operations_admin_user(
        RoleFactory $roleFactory,
        RulesFactory $rulesFactory,
        Role $role,
        Rules $rules
    ) {
        $roleFactory->create()->willReturn($role);

        $role->setName('Operations Admin')->shouldBeCalled()->willReturn($role);
        $role->setPid(0)->shouldBeCalled()->willReturn($role);
        $role->setRoleType(Group::ROLE_TYPE)->shouldBeCalled()->willReturn($role);
        $role->setUserType(UserContextInterface::USER_TYPE_ADMIN)->shouldBeCalled();

        $role->save()->shouldBeCalled();
        $role->getId()->willReturn(1);

        $rulesFactory->create()->willReturn($rules);
        $rules->setRoleId(1)->shouldBeCalled()->willReturn($rules);
        $rules->setResources([
            'Magento_Sales::sales',
            'Magento_Sales::sales_operation',
            'Magento_Sales::sales_order',
            'Magento_Sales::actions',
            'Magento_Sales::actions_view',
            'Magento_SalesArchive::archive',
            'Magento_SalesArchive::invoices',
            'Magento_SalesArchive::shipments',
            'Magento_SalesArchive::creditmemos',
            'Magento_Catalog::catalog',
            'Magento_Catalog::catalog_inventory',
            'Magento_Catalog::products',
            'Magento_PricePermissions::read_product_price',
        ])->shouldBeCalled()->willReturn($rules);
        $rules->saveRel()->shouldBeCalled();

        $this->create()->shouldBe(1);
    }
}
