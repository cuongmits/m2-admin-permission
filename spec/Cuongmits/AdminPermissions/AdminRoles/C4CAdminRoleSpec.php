<?php

namespace spec\Cuongmits\AdminPermissions\AdminRoles;

use Magento\Authorization\Model\Acl\Role\Group;
use Magento\Authorization\Model\RoleFactory;
use Magento\Authorization\Model\RulesFactory;
use Magento\Authorization\Model\UserContextInterface;
use Cuongmits\AdminPermissions\AdminRoles\C4CAdminRole;
use PhpSpec\ObjectBehavior;
use Cuongmits\AdminPermissions\AdminRoles\AbstractAdminRole;
use Magento\Authorization\Model\Role as BasicRole;
use Magento\Authorization\Model\Rules as BasicRules;

final class C4CAdminRoleSpec extends ObjectBehavior
{
    function let(RoleFactory $roleFactory, RulesFactory $rulesFactory)
    {
        $this->beConstructedWith($roleFactory, $rulesFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(C4CAdminRole::class);
    }

    function it_is_instance_of_base_class()
    {
        $this->shouldBeAnInstanceOf(AbstractAdminRole::class);
    }

    function it_should_create_new_c4c_admin_user(
        RoleFactory $roleFactory,
        RulesFactory $rulesFactory,
        Role $role,
        Rules $rules
    ) {
        $roleFactory->create()->willReturn($role);

        $role->setName('C4C Admin')->shouldBeCalled()->willReturn($role);
        $role->setPid(0)->shouldBeCalled()->willReturn($role);
        $role->setRoleType(Group::ROLE_TYPE)->shouldBeCalled()->willReturn($role);
        $role->setUserType(UserContextInterface::USER_TYPE_ADMIN)->shouldBeCalled();

        $role->save()->shouldBeCalled();
        $role->getId()->willReturn(1);

        $rulesFactory->create()->willReturn($rules);
        $rules->setRoleId(1)->shouldBeCalled()->willReturn($rules);
        $rules->setResources([
            'Magento_Customer::customer',
            'Magento_Customer::manage',
            'Magento_Customer::actions',
            'Magento_Customer::delete',
            'Magento_Customer::reset_password',
            'Magento_Customer::invalidate_tokens',
            'Magento_Backend::marketing',
            'Magento_CatalogRule::promo',
            'Magento_SalesRule::quote',
            'Magento_PromotionPermissions::quote_edit'
        ])->shouldBeCalled()->willReturn($rules);
        $rules->saveRel()->shouldBeCalled();

        $this->create()->shouldBe(1);
    }
}

class Role extends BasicRole
{
    public function setName(string $roleName)
    {

    }

    public function setPid(int $pid)
    {

    }
}

class Rules extends BasicRules
{
    public function setResources(array $resource)
    {

    }
}
