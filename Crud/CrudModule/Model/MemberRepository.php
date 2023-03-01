<?php

namespace Crud\CrudModule\Model;

use Crud\CrudModule\Api\MemberRepositoryInterface;
use Crud\CrudModule\Model\ResourceModel\Member\CollectionFactory;
use Crud\CrudModule\Model\ResourceModel\Member;
use Exception;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;

class MemberRepository implements MemberRepositoryInterface
{
    /**
     * @var Member
     */
    private $memberResourceModel;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Member            $memberResourceModel
    )
    {
        $this->memberResourceModel = $memberResourceModel;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->collectionFactory->create()->getItemById($id);
    }

    /**
     * @param $id
     * @return mixed|void
     * @throws CouldNotSaveException
     * @throws StateException
     */
    public function deleteById($id)
    {
        $member = $this->getById($id);
        try {
            $this->memberResourceModel->delete($member);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()), $e);
        } catch (Exception $e) {
            throw new StateException(
                __('The "%1" member couldn\'t be removed.', $member->getData()['nick']),
                $e
            );
        }
    }
}
