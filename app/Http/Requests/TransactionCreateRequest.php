<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionCreateRequest extends FormRequest
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
            "phone_number" => "string|max:255|required_without:account_number",
            "account_number" => "string|max:255|required_without:phone_number",
            "amount" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/",
            "comment" => 'sometimes|string'
        ];
    }
}
