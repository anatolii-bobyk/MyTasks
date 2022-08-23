<?php

namespace Luxury\LuxuryModule\Api;

use Luxury\LuxuryModule\Api\Data\ItemInterface;

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

//    /**
//     * @return ItemInterface[]
//     */
//    public function getList();

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Luxury\LuxuryModule\Api\Data\ItemSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @return ItemInterface[]
     */
    public function getAllItems();

}
