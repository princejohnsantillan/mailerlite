<?php

namespace Database\Seeders;

use App\Models\Enums\FieldType;
use App\Models\Field;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Field::factory()->create(['title' => 'Company', 'type' => FieldType::STRING]);
        Field::factory()->create(['title' => 'Country', 'type' => FieldType::STRING]);
        Field::factory()->create(['title' => 'Birthday', 'type' => FieldType::DATE]);
    }
}
