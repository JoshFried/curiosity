<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadsTests extends TestCase
{

    use DatabaseMigrations;


    /**
     *@test
     *
     * @return void
     */
    public function a_user_can_view_all_threads()
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads');
        
        $response->assertSee($thread->title);

        
    }


    /**
     * @test
     */
    public function a_user_can_view_a_single_thread(Type $var = null)
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads/'. $thread->id); 
        $response->assertSee($thread->title);
    }
}
