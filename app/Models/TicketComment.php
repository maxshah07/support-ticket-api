<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['body'])]
class TicketComment extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }
}
