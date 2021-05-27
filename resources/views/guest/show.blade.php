@extends('layouts.guest')

@section('pageTitle')
	{{$post->title}}
@endsection

@section('content')
<div class="mt-3">
    <h1 class="blog-post-title">{{$post->title}}</h1>
	<h4>{{$post->date}}</h4>
	<p>{{$post->content}}</p>

    {{-- Comments --}}
	<div class="mt-5 mb-3">
        @if ($post->comments->isNotEmpty())
		<h3>Comments</h3>
		<ul>
			@foreach ($post->comments as $comment)
				<li>
					<h5>{{$comment->name ? $comment->name : 'Anonymous'}}</>
					<p>{{$comment->content}}</p>
				</li>
			@endforeach
		</ul>
        @endif

    {{-- Add comment --}}
        <div class="mt-5">
            <h3>Add Comment</h3>
            <form action="{{route('guest.posts.add-comment', ['post' => $post->id])}}" method="post">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="content">Comment</label>
                    <textarea class="form-control"  name="content" id="content" cols="30" rows="5" placeholder="Comment"></textarea>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
	</div>
</div>
@endsection