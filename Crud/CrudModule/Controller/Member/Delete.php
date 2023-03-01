<?php

namespace Crud\CrudModule\Controller\Member;

use Crud\CrudModule\Api\MemberRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Action
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
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        try {
            $memberNick = $this->memberRepository->getById($id)->getData()['nick'];
            $this->memberRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__("Successfully removed the member %1", $memberNick));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__("Something went wrong." . $exception));
        }

        return $this->resultRedirectFactory->create()->setPath('crud');

    }
}
