<?php

namespace Crud\CrudModule\Model;

use Magento\Framework\Model\AbstractModel;

class Member extends AbstractModel
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Member::class);
    }
}
