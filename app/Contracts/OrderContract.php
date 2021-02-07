<?php

namespace App\Contracts;

interface OrderContract
{
    public function storeOrderDetails($params);

    public function storeAppOrderDetails($params);

    public function updateAppOrderDetails($params);

    public function listOrders(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    public function findOrderByNumber($orderNumber);
    public function findOrderById($id);

}
