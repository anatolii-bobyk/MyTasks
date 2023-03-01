<?php

namespace Crud\CrudModule\Controller\Member;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Crud\CrudModule\Model\MemberFactory;

class Save extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var MemberFactory
     */
    protected $memberFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param MemberFactory $memberFactory
     */
    public function __construct(
        Context       $context,
        PageFactory   $resultPageFactory,
        MemberFactory $memberFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->memberFactory = $memberFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $data = $this->getRequest()->getParams();
            if ($data) {
                $this->memberFactory->create()
                    ->setData($data)
                    ->save();
                $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("Something went wrong." . $e));
        }

        return $this->resultRedirectFactory->create()->setPath('crud');

    }
}
