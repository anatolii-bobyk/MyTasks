<?php

namespace Luxury\LuxuryModule\Controller\Adminhtml\Item;

use Luxury\LuxuryModule\Model\ItemFactory;
use Exception;

class Save extends \Magento\Backend\App\Action
{
    private $itemFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        ItemFactory                         $itemFactory
    )
    {
        $this->itemFactory = $itemFactory;
        parent::__construct($context);
    }

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
