<?php

namespace News\NewsModule\Controller\One;

use Magento\Framework\Controller\ResultFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use News\NewsModule\Api\ItemRepositoryInterface;
use Magento\Catalog\Model\ProductFactory;

class One extends \Magento\Framework\App\Action\Action
{
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
     * @param ProductFactory $productFactory
     * @param ItemRepositoryInterface $itemRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context      $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\Request\Http        $request,
        ProductFactory                             $productFactory,
        ItemRepositoryInterface                    $itemRepository
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->productFactory = $productFactory;
        $this->itemRepository = $itemRepository;
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $id = $this->request->getParam('id');
        if ($id) {
            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        } else {
            echo 'you didn`t write ID in url';
        }
    }
}
