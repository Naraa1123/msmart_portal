<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentTransactionRequest extends FormRequest
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
            'firstname' => 'required|max:200',
            'lastname' => 'required|max:200',
            'class' => 'required',
            'registration_number' => [
                'required',
                'string',
                'regex:/^[А-ЯҮӨа-яүө]{2}\d{8}$/u',
                Rule::unique('payment_transactions', 'registration_number'),
            ],
            'phone_number_1' => 'required|integer|digits:8',
            'phone_number_2' => 'nullable|integer|digits:8',
            'contract_no' => 'nullable|string',
            'total_payment' => 'required|numeric|gte:paid_amount',
            'paid_amount' => 'required|numeric',
        ];
    }


    public function messages(): array
    {
        return [
            'required' => 'Энэ талбарыг бөглөх шаардлагатай.',
            'alpha' => 'Энэ талбарт зөвхөн үсэг байх ёстой.',
            'max' => [
                'string' => 'Текстийн урт хамгийн их 200 тэмдэгттэй байх ёстой.',
            ],
            'regex' => 'Энэ талбарт буруу форматтай утга оруулсан байна.(Регистерийн үсгийг монголоор оруулна уу)',
            'unique' => 'Энэ утга аль хэдийн бүртгэгдсэн байна.',
            'integer' => 'Энэ талбарт бүтэн тоо оруулах ёстой.',
            'digits' => 'Энэ талбарт 8 оронтой тоо оруулах ёстой.',
            'numeric' => 'Энэ талбарт тоо оруулах ёстой.',
            'gte' => 'Төлөх төлбөр нь төлсөн дүнгээс их эсвэл тэнцүү байх ёстой.',
        ];
    }
}
