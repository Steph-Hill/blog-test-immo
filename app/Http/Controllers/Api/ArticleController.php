<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /* liste des articles */
        return ArticleResource::collection(Article::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        /* creer un nouvel Article */
        $article = Article::create($request->validated());

        /* vérifie si l'image existe */
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file_path = $file->storeAs('uploads/images', $file_name, 'public');

            /* attribue un chemin a l'image */
            $article->image = '/storage/' . $file_path;
            $article->save();
        }

        /* retourn la nouvelle instance del'article creer */
        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        /* retourn nouvelle instance del'article demandé */
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {
        /* met a jour l'article avec les vaditations effectuées */
        $article->update($request->validated());

        $this->extractData($article, $request);

        /* retourn une nouvelle instance de l'article mis a jour*/
        return new ArticleResource($article);
    }

    private function extractData(Article $article, ArticleRequest $request): array
    {
        $data = $request->validated();
        $image = $request->validated('image');

        if ($image == null || $image->getError()) {
            return $data;
        }
        /* supprime l'ancienne image */
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $file_name = time() . '_' . $image->getClientOriginalName();
        $data['image'] = $image->storeAs('uploads/images', $file_name, 'public');

        return $data;
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        /* supprime l'article de la base de données */
        $article->delete();

        /* retourne la page reponse http sans l'article supprimé*/
        return response()->noContent();
    }
}
