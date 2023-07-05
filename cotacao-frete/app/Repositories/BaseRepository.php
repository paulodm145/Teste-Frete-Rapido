<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param array $filters
     * @param int $perPage
     * @param string $sortField
     * @param string $sortDirection
     * @return LengthAwarePaginator
     */
    public function getAll(array $filters = [], int $perPage = 5, string $sortField = 'id', string $sortDirection = 'asc')
    {
        $query = $this->model->query();

        foreach ($filters as $key => $value) {
            $query->where($filters[$key][0], $filters[$key][1], $filters[$key][2]);
        }

        $query->orderBy($sortField, $sortDirection)->get();

        return $query->paginate($perPage);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        $model = $this->getById($id);
        $model->update($data);
        return $model;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $model = $this->getById($id);
        $model->delete();
        return $model;
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function massDelete(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    /**
     * @param $field
     * @param $value
     * @param $perPage
     * @return mixed
     */
    public function search($field, $value, $perPage = 20)
    {
        return $this->model->where($field, $value)->paginate($perPage);
    }

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function searchBy($field, $value)
    {
        return $this->model->where($field, $value)->get();
    }

}
