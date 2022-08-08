<?php

namespace Tutorial\TutorialModule\Helper;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Registry;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_TUTORIAL = 'tutorial/';

    const XML_PATH_MYLABEL = '/media/myImage/';

    /**
     * @param $field
     * @param $storeCode
     * @return mixed
     */
    public function getConfigValue($field, $storeCode = null)
    {
        return $this->scopeConfig->getValue($field, ScopeInterface::SCOPE_STORE, $storeCode);
    }

    /**
     * @param $fieldid
     * @param $storeCode
     * @return mixed
     */
    public function getGeneralConfig($fieldid, $storeCode = null)
    {
        return $this->getConfigValue(self::XML_PATH_TUTORIAL . 'general/' . $fieldid, $storeCode);
    }

    /**
     * @param $fieldid
     * @return string
     */
    public function getMyLabel($fieldid)
    {
        return self::XML_PATH_MYLABEL . $this->getGeneralConfig($fieldid);
    }


}
