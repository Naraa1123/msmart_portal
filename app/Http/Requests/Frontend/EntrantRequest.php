<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class EntrantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'department_id' => 'required|integer',
            'email' => 'required|email',
            'phone' => 'required|digits:8'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'Нэрний хэсгийг бөглөнө үү',
            'department_id.required' => 'Тэнхимээ сонгоно уу',
            'email.required' => 'И-Мейл хаяг хэсгийг бөглөнө үү',
            'phone.required' => 'Утасны дугаарыг бөглөнө үү',
            'phone.digits' => 'Утасны дугаар 8-н оронтой байх ёстой',
        ];
    }
}
