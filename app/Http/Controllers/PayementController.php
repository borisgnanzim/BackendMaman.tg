<?php
namespace App\Http\Controllers;

use App\Events\PayementReceived;
use App\Models\Payement;
use Illuminate\Http\Request;

class PayementController extends Controller
{
    public function index()
    {
        return Payement::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'solde' => 'required|numeric',
            'modePayement' => 'required|string|max:255',
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'commande_id' => 'required|exists:commandes,id'
        ]);

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

    public function update(Request $request, Payement $payement)
    {
        $validatedData = $request->validate([
            'titre' => 'sometimes|required|string|max:255',
            'solde' => 'sometimes|required|numeric',
            'modePaiment' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'user_id' => 'sometimes|required|exists:users,id',
            'commande_id' => 'sometimes|required|exists:commandes,id'
        ]);

        $payement->update($validatedData);

        return response()->json($payement, 200);
    }

    public function destroy(Payement $payement)
    {
        $payement->delete();

        return response()->json(null, 204);
    }
}
