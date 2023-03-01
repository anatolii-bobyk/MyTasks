<?php

namespace Crud\CrudModule\Controller\Member;

use Crud\CrudModule\Api\MemberRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Edit extends Action
{
    /**
     * @var MemberRepositoryInterface
     */
    private $memberRepository;

    /**
     * @param Context $context
     * @param MemberRepositoryInterface $memberRepository
     */
    public function __construct(
        Context                   $context,
        MemberRepositoryInterface $memberRepository
    )
    {
        $this->memberRepository = $memberRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page|(\Magento\Framework\View\Result\Page&\Magento\Framework\Controller\ResultInterface)
     */
    public function execute()
    {
        if ($this->isCorrectData()) {
            $this->_view->getPage()->getConfig()->getTitle()->set(__("Ukraine"));
            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        } else {
            $this->messageManager->addErrorMessage(__("Member Not Found"));
            $redirect = $this->resultRedirectFactory->create();
            $redirect->setPath('crud');
            return $redirect;
        }

    }

    /**
     * @return bool
     */
    public function isCorrectData()
    {
        $id = $this->getRequest()->getParam('id');
        $member = $this->memberRepository->getById($id)->getData();
        if ($member) {
            return true;
        } else {
            return false;
        }
    }
}
