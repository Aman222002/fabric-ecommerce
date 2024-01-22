<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRagistrationRequest extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|unique:companies|max:255',
            'registration_number' => 'required|string|max:255|unique:companies',
            'company_address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
        ];
    }
}
