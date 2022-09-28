<?php

namespace Luxury\LuxuryModule\Block\Adminhtml\Order\Invoice;

use Magento\Framework\DataObject;

class Totals extends \Magento\Sales\Block\Adminhtml\Order\Invoice\Totals
{
    /**
     * @return $this|Totals
     */
    protected function _initTotals()
    {
        parent::_initTotals();
        $order = $this->getSource();

        $this->_totals['custom_amount'] = new DataObject(
            [
                'code' => 'custom_amount',
                'value' => $order->getOrder()->getData('luxuryTax'),
                'base_value' => $order->getOrder()->getData('luxuryTax'),
                'label' => __('My Luxury Tax'),
            ]
        );
        $order->setGrandTotal($order->getGrandTotal() + $order->getOrder()->getData('custom_amount'));
        $order->setBaseGrandTotal($order->getBaseGrandTotal() + $order->getOrder()->getData('custom_amount'));

        $this->getTotals()['grand_total']->setValue($this->getTotals()['grand_total']->getValue() + $this->getTotals()['custom_amount']->getValue());
        $this->getTotals()['grand_total']->setBaseValue($this->getTotals()['grand_total']->getBaseValue() + $this->getTotals()['custom_amount']->getBaseValue());

        return $this;
    }
}
