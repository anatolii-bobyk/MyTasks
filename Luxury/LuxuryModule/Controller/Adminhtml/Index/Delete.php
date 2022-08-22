<?php

namespace Luxury\LuxuryModule\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Luxury\LuxuryModule\Model\ItemRepository;

/**
 * Class MassDelete
 */
class Delete extends \Magento\Backend\App\Action
{

    protected $itemRepository;

    public function __construct(
        Context           $context,
        ItemRepository $itemRepository
    )
    {
        parent::__construct($context);
        $this->itemRepository= $itemRepository;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $this->itemRepository->deleteById($id);
                $this->messageManager->addSuccess(__('Luxury Tax deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addError(__('Luxury Tax does not exist'));
        return $resultRedirect->setPath('*/*/');
    }
}
