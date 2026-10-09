<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Controllers\Traits\HandlesChatOperations;
use App\Models\ChatMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    use HandlesChatOperations;

    /**
     * Display chat interface.
     */
    public function index()
    {
        $messages = ChatMessage::forUser(auth()->id())
            ->with('user')
            ->limit(100)->get();

        // Mark admin messages as read
        ChatMessage::where('user_id', auth()->id())
            ->where('is_admin', true)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('chat.index', compact('messages'));
    }

    /**
     * Send a new message.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = ChatMessage::create([
            'user_id' => auth()->id(),
            'is_admin' => false,
            'message' => $request->message,
            'is_read' => false,
        ]);

        // Broadcast event
        broadcast(new MessageSent($message->load('user')))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Get all messages for current user (for floating widget).
     */
    public function messages(): JsonResponse
    {
        $messages = ChatMessage::forUser(auth()->id())
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'messages' => $this->formatMessages($messages),
        ]);
    }

    /**
     * Get unread message count for current user.
     */
    public function unreadCount(): JsonResponse
    {
        $count = ChatMessage::where('user_id', auth()->id())
            ->where('is_admin', true)
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Poll for new messages (for local dev without WebSocket).
     */
    public function poll(Request $request): JsonResponse
    {
        $request->validate([
            'after' => 'nullable|integer|min:0',
        ]);

        $afterId = (int) $request->input('after', 0);
        
        $messages = ChatMessage::forUser(auth()->id())
            ->where('id', '>', $afterId)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->limit(100)->get();

        // Mark admin messages as read
        if ($messages->isNotEmpty()) {
            ChatMessage::where('user_id', auth()->id())
                ->where('is_admin', true)
                ->where('is_read', false)
                ->where('id', '>', $afterId)
                ->update(['is_read' => true]);
        }

        return $this->pollResponse($this->formatMessages($messages));
    }
}
