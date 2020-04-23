@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Types</div>
                    <div class="card-body">
                        <a href="{{route('types.create')}}" class="btn btn-success float-right mb-3"><i
                                class="fas fa-plus"></i>
                            Create
                        </a>
                        <div class="clearfix"></div>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Last Update</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($types as $type)
                                <tr id="type-row-{{$type->id}}">
                                    <th scope="row">{{$type->id}}</th>
                                    <td>{{$type->title}}</td>
                                    <td>{{$type->slug}}</td>
                                    <td>{{\Carbon\Carbon::parse($type->updated_at)->diffForHumans()}}</td>
                                    <td>
                                        <a href="{{route('types.edit',['type'=>$type->id])}}" class="btn btn-link"><i
                                                class="fas fa-eye"></i> Edit</a> |
                                        <a href="javascript:" class="btn btn-link text-danger delete-type"
                                           data-id="{{$type->id}}"><i class="fas fa-trash"></i> Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
