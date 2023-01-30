<?php

namespace OrderList\OrderListModule\Api;

interface OrderInterface
{
    /**
     * GET for Post api
     * @param string $orderid order id.
     * @return boolean|array
     */

    public function getOrderById($orderid);

    /**
     * GET for Post api
     * @param string $customerId customer id.
     * @return boolean|array
     */

    public function getCustomerOrders($customerId);

    /**
     * GET for Post api
     * @param string $customerId customer id.
     * @return boolean|array
     */

    public function getCustomerCart($customerId);
}
