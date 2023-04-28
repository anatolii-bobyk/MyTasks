<?php

namespace Acl\AclModule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Backend\Model\Auth\Session;
use Acl\AclModule\Model\FilteredData;

class ProductSaveAfter implements ObserverInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var Session
     */
    protected $authSession;

    /**
     * @var FilteredData
     */
    protected $filteredData;


    /**
     * @param ProductRepositoryInterface $productRepository
     * @param Session $authSession
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        Session                    $authSession,
        FilteredData               $filteredData
    )
    {
        $this->productRepository = $productRepository;
        $this->authSession = $authSession;
        $this->filteredData = $filteredData;
    }


    /**
     * @param Observer $observer
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function execute(Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $userId = $this->filteredData->getAuthUserId();
        $product->setData('created_by', $userId);
        $this->productRepository->save($product);
    }
}
