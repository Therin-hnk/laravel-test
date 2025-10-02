<?php

namespace App\Traits;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

trait ManagesQuantity
{
    public function decrementQuantity(Ticket $ticket, int $quantity): void
    {
        if ($quantity <= 0 || $quantity > $ticket->quantity) {
            throw new \InvalidArgumentException('Invalid quantity or insufficient stock.');
        }

        $ticket->decrement('quantity', $quantity);
    }

    public function incrementQuantity(Ticket $ticket, int $quantity): void
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('Invalid quantity.');
        }

        $ticket->increment('quantity', $quantity);
    }
}