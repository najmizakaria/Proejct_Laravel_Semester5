<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    // List all conversations for the logged-in user
    public function index()
    {
        $conversations = auth()->user()->conversations()
            ->with(['messages' => fn ($q) => $q->latest()->limit(1)])
            ->get();

        return response()->json($conversations);
    }

    // Start a new conversation (e.g. customer messaging an artisan)
    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'subject'      => 'nullable|string',
            'workshop_id'  => 'nullable|exists:workshops,id',
            'message'      => 'required|string',
        ]);

        $conversation = Conversation::create([
            'subject'     => $request->subject,
            'workshop_id' => $request->workshop_id,
        ]);

        // Attach participant (Current User + Recipient Artisan/Customer)
        $conversation->participants()->attach([auth()->id(), $request->recipient_id]);

        // Create the initial message
        $message = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'body'    => $request->message,
        ]);

        broadcast(new MessageSent($message->load('sender')))->toOthers();

        return response()->json($conversation->load('messages'), 201);
    }

    // Send a message within an existing conversation
    public function sendMessage(Request $request, Conversation $conversation)
    {
        $request->validate(['body' => 'required|string']);

        // Check if user is participant
        abort_unless($conversation->participants()->where('users.id', auth()->id())->exists(), 403);

        $message = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'body'    => $request->body,
        ]);

        broadcast(new MessageSent($message->load('sender')))->toOthers();

        return response()->json($message);
    }
}