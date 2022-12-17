<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{
    //model muốn tương tác
    protected $model;

    //khởi tạo
    public function __construct()
    {
        $this->setModel();
    }

    //lấy model tương ứng
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function getAll()
    {
        return $this->model->get();
    }

    public function find($id)
    {
        $result = $this->model->find($id);

        return $result;
    }

    public function save($attributes = [])
    {
        $result = $this->model->create($attributes);
        return $result;
    }

    public function update($id, $attributes = [])
    {
        $this->model->where('id', $id)->update($attributes);
        $result = $this->model->find($id);
        return $result;
    }

    public function delete($id)
    {
        $this->model->destroy($id);
    }
}
