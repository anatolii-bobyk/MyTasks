<?php

namespace Parser\ParserModule\Block;

use Magento\Framework\App\Request\Http;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Parser\ParserModule\Model\ResourceModel\News\CollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Parser\ParserModule\Api\NewsRepositoryInterface;

class News extends Template
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
     * @var Http
     */
    private $request;

    /**
     * @var NewsRepositoryInterface
     */
    private $newsRepository;

    /**
     * @param Template\Context $context
     * @param CollectionFactory $collectionFactory
     * @param UrlInterface $urlBuilder
     * @param ProductRepositoryInterface $productRepository
     * @param Http $request
     * @param NewsRepositoryInterface $newsRepository
     * @param array $data
     */
    public function __construct(
        Template\Context           $context,
        CollectionFactory          $collectionFactory,
        UrlInterface               $urlBuilder,
        ProductRepositoryInterface $productRepository,
        Http                       $request,
        NewsRepositoryInterface    $newsRepository,
        array                      $data = []

    )
    {
        $this->newsRepository = $newsRepository;
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->urlBuilder = $urlBuilder;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }


    public function getItems()
    {
//        $pageSize = 10;
//        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
//        $allNews = $this->collectionFactory->create();
//        $allNews->setPageSize($pageSize)
//            ->setCurPage($page)
//            ->getItems();
//        return $allNews;


        return $this->collectionFactory->create()->getItems();

    }

    /**
     * @return array|mixed|null
     */
    public function getOneItem()
    {
        $id = $this->request->getParam('id');
        $oneNews = $this->newsRepository->getById($id);
        return $oneNews->getData();
    }

    /**
     * @return array|mixed|null
     */
    public function getOneNewsByTitle()
    {
        $title = $this->request->getParam('title');
        $oneNews = $this->newsRepository->getByTitle($title);
        return $oneNews->getData();
    }

}
