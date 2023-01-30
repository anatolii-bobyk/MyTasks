<?php

namespace Webkul\ProductFileAttribute\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Quote\Model\QuoteFactory;
use Magento\Quote\Model\ResourceModel\Quote;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Catalog\Ui\DataProvider\Product\ProductCollectionFactory;
use Magento\Framework\View\Element\Template;

class Index extends Action
{
    private \Magento\Catalog\Ui\DataProvider\Product\ProductCollection $collection;

    public function __construct(
        Context $context,
        ProductCollectionFactory $collectionFactory,
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        parent::__construct($context, $data);
    }

    public function execute()
    {


    }



}
