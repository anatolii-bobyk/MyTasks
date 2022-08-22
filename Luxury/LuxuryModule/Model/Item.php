<?php

namespace Luxury\LuxuryModule\Model;

use Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Luxury\LuxuryModule\Model\ResourceModel\Item::class);
    }
}
