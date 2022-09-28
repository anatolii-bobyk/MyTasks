<?php

namespace Parser\ParserModule\Controller\Index;

use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Parser\ParserModule\Api\NewsRepositoryInterface;

class Detail extends Action
{
    /**
     * @var Http
     */
    private $request;
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var NewsRepositoryInterface
     */
    private $newsRepository;


    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Http $request
     * @param ProductFactory $productFactory
     * @param NewsRepositoryInterface $newsRepository
     */
    public function __construct(
        Context                 $context,
        PageFactory             $resultPageFactory,
        Http                    $request,
        NewsRepositoryInterface $newsRepository
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->newsRepository = $newsRepository;
    }


    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $id = $this->request->getParam('title');
        if ($id) {
            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        } else {
            echo 'you didn`t write ID in url';
        }
    }
}
