<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Events\PayementReceived;
use App\Http\Requests\StorePayementRequest;
use App\Http\Requests\UpdatePayementRequest;
use App\Models\Payement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\JsonResponseTrait;
use App\Http\Resources\PayementResource;



/**
 * @group Payement Management
 * 
 * APIs to manage the Payements ressource
 **/
class PayementController extends Controller
{
    use JsonResponseTrait;

    public function index()
    {

        return $this->sucessResponseWithPaginate(
            PayementResource::class, 
            Payement::with(['user', 'commande'])->orderBy('created_at', 'desc')->paginate(20), 
            'payements'
            );

    }

    public function store(StorePayementRequest $request)
    {
        $payementData = $request->all();
        $payementData['user_id'] = Auth::id();
        $payement = Payement::create($payementData);
        event(new PayementReceived($payement->commande_id));

        return $this->successResponse(new PayementResource($payement), 'Payment received and status updated.', 201);
    }

    public function show($id)
    {
        $payement =Payement::find($id);
        if ($payement==null)
        {
            return $this-> errorResponse("Payement not found");
        }
        return $this->successResponse(new PayementResource($payement));
    }

    public function update(UpdatePayementRequest $request, $id)
    {
        $payementData = $request->all();
        $payementData['user_id'] = Auth::id();
        $payement =Payement::find($id);
        if ($payement==null)
        {
            return $this-> errorResponse("Payement not found");
        }
        $payement->update($payementData);
        return $this->successResponse(new PayementResource($payement), 'Payment updated successfully', 200);
    }

    public function destroy($id)
    {
        $payement =Payement::find($id);
        if ($payement==null)
        {
            return $this-> errorResponse("Payement not found");
        }
        $payement->delete();
        return $this->successResponse(null, 'Payment deleted successfully', 204);
    }
}
