<?php

namespace News\NewsModule\Api;

use News\NewsModule\Api\Data\ItemInterface;

interface ItemRepositoryInterface
{
    /**
     * @return ItemInterface[]
     */
    public function getList();
}
