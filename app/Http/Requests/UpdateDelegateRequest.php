<?php

namespace App\Http\Requests;

use App\Rules\UniqueCities;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDelegateRequest extends FormRequest
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
        $delegateId = $this->route('delegate')->id;
        return [
            'name' => 'required|string|max:255|min:2',
            'phone' => [
        'required',
        Rule::unique('delegates', 'phone')->ignore($delegateId),
        'regex:/^(077|078|079)\d{7}$/'
    ],
            'delegates' => ['required','array',new UniqueCities],
            'delegates.*.city' => 'required|exists:cities,id',
            'delegates.*.price' => 'required|numeric|min:1',
        ];
    }

   

    public function messages()
    {
        return [
            'phone.regex' => 'يجب أن يبدأ رقم الهاتف بـ 077 أو 078 أو 079 متبوعًا بـ 7 أرقام.',
            'delegates.*.price.min' => 'يجب أن يكون السعر أكبر من الصفر.',
        ];
    }
}
