<?php

namespace Shipping\ShippingModule\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Psr\Log\LoggerInterface;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Checkout\Model\Cart;

class Shipping extends AbstractCarrier implements CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'customshipping';

    /**
     * @var bool
     */
    protected $_isFixed = true;

    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    private $rateResultFactory;

    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    private $rateMethodFactory;

    /**
     * @var Cart
     */
    public $cart;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param Cart $cart
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory         $rateErrorFactory,
        LoggerInterface      $logger,
        ResultFactory        $rateResultFactory,
        MethodFactory        $rateMethodFactory,
        Cart                 $cart,
        array                $data = []
    )
    {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);

        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->cart = $cart;
    }

    /**
     * Custom Shipping Rates Collector
     *
     * @param RateRequest $request
     * @return \Magento\Shipping\Model\Rate\Result|bool
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $result = $this->rateResultFactory->create();

        $method = $this->rateMethodFactory->create();

        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));

        $shippingCost = (float)$this->getConfigData('shipping_cost');

        $discountStarts = (float)$this->getConfigData('discount_starts');

        $discountEnds = (float)$this->getConfigData('discount_ends');

        $discount = (float)$this->getConfigData('discount');

        $freeShipping = (float)$this->getConfigData('free_shipping');

        $finalTotal = $this->cart->getQuote()->getGrandTotal();

        $dynamicRows = $this->getConfigData('dynamic_rows');

        $data = json_decode($dynamicRows, true);

        foreach ($data as $datum) {
            if ($finalTotal >= $datum['starts'] && $finalTotal <= $datum['ends']) {
                $method->setPrice($datum['cost'] * $datum['disc'] / 100);
                $method->setCost($datum['cost'] * $datum['disc'] / 100);
            } else if ($finalTotal >= $datum['free']) {
                $method->setPrice(0);
                $method->setCost(0);
            } else {
                $method->setPrice($datum['cost']);
                $method->setCost($datum['cost']);
            }
        }

        if ($finalTotal >= $discountStarts && $finalTotal <= $discountEnds) {
            $method->setPrice($shippingCost * $discount / 100);
            $method->setCost($shippingCost * $discount / 100);
        } else if ($finalTotal >= $freeShipping) {
            $method->setPrice(0);
            $method->setCost(0);
        } else {
            $method->setPrice($shippingCost);
            $method->setCost($shippingCost);
        }

        $result->append($method);

        return $result;
    }

    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }
}

