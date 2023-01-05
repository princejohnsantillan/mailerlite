<?php

namespace App\Http\Requests;

use App\Rules\ValidSubscriberState;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriberRequest extends FormRequest
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
            'name' => 'sometimes',
            'email' => 'email:rfc,dns',
            'state' => [new ValidSubscriberState()],
        ];
    }
}
