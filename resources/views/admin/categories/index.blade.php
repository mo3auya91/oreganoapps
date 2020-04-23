@extends('layouts.app')

@section('content')
    {{--    <div class="container">--}}
    <div class="col-md-12">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">Categories</div>
                <div class="card-body">
                    <a href="{{route('categories.create')}}" class="btn btn-success float-right mb-3"><i
                            class="fas fa-plus"></i>
                        Create
                    </a>
                    <div class="clearfix"></div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title En</th>
                            <th scope="col">Type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Icon</th>
                            <th scope="col">Icon Filled</th>
                            <th scope="col">Image</th>
                            <th scope="col"># Images</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr id="category-row-{{$category->id}}">
                                <th scope="row">{{$category->id}}</th>
                                <td>{{$category->title_en}}</td>
                                <td>{{$category->type->title}}</td>
                                <td>{{$category->status?'Active':'Inactive'}}</td>
                                <td><img src="{{$category->icon}}" height="30" alt="{{$category->title_ar}}"></td>
                                <td><img src="{{$category->icon_filled}}" height="30" alt="{{$category->title_en}}">
                                </td>
                                <td><img src="{{$category->image}}" height="30" alt="{{$category->title_en}}"></td>
                                <td>
                                    ({{$category->images_count}})
                                    <a href="{{route('categories.images.index',['category'=>$category->id])}}"
                                       class="btn btn-link"><i
                                            class="fas fa-eye"></i> Show</a>
                                </td>
                                <td>
                                    <a href="{{route('categories.status',['category'=>$category->id,'status'=>$category->status?0:1])}}"
                                       class="btn btn-link"><i
                                            class="fas fa-edit"></i> {{$category->status?'Disable':'Enable'}}</a> |
                                    <a href="{{route('categories.edit',['category'=>$category->id])}}"
                                       class="btn btn-link"><i
                                            class="fas fa-edit"></i> Edit</a> |
                                    <a href="javascript:" class="btn btn-link text-danger delete-category"
                                       data-id="{{$category->id}}"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--    </div>--}}
@endsection
