<?php

namespace Luxury\LuxuryModule\Model\ResourceModel\Item;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Luxury\LuxuryModule\Model\Item;
use Luxury\LuxuryModule\Model\ResourceModel\Item as ItemResource;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Item::class, ItemResource::class);
    }
}
