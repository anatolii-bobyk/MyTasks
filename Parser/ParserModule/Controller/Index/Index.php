<?php

namespace Parser\ParserModule\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Parser\ParserModule\Api\NewsRepositoryInterface;
use Parser\ParserModule\Model\NewsFactory;

class Index extends Action
{

    /**
     * @var NewsFactory
     */
    private $collectionFactory;

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
     * @param NewsFactory $collectionFactory
     * @param NewsRepositoryInterface $newsRepository
     */
    public function __construct(
        Context                 $context,
        PageFactory             $resultPageFactory,
        Http                    $request,
        NewsFactory             $collectionFactory,
        NewsRepositoryInterface $newsRepository
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->collectionFactory = $collectionFactory;
        $this->newsRepository = $newsRepository;
    }


    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
