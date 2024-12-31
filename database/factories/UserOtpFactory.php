<?php

namespace JobMetric\Authio\Factories;

use App\Enums\LoginTypeEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserOtpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'source' => fake()->randomElement(LoginTypeEnum::values()),
            'secret' => fake()->text(30),
            'otp' => fake()->numberBetween(10000, 99999),
            'try_count' => 0,
            'used_at' => null,
            'ip_address' => fake()->ipv4(),
        ];
    }

    /**
     * Indicate that the model's user id.
     *
     * @param int $user_id
     * @return static
     */
    public function setUser(int $user_id): static
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $user_id
        ]);
    }

    /**
     * Indicate that the model's otp should be used.
     *
     * @return static
     */
    public function used(): static
    {
        return $this->state(fn(array $attributes) => [
            'used_at' => now()
        ]);
    }

    /**
     * Indicate that the model's real ip address.
     */
    public function realIpAddress(): static
    {
        return $this->state(fn(array $attributes) => [
            'ip_address' => request()->ip()
        ]);
    }
}
