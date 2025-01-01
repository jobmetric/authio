<?php

namespace JobMetric\Authio\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JobMetric\Authio\Models\UserToken;

/**
 * @extends Factory<UserToken>
 */
class UserTokenFactory extends Factory
{
    protected $model = UserToken::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'token' => fake()->text(30),
            'user_agent' => fake()->text(30),
            'ip_address' => fake()->ipv4(),
            'logout_at' => null,
            'expired_at' => null,
            'created_at' => now(),
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
     * Indicate that the model's token is token.
     *
     * @param string $token
     *
     * @return static
     */
    public function token(string $token): static
    {
        return $this->state(fn(array $attributes) => [
            'token' => $token
        ]);
    }

    /**
     * Indicate that the model's token is user agent.
     *
     * @param string $user_agent
     *
     * @return static
     */
    public function userAgent(string $user_agent): static
    {
        return $this->state(fn(array $attributes) => [
            'user_agent' => $user_agent
        ]);
    }

    /**
     * Indicate that the model's token is ip address.
     *
     * @param string $ip_address
     *
     * @return static
     */
    public function ipAddress(string $ip_address): static
    {
        return $this->state(fn(array $attributes) => [
            'ip_address' => $ip_address
        ]);
    }

    /**
     * Indicate that the model's token is logged out.
     *
     * @return static
     */
    public function loggedOut(): static
    {
        return $this->state(fn(array $attributes) => [
            'logout_at' => now()
        ]);
    }

    /**
     * Indicate that the model's token is expired.
     *
     * @return static
     */
    public function expired(): static
    {
        return $this->state(fn(array $attributes) => [
            'expired_at' => now()->subDay()
        ]);
    }
}
