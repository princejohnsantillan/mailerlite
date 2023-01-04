<?php

namespace Database\Factories;

use App\Models\Enums\SubscriberState;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscriber>
 */
class SubscriberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $first = $this->faker->firstName();
        $last = $this->faker->lastName();
        $uid = uniqid();
        $name = str("{$first}_{$last}_$uid")->lower()->replaceMatches('/[^a-z0-9_]/', '');
        $domain = $this->faker->freeEmailDomain();

        return [
            'email' => "$name@$domain",
            'name' => "$first $last",
            'state' => $this->faker->randomElement(SubscriberState::cases()),
        ];
    }
}
