<?php

namespace News\NewsModule\Model;

use News\NewsModule\Api\ItemRepositoryInterface;
use News\NewsModule\Model\ResourceModel\Item\CollectionFactory;

class ItemRepository implements ItemRepositoryInterface
{
    private $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function getList()
    {
        return $this->collectionFactory->create()->getItems();
    }

    public function getById($id)
    {
        return $this->collectionFactory->create()->getItemById($id);
    }
}
