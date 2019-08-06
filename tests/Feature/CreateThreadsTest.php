<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations; 



    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        //given a signed in user 
        $this->actingAs(factory('App\User')->create());

        //when we hit the enpoint to create a new thread
        $thread = factory('App\Thread')->make();

        $this->post('/threads' , $thread->toArray());

        //then, when we visit the thread page 
        // we should see the new thread
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
