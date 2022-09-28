<?php

namespace News\NewsModule\Model;

use Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\News\NewsModule\Model\ResourceModel\Item::class);
    }
}
