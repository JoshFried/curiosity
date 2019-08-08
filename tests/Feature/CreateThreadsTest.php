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

        $response = $this->post('/threads' , $thread->toArray());

        //then, when we visit the thread page 
        // we should see the new thread
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */ 
    function a_thread_requires_a_title() 
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */ 
    function a_thread_requires_a_body() 
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */ 
    function a_thread_requires_a_valid_channel() 
    {

        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');    
    }


    /** @test */
    function a_thread_can_be_deleted () 
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204); 

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function guests_cannot_delete_threads () 
    {
        $thread = create('App\Thread');
        $response = $this->delete($thread->path());

        $response->assertRedirect('/login');


    }

    /** @test */
    function threads_may_only_be_deleted_by_those_who_have_permission () 
    {
        
    }

    public function publishThread($overrides = []) 
    {
        $this->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }


}
