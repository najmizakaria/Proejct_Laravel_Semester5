<?php
/**
 * Student Name : Muhammad Najmi Bin Zakaria
 * Student ID   : SWE24070384
 */

namespace App\Actions;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class PublishArticleAction
{
    public function handle(User $user, Article $article): Article
    {
        Gate::forUser($user)->authorize('publish-article');

        $article->update([
            'status' => 'published',
        ]);

        return $article;
    }
}
