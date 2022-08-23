<?php

namespace Luxury\LuxuryModule\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Luxury\LuxuryModule\Api\ItemRepositoryInterface;
use Luxury\LuxuryModule\Model\ResourceModel\Item;
use Luxury\LuxuryModule\Model\ResourceModel\Item\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Luxury\LuxuryModule\Api\Data\ItemSearchResultInterfaceFactory;

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
     * @var ItemSearchResultInterfaceFactory
     */
    private $searchResultFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;


    /**
     * @param ItemFactory $itemFactory
     * @param Item $itemResource
     */
    public function __construct(
        ItemFactory       $itemFactory,
        Item              $itemResource,
        CollectionFactory $collectionFactory,
        ItemSearchResultInterfaceFactory $itemSearchResultInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->itemFactory = $itemFactory;
        $this->itemResource = $itemResource;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultFactory = $itemSearchResultInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $id
     * @return \Luxury\LuxuryModule\Api\Data\ItemInterface
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
        try {
            $this->itemResource->delete($item);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }
        return true;
    }

    public function getAllItems()
    {
        return $this->collectionFactory->create()->getItems();
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }


}
