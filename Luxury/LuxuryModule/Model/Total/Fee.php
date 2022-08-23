<?php

namespace Luxury\LuxuryModule\Model\Total;

use Magento\Framework\Phrase;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address\Total;

class Fee extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @var \Magento\Quote\Model\QuoteValidator|null
     */
    protected $quoteValidator = null;

    /**
     * @param \Magento\Quote\Model\QuoteValidator $quoteValidator
     */
    public function __construct(\Magento\Quote\Model\QuoteValidator $quoteValidator)
    {
        $this->quoteValidator = $quoteValidator;
    }

    /**
     * @param Quote $quote
     * @param ShippingAssignmentInterface $shippingAssignment
     * @param Total $total
     * @return $this|Fee
     */
    public function collect(
        \Magento\Quote\Model\Quote                          $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total            $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);

        $existAmount = $quote->getFee();
        $fee = 100;
        $balance = $fee - $existAmount;


        $total->setFee($balance);
        $total->setBaseFee($balance);

        $total->setGrandTotal($total->getGrandTotal() + $balance);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() + $balance);

        return $this;
    }

    /**
     * @param Total $total
     * @return void
     */
    protected function clearValues(Total $total)
    {
        $total->setFee('fee', 0);
        $total->setBaseFee('fee', 0);
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }

    /**
     * @param Quote $quote
     * @param Total $total
     * @return array
     */
    public function fetch(Quote $quote, Total $total): array
    {
        return [
            'code' => 'fee',
            'title' => 'Fee',
            'value' => 100
        ];
    }

    /**
     * @return Phrase|string
     */
    public function getLabel()
    {
        return __('Fee');
    }
}