<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'age' => ['required', 'integer', 'min:10', 'max:100'],
            'gender' => ['required', 'in:male,female'],
            'height' => ['required', 'numeric', 'min:100', 'max:250'],
            'weight' => ['required', 'numeric', 'min:30', 'max:250'],
            'activity_level' => ['required', 'string'],
            'fitness_goal' => ['required', 'in:fat_loss,muscle_gain,maintenance'],
            'current_password' => ['nullable', 'current_password'],
        ];
    }
}
