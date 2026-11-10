<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index(Request $request) {
        $validated = $request->validate([
            'status' => 'sometimes|in:open,in_progress,closed',
            'priority' => 'sometimes|in:low,medium,high'
        ]);

        $status = $validated['status'] ?? null;
        $priority = $validated['priority'] ?? null;

        $user = $request->user();

        $tickets = $user->tickets()
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($priority, function ($query) use ($priority) {
                $query->where('priority', $priority);
            })
            ->paginate(10)
            ->withQueryString();

        return response()->json($tickets);
    }

    public function show(Request $request, Ticket $ticket)
    {
        if($ticket->user_id !== $request->user()->id) {
            abort(404);
        }

        return response()->json($ticket);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'sometimes|in:low,medium,high'
        ]);

        $user = $request->user();
        $ticket = $user->tickets()->create($validated);

        $ticket->refresh();

        return response()->json($ticket, 201);
    }

    public function update(Request $request, Ticket $ticket)
    {
        if($ticket->user_id !== $request->user()->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'status' => 'sometimes|in:open,in_progress,closed',
            'priority' => 'sometimes|in:low,medium,high'
        ]);

        $ticket->update($validated);

        return response()->json($ticket);
    }

    public function destroy(Request $request, Ticket $ticket) 
    {
        if($ticket->user_id !== $request->user()->id) {
            abort(404);
        }

        $ticket->delete();

        return response()->noContent();
    }
}
