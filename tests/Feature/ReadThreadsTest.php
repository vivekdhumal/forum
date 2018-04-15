<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_user_can_browse_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_a_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadInNotChannel = create('App\Thread');

        $this->get('/threads/'.$channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadInNotChannel->title);
    }

    /** @test */
    public function an_authenticated_user_can_filter_threads_by_an_user_name()
    {
        $this->signIn(create('App\User', ['username' => 'VivekDhumal']));

        $threadsByVivek = create('App\Thread', ['user_id' => auth()->id()]);

        $threadsNotByVivek = create('App\Thread');

        $this->get('/threads?by=VivekDhumal')
            ->assertSee($threadsByVivek->title)
            ->assertDontSee($threadsNotByVivek->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadsWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadsWithTwoReplies->id], 2);

        $threadsWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadsWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson('/threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }

    /** @test */
    public function a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $thread = create('App\Thread');

        create('App\Reply', ['thread_id' => $this->thread->id]);

        $response = $this->getJson('/threads?unanswered=1')->json();

        $this->assertCount(1, $response['data']);
    }

    /** @test */
    public function a_user_can_request_all_replies_for_a_given_thread()
    {
       $thread = create('App\Thread');

        create('App\Reply', ['thread_id' => $thread->id], 2);

       $response = $this->getJson($thread->path().'/replies')->json();

        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    }

    /** @test */
    public function it_records_a_new_vist_each_time_the_thread_is_read()
    {
        $thread = create('App\Thread');

        $this->assertSame(0, $thread->visits);

        $this->call('GET', $thread->path());

        $this->assertEquals(1, $thread->fresh()->visits);
    }
}
