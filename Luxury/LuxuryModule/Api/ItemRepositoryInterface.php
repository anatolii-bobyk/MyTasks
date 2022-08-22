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

    /**
     * @return ItemInterface[]
     */
    public function getList();

}
