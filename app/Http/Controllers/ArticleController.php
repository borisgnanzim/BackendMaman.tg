<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepositoryInterface;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Traits\JsonResponseTrait;

class ArticleController extends Controller
{
    use JsonResponseTrait;

    protected $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function index()
    {
        $articles = $this->articleRepository->all();
        return $this->successResponse($articles);
    }

    public function store(StoreArticleRequest $request)
    {
        $article = $this->articleRepository->create($request->validated());
        return $this->successResponse($article, 'Article created successfully', 201);
    }

    public function show($id)
    { 
        $article = $this->articleRepository->find($id);
        return $this->successResponse($article);
    }

    public function update(UpdateArticleRequest $request, $id)
    {
        $article = $this->articleRepository->update($id, $request->validated());
        return $this->successResponse($article, 'Article updated successfully', 200);
    }

    public function destroy($id)
    {
        $this->articleRepository->delete($id);
        return $this->successResponse(null, 'Article deleted successfully', 204);
    }

    public function getImages($article_id)
    {
        $article = $this->articleRepository->find($article_id);
        return $this->successResponse($article->images);
    }

    public function getCategories($article_id)
    {
        $article = $this->articleRepository->find($article_id);
        return $this->successResponse($article->categories);
    }
}
