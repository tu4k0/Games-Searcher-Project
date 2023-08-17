<?php

namespace App\Http\Requests;

use App\Constants\GameConstant;
use BackedEnum;
use Elegant\Sanitizer\Laravel\SanitizesInput;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Foundation\Http\FormRequest;
use Elegant\Sanitizer\Filters\Enum;

class GameRequest extends FormRequest
{
    use SanitizesInput;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $body = $this->only(GameConstant::FILLABLE);
        $filters = [
            'id' => ['trim', 'digit', 'cast:integer'],
            'name' => ['escape', 'trim', 'capitalize'],
            'rating' => ['trim', 'empty_string_to_null', 'digit', 'cast:float'],
            'summary' => ['strip_tags', 'trim'],
            'first_release_date' => ['trim'],
            'category_id' => ['trim', 'digit', 'cast:integer'],
        ];
        $sanitizedBody = \Sanitizer::make($body, $filters)->sanitize();
        $this->merge($sanitizedBody);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'numeric', 'integer'],
            'name' => ['required', 'string'],
            'rating' => ['numeric', 'between:1,100'],
            'summary' => ['required', 'string'],
            'first_release_date' => ['required'],
            'category_id' => ['required', 'numeric', 'integer'],
        ];
    }
}
