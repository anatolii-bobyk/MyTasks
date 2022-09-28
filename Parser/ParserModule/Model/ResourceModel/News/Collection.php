<?php

namespace Parser\ParserModule\Model\ResourceModel\News;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Parser\ParserModule\Model\News;
use Parser\ParserModule\Model\ResourceModel\News as NewsResource;

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
        $this->_init(News::class, NewsResource::class);
    }


}
