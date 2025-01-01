<?php

namespace JobMetric\Authio\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JobMetric\Authio\Enums\LoginTypeEnum;
use JobMetric\Authio\Models\UserOtp;

/**
 * @extends Factory<UserOtp>
 */
class UserOtpFactory extends Factory
{
    protected $model = UserOtp::class;

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
     * Indicate that the model's source is mobile.
     *
     * @return static
     */
    public function sourceMobile(): static
    {
        return $this->state(fn(array $attributes) => [
            'source' => LoginTypeEnum::MOBILE
        ]);
    }

    /**
     * Indicate that the model's source is email.
     *
     * @return static
     */
    public function sourceEmail(): static
    {
        return $this->state(fn(array $attributes) => [
            'source' => LoginTypeEnum::EMAIL
        ]);
    }

    /**
     * Indicate that the model's secret.
     *
     * @param string $secret
     *
     * @return static
     */
    public function secret(string $secret): static
    {
        return $this->state(fn(array $attributes) => [
            'secret' => $secret
        ]);
    }

    /**
     * Indicate that the model's otp.
     *
     * @param string $otp
     *
     * @return static
     */
    public function otp(string $otp): static
    {
        return $this->state(fn(array $attributes) => [
            'otp' => $otp
        ]);
    }

    /**
     * Indicate that the model's try count.
     *
     * @param int $try_count
     *
     * @return static
     */
    public function tryCount(int $try_count): static
    {
        return $this->state(fn(array $attributes) => [
            'try_count' => $try_count
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
}
