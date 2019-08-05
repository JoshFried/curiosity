<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{

    use DatabaseMigrations;


    /** @test */

    // public function unauthenticated_users_may_not_add_replies() { 


    //     $thread = factory('App\Thread')->create();

    //     $reply = factory('App\Reply')->create();
    //     $this->post($thread->path().'/replies/', $reply->toArray());
    // }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        //given we have an authenticated user 
        $this->be($user = factory('App\User')->create());

        //and an existing thread
        $thread = factory('App\Thread')->create(); 

        //when the user adds a rpely to the thread
        $reply = factory('App\Reply')->make();
        $this->post($thread->path().'/replies', $reply->toArray()); 

        //then their reply should be visible on the page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
