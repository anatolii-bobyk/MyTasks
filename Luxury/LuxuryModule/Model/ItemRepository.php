<?php

namespace Luxury\LuxuryModule\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Luxury\LuxuryModule\Api\ItemRepositoryInterface;
use Luxury\LuxuryModule\Model\ResourceModel\Item;
use Luxury\LuxuryModule\Model\ResourceModel\Item\CollectionFactory;

class ItemRepository implements ItemRepositoryInterface
{

    /**
     * @var ItemFactory
     */
    private $itemFactory;

    /**
     * @var Item
     */
    private $itemResource;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;


    /**
     * @param ItemFactory $itemFactory
     * @param Item $itemResource
     */
    public function __construct(ItemFactory $itemFactory, Item $itemResource, CollectionFactory $collectionFactory)
    {
        $this->itemFactory = $itemFactory;
        $this->itemResource = $itemResource;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param int $id
     * @return \News\NewsModule\Api\Data\NewsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $item = $this->itemFactory->create();
        $this->itemResource->load($item, $id);
        if (!$item->getId()) {
            throw new NoSuchEntityException(__('Unable to find News with ID "%1"', $id));
        }
        return $item;
    }

    public function deleteById($id)
    {
        $item = $this->getById($id);
        try{
            $this->itemResource->delete($item);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }
        return true;
    }

    public function getList()
    {
        return $this->collectionFactory->create()->getItems();
    }
}
