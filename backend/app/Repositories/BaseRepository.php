<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    const PAGINATE = 10;
    /**
     * @var Model
     */
    protected $model;

    /**
     * Get query model.
     *
     * @param mixed $data
     * @param array $relations
     * @param array $relationCounts
     *
     * @return Collection $entities
     */
    public function query($params, $relations = [], $relationCounts = [], $selectable = ['*'], $mapQuery = false)
    {
        $params = collect($params);

        // Select list column
        $entities = $this->model->select(!empty($selectable) ? $selectable : ($this->model->selectable ?? ['*']));

        // Load realtion counts
        if (count($relationCounts)) {
            $entities = $entities->withCount($relationCounts);
        }

        // Load relations
        if (count($relations)) {
            $entities = $entities->with($relations);
        }

        // Filter list by condition
        if (count($params) && method_exists($this, 'mergeQuery')) {
            foreach ($params as $key => $value) {
                $entities = $this->mergeQuery($entities, $key, $value);
            }
        }

        // Order list
        $orderBy = $params->has('sort') ? $params['sort']
        : $this->model->getKeyName();
        $entities = $entities->orderBy($orderBy, $params->has('sortType') && $params['sortType'] == 1 ? 'asc' : 'desc');

        // If concatenating query
        if ($mapQuery) {
            return $entities;
        }

        // Limit result
        $limit = $params->has('limit') ? (int) $params['limit'] : self::PAGINATE;
        if ($limit) {
            return $entities->paginate($limit);
        }

        return $entities->get();
    }
    /**
     * Create model.
     *
     * @param array $data
     *
     * @return Model
     */
    public function create($data = [])
    {
        return $this->model->create($data);
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
        if (count($relations)) {
            return $entity->load($relations);
        }

        return $entity;
    }

    /**
     * Update model.
     *
     * @param Model $entity
     * @param array $data
     *
     * @return Model
     */
    public function update(Model $entity, $data = [])
    {
        $entity->update($data);

        return $entity;
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
        return $this->model->updateOrCreate($condition, $data);
    }

    /**
     * Delete model.
     *
     * @param Model $entity
     *
     * @return void
     */
    public function delete(Model $entity)
    {
        $entity->delete();
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
        $entity->$relation()->sync($data);
    }

    /**
     * Insert multiple values.
     *
     * @return int
     */
    public function insert($data)
    {
        $data = array_map(function ($item) {
            $item['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $item['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

            return $item;
        }, $data);

        return $this->model->insert($data);
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
        $entity = $this->model->findOrFail($id);

        if (count($relations)) {
            return $entity->load($relations);
        }

        return $entity;
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
        $entity = $this->model->find($id);

        if (count($relations)) {
            return $entity->load($relations);
        }

        return $entity;
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
        $entities = $this->model->select($this->model->selectable);

        if (count($relations)) {
            $entities = $entities->with($relations);
        }

        if (count($condition)) {
            foreach ($condition as $key => $value) {
                $entities = $this->mergeQuery($entities, $key, $value);
            }
        }

        return $entities;
    }

    /**
     * Get model's fillable attribute.
     *
     * @return array
     */
    public function getFillable()
    {
        return $this->model->getFillable();
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
        $model = $this->model;
        if (count($condition) && method_exists($this, 'mergeQuery')) {
            foreach ($condition as $key => $value) {
                $model = $this->mergeQuery($model, $key, $value);
            }
        }

        return $model->update($data);
    }
}
