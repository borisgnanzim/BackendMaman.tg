<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepositoryInterface;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class ArticleController extends Controller
{
    protected $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function index()
    {
        $articles = $this->articleRepository->all();
        return response()->json($articles);
    }

    public function store(StoreArticleRequest $request)
    {
        $article = $this->articleRepository->create($request->validated());
        return response()->json($article, 201);
    }

    public function show($id)
    {
        $article = $this->articleRepository->find($id);
        return response()->json($article);
    }

    public function update(UpdateArticleRequest $request, $id)
    {
        $article = $this->articleRepository->update($id, $request->validated());
        return response()->json($article, 200);
    }

    public function destroy($id)
    {
        $this->articleRepository->delete($id);
        return response()->json(null, 204);
    }

    public function getImages($article_id)
    {
        $article = $this->articleRepository->find($article_id);
        return response()->json($article->images);
    }

    public function getCategories($article_id)
    {
        $article = $this->articleRepository->find($article_id);
        return response()->json($article->categories);
    }
}
