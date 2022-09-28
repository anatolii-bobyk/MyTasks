<?php

namespace Parser\ParserModule\Api\Data;

interface NewsInterface
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

    /**
     * @return mixed
     */
    public function getUrl();
}
