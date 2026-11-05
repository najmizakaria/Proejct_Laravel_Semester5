<?php
/**
 * Student Name : Muhammad Najmi Bin Zakaria
 * Student ID   : SWE24070384
 */

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Article $article): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Only the author may edit an article.
     * Even administrators cannot edit another user's article.
     */
    public function update(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }

    /**
     * Authors can delete their own articles.
     * Administrators can delete any article.
     */
    public function delete(User $user, Article $article): bool
    {
        return $user->id === $article->user_id
            || $user->isAdmin();
    }

    public function restore(User $user, Article $article): bool
    {
        return false;
    }

    public function forceDelete(User $user, Article $article): bool
    {
        return false;
    }
}
