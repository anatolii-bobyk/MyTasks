<?php

namespace Luxury\LuxuryModule\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;


class Item extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('luxury_tax', 'id');
    }

}

