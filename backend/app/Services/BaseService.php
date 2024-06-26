<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Lcobucci\JWT\Exception;

abstract class BaseService
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function list($conditions, $relations = [], $relationCounts = [], $selects = ['*'])
    {
        $list = $this->repository->query($conditions, $relations, $relationCounts, $selects);

        return $list;
    }

    /**
     * Create model.
     *
     * @param  array $data
     *
     * @return  Model
     */
    public function create($data)
    {
        $entity = $this->repository->create($data);
        return $entity;
    }

    /**
     * Update model.
     *
     * @param  Model $entity
     * @param  array $data
     *
     * @return  Model
     */
    public function update($entity, $data = [])
    {
        $this->repository->update($entity, $data);

        return $entity;
    }

    /**
     * Delete model.
     *
     * @param  Model $entity
     *
     * @return  void
     */
    public function destroy($entity)
    {
        return $this->repository->delete($entity);
    }

    /**
     * Get model detail.
     *
     * @param Model $entity
     *
     * @return Model
     */
    public function show(Model $entity, $relations = [])
    {
        return $this->repository->show($entity, $relations);
    }

    /**
     * Update or create model.
     *
     * @param array $condition
     * @param array $data
     *
     * @return Model
     */
    public function updateOrCreate($condition = [], $data = [])
    {
        return $this->repository->updateOrCreate($condition, $data);
    }

    /**
     * Synchro model relation with data.
     *
     * @param Model $entity
     * @param mixed $relation
     * @param array $data
     *
     * @return void
     */
    public function sync(Model $entity, $relation, $data = [])
    {
        return $this->repository->sync($entity, $relation, $data);
    }

    /**
     * Insert multiple values.
     *
     * @return int
     */
    public function insert($data)
    {
        return $this->repository->insert($data);
    }

    /**
     * Find model by id.
     *
     * @param mixed $id
     * @param array $relations
     *
     * @return Model
     */
    public function findOrFail($id, $relations = [])
    {
        return $this->repository->findOrFail($id, $relations);
    }

    /**
     * Find model by id.
     *
     * @param mixed $id
     * @param array $relations
     *
     * @return Model
     */
    public function find($id, $relations = [])
    {
        return $this->repository->find($id, $relations);
    }

    /**
     * Find by condition .
     *
     * @param mixed $request
     * @param array $relations
     *
     * @return object $entities
     */
    public function findByCondition($condition, $relations = [])
    {
        return $this->repository->findByCondition($condition, $relations);
    }

    /**
     * Get model's fillable attribute.
     *
     * @return array
     */
    public function getFillable()
    {
        return $this->repository->getFillable();
    }

    /**
     * Batch update.
     *
     * @param array $condition
     * @param array $data
     * @return mixed
     */
    public function batchUpdate(array $condition, array $data)
    {
        return $this->repository->batchUpdate($condition, $data);
    }

    /**
     * Check Duplicate Data
     *
     * @param  mixed $data
     * @param  mixed $model
     * @return void
     */
    public function checkDuplicateData($data, $column, $model)
    {
        $exitsData = $model->where($column, $data)->exists();

        // check case update
        if ((array) $model) {
            return $model->$column === $data || !$exitsData ? false : true;
        }
        return $exitsData;
    }
}
