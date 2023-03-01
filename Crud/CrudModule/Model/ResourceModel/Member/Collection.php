<?php

namespace Crud\CrudModule\Model\ResourceModel\Member;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Crud\CrudModule\Model\Member;
use Crud\CrudModule\Model\ResourceModel\Member as MemberResourceModel;

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
        $this->_init(Member::class, MemberResourceModel::class);
    }


}
