<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Subscriber;
use Database\Seeders\DatabaseSeeder;
use App\Models\Enums\SubscriberState;
use App\Http\Resources\SubscriberResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
