<?php

namespace App\Repositories;

use App\Models\User;
use App\Contracts\UserContract;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class CategoryRepository
 *
 * @package \App\Repositories
 */
class UserRepository extends BaseRepository implements UserContract
{

    /**
     * CategoryRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
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
    public function listUsers(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    // /**
    //  * @param int $id
    //  * @return mixed
    //  * @throws ModelNotFoundException
    //  */
    // public function findUserById(int $id)
    // {
    //     try {
    //         return $this->findOneOrFail($id);

    //     } catch (ModelNotFoundException $e) {

    //         throw new ModelNotFoundException($e);
    //     }
    // }

    // /**
    //  * @param array $params
    //  * @return User|mixed
    //  */
    // public function createUser(array $params)
    // {
    //     try {
    //         $collection = collect($params);

    //         $user = new User($collection->all());

    //         $user->save();

    //         return $user;

    //     } catch (QueryException $exception) {
    //         throw new InvalidArgumentException($exception->getMessage());
    //     }
    // }

    // /**
    //  * @param array $params
    //  * @return mixed
    //  */
    // public function updateUser(array $params)
    // {

    // }

    // /**
    //  * @param $id
    //  * @return bool|mixed
    //  */
    // public function deleteUser($id)
    // {

    // }

    // public function findBySlug($slug)
    // {

    // }

}
