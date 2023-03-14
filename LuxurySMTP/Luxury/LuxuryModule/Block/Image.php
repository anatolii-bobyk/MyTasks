<?php

namespace Luxury\LuxuryModule\Block;

use Magento\Framework\App\Request\Http;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Luxury\LuxuryModule\Model\ResourceModel\Item\Collection;
use Luxury\LuxuryModule\Model\ResourceModel\Item\CollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Luxury\LuxuryModule\Api\ItemRepositoryInterface;
use Luxury\LuxuryModule\Helper\Data;

class Image extends Template
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     *
     */
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param Template\Context $context
     * @param CollectionFactory $collectionFactory
     * @param UrlInterface $urlBuilder
     * @param ProductRepositoryInterface $productRepository
     * @param Http $request
     * @param ItemRepositoryInterface $itemRepository
     * @param array $data
     */
    public function __construct(
        Template\Context  $context,
        CollectionFactory $collectionFactory,
        Data              $helper,
        array             $data = []

    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * @return array|mixed|null
     */
    public function getImage()
    {
        $customerId = $this->helper->getCustomerId();
        return $this->helper->getImage($customerId);
    }

}
