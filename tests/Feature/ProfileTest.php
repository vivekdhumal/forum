<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_has_a_profile()
    {
        $user = create('App\User');

        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }

    /** @test */
    public function a_profiles_has_a_threads_associated_with_the_user()
    {
        $user = create('App\User');

        $thread = create('App\Thread', ['user_id' => $user->id]);

        $this->get("/profiles/{$user->name}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
