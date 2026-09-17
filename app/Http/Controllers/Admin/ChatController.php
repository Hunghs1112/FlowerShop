<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display all users with chat messages.
     */
    public function index()
    {
        // Get users who have chat messages, with unread count and latest message
        $users = User::whereHas('chatMessages')
            ->withCount(['unreadMessages'])
            ->with(['chatMessages' => function ($query) {
                $query->latest()->limit(1);
            }])
            ->get()
            ->sortByDesc(function ($user) {
                return $user->chatMessages->first()?->created_at;
            });

        return view('admin.chats.index', compact('users'));
    }

    /**
     * Display chat with a specific user.
     */
    public function show($userId)
    {
        $user = User::findOrFail($userId);
        $messages = ChatMessage::forUser($userId)->with('user')->get();

        // Mark user messages as read
        ChatMessage::where('user_id', $userId)
            ->where('is_admin', false)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $users = User::whereHas('chatMessages')
            ->withCount(['unreadMessages'])
            ->get();

        return view('admin.chats.show', compact('user', 'messages', 'users'));
    }

    /**
     * Send a message to a user.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $message = ChatMessage::create([
            'user_id' => $request->user_id,
            'is_admin' => true,
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
     * Mark messages as read.
     */
    public function markAsRead(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        ChatMessage::where('user_id', $request->user_id)
            ->where('is_admin', false)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Get total unread count for admin dashboard.
     */
    public function unreadCount(): JsonResponse
    {
        $count = ChatMessage::where('is_admin', false)
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Poll for new messages (admin side).
     */
    public function poll(Request $request): JsonResponse
    {
        $userId = $request->input('user_id');
        $afterId = (int) $request->input('after', 0);

        $messages = ChatMessage::where('user_id', $userId)
            ->where('id', '>', $afterId)
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'is_admin' => $msg->is_admin,
                    'sender_name' => $msg->is_admin ? 'Admin' : $msg->user->name,
                    'created_at' => $msg->created_at->format('H:i'),
                ];
            });

        return response()->json(['messages' => $messages]);
    }
}
