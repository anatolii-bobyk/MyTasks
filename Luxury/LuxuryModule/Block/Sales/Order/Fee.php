<?php

namespace Luxury\LuxuryModule\Block\Sales\Order;

use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Tax\Model\Config;

class Fee extends Template
{
    /**
     * @var Config
     */
    protected $_config;

    /**
     * @var
     */
    protected $_order;

    /**
     * @var
     */
    protected $_source;

    /**
     * @param Context $context
     * @param Config $taxConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        Config  $taxConfig,
        array   $data = []
    )
    {
        $this->_config = $taxConfig;
        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function displayFullSummary()
    {
        return true;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->_source;
    }

    /**
     * @return mixed
     */
    public function getStore()
    {
        return $this->_order->getStore();
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->_order;
    }

    /**
     * @return mixed
     */
    public function getLabelProperties()
    {
        return $this->getParentBlock()->getLabelProperties();
    }

    /**
     * @return mixed
     */
    public function getValueProperties()
    {
        return $this->getParentBlock()->getValueProperties();
    }

    /**
     * @return $this
     */
    public function initTotals()
    {
        $parent = $this->getParentBlock();
        $this->_order = $parent->getOrder();
        $this->_source = $parent->getSource();
        $store = $this->getStore();
        $fee = new DataObject(
            [
                'code' => 'custom_amount',
                'strong' => false,
                'value' => 200,
                'label' => __('My Luxury Tax'),
            ]
        );

        $parent->addTotal($fee, 'custom_amount');
        $parent->addTotal($fee, 'custom_amount');
        return $this;
    }
}
