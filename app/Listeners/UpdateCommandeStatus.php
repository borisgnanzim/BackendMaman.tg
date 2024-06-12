<?php

namespace App\Listeners;

use App\Events\PayementReceived;
use App\Models\Commande;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateCommandeStatus
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PayementReceived $event): void
    {
        //
        $commande = Commande::find($event->commande_id);
        if ($commande)
        {
            $commande->statut = "paye";
            $commande->save();
        }
    }
}
