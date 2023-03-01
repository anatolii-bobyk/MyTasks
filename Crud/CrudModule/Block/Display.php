<?php

namespace Crud\CrudModule\Block;

use Magento\Framework\View\Element\Template;
use Crud\CrudModule\Api\MemberRepositoryInterface;
use Crud\CrudModule\Model\ResourceModel\Member\CollectionFactory;

class Display extends Template
{
    /**
     * @var MemberFactory
     */
    private $allMembersFactory;

    /**
     * @var MemberRepositoryInterface
     */
    private $memberRepository;

    /**
     * @param Template\Context $context
     * @param MemberRepositoryInterface $memberRepository
     * @param MemberFactory $allMembersFactory
     * @param array $data
     */
    public function __construct(
        Template\Context          $context,
        MemberRepositoryInterface $memberRepository,
        CollectionFactory         $allMembersFactory,
        array                     $data = []
    )
    {
        $this->memberRepository = $memberRepository;
        $this->allMembersFactory = $allMembersFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     */
    public function getAllMembers()
    {
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $limit = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 2;

        $collection = $this->allMembersFactory->create()->clear();
        $collection->setPageSize($limit);
        $collection->setCurPage($page);

        return $collection;

    }

    /**
     * @return $this|Display
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        if ($this->getAllMembers()) {
            $pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager', 'crud.crudmodule.pager'
            )->setAvailableLimit(array(2 => 2, 10 => 10, 15 => 15, 20 => 20))
                ->setShowPerPage(true)
                ->setCollection($this->getAllMembers());

            $this->setChild('pager', $pager);

            $this->getAllMembers()->load();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('crud/member/save');
    }

    /**
     * @return string
     */
    public function getEditPageUrl()
    {
        return $this->getUrl('crud/member/edit');
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('crud/member/delete');
    }

    /**
     * @return mixed
     */
    public function getMemberById()
    {
        $id = $this->getRequest()->getParam('id');
        return $this->memberRepository->getById($id)->getData();
    }

}
