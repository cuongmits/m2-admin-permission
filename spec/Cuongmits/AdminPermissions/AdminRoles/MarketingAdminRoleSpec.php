<?php

namespace spec\Cuongmits\AdminPermissions\AdminRoles;

use Magento\Authorization\Model\Acl\Role\Group;
use Magento\Authorization\Model\RoleFactory;
use Magento\Authorization\Model\RulesFactory;
use Magento\Authorization\Model\UserContextInterface;
use Cuongmits\AdminPermissions\AdminRoles\MarketingAdminRole;
use PhpSpec\ObjectBehavior;
use Cuongmits\AdminPermissions\AdminRoles\AbstractAdminRole;

final class MarketingAdminRoleSpec extends ObjectBehavior
{
    function let(RoleFactory $roleFactory, RulesFactory $rulesFactory)
    {
        $this->beConstructedWith($roleFactory, $rulesFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MarketingAdminRole::class);
    }

    function it_is_instance_of_base_class()
    {
        $this->shouldBeAnInstanceOf(AbstractAdminRole::class);
    }

    function it_should_create_new_marketing_admin_user(
        RoleFactory $roleFactory,
        RulesFactory $rulesFactory,
        Role $role,
        Rules $rules
    ) {
        $roleFactory->create()->willReturn($role);

        $role->setName('Marketing Admin')->shouldBeCalled()->willReturn($role);
        $role->setPid(0)->shouldBeCalled()->willReturn($role);
        $role->setRoleType(Group::ROLE_TYPE)->shouldBeCalled()->willReturn($role);
        $role->setUserType(UserContextInterface::USER_TYPE_ADMIN)->shouldBeCalled();

        $role->save()->shouldBeCalled();
        $role->getId()->willReturn(1);

        $rulesFactory->create()->willReturn($rules);
        $rules->setRoleId(1)->shouldBeCalled()->willReturn($rules);
        $rules->setResources([
            'Magento_Backend::marketing',
            'Magento_CatalogRule::promo',
            'Magento_SalesRule::quote',
            'Magento_PromotionPermissions::quote_edit',
            'Magento_Backend::stores',
            'Magento_Backend::stores_settings',
            'Magento_Config::config',
            'Cuongmits_Baumarkt::config',
            'Cuongmits_Offer::config'
        ])->shouldBeCalled()->willReturn($rules);
        $rules->saveRel()->shouldBeCalled();

        $this->create()->shouldBe(1);
    }
}
