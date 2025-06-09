<?php

namespace App\Http\Requests\Api\V1;

use App\DTOs\StoreTokenDTO;
use Illuminate\Foundation\Http\FormRequest;

class StoreTokenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ];
    }

    public function toDto(): StoreTokenDTO
    {
        return new StoreTokenDTO(
            email: $this->string('email'),
            password: $this->string('password')
        );
    }
}
