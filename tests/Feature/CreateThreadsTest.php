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
    function authorized_users_may_delete_threads () 
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204); 

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads () 
    {
        $thread = create('App\Thread');

        $this->delete($thread->path())
            ->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())
            ->assertStatus(403);


    }

    public function publishThread($overrides = []) 
    {
        $this->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }


}
