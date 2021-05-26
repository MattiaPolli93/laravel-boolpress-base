@extends('layouts.base')

@section('pageTitle')
	{{$post->title}}
@endsection

@section('content')
	<p><strong>Date:</strong> {{$post->date}}</p>
	<p><strong>Status:</strong> {{$post->published ? 'published' : 'not published'}}</p>
    <div>
        <p><strong>Tags: </strong>
		@foreach ($post->tags as $tag)
			<span class="badge badge-primary">{{$tag->name}}</span>
		@endforeach
        </p>
	</div>
	<hr>
	<p>{{$post->content}}</p>

	@if ($post->comments->isNotEmpty())
	<div class="mt-5">
		<h3>Comments</h3>
		<ul>
			@foreach ($post->comments as $comment)
				<li>
					<h5><h5>{{$comment->name ? $comment->name : 'Anonymous'}}</h5>
					<p>{{$comment->content}}</p>
				</li>
			@endforeach
		</ul>
	</div>
	@endif
	<a href="{{route('admin.posts.index')}}">Back to Posts List</a>
@endsection