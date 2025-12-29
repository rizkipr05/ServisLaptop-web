<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // GET /api/chat/conversations
    public function conversations(Request $request)
    {
        $user = $request->user();

        $query = Conversation::query()
            ->with(['customer:id,name,role', 'admin:id,name,role'])
            ->orderByDesc('last_message_at');

        // customer hanya convo miliknya
        if ($user->role === 'customer') {
            $query->where('customer_id', $user->id);
        }

        // admin lihat semua (atau yang ditangani saja kalau mau)
        // ->where('admin_id', $user->id)

        return response()->json(['data' => $query->paginate(20)]);
    }

    // POST /api/chat/conversations (customer membuat / ambil yg sudah ada)
    public function createOrGet(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'customer') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $conv = Conversation::firstOrCreate(
            ['customer_id' => $user->id],
            ['admin_id' => null, 'last_message_at' => now()]
        );

        return response()->json(['data' => $conv]);
    }

    // GET /api/chat/conversations/{conversation}/messages
    public function messages(Request $request, Conversation $conversation)
    {
        $user = $request->user();

        // authorization simple (selaras dengan channels.php)
        if ($user->role === 'customer' && $conversation->customer_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $messages = Message::with(['sender:id,name,role'])
            ->where('conversation_id', $conversation->id)
            ->orderBy('id')
            ->paginate(50);

        return response()->json(['data' => $messages]);
    }

    // POST /api/chat/conversations/{conversation}/messages
    public function send(Request $request, Conversation $conversation)
    {
        $user = $request->user();

        if ($user->role === 'customer' && $conversation->customer_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'body' => ['required','string','min:1','max:2000'],
        ]);

        // auto assign admin kalau belum ada & pengirim admin
        if ($user->role === 'admin' && $conversation->admin_id === null) {
            $conversation->admin_id = $user->id;
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'body' => $validated['body'],
        ]);

        $conversation->last_message_at = now();
        $conversation->save();

        // broadcast realtime
        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'message' => 'Sent',
            'data' => $message->load('sender:id,name,role'),
        ], 201);
    }
}
