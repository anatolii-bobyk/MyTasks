<?php

namespace Parser\ParserModule\Api;

use Parser\ParserModule\Api\Data\NewsInterface;

interface NewsRepositoryInterface
{
    /**
     * @return NewsInterface[]
     */
    public function getList();
}
