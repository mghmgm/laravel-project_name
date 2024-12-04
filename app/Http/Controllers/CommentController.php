<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Article;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Jobs\VeryLongJob;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index() {
        $comments = Comment::latest()->paginate(10);
        return view('comments.index', ['comments'=>$comments]);
    }

    public function store(Request $request){
        $article = Article::findOrFail($request->article_id);

        $request->validate([
            'name'=>'required|min:3',
            'desc'=>'required|max:256'
        ]);
        $comment = new Comment;
        $comment->name = request('name');
        $comment->desc = request('desc');
        $comment->article_id = request('article_id');
        $comment->user_id = Auth::id();
        $comment->save();
        if ($comment->save()) {
            VeryLongJob::dispatch($comment, $article->name);
            return redirect()->route('articles.show', $comment->article_id)
                ->with('status', 'New comment send to moderation');
        }

        return redirect()->route('articles.show', $comment->article_id)
                ->with('status', 'Add comment failed');
        
    }

    public function edit($id){
        $comment = Comment::findOrFail($id);
        Gate::authorize('update_comment', $comment);
        return view('comments.update', ['comment'=>$comment]);
    }

    public function update(Request $request, Comment $comment){
        Gate::authorize('update_comment', $comment);
        $request->validate([
            'name'=>'required|min:3',
            'desc'=>'required|max:256'
        ]);
        $comment->name = request('name');
        $comment->desc = request('desc');
        $comment->save();
        if ($comment->save()) return redirect()->route('articles.show', $comment->article_id)
        ->with('status', 'Comment update success');
        return redirect()->back()->with('status', 'Comment update failed');
    }
    
    public function destroy($id){
        $comment = Comment::findOrFail($id);
        Gate::authorize('update_comment', $comment);
        $comment->delete();
        return redirect()->route('articles.show', ['article'=>$comment->article_id])
        ->with('status','Delete success');
    }

    public function accept(Comment $comment) {
        $comment->accept = true;
        $comment->save();
        return redirect()->route('comment.index');
    }

    public function reject(Comment $comment) {
        $comment->accept = false;
        $comment->save();
        return redirect()->route('comment.index');
    }
}
