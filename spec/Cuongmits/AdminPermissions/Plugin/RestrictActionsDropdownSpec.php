<?php

namespace spec\Cuongmits\AdminPermissions\Plugin;

use Magento\Catalog\Ui\Component\Product\MassAction;
use Magento\Framework\AuthorizationInterface;
use Cuongmits\AdminPermissions\Controller\Adminhtml\Product\MassDelete;
use Cuongmits\AdminPermissions\Controller\Adminhtml\Product\MassStatus;
use PhpSpec\ObjectBehavior;
use Cuongmits\AdminPermissions\Plugin\RestrictActionsDropdown;

final class RestrictActionsDropdownSpec extends ObjectBehavior
{
    function let(AuthorizationInterface $authorization)
    {
        $this->beConstructedWith($authorization);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RestrictActionsDropdown::class);
    }

    function it_should_set_config_to_null_when_no_action_exist(MassAction $subject)
    {
        $subject->getConfiguration()->willReturn(['actions' => []]);

        $subject->setData('config', null)->shouldBeCalled();

        $this->afterPrepare($subject);
    }

    function it_should_not_set_config_to_null_when_at_least_an_action_exists(MassAction $subject)
    {
        $subject->getConfiguration()->willReturn(['actions' => ['delete']]);

        $subject->setData('config', null)->shouldNotBeCalled();

        $this->afterPrepare($subject);
    }

    function it_should_return_correct_value_regarding_to_product_delete_permission(
        MassAction $subject,
        AuthorizationInterface $authorization
    ) {
        $actionType = RestrictActionsDropdown::ACTION_TYPE_DELETE;
        $authorization->isAllowed(MassDelete::ADMIN_RESOURCE)->willReturn(true);

        $this->afterIsActionAllowed($subject, true, $actionType)->shouldReturn(true);

        $authorization->isAllowed(MassDelete::ADMIN_RESOURCE)->willReturn(false);

        $this->afterIsActionAllowed($subject, true, $actionType)->shouldReturn(false);
    }

    function it_should_return_correct_value_regarding_to_product_status_permission(
        MassAction $subject,
        AuthorizationInterface $authorization
    ) {
        $actionType = RestrictActionsDropdown::ACTION_TYPE_STATUS;
        $authorization->isAllowed(MassStatus::ADMIN_RESOURCE)->willReturn(true);

        $this->afterIsActionAllowed($subject, true, $actionType)->shouldReturn(true);

        $authorization->isAllowed(MassStatus::ADMIN_RESOURCE)->willReturn(false);

        $this->afterIsActionAllowed($subject, true, $actionType)->shouldReturn(false);
    }

    function it_should_return_original_value_when_action_type_is_not_delete_or_status(
        MassAction $subject,
        AuthorizationInterface $authorization
    ) {
        $actionType = 'not-delete-or-status-type';
        $authorization->isAllowed(MassStatus::ADMIN_RESOURCE)->shouldNotBeCalled();
        $authorization->isAllowed(MassDelete::ADMIN_RESOURCE)->shouldNotBeCalled();

        $this->afterIsActionAllowed($subject, true, $actionType)->shouldReturn(true);
        $this->afterIsActionAllowed($subject, false, $actionType)->shouldReturn(false);
    }
}
