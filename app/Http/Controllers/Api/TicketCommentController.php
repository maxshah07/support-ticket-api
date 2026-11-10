<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketCommentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        if($ticket->user_id !== $user->id) {
            abort(404);
        }

        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $comment = $ticket->comments()->make($validated);

        $comment->user()->associate($user); 

        $comment->save();

        return response()->json($comment, 201);
    }
}
