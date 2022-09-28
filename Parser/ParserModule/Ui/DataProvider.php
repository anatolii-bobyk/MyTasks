<?php

namespace Parser\ParserModule\Ui;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Parser\ParserModule\Model\ResourceModel\News\CollectionFactory;

class DataProvider extends AbstractDataProvider

{
    /**
     * @var
     */
    protected $collection;

    /**
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string            $name,
        string            $primaryFieldName,
        string            $requestFieldName,
        CollectionFactory $collectionFactory,
        array             $meta = [],
        array             $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * @return array
     */
    public function getData()
    {
        $result = [];
        foreach ($this->collection->getItems() as $item) {
            $result[$item->getId()]['general'] = $item->getData();
        }
        return $result;
    }
}
