<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\CategorieArticle;
use App\Models\Image;
use App\Repositories\ArticleRepositoryInterface;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateArticleController extends Controller
{
    //
    use JsonResponseTrait;

    protected $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }
    public function store(CreateArticleRequest $request)
    {
        DB::beginTransaction();
        try {
            // Creation de l'article 
            $articleData = $request->only(['nom', 'description', 'mini_description', 'prix', 'quantite']);
            $article = $this->articleRepository->create($articleData) ;

            // Création des images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $imagePath = $imageFile->store("images/{$article->id}", 'public');
                    $imageData = [
                        'path' => $imagePath,
                        'article_id' => $article->id,
                    ];
                    Image::create($imageData);
                }
            } else {
                return $this->errorResponse('No images uploaded', 400);
            }

            // Attribution des catégories
            if ($request->has('categorie_ids')) {
                foreach ($request->categorie_ids as $categorieId) {
                    $categorieArticleData = [
                        'categorie_id' => $categorieId,
                        'article_id' => $article->id,
                    ];
                    CategorieArticle::create($categorieArticleData);
                }
            } else {
                return $this->errorResponse('No categories provided', 400);
            }


            DB::commit();
            return $this->successResponse(new ArticleResource($article), 'Article created successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to create article: ' . $e->getMessage(), 500);
        }
        
    }
}
