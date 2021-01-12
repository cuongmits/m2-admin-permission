<?php

namespace spec\Cuongmits\AdminPermissions\Plugin;

use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\AddAttribute;
use Magento\Framework\AuthorizationInterface;
use Cuongmits\AdminPermissions\Plugin\HideAddAttributeButtonWhenNoPermission;
use PhpSpec\ObjectBehavior;

final class HideAddAttributeButtonWhenNoPermissionSpec extends ObjectBehavior
{
    function let(AuthorizationInterface $authorization)
    {
        $this->beConstructedWith($authorization);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(HideAddAttributeButtonWhenNoPermission::class);
    }

    function it_should_return_empty_array_when_admin_user_does_not_have_attributes_permission(
        AddAttribute $subject,
        AuthorizationInterface $authorization
    ) {
        $authorization->isAllowed(HideAddAttributeButtonWhenNoPermission::ADMIN_RESOURCE)->willReturn(false);

        $this->afterGetButtonData($subject, ['original result'])->shouldReturn([]);
    }

    function it_should_return_original_data_when_admin_user_have_attributes_permission(
        AddAttribute $subject,
        AuthorizationInterface $authorization
    ) {
        $authorization->isAllowed(HideAddAttributeButtonWhenNoPermission::ADMIN_RESOURCE)->willReturn(true);

        $this->afterGetButtonData($subject, ['original result'])->shouldReturn(['original result']);
    }
}
