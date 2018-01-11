<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_not_favorite_anything()
    {
        $this->post('replies/1/favorites')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->withoutExceptionHandling()
            ->signIn();

        $reply = create('App\Reply');

        $this->post('replies/'.$reply->id.'/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_not_favorite_reply_multiple_times()
    {
        $this->withoutExceptionHandling()
            ->signIn();

        $reply = create('App\Reply');

        try {
            $this->post('replies/'.$reply->id.'/favorites');
            $this->post('replies/'.$reply->id.'/favorites');
        } catch(\Exception $exception) {
            $this->fail("Do not expect to insert same record twice");
        }

        $this->assertCount(1, $reply->favorites);
    }
}
