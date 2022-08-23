<?php

namespace Luxury\LuxuryModule\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ItemSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Luxury\LuxuryModule\Api\Data\ItemInterface[]
     */
    public function getItems();

    /**
     * @param \Luxury\LuxuryModule\Api\Data\ItemInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
