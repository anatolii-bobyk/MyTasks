<?php

namespace Parser\ParserModule\Model;

use Magento\Framework\Model\AbstractModel;

class News extends AbstractModel
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\News::class);
    }
}
