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
    public function guests_cannot_see_the_create_thread_page() 
    {
        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        //given a signed in user 
        $this->signIn();

        //when we hit the enpoint to create a new thread
        $thread = make('App\Thread');

        $this->post('/threads' , $thread->toArray());

        //then, when we visit the thread page 
        // we should see the new thread
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
