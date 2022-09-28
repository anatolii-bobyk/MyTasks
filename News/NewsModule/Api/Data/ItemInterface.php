<?php

namespace News\NewsModule\Api\Data;

interface ItemInterface
{
    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string|null
     */
    public function getDescription();

    /**
     * @return mixed
     */
    public function getImage();
}
