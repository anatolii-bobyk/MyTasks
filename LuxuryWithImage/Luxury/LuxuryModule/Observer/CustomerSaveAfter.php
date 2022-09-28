<?php

namespace Luxury\LuxuryModule\Observer;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

class CustomerSaveAfter implements ObserverInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param RequestInterface $request
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        RequestInterface            $request
    )
    {
        $this->_request = $request;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function execute(Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();

        $groupId = $customer->getGroupId();

        $customer->setCustomAttribute('luxuryTax', $groupId);

        $this->customerRepository->save($customer);
    }
}
