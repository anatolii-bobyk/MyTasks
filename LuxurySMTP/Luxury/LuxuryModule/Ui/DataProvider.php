<?php

namespace Luxury\LuxuryModule\Ui;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Luxury\LuxuryModule\Model\ResourceModel\Item\CollectionFactory;

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
            $item = $item->getData();
            if (!empty($item['image'])) {
                $item['image_str'] = $item['image'];
                unset($item['image']);
                $item['image'][] = array(
                    'name' => basename($item['image_str']),
                    'url' => $item['image_str']
                );
            }
            $result[$item['id']]['general'] = $item;
        }
        return $result;
    }
}
