<?php

namespace App\Repository;


interface BaseRepositoryInterface
{
    public function all(array $columns = ['*']);

    public function count();

    public function create(array $data);

    public function updateOrCreate(array $conditions, array $data);

    public function createMultiple(array $data);

    public function delete();

    public function deleteById($id);

    public function deleteMultipleById(array $ids);

    public function first(array $columns = ['*']);

    public function get(array $columns = ['*']);

    public function getColumnValues($column);

    public function getById($id, array $columns = ['*']);

    public function getFirstByColumn($item, $column, array $columns = ['*']);

    public function getAllByColumn($item, $column, array $columns = ['*']);

    public function getByColumn($item, $column);

    public function paginate($limit = 25, array $columns = ['*'], $pageName = 'page', $page = null);

    public function updateById($id, array $data);

    public function updateByColumn($column_name, $column_value, array $data);

    public function limit($limit);

    public function orderBy($column, $value);

    public function where($column, $value, $operator = '=');

    public function whereIn($column, $value);

    public function with($relations);

    public function exists($attrs);

    public function insert(array $data);

    public function updateByColumnWithNullableValues($column_name, $column_value, array $data);

    public function updateByIdWithNullableValues($id, array $data);

    public function incrementDecrement(int $id, string $column_name, int $value, bool $isIncrement);
}
