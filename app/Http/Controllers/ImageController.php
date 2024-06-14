<?php
namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        return Image::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'article_id' => 'required|exists:articles,id',
        ]);

        // if ($request->hasFile('image')) {
        //     $path = $request->file('image')->store('images', 'public');
        //     $image = Image::create([
        //         'titre' => $request->titre,
        //         'description' => $request->description,
        //         'path' => $path,
        //         'article_id' => $request->article_id,
        //     ]);

        //     return response()->json($image, 201);
        // }

        if ($request->hasFile('image')) {
            $article_id = $request->article_id;
            // Stocker l'image dans un dossier basé sur l'ID de l'article
            $path = $request->file('image')->store("images/{$article_id}", 'public');

            $image = Image::create([
                'titre' => $request->titre,
                'description' => $request->description,
                'path' => $path,
                'article_id' => $article_id,
            ]);

            return response()->json($image, 201);
        }

        return response()->json(['error' => 'Image not uploaded'], 400);
    }

    public function show(Image $image)
    {
        return response()->json($image);
    }

    public function update(Request $request, Image $image)
    {
        $validatedData = $request->validate([
            'titre' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'article_id' => 'sometimes|required|exists:articles,id',
        ]);

        // if ($request->hasFile('image')) {
        //     Storage::disk('public')->delete($image->path);
        //     $path = $request->file('image')->store('images', 'public');
        //     $image->update([
        //         'titre' => $request->titre ?? $image->titre,
        //         'description' => $request->description ?? $image->description,
        //         'path' => $path,
        //         'article_id' => $request->article_id ?? $image->article_id,
        //     ]);
        // } else {
        //     $image->update($request->only(['titre', 'description', 'article_id']));
        // }

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            Storage::disk('public')->delete($image->path);
            $article_id = $request->article_id ?? $image->article_id;
            // Stocker la nouvelle image dans le bon dossier
            $path = $request->file('image')->store("images/{$article_id}", 'public');
            $image->update([
                'titre' => $request->titre ?? $image->titre,
                'description' => $request->description ?? $image->description,
                'path' => $path,
                'article_id' => $article_id,
            ]);
        } else {
            $image->update($request->only(['titre', 'description', 'article_id']));
        }

        return response()->json($image, 200);
    }

    public function destroy(Image $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return response()->json(null, 204);
    }

    public function download(Image $image)
    {
        $filePath = storage_path('app/public/' . $image->path);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
}
