@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Images by {{$category->title}}</div>
                    <div class="card-body">
                        <a href="{{route('categories.images.create',['category'=>$category->id])}}"
                           class="btn btn-success float-right mb-3"><i
                                class="fas fa-plus"></i>
                            Create
                        </a>
                        <div class="clearfix"></div>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Image</th>
                                <th scope="col">Last update</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($images as $image)
                                <tr id="image-row-{{$image->id}}">
                                    <th scope="row">{{$image->id}}</th>
                                    <td><a href="{{$image->image}}" target="_blank"><img src="{{$image->image}}" height="30" alt=""></a></td>
                                    <td>{{\Carbon\Carbon::parse($image->updated_at)->diffForHumans()}}</td>
                                    <td>
                                        <a href="javascript:" class="btn btn-link text-danger delete-image"
                                           data-id="{{$image->id}}" data-category_id="{{$category->id}}"><i class="fas fa-trash"></i> Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$images->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
