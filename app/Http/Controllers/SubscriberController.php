<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriberRequest;
use App\Http\Requests\UpdateSubscriberRequest;
use App\Http\Resources\SubscriberResource;
use App\Models\Subscriber;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SubscriberResource::collection(Subscriber::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubscriberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscriberRequest $request)
    {
        $data = $request->validated();

        $subscriber = Subscriber::query()->create($data);

        if (Arr::has($data, 'fields')) {
            $fieldValues = collect(data_get($data, 'fields'))
                ->map(
                    fn ($field) => [
                        'subscriber_id' => $subscriber->id,
                        'field_id' => $field['id'],
                        'value' => $field['value'],
                    ]
                )->toArray();
            DB::table('field_subscriber')->insert($fieldValues);
        }

        return response()->json(['subscriber' => $subscriber]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        return new SubscriberResource($subscriber);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubscriberRequest  $request
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubscriberRequest $request, Subscriber $subscriber)
    {
        $data = $request->validated();

        $status = $subscriber->update($data);

        if (Arr::has($data, 'fields')) {
            $fieldValues = collect(data_get($data, 'fields'))
                ->map(
                    fn ($field) => [
                        'subscriber_id' => $subscriber->id,
                        'field_id' => $field['id'],
                        'value' => $field['value'],
                    ]
                )->toArray();
            DB::table('field_subscriber')->upsert($fieldValues, ['subscriber_id', 'field_id'], ['value']);
        }

        return response()->json(['status' => $status]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        $status = $subscriber->delete();

        return response()->json(['status' => (bool) $status]);
    }
}
