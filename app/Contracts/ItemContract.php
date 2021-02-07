<?php

namespace App\Contracts;

/**
 * Interface BrandContract
 * @package App\Contracts
 */
interface ItemContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listItems(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findItemById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createItem(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateItem(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteItem($id);

    /**
    * @param $slug
    * @return mixed
    */
    public function findBySlug($slug);
}
