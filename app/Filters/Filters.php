<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * Declare the Request and Query builder variables.
     *
     * @var Illumniate\Http\Request
     * @var Illuminate\Database\Eloquent\Builder
     */
    protected $request, $builder;

    /**
     * Declare ehe empty filters.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Create a new filters instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the filters to the query.
     *
     * @param Illuminate\Database\Eloquent\Builder $builder
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if(method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * Get the filters from the request.
     *
     * @return array
     */
    public function getFilters()
    {
        return array_filter($this->request->only($this->filters));
    }
}
