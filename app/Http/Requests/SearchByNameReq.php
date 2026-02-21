<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchByNameReq extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
   public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'], // valida que venga un string y no muy largo
        ];
    }

    /**
     * Prepare the data for validation.
     * Esto asegura que query params también se validen.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->query('name'),
        ]);
    }
}
