<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    const USER_MIN_PASSWORD = 8;
    const REMEMBER_TOKEN_MAX_LENGTH = 10;

    public static function makeLogin(): string
    {
        return fake()->name();
    }

    public static function makeEmail(): string
    {
        return fake()->unique()->safeEmail();
    }

    public static function makePassword(): string
    {
        return fake()->password(self::USER_MIN_PASSWORD);
    }

    public static function hashPassword(string $password): string
    {
        return Hash::make($password);
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'login' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make(fake()->password(self::USER_MIN_PASSWORD)),
            'remember_token' => Str::random(self::REMEMBER_TOKEN_MAX_LENGTH),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
