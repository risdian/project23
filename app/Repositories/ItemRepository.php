<?php

namespace App\Repositories;

use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\ItemContract;
use App\Models\Item;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Auth;

/**
 * Class CategoryRepository
 *
 * @package \App\Repositories
 */
class ItemRepository extends BaseRepository implements ItemContract
{
    use UploadAble;

    /**
     * CategoryRepository constructor.
     * @param Item $model
     */
    public function __construct(Item $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listItems(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findItemById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return Item|mixed
     */
    public function createItem(array $params)
    {
        try {
            $collection = collect($params);

            $user_id = Auth()->user()->id;

            $image = null;

            if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'items');
            }

            $merge = $collection->merge(compact('image','user_id'));

            $item = new Item($merge->all());

            $item->save();

            return $item;

        } catch (QueryException $exception) {

            throw new InvalidArgumentException($exception->getMessage());

        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateItem(array $params)
    {
        $item = $this->findItemById($params['id']);

        $collection = collect($params)->except('_token');

        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {

            if ($item->image != null) {
                $this->deleteOne($item->image);
            }

            $image = $this->uploadOne($params['image'], 'items');

        }else {

            $image = $item->image;

        }

        $merge = $collection->merge(compact('image'));

        $item->update($merge->all());

        return $item;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteItem($id)
    {
        $item = $this->findItemById($id);

        if ($item->image != null) {
            $this->deleteOne($item->image);
        }

        $item->delete();

        return $item;
    }

    public function findBySlug($slug)
    {
        return Item::with('products')
            ->where('slug', $slug)
            // ->where('menu', 1)
            ->first();
    }

}
