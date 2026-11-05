<?php
/**
 * Student Name : Muhammad Najmi Bin Zakaria
 * Student ID   : SWE24070384
 */

namespace App\Http\Requests;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveArticleRequest extends FormRequest
{
    /**
     * Authorize the user to create or edit an article.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        if (! $user) {
            return false;
        }

        $articleId = $this->articleId();

        return $articleId
            ? $user->can('update', Article::findOrFail($articleId))
            : $user->can('create', Article::class);
    }

    /**
     * Validation rules for both forms.
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:5',
                'max:100',
                Rule::unique('articles', 'title')
                    ->ignore($this->articleId()),
            ],

            'category' => [
                'required',
                Rule::in(Article::CATEGORIES),
            ],

            'reading_time' => [
                'required',
                'integer',
                'between:1,60',
            ],

            'body' => [
                'required',
                'string',
                'min:20',
            ],

            'status' => [
                'required',
                Rule::in(Article::STATUSES),
            ],
        ];
    }

    /**
     * Custom validation error messages.
     */
    public function messages(): array
    {
        return [
            'title.unique' =>
                'An article with this title already exists.',

            'category.in' =>
                'Please choose a valid category.',

            'reading_time.between' =>
                'Reading time must be between :min and :max minutes.',

            'body.min' =>
                'The article body must contain at least :min characters.',
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'reading_time' => 'reading time (minutes)',
        ];
    }

    /**
     * Identify the article being saved.
     *
     * Null means a new article.
     */
    protected function articleId(): ?int
    {
        // Article from a controller route
        $routeArticle = $this->route('article');

        if ($routeArticle instanceof Article) {
            return $routeArticle->id;
        }

        // Article ID provided by Livewire
        return $this->integer('article_id') ?: null;
    }
}
