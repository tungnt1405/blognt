<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;
    protected string $table = '';
    protected array $join = [];
    // protected array $fields = [];

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

    public function filterSearch($records = 10, $conditions = [], $orders = [], $columns = ['*'])
    {
        $search = $this->model->withTrashed()->whereNull('deleted_at');

        if (is_array($conditions) && !empty($conditions)) {
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
                        $search->where(function ($query) use ($field, $value) {
                            $query->where($field, $value[0]);
                            $new_values = array_slice($value, 1);
                            if (!empty($new_values)) {
                                foreach ($new_values as $new_value) {
                                    $query->orWhere($field, $new_value);
                                }
                            }
                        });
                    }
                } else {
                    $search->where($field, $value);
                }
            }
        }

        if (!empty($orders) && is_array($orders)) {
            foreach ($orders as $field => $value) {
                $search->orderBy($field, $value);
            }
        }

        // if (empty($columns) && !empty($this->fields)) {
        //     $columns = $this->fields;
        // }
        // $search->select($columns);
        if (empty($columns) || is_array($columns) && in_array('*', $columns) || $columns === '*') {
            $search->select(['*']);
        } else {
            $search->select($columns);
        }

        return $search->paginate($records);
    }

    public function filterOnlyTrashSearch($records = 10, $conditions = [], $orders = [], $columns = ['*'])
    {
        $search = $this->model->onlyTrashed();

        if (is_array($conditions) && !empty($conditions)) {
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
                        $search->where(function ($query) use ($field, $value) {
                            $query->where($field, $value[0]);
                            $new_values = array_slice($value, 1);
                            if (!empty($new_values)) {
                                foreach ($new_values as $new_value) {
                                    $query->orWhere($field, $new_value);
                                }
                            }
                        });
                    }
                } else {
                    $search->where($field, $value);
                }
            }
        }

        if (!empty($orders) && is_array($orders)) {
            foreach ($orders as $field => $value) {
                $search->orderBy($field, $value);
            }
        }

        if (empty($columns) || is_array($columns) && in_array('*', $columns) || $columns === '*') {
            $search->select(['*']);
        } else {
            $search->select($columns);
        }

        return $search->paginate($records);
    }
}
