<?php

namespace News\NewsModule\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    const XML_PATH_ENABLED = 'news/general/enabled';
    const XML_PATH_SKU1 = 'news/general/sku1';
    const XML_PATH_SKU2 = 'news/general/sku2';

    private $config;

    public function __construct(ScopeConfigInterface $config)
    {
        $this->config = $config;
    }

    public function isEnabled()
    {
        return $this->config->getValue(self::XML_PATH_ENABLED);
    }

    public function getSku1()
    {
        return $this->config->getValue(self::XML_PATH_SKU1);
    }

    public function getSku2()
    {
        return $this->config->getValue(self::XML_PATH_SKU2);
    }

}
