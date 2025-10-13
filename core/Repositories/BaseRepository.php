<?php

namespace Core\Repositories;

use Exception;

class BaseRepository implements BaseInterface
{
    protected  $model;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (!property_exists($this, 'model')) {
            throw new Exception(static::class . ' must define the $model property.');
        }

        if (!class_exists($this->model)) {
            throw new Exception("Model class {$this->model} does not exist.");
        }
    }

    /**
     * Summary of getAll
     * @return array
     */
    public function getAll(): array
    {
        return $this->model::all()->toArray();
    }

    /**
     * Summary of findById
     * @param mixed $id
     */
    public function findById($id)
    {
        return $this->model::find($id);
    }

    /**
     * Summary of create
     * @param array $data
     */
    public function create($data)
    {
        return $this->model::create($data);
    }

    /**
     * Summary of update
     * @param mixed $id
     * @param mixed $attributes
     * @throws \Exception
     */
    public function update($id, $attributes)
    {
        $model = $this->model::find($id);

        if (!$model) {
            throw new \Exception("Record not found for ID {$id}");
        }

        $model->update($attributes);

        return $model;
    }

    /**
     * Summary of delete
     * @param mixed $id
     * @return void
     */
    public function delete($id)
    {
        $this->model::destroy($id);
    }
}
