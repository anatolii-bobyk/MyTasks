<?php

namespace Luxury\LuxuryModule\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

class CustomerSaveAfter implements ObserverInterface
{
    protected $customerRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->_request = $request;
        $this->customerRepository = $customerRepository;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();

        $groupId = $customer->getGroupId();

        $customer->setCustomAttribute('luxury_tax', $groupId);

        $this->customerRepository->save($customer);
    }
}
