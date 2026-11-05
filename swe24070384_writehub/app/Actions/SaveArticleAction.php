<?php
/**
 * Student Name : Muhammad Najmi Bin Zakaria
 * Student ID   : SWE24070384
 */

namespace App\Actions;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class SaveArticleAction
{
    /**
     * Create a new article or update an existing article.
     *
     * @param array<string, mixed> $data
     */
    public function handle(
        User $user,
        array $data,
        ?Article $article = null
    ): Article {

        // Remove spaces at the beginning and end of the title
        $data['title'] = trim($data['title']);

        // Check whether the article is becoming published
        $becomingPublished = $data['status'] === 'published'
            && $article?->status !== 'published';

        // Only administrators may publish articles
        if ($becomingPublished) {
            Gate::forUser($user)->authorize('publish-article');
        }

        // Update an existing article
        if ($article) {
            $article->update($data);

            return $article;
        }

        // Create a new article
        return $user->articles()->create($data);
    }
}
