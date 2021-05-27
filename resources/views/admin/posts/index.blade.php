@extends('layouts.base')

@section('pageTitle')
	Post-List
@endsection

@section('content')

<div class="mb-3 text-center">
	<a href="{{route('admin.posts.create')}}"><button type="button" class="btn btn-success">Add Post <i class="fas fa-plus-square"></i></button></a>
</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Image</th>
			<th scope="col">Title</th>
			<th scope="col">Date</th>
			<th scope="col">Published</th>
			<th scope="col">N° Comments</th>
			<th scope="col">Actions</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($posts as $post)
		<tr>
			<td><img src="{{$post->image ? $post->image : 'https://via.placeholder.com/200'}}" alt="{{$post->title}}" style="width: 100px"></td>
			<td>{{$post->title}}</td>
			<td>{{$post->date}}</td>
			<td>{!! $post->published ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>'!!}</td>
            <td>{{count($post->comments)}}</td>
			<td>
				<a href="{{route('admin.posts.show', ['post' => $post->id])}}"><button type="button" class="btn btn-primary"><i class="fas fa-search"></i></button></a>
				<a href="{{route('admin.posts.edit', ['post' => $post->id])}}"><button type="button" class="btn btn-success"><i class="fas fa-pencil-alt"></i></button></a>
				<form action="{{route('admin.posts.destroy', ['post' => $post->id])}}" method="POST">
					@csrf
					@method('DELETE')
					<button type="submit" class="btn btn-danger mt-1"><i class="fas fa-trash"></i></button>
				</form>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>

@if (session('message'))
    <div class="alert alert-success" style="position: fixed; bottom: 30px; right: 30px">
        {{session('message')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
    </div>
@endif

@endsection