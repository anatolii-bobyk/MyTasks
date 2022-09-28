<?php

namespace Parser\ParserModule\Block;

use Magento\Framework\View\Element\Template;
use Parser\ParserModule\Model\NewsFactory;
use Parser\ParserModule\Api\NewsRepositoryInterface;
use Magento\Framework\App\Request\Http;

class ListNews extends Template
{
    /**
     * @var Http
     */
    private $request;

    /**
     * @var NewsRepositoryInterface
     */
    private $newsRepository;


    /**
     * @var NewsFactory
     */
    protected $allNewsFactory;

    /**
     * @param Template\Context $context
     * @param NewsFactory $allNewsFactory
     */
    public function __construct(
        Template\Context        $context,
        NewsFactory             $allNewsFactory,
        Http                    $request,
        NewsRepositoryInterface $newsRepository
    )
    {
        parent::__construct($context);
        $this->allNewsFactory = $allNewsFactory;
        $this->newsRepository = $newsRepository;
        $this->request = $request;
    }

    /**
     * @return \Magento\Framework\Data\Collection\AbstractDb|\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection|null
     */
    public function getListNews()
    {
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $limit = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 2;

        $collection = $this->allNewsFactory->create()->getCollection();
        $collection->setPageSize($limit);
        $collection->setCurPage($page);

        return $collection;
    }

    /**
     * @return $this|ListNews
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Latest News'));

        if ($this->getListNews()) {
            $pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager', 'parser.parsermodule.pager'
            )->setAvailableLimit(array(2 => 2, 10 => 10, 15 => 15, 20 => 20))
                ->setShowPerPage(true)
                ->setCollection($this->getListNews());

            $this->setChild('pager', $pager);

            $this->getListNews()->load();
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

    public function getOneNewsByTitle()
    {
        $title = $this->request->getParam('title');
//        $title = 'evrokomisiu-ta-velikobritaniu-zaklikali-posiliti-vpliv-sankcij-proti-blizkogo-otocenna-putina';

        $oneNews = $this->newsRepository->getByTitle($title);
        return $oneNews->getData();
    }
}
