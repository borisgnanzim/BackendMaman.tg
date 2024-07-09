<?php
namespace App\Http\Controllers;

use App\Events\PayementReceived;
use App\Http\Requests\StorePayementRequest;
use App\Http\Requests\UpdatePayementRequest;
use App\Models\Payement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayementController extends Controller
{
    public function index()
    {
        // Récupérer tous les paiements avec les informations utilisateur et commande
        $payements = Payement::with(['user', 'commande'])->get();

        // Transformer les données pour inclure le nom de l'utilisateur et la référence de la commande
        $payements = $payements->map(function($payement) {
            return [
                'id' => $payement->id,
                'reference' => $payement->reference,
                'titre' => $payement->titre,
                'solde' => $payement->solde,
                'modePayement' => $payement->modePayement,
                'date' => $payement->date,
                'user_id' => $payement->user->id,
                'user_nom_complet' => $payement->user->nom . ' ' . $payement->user->prenom,
                'commande_id' => $payement->commande->id,
                'commande_reference' => $payement->commande->reference, // Assurez-vous que la commande a un champ 'reference'
            ];
        });

        return response()->json($payements);
    }

    public function store(StorePayementRequest $request)
    {
        $validatedData = $request->validated();

        $payement = Payement::create($validatedData);
        event(new PayementReceived($payement->commande_id));


        // return response()->json($payement, 201);
        return response()->json([
            'message' => 'Payment received and status updated.',
            'payement' => $payement], 
            201);

    }

    public function show(Payement $payement)
    {
        return $payement;
    }

    public function update(UpdatePayementRequest $request, Payement $payement)
    {
        $validatedData = $request->validated();

        $payement->update($validatedData);

        return response()->json($payement, 200);
    }

    public function destroy(Payement $payement)
    {
        $payement->delete();

        return response()->json(null, 204);
    }
}
