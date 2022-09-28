<?php

namespace News\NewsModule\Model\ResourceModel\Item;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use News\NewsModule\Model\Item;
use News\NewsModule\Model\ResourceModel\Item as ItemResource;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id_column';

    protected function _construct()
    {
        $this->_init(Item::class, ItemResource::class);
    }


}
