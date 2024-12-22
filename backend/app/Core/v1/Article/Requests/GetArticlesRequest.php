<?php

namespace App\Core\v1\Article\Requests;

use App\Rules\SearchQueryRule;
use Illuminate\Foundation\Http\FormRequest;

class GetArticlesRequest extends FormRequest
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
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'source_id' => ['nullable', 'integer', 'exists:sources,id'],
            'search' => ['nullable', 'string', new SearchQueryRule],
            'page' => ['nullable', 'integer'],
            'per_page' => ['nullable', 'integer'],
        ];
    }
}
