<?php

namespace Crud\CrudModule\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $this->_view->getPage()->getConfig()->getTitle()->set(__("Ukraine"));
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
