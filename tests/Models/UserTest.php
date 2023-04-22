<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password'
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('johndoe@example.com', $user->email);
        $this->assertTrue(password_verify('password', $user->password));
    }

    public function test_password_is_hidden()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password'
        ]);

        $this->assertArrayNotHasKey('password', $user->toArray());
    }

    public function test_api_tokens_can_be_generated()
    {
        $user = User::factory()->create();

        $this->assertNotNull($user->createToken('test-token')->plainTextToken);
    }
}

