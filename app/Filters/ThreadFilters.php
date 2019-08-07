<?php 
namespace App\Filters;

use Illuminate\Http\Request;
use App\User; 


class ThreadFilters extends Filters {

    protected $filters = ['by', 'popular'];

    /**
     * Filter the query by a given username
     *
     * @param  string $username
     *
     * @return mixed
     */
    protected function by($username)
    {
        
        $user = User::where('name', $username)->firstOrFail();    
        
        return $this->builder->where('user_id', $user->id);
    }


    /**
     * Filter query according to replies count 
     */

    protected function popular() 
    {
        // clear out existing orders from getThreads method in threads controller
        $this->builder->getQuery()->orders = []; 
        
        return $this->builder->orderBy('replies_count', 'desc');
    }
} 