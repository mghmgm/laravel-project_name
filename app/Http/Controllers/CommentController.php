<?php

namespace App\Http\Controllers;
use App\Models\Comment;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'name'=>'required|min:3',
            'desc'=>'required|max:256'
        ]);
        $comment = new Comment;
        $comment->name = request('name');
        $comment->desc = request('desc');
        $comment->article_id = request('article_id');
        $comment->user_id = 1;
        $comment->save();
        // return redirect()->back();
        if ($comment->save()) return redirect()->route('articles.show', $comment->article_id)
            ->with('status', 'Add comment success');
        return redirect()->route('articles.show', $comment->article_id)
        ->with('status', 'Add comment failed');
    }

    public function edit($id){
        $comment = Comment::findOrFail($id);
        return view('comments.update', ['comment'=>$comment]);
    }

    public function update(Request $request, Comment $comment){
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
    
    public function delete($id){
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->route('articles.show', ['article'=>$comment->article_id])
        ->with('status','Delete success');
    }
}
