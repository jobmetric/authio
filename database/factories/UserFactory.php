<?php

namespace JobMetric\Authio\Factories;

use Faker\Factory as Faker;
use Faker\Provider\fa_IR\PhoneNumber as IranPhoneNumber;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use JobMetric\Authio\Models\User;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

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
        $fake = Faker::create('fa_IR');

        return [
            'name' => $fake->name(),
            'email' => Str::random(5) . $fake->safeEmail(),
            'email_verified_at' => now(),
            'mobile_prefix' => '+98',
            'mobile' => substr(IranPhoneNumber::mobileNumber(), 1, 10),
            'mobile_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'deleted_at' => null,
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
     * Indicate that the model's email.
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
     * Indicate that the model's email should be unverified.
     *
     * @return static
     */
    public function emailUnverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => now()
        ]);
    }

    /**
     * Indicate that the model's mobile should be verified.
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
     * Indicate that the model's password.
     *
     * @param string $password
     * @return static
     */
    public function setPassword(string $password): static
    {
        return $this->state(fn(array $attributes) => [
            'password' => Hash::make($password)
        ]);
    }

    /**
     * Indicate that the model's remember token.
     *
     * @param string $remember_token
     * @return static
     */
    public function setRememberToken(string $remember_token): static
    {
        return $this->state(fn(array $attributes) => [
            'remember_token' => $remember_token
        ]);
    }

    /**
     * Indicate that the model's deleted at.
     *
     * @return static
     */
    public function setDeletedAt(): static
    {
        return $this->state(fn(array $attributes) => [
            'deleted_at' => now()
        ]);
    }
}
