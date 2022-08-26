<?php

namespace Luxury\LuxuryModule\Api;

use Luxury\LuxuryModule\Api\Data\ItemInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ItemRepositoryInterface
{

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param $id
     * @return mixed
     */
    public function deleteById($id);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Luxury\LuxuryModule\Api\Data\ItemSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @return ItemInterface[]
     */
    public function getAllItems();

}
