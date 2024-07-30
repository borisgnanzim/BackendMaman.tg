<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateArticleController extends Controller
{
    //
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Creation de l'article 
            //$article = ;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
        
    }
}
