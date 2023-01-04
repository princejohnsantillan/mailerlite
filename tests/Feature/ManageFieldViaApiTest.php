<?php

namespace Tests\Feature;

use App\Http\Resources\FieldResource;
use App\Models\Enums\FieldType;
use App\Models\Field;
use Tests\TestCase;

class ManageFieldViaApiTest extends TestCase
{
    /** @test */
    public function it_shows_a_list_of_fields()
    {
        $response = $this->getJson('api/field');

        $this->assertEquals(count($response['data']), Field::query()->count());
        $this->assertArrayHasKey('id', $response['data'][0]);
        $this->assertArrayHasKey('title', $response['data'][0]);
        $this->assertArrayHasKey('type', $response['data'][0]);
    }

    /** @test */
    public function it_shows_a_specific_field()
    {
        $data = ['title' => 'Company', 'type' => 'string'];

        $field = Field::create($data);

        $response = $this->getJson("api/field/{$field->id}");

        $this->assertEquals((new FieldResource($field))->resolve(), $response['data']);
    }

    /** @test */
    public function it_can_create_a_field_via_api()
    {
        $data = ['title' => 'Company',  'type' => 'string'];

        $this->postJson('api/field', $data);

        $this->assertDatabaseHas('fields', $data);
    }

    /** @test */
    public function it_validates_before_storing()
    {
        $this->handleValidationExceptions();

        $response = $this->postJson('api/field', ['title' => 'Company',  'type' => 'float']);

        $response->assertJsonValidationErrors(['type' => 'Invalid field type.']);
    }

    /** @test */
    public function it_can_update_a_field_via_api()
    {
        $field = Field::create(['title' => 'Company',  'type' => 'boolean']);

        $this->patchJson("api/field/{$field->id}", ['type' => 'string']);

        $this->assertEquals($field->fresh()->type, FieldType::STRING);
    }

    /** @test */
    public function it_validates_before_updating()
    {
        $this->handleValidationExceptions();

        $field = Field::create(['title' => 'Company',  'type' => 'string']);

        $response = $this->patchJson("api/field/{$field->id}", ['type' => 'integer']);

        $response->assertJsonValidationErrors(['type' => 'Invalid field type.']);
    }

    /** @test */
    public function it_can_delete_a_field_via_api()
    {
        $field = Field::create(['title' => 'Company',  'type' => 'string']);

        $this->deleteJson("api/field/{$field->id}");

        $this->assertDatabaseMissing('fields', ['id' => $field->id]);
    }
}
