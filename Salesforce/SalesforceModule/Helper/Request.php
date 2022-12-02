<?php

namespace Salesforce\SalesforceModule\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Products helper
 */
class Request extends AbstractHelper
{
    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    )
    {
        parent::__construct($context);
    }

    public function createRequest($requestUrl, $requestBody, $Cookie)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $requestUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $requestBody,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/xml',
                'SOAPAction: login',
                "Cookie: BrowserId=$Cookie"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }


}
