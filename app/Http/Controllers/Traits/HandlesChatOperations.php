<?php

namespace App\Http\Controllers\Traits;

use App\Models\ChatMessage;
use Illuminate\Database\Eloquent\Collection;

/**
 * Shared helpers for ChatController (customer) and Admin\ChatController.
 *
 * Both controllers work with the same ChatMessage format but operate on
 * different subsets of messages (user-owned vs admin-side). This trait
 * centralises the message-formatting logic so the shape of the JSON
 * response stays consistent across both endpoints.
 */
trait HandlesChatOperations
{
    /**
     * Format a collection of ChatMessages into the standard API array.
     *
     * Used by poll() and messages() in both controllers.
     *
     * @param  Collection<ChatMessage> $messages
     * @return array
     */
    protected function formatMessages(Collection $messages): array
    {
        return $messages->map(function (ChatMessage $message) {
            return [
                'id'          => $message->id,
                'message'     => $message->message,
                'is_admin'    => $message->is_admin,
                'sender_name' => $message->is_admin ? 'Admin' : ($message->user?->name ?? 'Khách'),
                'created_at'  => $message->created_at->format('H:i'),
            ];
        })->values()->all();
    }

    /**
     * Build a standard poll JSON response.
     *
     * @param  array $formattedMessages  Output of formatMessages()
     * @return \Illuminate\Http\JsonResponse
     */
    protected function pollResponse(array $formattedMessages): \Illuminate\Http\JsonResponse
    {
        return response()->json(['messages' => $formattedMessages]);
    }
}
