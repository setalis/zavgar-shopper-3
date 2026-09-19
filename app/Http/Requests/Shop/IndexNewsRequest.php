<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop;

use App\Models\NewsArticle;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;

final class IndexNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'q' => ['sometimes', 'nullable', 'string', 'max:100'],
        ];
    }

    public function search(): string
    {
        return trim((string) ($this->validated('q') ?? ''));
    }

    /**
     * @param  Builder<NewsArticle>  $query
     * @return Builder<NewsArticle>
     */
    public function apply(Builder $query): Builder
    {
        $search = $this->search();

        if ($search !== '') {
            $query->where('title', 'like', '%'.addcslashes($search, '%_\\').'%');
        }

        return $query;
    }
}
