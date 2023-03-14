<?php

namespace Luxury\LuxuryModule\Block\Adminhtml\Order;

use Magento\Framework\DataObject;

class Totals extends \Magento\Sales\Block\Adminhtml\Order\Totals
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
                'value' => $order->getData('luxuryTax'),
                'base_value' => $order->getData('luxuryTax'),
                'label' => __('My Luxury Tax'),
            ]
        );

        return $this;
    }
}
