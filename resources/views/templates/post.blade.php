@extends('layouts.main')

@section('container')
    <article>
        <h1 class="mb-3">{{$post->title}}</h1>

        <p>By: Jason Aldeo in <a href="/categories/{{$post->category->slug}}">{{$post->category->name}}</a></p>

{{--        {{$post->body}}--}}
        {!! $post->body !!}

    </article>

    <a href="/posts">Back to posts</a>
@endsection

