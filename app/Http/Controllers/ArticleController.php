<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Events\NewArticleEvent;

class ArticleController extends Controller
{

    public function index()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $articles = Cache::remember('articles'.$page, 3000, function() {
            return Article::latest()->paginate(6);
        });
        return view('articles.index', ['articles'=>$articles]);
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key' => 'articles*[0-9]'])->get();
        foreach($keys as $param) {
            Cache::forget($param->key);
        };
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
        if (isset($_GET['notify'])) auth()->user()->notifications->where('id', $_GET['notify'])->first()->markAsRead();
        $result = Cache::rememberForever('comment_article', function()use($article){
            $comments = Comment::where('article_id', $article->id)
                ->where('accept', true)
                ->get();
            $user = User::findOrFail($article->user_id);
            return [
                'comments'=>$comments,
                'user'=>$user
            ];
        });
        return view('articles.show', ['article'=>$article, 'user'=>$result['user'], 'comments'=>$result['comments']]);
    }

    public function edit(Article $article)
    {
        return view('articles.update', ['article' => $article]);
    }

    public function update(Request $request, Article $article)
    {
        $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key' => 'articles*[0-9]'])->get();
        foreach($keys as $param) {
            Cache::forget($param->key);
        };
        Gate::authorize('update', $article);
        $request->validate([
            'name'=>'required|min:6',
            'desc'=>'required|max:256'
        ]);
        $article->date = request('date');
        $article->name = request('name');
        $article->desc = request('desc');
        $article->user_id = 1;
        $article->save();
        return redirect()->route('articles.index');
    }

    public function destroy(Article $article)
    {
        Cache::flush();
        Gate::authorize('delete', $article);
        $article->delete();
        return redirect('/articles');
    }
}
