<?php

namespace Parser\ParserModule\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class News extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('parsed_news', 'id');
    }
}
