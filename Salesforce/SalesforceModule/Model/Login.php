<?php

namespace Salesforce\SalesforceModule\Model;

use Salesforce\SalesforceModule\Helper\Request;


class Login
{
    /**
     * @var Request
     */
    protected $helper;

    /**
     * @param Request $helper
     */
    public function __construct(
        Request $helper
    )
    {
        $this->helper = $helper;
    }


    /**
     * @return bool|string
     */
    public function loginCustomer()
    {
        $requestUrl = "https://login.salesforce.com/services/Soap/u/50.0";

        $requestBody = '<?xml version="1.0" encoding="utf-8" ?>
<env:Envelope xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:env="http://schemas.xmlsoap.org/soap/envelope/">
  <env:Body>
    <n1:login xmlns:n1="urn:partner.soap.sforce.com">
      <n1:username>bojkoio@ukr.net</n1:username>
      <n1:password>YGWQ5VTeRXnCWQAexMzaeZgCedE5OS2fHpZ7tr3</n1:password>
    </n1:login>
  </env:Body>
</env:Envelope>';

        $Cookie = "zVVpGFXiEe2B0jtFPkvYTg";

        return $this->helper->createRequest($requestUrl, $requestBody, $Cookie);

    }

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        $xmlParser = xml_parser_create();

        xml_parse_into_struct($xmlParser, $this->loginCustomer(), $value, $index);

        return $value[8]['value'];

    }

}
