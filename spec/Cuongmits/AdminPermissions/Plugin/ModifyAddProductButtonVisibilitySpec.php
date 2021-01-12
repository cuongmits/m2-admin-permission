<?php

namespace spec\Cuongmits\AdminPermissions\Plugin;

use Magento\Backend\Block\Widget\Button\Item;
use Magento\Catalog\Block\Adminhtml\Product;
use Magento\Framework\AuthorizationInterface;
use Cuongmits\AdminPermissions\Plugin\ModifyAddProductButtonVisibility;
use PhpSpec\ObjectBehavior;

final class ModifyAddProductButtonVisibilitySpec extends ObjectBehavior
{
    function let(AuthorizationInterface $authorization)
    {
        $this->beConstructedWith($authorization);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ModifyAddProductButtonVisibility::class);
    }

    function it_should_return_true_when_product_is_not_deleted_and_admin_user_have_permission(
        Product $subject,
        Item $item,
        AuthorizationInterface $authorization
    ) {
        $item->isDeleted()->willReturn(false);
        $authorization->isAllowed('Magento_AdminPermissions::new_product')->willReturn(true);
        $authorization->isAllowed('Magento_AdminPermissions::save_product')->willReturn(true);
        $proceed = function () {
            return;
        };

        $this->aroundCanRender($subject, $proceed, $item)->shouldReturn(true);
    }

    function it_should_return_false_when_product_item_is_deleted(
        Product $subject,
        Item $item,
        AuthorizationInterface $authorization
    ) {
        $item->isDeleted()->willReturn(true);
        $proceed = function () {
            return;
        };

        $authorization->isAllowed('Magento_AdminPermissions::new_product')->willReturn(true);
        $authorization->isAllowed('Magento_AdminPermissions::save_product')->willReturn(true);
        $this->aroundCanRender($subject, $proceed, $item)->shouldReturn(false);

        $authorization->isAllowed('Magento_AdminPermissions::new_product')->willReturn(false);
        $authorization->isAllowed('Magento_AdminPermissions::save_product')->willReturn(false);
        $this->aroundCanRender($subject, $proceed, $item)->shouldReturn(false);
    }

    function it_should_return_false_when_product_is_not_deleted_and_admin_user_does_not_have_new_product_permission(
        Product $subject,
        Item $item,
        AuthorizationInterface $authorization
    ) {
        $item->isDeleted()->willReturn(false);
        $authorization->isAllowed('Magento_AdminPermissions::new_product')->willReturn(false);
        $proceed = function () {
            return;
        };

        $this->aroundCanRender($subject, $proceed, $item)->shouldReturn(false);
    }

    function it_should_return_false_when_product_is_not_deleted_and_admin_user_does_not_have_save_product_permission(
        Product $subject,
        Item $item,
        AuthorizationInterface $authorization
    ) {
        $item->isDeleted()->willReturn(false);
        $authorization->isAllowed('Magento_AdminPermissions::save_product')->willReturn(false);
        $proceed = function () {
            return;
        };

        $authorization->isAllowed('Magento_AdminPermissions::new_product')->willReturn(true);
        $this->aroundCanRender($subject, $proceed, $item)->shouldReturn(false);

        $authorization->isAllowed('Magento_AdminPermissions::new_product')->willReturn(false);
        $this->aroundCanRender($subject, $proceed, $item)->shouldReturn(false);
    }
}
