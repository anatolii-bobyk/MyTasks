<?php

namespace Crud\CrudModule\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Member extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('events_visiting', 'id');
    }
}
