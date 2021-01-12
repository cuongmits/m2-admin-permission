<?php

namespace spec\Cuongmits\AdminPermissions\Plugin;

use Magento\Framework\AuthorizationInterface;
use Cuongmits\AdminPermissions\Plugin\HideProductSaveButtonsWhenNoPermission;
use PhpSpec\ObjectBehavior;
use Magento\ConfigurableProduct\Block\Adminhtml\Product\Edit\Button\Save;
use Cuongmits\AdminPermissions\Controller\Adminhtml\Product\Save as SaveAction;

final class HideProductSaveButtonsWhenNoPermissionSpec extends ObjectBehavior
{
    function let(AuthorizationInterface $authorization)
    {
        $this->beConstructedWith($authorization);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(HideProductSaveButtonsWhenNoPermission::class);
    }

    function it_should_return_empty_array_when_admin_user_does_not_have_save_permission(
        Save $subject,
        AuthorizationInterface $authorization
    ) {
        $authorization->isAllowed(SaveAction::ADMIN_RESOURCE)->willReturn(false);

        $this->afterGetButtonData($subject, ['original result'])->shouldReturn([]);
    }

    function it_should_return_all_3_buttons_when_admin_user_have_save_create_and_duplicate_permission(
        Save $subject,
        AuthorizationInterface $authorization
    ) {
        $authorization->isAllowed(SaveAction::ADMIN_RESOURCE)->willReturn(true);

        $this->afterGetButtonData($subject, ['original result'])->shouldReturn(['original result']);
    }
}
