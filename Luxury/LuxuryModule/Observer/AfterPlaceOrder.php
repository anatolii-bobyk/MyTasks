<?php

namespace Luxury\LuxuryModule\Observer;

use Luxury\LuxuryModule\Helper\Data;
use Luxury\LuxuryModule\Model\ItemFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\Data\OrderInterface;

class AfterPlaceOrder implements ObserverInterface
{
    /**
     * @var OrderInterface
     */
    protected $_order;
    /**
     * @var ItemFactory
     */
    protected $_dataFactory;
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param OrderInterface $order
     * @param ItemFactory $dataFactory
     * @param Data $helper
     */
    public function __construct(
        OrderInterface $order,
        ItemFactory    $dataFactory,
        Data           $helper
    )
    {
        $this->_dataFactory = $dataFactory;
        $this->_order = $order;
        $this->helper = $helper;
    }

    /**
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();

        $customerId = $order->getCustomerId();

        $subtotal = $order->getSubtotal();

        $luxuryTax = $this->helper->getConditionAmount($customerId, $subtotal);

        $order->setData('luxuryTax', $luxuryTax);

        $order->save();

    }
}
