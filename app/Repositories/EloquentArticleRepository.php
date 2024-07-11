<?php

namespace App\Repositories;

use App\Models\Article;

class EloquentArticleRepository implements ArticleRepositoryInterface
{
    public function all()
    {
        return Article::with('images','categories')->get();
    }
    public function paginate($perPage)
    {
        return Article::with('images','categories')->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return Article::with('images')->find($id);
    }

    public function create(array $data)
    {
        return Article::create($data);
    }

    public function update($id, array $data)
    {
        $article = Article::find($id);
        if ($article) {
            if (isset($data['prix']) && $article->prix != $data['prix']) {
                $data['ancienPrix'] = $article->prix;
            }
            $article->update($data);
            return $article;
        }
        return null;
    }

    public function delete($id)
    {
        $article = Article::find($id);
        if ($article) {
            return $article->delete();
        }
        return false;
    }
}
