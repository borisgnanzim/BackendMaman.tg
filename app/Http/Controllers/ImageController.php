<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Traits\JsonResponseTrait;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ImageResource;

class ImageController extends Controller
{
    use JsonResponseTrait;

    public function index()
    {
        $images = Image::all();
        return $this->successResponse(ImageResource::collection($images));
    }

    public function store(StoreImageRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $article_id = $request->article_id;
            $path = $request->file('image')->store("images/{$article_id}", 'public');

            $image = Image::create([
                'titre' => $request->titre,
                'description' => $request->description,
                'path' => $path,
                'article_id' => $article_id,
            ]);

            return $this->successResponse(new ImageResource($image), 'Image created successfully', 201);
        }

        return $this->errorResponse('Image not uploaded');
    }

    public function show(Image $image)
    {
        $relativePath = $image->path;

        if (!Storage::exists($relativePath)) {
            return $this->errorResponse('Image not found', 404);
        }

        $filePath = storage_path('app/public/' . $relativePath);
        return response()->file($filePath);
    }

    public function update(UpdateImageRequest $request, Image $image)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($image->path);
            $article_id = $request->article_id ?? $image->article_id;
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

        return $this->successResponse(new ImageResource($image), 'Image updated successfully');
    }

    public function destroy(Image $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return $this->successResponse(null, 'Image deleted successfully', 204);
    }

    public function download(Image $image)
    {
        $filePath = storage_path('app/public/' . $image->path);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return $this->errorResponse('File not found', 404);
        }
    }
}
