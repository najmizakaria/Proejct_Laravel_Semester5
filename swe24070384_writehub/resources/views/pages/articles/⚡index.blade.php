
<?php
/**
 * Student Name : Muhammad Najmi Bin Zakaria
 * Student ID   : SWE24070384
 */

use App\Actions\PublishArticleAction;
use App\Models\Article;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Articles')] class extends Component {
    public ?string $notice = null;

    public function mount(): void
    {
        $this->notice = session('status');
    }

    #[Computed]
    public function articles()
    {
        return Article::with('user')
            ->orderBy('id')
            ->get();
    }

    /**
     * Publish an article.
     * Only administrators are allowed.
     */
    public function publish(
        int $id,
        PublishArticleAction $action
    ): void {
        $article = Article::findOrFail($id);

        Gate::authorize('publish-article');

        if ($article->status !== 'draft') {
            return;
        }

        $action->handle(auth()->user(), $article);

        $this->notice = 'Article published successfully.';
    }

    /**
     * Delete an article.
     * Only the author or administrator can delete.
     */
    public function destroy(int $id): void
    {
        $article = Article::findOrFail($id);

        Gate::authorize('delete', $article);

        $article->delete();

        $this->notice = 'Article deleted.';
    }
};
?>

<div class="space-y-6">

    <!-- Page Heading -->
    <div class="flex items-center justify-between">
        <flux:heading size="xl">
            Articles
        </flux:heading>

        @can('create', App\Models\Article::class)
            <flux:button
                variant="primary"
                :href="route('articles.create')"
                wire:navigate
            >
                New article
            </flux:button>
        @endcan
    </div>

    <!-- Success Notice -->
    @if ($notice)
        <div class="rounded-lg bg-green-100 p-3 text-sm text-green-800 dark:bg-green-900 dark:text-green-100">
            {{ $notice }}
        </div>
    @endif

    <!-- Article Count -->
    <p class="text-sm text-zinc-500">
        Total articles: {{ $this->articles->count() }}
    </p>

    <!-- Articles Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">

            <thead>
                <tr class="border-b border-zinc-200 dark:border-zinc-700">
                    <th class="p-2">#</th>
                    <th class="p-2">Title</th>
                    <th class="p-2">Author</th>
                    <th class="p-2">Category</th>
                    <th class="p-2">Minutes</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($this->articles as $article)

                    <tr
                        class="border-b border-zinc-200 dark:border-zinc-700"
                        wire:key="article-{{ $article->id }}"
                    >

                        <!-- Article ID -->
                        <td class="p-2">
                            {{ $article->id }}
                        </td>

                        <!-- Title -->
                        <td class="p-2">
                            {{ $article->title }}
                        </td>

                        <!-- Author -->
                        <td class="p-2">
                            {{ $article->user->name }}
                        </td>

                        <!-- Category -->
                        <td class="p-2">
                            {{ ucfirst($article->category) }}
                        </td>

                        <!-- Reading Time -->
                        <td class="p-2">
                            {{ $article->reading_time }}
                        </td>

                        <!-- Status -->
                        <td class="p-2">
                            <flux:badge
                                :color="$article->status === 'published' ? 'green' : 'zinc'"
                            >
                                {{ ucfirst($article->status) }}
                            </flux:badge>
                        </td>

                        <!-- Actions -->
                        <td class="p-2">
                            <div class="flex gap-2">

                                <!-- Publish Button -->
                                @if ($article->status === 'draft')
                                    @can('publish-article')
                                        <flux:button
                                            size="sm"
                                            variant="primary"
                                            wire:click="publish({{ $article->id }})"
                                            wire:confirm="Publish this article?"
                                        >
                                            Publish
                                        </flux:button>
                                    @endcan
                                @endif

                                <!-- Edit Button -->
                                @can('update', $article)
                                    <flux:button
                                        size="sm"
                                        :href="route('articles.edit', $article)"
                                        wire:navigate
                                    >
                                        Edit
                                    </flux:button>
                                @endcan

                                <!-- Delete Button -->
                                @can('delete', $article)
                                    <flux:button
                                        size="sm"
                                        variant="danger"
                                        wire:click="destroy({{ $article->id }})"
                                        wire:confirm="Delete this article?"
                                    >
                                        Delete
                                    </flux:button>
                                @endcan

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="7"
                            class="p-4 text-center"
                        >
                            No articles found.
                        </td>
                    </tr>

                @endforelse
            </tbody>

        </table>
    </div>
</div>
