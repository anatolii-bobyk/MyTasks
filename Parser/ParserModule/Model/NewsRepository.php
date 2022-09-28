<?php

namespace Parser\ParserModule\Model;

use Parser\ParserModule\Api\NewsRepositoryInterface;
use Parser\ParserModule\Model\ResourceModel\News\CollectionFactory;

class NewsRepository implements NewsRepositoryInterface
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

    public function getByTitle($title)
    {
        return $this->collectionFactory->create()->getItemByColumnValue('title', $title);
    }
}
