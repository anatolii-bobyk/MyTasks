<?php

namespace News\NewsModule\Controller\Index;

use Magento\Bundle\Model\ResourceModel\Option\CollectionFactory;
use Magento\Catalog\Controller\Product\Compare;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use News\NewsModule\Api\ItemRepositoryInterface;
use Magento\Catalog\Model\ProductFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \News\NewsModule\Model\ItemFactory
     */
    private $collectionFactory;
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    private $request;
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;


    /**
     * @var ProductFactory
     */
    private $productFactory;

    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;


    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\App\Request\Http $request
     * @param \News\NewsModule\Model\ItemFactory $collectionFactory
     * @param ProductRepositoryInterface $productRepository
     * @param ProductFactory $productFactory
     * @param ItemRepositoryInterface $itemRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context      $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\Request\Http        $request,
        \News\NewsModule\Model\ItemFactory         $collectionFactory,
        ProductRepositoryInterface                 $productRepository,
        ProductFactory                             $productFactory,
        ItemRepositoryInterface                    $itemRepository
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->collectionFactory = $collectionFactory;
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
        $this->itemRepository = $itemRepository;
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->request->getParam('id');
//        if ($id) {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
//        } else {
//            $collection = $this->collectionFactory->create();
//            $collection->load($id);
//            $result = $collection->getData();
//            print_r($result);
//            $oneNews = $this->itemRepository->getById($id);
//            $news = $oneNews->getData();
//            var_dump($news);

//            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
//            echo 'mistake';
//    }
    }
}
