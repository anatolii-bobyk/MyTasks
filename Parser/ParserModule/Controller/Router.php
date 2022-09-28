<?php

namespace Parser\ParserModule\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\State;
use Magento\Framework\DataObject;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Url;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class Router implements RouterInterface
{

    /**
     * @var ActionFactory
     */
    protected $actionFactory;

    /**
     * Event manager
     *
     * @var ManagerInterface
     */
    protected $_eventManager;

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $_storeManager;


    /**
     * Config primary
     *
     * @var State
     */
    protected $_appState;

    /**
     * Url
     *
     * @var UrlInterface
     */
    protected $_url;

    /**
     * Response
     *
     * @var ResponseInterface
     */
    protected $_response;


    public function __construct(
        ActionFactory         $actionFactory,
        ManagerInterface      $eventManager,
        UrlInterface          $url,
        StoreManagerInterface $storeManager,
        ResponseInterface     $response
    )
    {
        $this->actionFactory = $actionFactory;
        $this->_eventManager = $eventManager;
        $this->_url = $url;
        $this->_storeManager = $storeManager;
        $this->_response = $response;
    }

    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');

        $get_url_params = explode('/', $identifier);

        $condition = new DataObject(['identifier' => $identifier, 'continue' => true]);

        $identifier = $condition->getIdentifier();

        if ($condition->getRedirectUrl()) {
            $this->_response->setRedirect($condition->getRedirectUrl());
            $request->setDispatched(true);
            return $this->actionFactory->create('Magento\Framework\App\Action\Redirect');
        }

        if (!$condition->getContinue()) {
            return null;
        }

        // check your custom condition here if its satisfy they go ahed othrwise set return null
        $satisfy = true;
        if (!$satisfy) {
            return null;
        }

        $request->setModuleName('parser')->setControllerName('index')->setActionName('detail')->setParam('title', end($get_url_params));
        $request->setAlias(Url::REWRITE_REQUEST_PATH_ALIAS, $identifier);

        return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
    }
}
