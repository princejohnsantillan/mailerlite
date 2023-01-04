<?php

namespace Tests\Feature;

use App\Http\Resources\SubscriberResource;
use App\Models\Enums\SubscriberState;
use App\Models\Field;
use App\Models\Subscriber;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageSubscriberViaApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_a_list_of_subscribers()
    {
        (new DatabaseSeeder())->run();

        $response = $this->getJson('api/subscriber');

        $this->assertEquals(count($response['data']), Subscriber::query()->count());
        $this->assertArrayHasKey('id', $response['data'][0]);
        $this->assertArrayHasKey('email', $response['data'][0]);
        $this->assertArrayHasKey('name', $response['data'][0]);
        $this->assertArrayHasKey('state', $response['data'][0]);
    }

    /** @test */
    public function it_shows_a_specific_subsriber()
    {
        $data = ['email' => 'john@doe.com', 'name' => 'john doe', 'state' => 'active'];

        $subscriber = Subscriber::create($data);

        $response = $this->getJson("api/subscriber/{$subscriber->id}");

        $this->assertEquals((new SubscriberResource($subscriber))->resolve(), $response['data']);
    }

    /** @test */
    public function it_can_create_a_subscriber_via_api()
    {
        $data = ['email' => 'john@doe.com', 'name' => 'john doe', 'state' => 'active'];

        $this->postJson('api/subscriber', $data);

        $this->assertDatabaseHas('subscribers', $data);
    }

    /** @test */
    public function it_can_create_a_subscriber_with_fields_via_api()
    {
        Field::factory()->count(3)->create();

        $fields = ['fields' => [
            ['id' => 1, 'value' => fake()->word()],
            ['id' => 2, 'value' => fake()->word()],
            ['id' => 3, 'value' => fake()->word()],
        ]];
        $data = ['email' => 'john@doe.com', 'name' => 'john doe', 'state' => 'active'];

        $this->postJson('api/subscriber', array_merge($data, $fields));

        $subscriber = Subscriber::query()->where($data)->first();

        $this->assertDatabaseHas('subscribers', $data);
        $this->assertDatabaseHas('field_subscriber', ['subscriber_id' => $subscriber->id, 'value' => data_get($fields, 'fields.0.value')]);
        $this->assertDatabaseHas('field_subscriber', ['subscriber_id' => $subscriber->id, 'value' => data_get($fields, 'fields.1.value')]);
        $this->assertDatabaseHas('field_subscriber', ['subscriber_id' => $subscriber->id, 'value' => data_get($fields, 'fields.2.value')]);
    }

    /** @test */
    public function it_validates_before_storing()
    {
        $this->handleValidationExceptions();

        $response = $this->postJson('api/subscriber', ['email' => 'johndoe.com', 'name' => 'john doe', 'state' => 'active']);

        $response->assertJsonValidationErrors(['email' => 'The email must be a valid email address.']);
    }

    /** @test */
    public function it_can_update_a_subscriber_via_api()
    {
        $subscriber = Subscriber::create(['email' => 'john@doe.com', 'name' => 'john doe', 'state' => 'active']);

        $this->patchJson("api/subscriber/{$subscriber->id}", ['state' => 'unsubscribed']);

        $this->assertEquals($subscriber->fresh()->state, SubscriberState::UNSUBSCRIBED);
    }

    /** @test */
    public function it_validates_before_updating()
    {
        $this->handleValidationExceptions();

        $subscriber = Subscriber::create(['email' => 'john@doe.com', 'name' => 'john doe', 'state' => 'active']);

        $response = $this->patchJson("api/subscriber/{$subscriber->id}", ['state' => 'inactive']);

        $response->assertJsonValidationErrors(['state' => 'Invalid subscriber state.']);
    }

    /** @test */
    public function it_can_delete_a_subscriber_via_api()
    {
        $subscriber = Subscriber::create(['email' => 'john@doe.com', 'name' => 'john doe', 'state' => 'active']);

        $this->deleteJson("api/subscriber/{$subscriber->id}");

        $this->assertDatabaseMissing('subscribers', ['id' => $subscriber->id]);
    }
}
