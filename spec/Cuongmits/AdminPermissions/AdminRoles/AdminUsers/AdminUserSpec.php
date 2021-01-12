<?php

namespace spec\Cuongmits\AdminPermissions\AdminRoles\AdminUsers;

use Magento\User\Model\UserFactory;
use Cuongmits\AdminPermissions\AdminRoles\AdminUsers\AdminUser;
use PhpSpec\ObjectBehavior;
use Magento\User\Model\User as BasicUser;

final class AdminUserSpec extends ObjectBehavior
{
    function let(UserFactory $userFactory)
    {
        $this->beConstructedWith($userFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AdminUser::class);
    }

    function it_is_instance_of_base_class()
    {
        $this->shouldBeAnInstanceOf(AdminUser::class);
    }

    function it_should_create_new_admin_user(UserFactory $userFactory, User $user)
    {
        $adminInfo = [
            'username' => 'ABC',
            'firstname' => 'XYZ',
            'lastname' => 'Admin',
            'email' => 'admin@toom.de',
            'password' =>'admin123',
            'interface_locale' => 'de_DE',
            'is_active' => 1
        ];

        $userFactory->create()->willReturn($user);

        $user->setData($adminInfo)->shouldBeCalled();
        $user->setRoleId(1)->shouldBeCalled();
        $user->save()->shouldBeCalled();

        $this->create(1, $adminInfo);
    }
}

class User extends BasicUser
{
    public function setRoleId(int $id)
    {

    }
}
