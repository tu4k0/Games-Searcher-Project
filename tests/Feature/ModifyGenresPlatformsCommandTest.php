<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ModifyGenresPlatformsCommandTest extends TestCase
{
    public function test_modify_genres_platforms_command(): void
    {
        $this->artisan('app:modify-genres-platforms')->assertSuccessful();
    }
}
