<?php

namespace Acl\AclModule\Ui\DataProvider\Product;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Ui\DataProvider\Product\ProductDataProvider as DefaultProductDataProvider;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Backend\Model\Auth\Session as AuthSession;
use Acl\AclModule\Model\FilteredData;

class ProductDataProvider extends DefaultProductDataProvider
{
    /**
     * @var AuthSession
     */
    protected $authSession;

    /**
     * @var FilteredData
     */
    protected $filteredData;

    /**
     * @param FilteredData $filteredData
     * @param AuthSession $authSession
     * @param CollectionFactory $collectionFactory
     * @param array $addFieldStrategies
     * @param array $addFilterStrategies
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $modifiersPool
     */
    public function __construct(
        FilteredData      $filteredData,
        AuthSession       $authSession,
                          $name,
                          $primaryFieldName,
                          $requestFieldName,
        CollectionFactory $collectionFactory,
        array             $addFieldStrategies = [],
        array             $addFilterStrategies = [],
        array             $meta = [],
        array             $data = [],
        PoolInterface     $modifiersPool = null
    )
    {
        $this->filteredData = $filteredData;
        $this->authSession = $authSession;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $collectionFactory,
            $addFieldStrategies,
            $addFilterStrategies,
            $meta,
            $data,
            $modifiersPool
        );
    }


    /**
     * @return array
     */
    public function getData()
    {
        $created_by_id = $this->filteredData->getAuthUserId();
        $userGroup = $this->filteredData->getAuthUserGroup();
        if ($userGroup !== 'dealer') {
            $collection = $this->getCollection();
            $collection->addAttributeToFilter('created_by', $created_by_id);
        }
        return parent::getData();
    }

}
