<?php 

namespace App\Filters;
use Illuminate\Http\Request;
use App\User;

abstract class Filters 
{
    
    protected $request; 
    protected $builder;

    protected $filters = [];


    /**
     * __construct
     *
     * @param  mixed $request
     *
     * @return void
    */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * apply
     *
     * @param  mixed $builder
     *
     * @return void
     */
    public function apply($builder) { 
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) { 
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        
            $this->$filter($this->request->$filter);
            
        }

        return $this->builder;


        
    }

    /**
     * Fetch all relevant filters from the request.
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = array_intersect(array_keys($this->request->all()), $this->filters); 
        return $this->request->only($filters);
    }

}