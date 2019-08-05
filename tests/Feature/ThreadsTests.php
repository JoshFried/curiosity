<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadsTests extends TestCase
{

    use DatabaseMigrations;


    public function setUp(): void { 
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }



    /**
     *@test
     *
     * @return void
     */
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads');
        
        $response->assertSee($this->thread->title);

        
    }


    /**
     * @test
     */
    public function a_user_can_view_a_single_thread()
    {

        $response = $this->get('/threads/'. $this->thread->id); 
        $response->assertSee($this->thread->title);
    }

    
    /** @test */ 
    function a_user_can_read_replies_that_are_associated_with_a_thread() { 

        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);

        $this->get('/threads/' . $this->thread->id)
            ->assertSee($reply->body);


    }


}
