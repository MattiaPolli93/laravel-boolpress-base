@extends('layouts.base')

@section('pageTitle')
	Create a New Post
@endsection

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{route('admin.posts.store')}}" method="POST">
	@csrf
	@method('POST')
	<div class="form-group">
		<label for="title">Title</label>
		<input type="text" class="form-control" id="title" name="title" placeholder="Title">
	</div>
	<div class="form-group">
		<label for="date">Date</label>
		<input type="date" class="form-control" id="date" name="date" placeholder="Date">
	</div>
	<div class="form-group">
		<label for="content">Content</label>
		<textarea class="form-control"  name="content" id="content" cols="30" rows="10" placeholder="content"></textarea>
	</div>
	<div class="form-group">
		<label for="image">Image</label>
		<input type="text" class="form-control" id="image" name="image" placeholder="Image">
	</div>
	<div class="form-check form-check-inline">
		<input class="form-check-input" type="checkbox" id="published" name="published">
		<label class="form-check-label" for="published">Published</label>
	</div>
	<div class="mt-3">
		<button type="submit" class="btn btn-primary">Create</button>
	</div>
</form>

@endsection