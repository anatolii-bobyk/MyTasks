<?php

namespace Crud\CrudModule\Api\Data;

interface MemberInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string|null
     */
    public function getNick();

    /**
     * @return mixed
     */
    public function getVisiting();

    /**
     * @return mixed
     */
    public function getBoxes();
}
