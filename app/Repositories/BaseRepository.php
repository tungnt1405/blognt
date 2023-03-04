<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;
    protected string $table = '';
    protected array $join = [];
    protected array $fields = [];

    public function __construct()
    {
        $this->setModel();
        $this->setTable();
        $this->setJoinTable();
    }

    /**
     * Get model
     */
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

    /**
     * Get table
     */
    abstract public function getTable();

    /**
     * Set table
     */
    public function setTable()
    {
        $this->table = $this->getTable();
    }

    /**
     * Get Join Table
     */
    abstract public function getJoinTable();

    /**
     * Set table
     */
    public function setJoinTable()
    {
        $this->join = $this->getJoinTable();
    }


    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        $result = $this->model->find($id);

        return $result;
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    // inprogress
    public function paginate($conditions = [], $orders = [], $records = 10, $columns = ['*'])
    {
        if (!empty($conditions) && is_array($conditions)) {
            $results = $this->filterSearch($conditions, $orders, $columns);
        } else {
            $results = $this->all();
        }

        return $results->paginate($records)->get();
    }

    public function filterSearch($conditions = [], $orders = [], $columns = ['*'])
    {
        $search = DB::table($this->table);

        foreach ($conditions as $key => $value) {
            if (is_array($value)) {
                $search->where($key, function ($query, $key) use ($value) {
                    $query->where($key, $value[0]);
                    $new_values = array_slice($value, 1);
                    if (!empty($new_values)) {
                        foreach ($new_values as $new_value) {
                            $query->orWhere($key, $new_value);
                        }
                    }
                });
            } else {
                $search->where($key, $value['query'], $value['sql']);
            }
        }

        if (!empty($orders) && is_array($orders)) {
            foreach ($orders as $key => $value) {
                $search->orderBy($key, $value);
            }
        }

        if (empty($columns) && !empty($this->fields)) {
            $columns = $this->fields;
        } else {
            $columns = ['*'];
        }
        $search->select($columns);
        return $search;
    }
}
