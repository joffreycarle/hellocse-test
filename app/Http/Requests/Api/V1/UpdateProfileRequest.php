<?php

namespace App\Http\Requests\Api\V1;

use App\DTOs\UpdateProfileDTO;
use App\Enums\ProfileStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:3', 'max:255'],
            'last_name' => ['required', 'string', 'min:3', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'string', 'in:'.implode(',', ProfileStatus::toArray())],
        ];
    }

    public function toDto(): UpdateProfileDTO
    {
        return new UpdateProfileDTO(
            first_name: $this->string('first_name'),
            last_name: $this->string('last_name'),
            status: $this->string('status'),
            image: $this->file('image')
        );
    }
}
