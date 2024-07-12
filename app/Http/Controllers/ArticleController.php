<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepositoryInterface;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CategorieResource;
use App\Http\Resources\ImageResource;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    use JsonResponseTrait;

    protected $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    // public function index()
    // {
    //     $articles = $this->articleRepository->all();
    //     return $this->successResponse(ArticleResource::collection($articles));
    // }
    public function index()
    {
        $articles = $this->articleRepository->paginate(30); // Fetch articles with pagination and sorting
        return $this-> successResponse([
            'articles' =>ArticleResource::collection($articles),
            'links' => [
            'first' => $articles->url(1),
            'last' => $articles->url($articles->lastPage()),
            'prev' => $articles->previousPageUrl(),
            'next' => $articles->nextPageUrl(),
        ],
        'meta' => [
            'current_page' => $articles->currentPage(),
            'from' => $articles->firstItem(),
            'last_page' => $articles->lastPage(),
            'path' => $articles->path(),
            'per_page' => $articles->perPage(),
            'to' => $articles->lastItem(),
            'total' => $articles->total(),
        ]
        ]);
    }

    public function store(StoreArticleRequest $request)
    {
        $article = $this->articleRepository->create($request->validated());
        return $this->successResponse(new ArticleResource($article), 'Article created successfully', 201);
    }

    public function show($id)
    { 
        $article = $this->articleRepository->find($id);
        return $this->successResponse(new ArticleResource($article));
    }

    public function update(UpdateArticleRequest $request, $id)
    {
        $article = $this->articleRepository->update($id, $request->validated());
        return $this->successResponse(new ArticleResource($article), 'Article updated successfully', 200);
    }

    public function destroy($id)
    {
        $this->articleRepository->delete($id);
        return $this->successResponse(null, 'Article deleted successfully', 204);
    }

    public function getImages($article_id)
    {
        $article = $this->articleRepository->find($article_id);
        $images = $article->images;

        $imageResources = ImageResource::collection($images);

        if ($images->isEmpty()) {
            return $this->errorResponse('No images found for this article', 404);
        }

        $firstImage = $images->first();
        $relativePath = $firstImage->path;

        if (!Storage::exists($relativePath)) {
            return $this->errorResponse('First image file not found', 404);
        }

        $filePath = storage_path('app/public/' . $relativePath);

        return response()->file($filePath);
    }

    public function getCategories($article_id)
    {
        $article = $this->articleRepository->find($article_id);
        return $this->successResponse(CategorieResource::collection($article->categories));
    }
}
