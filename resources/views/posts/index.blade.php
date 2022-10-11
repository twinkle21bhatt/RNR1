@extends('module.layout')
     
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>CRUD </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('userpost.create') }}"> Create New post</a>
            </div>
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
     
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>title</th>
            <th>Image</th>
            <th>Description</th>
            <th>Status</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($posts as $post)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $post->title }}</td>
            <td><img src="/image/{{ $post->image }}" width="100px"></td>
            <td>{{$post->description}}
            <td>{{ $post->status }}</td>
            <td>
                <a href="{{ route('userpost.edit',$post->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <form action="{{ route('userpost.destroy', $post->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    
    {{-- {!! $modules->links() !!} --}}
        
@endsection