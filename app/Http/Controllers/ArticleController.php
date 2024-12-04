<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Events\NewArticleEvent;

class ArticleController extends Controller
{

    public function index()
    {
        $articles=Article::latest()->paginate(6);
        return view('articles.index', ['articles'=>$articles]);
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', self::class);
        $request->validate([
            'date'=>'date',
            'name'=>'required|min:5|max:100',
            'desc'=>'required|min:5'
        ]);
        $article = new Article;
        $article->date = $request->date;
        $article->name = $request->name;
        $article->desc = $request->desc;
        $article->user_id = 1;
        if ($article->save()) {
            NewArticleEvent::dispatch($article);
        };
        return redirect('/articles');
    }

    public function show(Article $article)
    {
        $comments = Comment::where('article_id', $article->id)
            ->where('accept', true)
            ->get();
        $user = User::findOrFail($article->user_id);
        return view('articles.show', ['article'=>$article, 'user'=>$user, 'comments'=>$comments]);
    }

    public function edit(Article $article)
    {
        return view('articles.update', ['article' => $article]);
    }

    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', $article);
        $request->validate([
            'name'=>'required|min:6',
            'desc'=>'required|max:256'
        ]);
        $article = new Article;
        $article->date = request('date');
        $article->name = request('name');
        $article->desc = request('desc');
        $article->user_id = 1;
        $article->save();
        return redirect()->route('articles.index');
    }

    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);
        $article->delete();
        return redirect('/articles');
    }
}
