<?php

namespace Acl\AclModule\Model;

use Magento\Backend\Model\Auth\Session;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Sales\Model\Order\ItemFactory;

class FilteredData
{
    /**
     * @var Session
     */
    protected $authSession;

    /**
     * @var CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var ItemFactory
     */
    protected $orderItemCollectionFactory;

    /**
     * @param Session $authSession
     * @param CollectionFactory $productCollectionFactory
     * @param ItemFactory $orderItemCollectionFactory
     */
    public function __construct(
        Session           $authSession,
        CollectionFactory $productCollectionFactory,
        ItemFactory       $orderItemCollectionFactory
    )
    {
        $this->authSession = $authSession;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->orderItemCollectionFactory = $orderItemCollectionFactory;
    }

    /**
     * @return mixed
     */
    public function getAuthUserId()
    {
        return $this->authSession->getUser()->getId();
    }

    /**
     * @return mixed
     */
    public function getAuthUserGroup()
    {
        return $this->authSession->getUser()->getGroupCustom();
    }

    /**
     * @param $created_by_id
     * @return array
     */
    public function getFilteredProductIdsArray($created_by_id)
    {
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToFilter('created_by', $created_by_id)->getData();
        $productIdsArray = [];
        foreach ($productCollection as $product) {
            $productIdsArray[] = $product->getEntityId();
        }

        return $productIdsArray;
    }

    /**
     * @param $productIdsArray
     * @return array
     */
    public function getFilteredOrderIdsArray($productIdsArray)
    {
        $orderCollection = $this->orderItemCollectionFactory->create()->getCollection();
        $orderCollection->addAttributeToFilter('product_id', $productIdsArray)->getData();
        $orderIdsArray = [];
        foreach ($orderCollection as $order) {
            $orderIdsArray[] = $order->getOrderId();
        }

        return $orderIdsArray;
    }

}
