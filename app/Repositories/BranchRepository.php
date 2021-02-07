<?php

namespace App\Repositories;

use App\Models\Branch;
use App\Contracts\BranchContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class BranchRepository
 *
 * @package \App\Repositories
 */
class BranchRepository extends BaseRepository implements BranchContract
{

    /**
     * BranchRepository constructor.
     * @param Branch $model
     */
    public function __construct(Branch $model)
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
    public function listBranches(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findBranchById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return Branch|mixed
     */
    public function createBranch(array $params)
    {
        try {
            $collection = collect($params);
            // dd($collection);
            $branch = new Branch($collection->all());

            $branch->save();

            return $branch;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBranch(array $params)
    {
        $branch = $this->findBranchById($params['id']);

        $collection = collect($params)->except('_token');

        $branch->update($collection->all());

        return $branch;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteBranch($id)
    {
        $branch = $this->findBranchById($id);

        $branch->delete();

        return $branch;
    }


}
