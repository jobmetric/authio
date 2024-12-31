<?php

namespace JobMetric\Authio\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'mobile_prefix' => null,
            'mobile' => null,
            'mobile_verified_at' => null,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password')
        ];
    }

    /**
     * Indicate that the model's name.
     *
     * @param string|null $name
     * @return static
     */
    public function setName(string $name = null): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => $name
        ]);
    }

    /**
     * Indicate that the model's mobile should be unverified.
     *
     * @param string $mobile_prefix
     * @param string $mobile
     * @return static
     */
    public function setMobile(string $mobile_prefix, string $mobile): static
    {
        return $this->state(fn(array $attributes) => [
            'mobile_prefix' => $mobile_prefix,
            'mobile' => $mobile
        ]);
    }

    /**
     * Indicate that the model's mobile should be unverified.
     */
    public function mobileUnverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'mobile_verified_at' => null
        ]);
    }

    /**
     * Indicate that the model's email should be unverified.
     *
     * @param string|null $email
     * @return static
     */
    public function setEmail(string $email = null): static
    {
        return $this->state(fn(array $attributes) => [
            'email' => $email
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function emailUnverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
