<?php

namespace Acl\AclModule\View\Element\UiComponent\DataProvider;

use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as DefaultDataProvider;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Api\Filter;
use Magento\Backend\Model\Auth\Session;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Sales\Model\Order\ItemFactory;
use Acl\AclModule\Model\FilteredData;

class DataProvider extends DefaultDataProvider
{
    /**
     * Data Provider name
     *
     * @var string
     */
    protected $name;

    /**
     * Data Provider Primary Identifier name
     *
     * @var string
     */
    protected $primaryFieldName;

    /**
     * Data Provider Request Parameter Identifier name
     *
     * @var string
     */
    protected $requestFieldName;

    /**
     * @var array
     */
    protected $meta = [];

    /**
     * Provider configuration data
     *
     * @var array
     */
    protected $data = [];

    /**
     * @var ReportingInterface
     */
    protected $reporting;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var SearchCriteria
     */
    protected $searchCriteria;

    /**
     * @var Filter
     */
    protected $myFilter;

    /**
     * @var Session
     */
    protected $authSession;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ItemFactory
     */
    protected $orderItemCollectionFactory;

    /**
     * @var FilteredData
     */
    protected $filteredData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        FilteredData          $filteredData,
        ItemFactory           $orderItemCollectionFactory,
        CollectionFactory     $collectionFactory,
        Session               $authSession,
        Filter                $myFilter,
                              $name,
                              $primaryFieldName,
                              $requestFieldName,
        ReportingInterface    $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface      $request,
        FilterBuilder         $filterBuilder,
        array                 $meta = [],
        array                 $data = []
    )
    {
        $this->filteredData = $filteredData;
        $this->orderItemCollectionFactory = $orderItemCollectionFactory;
        $this->collectionFactory = $collectionFactory;
        $this->authSession = $authSession;
        $this->myFilter = $myFilter;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
    }

    /**
     * @param SearchResultInterface $searchResult
     * @return array
     */
    protected function searchResultToOutput(SearchResultInterface $searchResult)
    {
        $arrItems = [];

        $arrItems['items'] = [];
        foreach ($searchResult->getItems() as $item) {
            $itemData = [];
            foreach ($item->getCustomAttributes() as $attribute) {
                $itemData[$attribute->getAttributeCode()] = $attribute->getValue();
            }
            $arrItems['items'][] = $itemData;
            $arrItems['totalRecords'] = $searchResult->getTotalCount();
        }
        return $arrItems;
    }

    /**
     * @return SearchCriteria
     */
    public function getSearchCriteria()
    {
        if (!$this->searchCriteria) {
            $this->searchCriteria = $this->searchCriteriaBuilder->create();
            $this->searchCriteria->setRequestName($this->name);
        }
        return $this->searchCriteria;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $created_by_id = $this->filteredData->getAuthUserId();
        $userGroup = $this->filteredData->getAuthUserGroup();
        $productIdsArray = $this->filteredData->getFilteredProductIdsArray($created_by_id);
        $orderIdsArray = $this->filteredData->getFilteredOrderIdsArray($productIdsArray);

        if ($userGroup !== 'dealer') {
            $filter = $this->myFilter->setField("entity_id")->setValue(implode(',', $orderIdsArray))->setConditionType("in");
            $this->addFilter($filter);
        }
        return $this->searchResultToOutput($this->getSearchResult());
    }

    /**
     * Get config data
     *
     * @return array
     */


    /**
     * Set data
     *
     * @param mixed $config
     * @return void
     */

    /**
     * Returns Search result
     *
     * @return SearchResultInterface
     */

    public function getSearchResult()
    {
        return $this->reporting->search($this->getSearchCriteria());
    }

}











