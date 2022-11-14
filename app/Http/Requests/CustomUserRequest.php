<?php

namespace App\Http\Requests;

use App\DTO\CustomUserDto;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CustomUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name'       => 'required|string|min:1|max:30',
            'email'      => 'required|string|min:1|max:15',
            'phone'      => 'required|string|min:1|max:15',
        ];
    }

    /**
     * @return CustomUserDto
     */
    public function makeDto(): CustomUserDto
    {
        $dto = new CustomUserDto();
        $dto->name = $this->name;
        $dto->email = $this->email;
        $dto->phone = $this->phone;

        return $dto;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $response = [
            'success' => false,
            'message' => $errors,
        ];

        throw new HttpResponseException(response()->json($response, JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
