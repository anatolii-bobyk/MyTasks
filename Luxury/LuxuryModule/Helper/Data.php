<?php
/**
 * Copyright © Vasyl Samborskyi, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Luxury\LuxuryModule\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Products helper
 */
class Data extends AbstractHelper
{

    protected $_customerSession;

    protected $customerRepository;


    public function __construct(
        Context                     $context,
        CustomerRepositoryInterface $customerRepository,
        Session                     $customerSession
    )
    {
        parent::__construct($context);
        $this->_customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
    }


    public function getCustomerId()
    {
        //$this->_customerSession->getCustomer()->getId();

        return $this->_customerSession->getCustomerId();
    }


    public function getAttributeLuxuryTax($customerId)
    {
        $customer = $this->customerRepository->getById($customerId);
        return $customer->getCustomAttribute('luxury_tax');
    }

}
