<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use Illuminate\Auth\Events\Validated;
use App\Http\Resources\ArticleResource;
use Illuminate\Support\Facades\Storage;
use RahulHaque\Filepond\Facades\Filepond;

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

        /* vérifie si fichier est une image*/
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
    public function update(Request $request, Article $article)
    {
        $article->update($request->validated());

        // Single and multiple file validation
        $this->validate($request, [
              'avatar' => Rule::filepond([
                'required',
                'image',
                'max:2000'
            ]),
        ]);
        // Set filename
        $avatarName = 'avatar-' . 1;

        $fileInfo = Filepond::field($request->avatar)
            ->moveTo('avatars/' . $avatarName);

        

        return response()->json([
            'data' => $fileInfo,
        ]);
/*         return new ArticleResource($article);
 */    }

    

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
