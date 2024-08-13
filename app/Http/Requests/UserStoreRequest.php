<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
    public function rules(): array
    {

        return [
            'class' => 'required|exists:classes,id',
            'gender' => 'required',
            'role_as' => 'required',
            'firstname' => 'required|max:200',
            'lastname' => 'required|max:200',
            'email' => 'nullable|unique:users,email',

            'registration_number' => [
                'required',
                'string',
                'regex:/^[А-ЯҮӨа-яүө]{2}\d{8}$/u',
                Rule::unique('user_details', 'registration_number'),
            ],
            'image' => 'nullable|image',
            'phone_number_1' => 'required|integer|digits:8',
            'phone_number_2' => 'required|integer|digits:8',
            'phone_number_3' => 'nullable|integer|digits:8',
            'guardian_name' => 'nullable|max:200',
            'guardian_phone_number' => 'nullable|integer|digits:8',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'admission_year' => 'nullable|date_format:Y-m-d',
            'address' => 'nullable',
            'contract' => 'nullable',
            'made_contract'=>'required',

            //Payment Validation
            'total_amount' => 'sometimes',
            'discount_percentage' => 'sometimes',
            'paid_amount' => 'sometimes',
            'payment_method' => 'sometimes',
            'payment_description' => 'sometimes',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->sometimes(['total_amount', 'discount_percentage', 'paid_amount'], 'required|numeric', function ($input) {
            return $input->role_as == 3;
        });

        $validator->sometimes(['payment_method', 'payment_description'], 'required|string', function ($input) {
            return $input->role_as == 3;
        });

        $validator->after(function ($validator) {
            $input = $validator->getData();

            $total_amount = isset($input['total_amount']) ? $input['total_amount'] : 0;
            $discount_percentage = isset($input['discount_percentage']) ? $input['discount_percentage'] : 0;
            $amount_due = $total_amount - ($total_amount * $discount_percentage) / 100;

            if (isset($input['paid_amount']) && $input['paid_amount'] > $amount_due) {
                $validator->errors()->add('paid_amount', 'Төлсөн дүн нь төлөх дүнгээс их байх боломжгүй.');
            }
        });
    }

}


