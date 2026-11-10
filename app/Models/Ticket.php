<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'description', 'status', 'priority'])]
class Ticket extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(TicketComment::class);
    }
}
