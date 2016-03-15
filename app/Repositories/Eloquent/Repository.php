<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\RepositoryInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Container\Container as App;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

abstract class Repository implements RepositoryInterface
{
    use ValidatesRequests;

    /**
     *
     * @var $app
     */
    private $app;

    /**
     *
     * @var $model
     */
    protected $model;

    /**
     *
     * @var $withTrashed
     */
    private $withTrashed;

    /**
     *
     * @var $onlyTrashed
     */
    private $onlyTrashed;

    /**
     *
     * @var $where
     */
    private $where;

    /**
     *
     * @var $orWhere
     */
    private $orWhere;

    /**
     *
     * @var $skip
     */
    private $skip;

    /**
     *
     * @var $take
     */
    private $take;

    /**
     *
     * @var $orderBy
     */
    private $orderBy;

    /**
     * @var $errorBagName
     */
    private $errorBagName;

    /**
     *
     * @param App $app
     * @param Collection $collection
     */
    public function __construct()
    {
        $this->app = new App();
        $this->makeModel();
        $this->validationRules = [];
        $this->validationMessages = [];

        if (method_exists($this, 'validationMessages')) {
            $this->validationMessages = $this->validationMessages();
        }

        if (method_exists($this, 'validationRules')) {
            $this->validationRules = $this->validationRules();
        }

        if (method_exists($this, 'errorBagName')) {
            $this->errorBagName = $this->errorBagName();
        }
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public abstract function model();

    /**
     *
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        $this->newQuery()
             ->eagerLoadTrashed()
             ->eagerLoadWhere()
             ->eagerTakeAndSkip()
             ->eagerOrderBy();

        return $this->model->get($columns);
    }


    /**
     *
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 20, $columns = ['*'])
    {
        $this->newQuery()
             ->eagerLoadTrashed()
             ->eagerLoadWhere()
             ->eagerOrderBy();

        return $this->model->paginate($perPage, $columns);
    }

    /**
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        if (isset($this->validationRules['create'])) {
            $this->validateOrFail($this->validationRules['create']);
        }

        return $this->model->create($data);
    }

    /**
     *
     * @param array $data
     * @param string $exist_field
     * @return bool
     */
    public function save(array $data, $exist_field = 'id')
    {
        $this->model->unguard();
        $model = $this->model->fill($data);
        $model->exists = $data[$exist_field];
        $this->model->reguard();

        return $model->save();
    }

    /**
     *
     * @param array $data
     * @param string|int $id
     * @param string $attribute
     * @param bool $withSoftDel
     * @return mixed
     */
    public function update(array $data, $id, $attribute = 'id', $withSoftDel = false)
    {
        if (isset($this->validationRules['update'])) {
            $this->validateOrFail($this->validationRules['update']);
        }

        if ($withSoftDel) {
            $this->newQuery()->eagerLoadTrashed();
        }

        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     *
     * @param string|int $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * Truly remove a model from database
     * @return mixed
     */
    public function forceDelete($id)
    {
        return $this->find($id)->forceDelete();
    }

    /**
     *
     * @param string|int $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        $this->makeModel();

        $this->newQuery()->eagerLoadTrashed();

        return $this->model->findOrFail($id, $columns);
    }

    /**
     *
     * @param string $field
     * @param string $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*'])
    {
        $this->newQuery()->eagerLoadTrashed();

        return $this->model->where($field, '=', $value)->firstOrFail($columns);
    }

    /**
     *
     * @param string $field
     * @param string $value
     * @param array $columns
     * @return mixed
     */
    public function findAllBy($field, $value, $columns = ['*'])
    {
        $this->newQuery()
             ->eagerLoadTrashed()
             ->eagerOrderBy();

        return $this->model->where($field, '=', $value)->get($columns);
    }

    /**
     *
     * @param array $columns
     * @return mixed
     */
    public function firstOrFail($columns = ['*'])
    {
        $this->newQuery()->eagerLoadTrashed()->eagerLoadWhere();

        return $this->model->firstOrFail();
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws Exception
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Load result with soft delete
     *
     * @return $this
     */
    public function withTrashed()
    {
        $this->withTrashed = func_get_args();
        return $this;
    }

    /**
     * Load result only deleted with soft delete
     *
     * @return $this
     */
    public function onlyTrashed()
    {
        $this->onlyTrashed = func_get_args();

        return $this;
    }

    /**
     * And where
     *
     * @param mixed $condition Array of conditions or string field name
     * @param mixed $value Value of field (if condition is field name string)
     * @param string $operator Condition operator (ie: =, <=, >=, <>, ...)
     * @return $this
     */
    public function where($conditions, $operator = '=', $value = '1')
    {
        $this->where[] = func_get_args();

        return $this;
    }

    /**
     * Or where
     *
     * @param mixed $condition Array of conditions or string field name
     * @param mixed $value Value of field (if condition is field name string)
     * @param string $operator Condition operator (ie: =, <=, >=, <>, ...)
     * @return $this
     */
    public function orWhere($conditions, $operator = '=', $value = '1')
    {
        $this->orWhere[] = func_get_args();

        return $this;
    }

    /**
     * Offset of cursor in result set
     *
     * @param int $offset Offset number
     * @return $this
     */
    public function skip($offset = 0)
    {
        $this->skip = $offset;

        return $this;
    }

    /**
     * Limit records of result set
     *
     * @param int $limit Limit number
     * @return $this
     */
    public function take($limit = 20)
    {
        $this->take = $limit;

        return $this;
    }

    /**
     * Sort result set
     *
     * @param string $field Field name
     * @param string $direction Sort direction (ASC and DESC)
     * @return $this
     */
    public function orderBy($field, $direction = 'ASC')
    {
        $this->orderBy[] = func_get_args();

        return $this;
    }

    /**
     * Insert and support created_at and updated_at columns
     *
     * @param  array   $dataArr       Insert data array
     * @param  boolean $withUpdatedAt With updated_at column?
     * @return boolean                Insert status
     */
    public function insert(array $dataArr, $withUpdatedAt = true)
    {
        $insertData = [];
        $now = Carbon::now();

        if (is_array($dataArr) && count($dataArr)) {
            foreach ($dataArr as $data) {
                $data['created_at'] = $now;

                if ($withUpdatedAt) {
                    $data['updated_at'] = $now;
                }

                $insertData[] = $data;
            }

            return $this->model->insert($insertData);
        }

        return false;
    }

    public function whereIn($field, $values, $columns = ['*'])
    {
        return $this->model->whereIn($field, $values)->get($columns);
    }

    /**
     * Create new query for model
     *
     * @return $this
     */
    private function newQuery()
    {
        $this->model = $this->model->newQuery();

        return $this;
    }

    /**
     * Eager loading trashed
     *
     * @return $this
     */
    private function eagerLoadTrashed()
    {
        if (!is_null($this->withTrashed)) {
            $this->model->withTrashed();
        } elseif (!is_null($this->onlyTrashed)) {
            $this->model->onlyTrashed();
        }

        return $this;
    }

    /**
     * Eager loading for and where & or where
     *
     * @return $this
     */
    private function eagerLoadWhere()
    {
        if (count($this->where) > 0) {
            foreach ($this->where as $where) {
                if (is_array($where[0])) {
                    $this->model->where($where[0]);
                } else {
                    if (count($where) == 3) {
                        $this->model->where($where[0], $where[1], $where[2]);
                    } else {
                        $this->model->where($where[0], '=', $where[1]);
                    }
                }
            }
        }

        if (count($this->orWhere) > 0) {
            foreach ($this->orWhere as $orWhere) {
                if (is_array($orWhere[0])) {
                    $this->model->orWhere($orWhere[0]);
                } else {
                    if (count($where) == 3) {
                        $this->model->orWhere($where[0], $where[1], $where[2]);
                    } else {
                        $this->model->orWhere($where[0], '=', $where[1]);
                    }
                }
            }

            if (!is_null($this->withTrashed)) {
                $this->model->where(function($query) {
                    return $query->whereNull('deleted_at')->orWhereNotNull('deleted_at');
                });
            }

            if (!is_null($this->onlyTrashed)) {
                $this->model->whereNotNull('deleted_at');
            }
        }

        return $this;
    }

    /**
     * Eager loading for take and skip
     *
     * @return $this
     */
    private function eagerTakeAndSkip()
    {
        if (!is_null($this->skip)) {
            $this->model->skip($this->skip);
        }

        if (!is_null($this->take)) {
            $this->model->take($this->take);
        }

        return $this;
    }

    /**
     * Eager loading for order by
     *
     * @return $this
     */
    private function eagerOrderBy()
    {
        if (count($this->orderBy) > 0) {
            foreach ($this->orderBy as $orderBy) {
                $direction = (isset($orderBy[1]) ? $orderBy[1] : 'ASC');
                $this->model->orderBy($orderBy[0], $direction);
            }
        }

        return $this;
    }

    /**
     * Validate or fail
     *
     * @param  array $rules Validation rules
     * @return mixed Validation exeption
     */
    private function validateOrFail($rules)
    {
        $request = \Request::instance();
        $validator = Validator::make($request->all(), $rules, $this->validationMessages);

        if ($validator->fails()) {
            \Log::error($validator->messages());
            $this->throwValidationException($request, $validator);
        }
    }

     /**
     * Create the response for when a request fails validation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $errors
     * @return \Illuminate\Http\Response
     */
    protected function buildFailedValidationResponse(\Illuminate\Http\Request $request, array $errors)
    {
        $errorBag = $this->errorBagName;

        if (!$errorBag) {
            $errorBag = $this->errorBag();
        }

        if ($request->ajax() || $request->wantsJson()) {
            return new JsonResponse($errors, 422);
        }

        return redirect()->to($this->getRedirectUrl())
                        ->withInput($request->input())
                        ->withErrors($errors, $errorBag);
    }
}
