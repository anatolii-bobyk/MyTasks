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
            $this->itemFactory->create()
                ->setData($this->getRequest()->getPostValue()['general'])
                ->save();
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage('This custom group already exist! Choose another one');
        }
        return $this->resultRedirectFactory->create()->setPath('luxury/index/index');
    }
}
