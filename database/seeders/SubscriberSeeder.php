<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\Subscriber;
use Illuminate\Database\Seeder;

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // No fields
        Subscriber::factory()->count(5)->create();

        // With fields
        $i = 5;
        while ($i > 0) {
            Subscriber::factory()
                ->hasAttached(Field::find(1), ['value' => fake()->company()])
                ->hasAttached(Field::find(2), ['value' => fake()->countryCode()])
                ->hasAttached(Field::find(3), ['value' => fake()->date()])
                ->create();
            $i--;
        }
    }
}
