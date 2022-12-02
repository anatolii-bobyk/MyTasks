<?php

namespace Salesforce\SalesforceModule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Quote\Model\QuoteFactory;
use Salesforce\SalesforceModule\Model\OrderItem;
use Salesforce\SalesforceModule\Model\Login;
use Salesforce\SalesforceModule\Model\Order;
use Salesforce\SalesforceModule\Model\Contact;
use Salesforce\SalesforceModule\Model\Product;


class AfterPlaceOrder implements ObserverInterface
{
    /**
     * @var Login
     */
    protected $loginModel;

    /**
     * @var Order
     */
    protected $orderModel;

    /**
     * @var Contact
     */
    protected $contactModel;

    /**
     * @var Product
     */
    protected $productModel;

    /**
     * @var OrderInterface
     */
    protected $_order;

    /**
     * @param OrderInterface $order
     */
    public function __construct(
        OrderInterface $order,
        QuoteFactory   $quoteFactory,
        Login          $loginModel,
        Order          $orderModel,
        Contact        $contactModel,
        Product        $productModel
    )
    {
        $this->_order = $order;
        $this->quoteFactory = $quoteFactory;
        $this->loginModel = $loginModel;
        $this->orderModel = $orderModel;
        $this->contactModel = $contactModel;
        $this->productModel = $productModel;

    }

    /**
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();

        $description = $order->getShippingDescription();

        $firstName = $order->getCustomerFirstName();

        $lastName = $order->getCustomerLastName();

        $email = $order->getCustomerEmail();

        $billingCity = $order->getShippingAddress()->getCity();
        $billingCountry = $order->getShippingAddress()->getCountryId();

        $sessionId = $this->loginModel->getSessionId();

        $orderId = $this->orderModel->getEmptyOrderId($sessionId, $description, $billingCity, $billingCountry, $billingCity);

        $this->contactModel->createContact($sessionId, $firstName, $lastName, $email);

        $orderItems = [];
        foreach ($order->getAllItems() as $item) {
            $orderItem = new OrderItem();
            $orderItem->setPrice($item->getPrice());
            $orderItem->setQuantity($item->getQtyOrdered());
            $orderItem->setPriceBookEntryId($this->productModel->getPriceBookEntryId($sessionId, $this->productModel->getProductId($sessionId, $item->getName(), $item->getSku()), $item->getPrice()));
            $orderItems[] = $orderItem;
        }

        foreach ($orderItems as $orderItem) {
            $this->orderModel->createOrderItem($sessionId, $orderId, $orderItem->getQuantity(), $orderItem->getPrice(), $orderItem->getPriceBookEntryId());
        }

        $order->save();

    }

}
