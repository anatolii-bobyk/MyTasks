<?php

namespace Crud\CrudModule\Api;

use Crud\CrudModule\Api\Data\MemberInterface;

interface MemberRepositoryInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function deleteById($id);

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);
}
