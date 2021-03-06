<?php

/**
 * Created by PhpStorm.
 * Role: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Tickets\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Tickets\Entities\Ticket;
use Modules\Tickets\Repositories\Contracts\TicketsRepository;

/**
 * Class EloquentTicketsRepository.
 */
class EloquentTicketsRepository extends RepositoryAbstract implements TicketsRepository
{
    public function model()
    {
        return Ticket::class;
    }

    public function duplicate($ticket): Ticket
    {
        $newTicket = $ticket->replicate();
        $newTicket->save();

        return $newTicket;
    }

    public function updateQuantity(int $id, int $quantity): Ticket
    {
        $ticket = $this->find($id);
        $newQuantity = (int)$ticket->quantity - $quantity;
        $newSale = (int)$ticket->sale + $quantity;

        return $this->update($id, ['quantity' => $newQuantity, 'sale' => $newSale]);
    }
}
