<?php

namespace App\Http\Requests;

use App\Rules\ValidSubscriberState;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|unique:subscribers|email:rfc,dns',
            'name' => 'required',
            'state' => ['required', new ValidSubscriberState()],
            'fields.*.id' => 'exists:fields',
            'fields.*.value' => 'sometimes|required',
        ];
    }
}
