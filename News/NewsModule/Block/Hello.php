<?php

namespace News\NewsModule\Block;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use News\NewsModule\Model\ResourceModel\Item\Collection;
use News\NewsModule\Model\ResourceModel\Item\CollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use News\NewsModule\Api\ItemRepositoryInterface;

class Hello extends Template
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    private $request;

    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;

    /**
     * @param Template\Context $context
     * @param CollectionFactory $collectionFactory
     * @param UrlInterface $urlBuilder
     * @param ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\App\Request\Http $request
     * @param ItemRepositoryInterface $itemRepository
     * @param array $data
     */
    public function __construct(
        Template\Context                    $context,
        CollectionFactory                   $collectionFactory,
        UrlInterface                        $urlBuilder,
        ProductRepositoryInterface          $productRepository,
        \Magento\Framework\App\Request\Http $request,
        ItemRepositoryInterface             $itemRepository,
        array                               $data = []

    )
    {
        $this->itemRepository = $itemRepository;
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->urlBuilder = $urlBuilder;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return \News\NewsModule\Model\Item[]
     */

    public function getItems()
    {
        return $this->collectionFactory->create()->getItems();
    }

    /**
     * @return array|mixed|null
     */
    public function getOneItem()
    {
        $id = $this->request->getParam('id');
        $oneNews = $this->itemRepository->getById($id);
        return $oneNews->getData();
    }

    /**
     * @param $route
     * @param $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return parent::getUrl($route, $params);
    }

    /**
     * @return string
     */
    public function getParamUrl()
    {
        $queryParams = [
            'id' => 1, // value for parameter
        ];

        return $this->urlBuilder->getUrl('oneNews', ['_current' => true, '_use_rewrite' => true, '_query' => $queryParams]);
    }
}
