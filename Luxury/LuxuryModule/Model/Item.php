<?php

namespace Luxury\LuxuryModule\Model;

use Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Item::class);
    }
}
