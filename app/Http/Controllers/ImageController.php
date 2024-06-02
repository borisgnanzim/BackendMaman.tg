<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Image::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'path' => 'required|string',
            'article_id' => 'required|exists:articles,id'
        ]);

        $image = Image::create($validatedData);

        return response()->json($image, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
        return $image;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        //
        $validatedData = $request->validate([
            'path' => 'sometimes|required|string',
            'article_id' => 'sometimes|required|exists:articles,id'
        ]);

        $image->update($validatedData);

        return response()->json($image, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
        $image->delete();

        return response()->json(null, 204);
    }
}
