<?php

namespace Luxury\LuxuryModule\Controller\Adminhtml\Item;

use Luxury\LuxuryModule\Model\ItemFactory;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Save extends Action
{
    /**
     * @var ItemFactory
     */
    private $itemFactory;

    /**
     * @param Context $context
     * @param ItemFactory $itemFactory
     */
    public function __construct(
        Context     $context,
        ItemFactory $itemFactory
    )
    {
        $this->itemFactory = $itemFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $to_save_data = $this->getRequest()->getPostValue()['general'];
            if (isset($to_save_data['image']) && !empty($to_save_data['image'])) {
                $to_save_data['image'] = reset($to_save_data['image'])['url'];
            }
            $this->itemFactory->create()
                ->setData($to_save_data)
                ->save();
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setRefererOrBaseUrl();
            return $resultRedirect;
        }
        return $this->resultRedirectFactory->create()->setPath('luxury/index/index');
    }

}
