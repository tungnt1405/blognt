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

    public function filterSearch($conditions = [], $orders = [], $columns = ['*'])
    {
        $search = DB::table($this->table);

        if (!empty($this->join)) {
            foreach ($this->join as $table => $keys) {
                $search->leftJoin($table, $table . '.' . $keys['foreign_key'], '=', $this->table . '.' . $keys['key']);
            }
        }
        foreach ($conditions as $field => $value) {
            if (is_array($value)) {
                if (!empty($value['sql']) && !empty($value['value'])) {
                    $search->where($field, $value['sql'], $value['value']);
                } else {
                    $search->where($field, $value[0]);
                    $new_values = array_slice($value, 1);
                    if (!empty($new_values)) {
                        foreach ($new_values as $new_value) {
                            $search->orWhere($field, $new_value);
                        }
                    }
                }
            } else {
                $search->where($field, $value);
            }
        }

        if (!empty($orders) && is_array($orders)) {
            dump($orders);
            foreach ($orders as $field => $value) {
                $search->orderBy($field, $value);
            }
        }

        if (empty($columns) && !empty($this->fields)) {
            $columns = $this->fields;
        }
        $search->select($columns);
        if (!empty($orders)) {
            dump($columns);
            dd($search->toSql());
        }
        return $search->paginate(10);
    }
}
