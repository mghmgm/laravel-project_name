@extends('layout')
@section('content')
@use('App\Models\User', 'User')

<table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">Author</th>
    </tr>
  </thead>
  <tbody>
    @foreach($articles as $article)
    <tr>
      <th scope="row">{{$article->date}}</th>
      <td><a href="/articles/{{ $article->id }}">{{$article->name}}</a></td>
      <td>{{$article->desc}}</td>
      <td>{{User::findOrFail($article->user_id)->name}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $articles->links() }}
@endsection