@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create New Category</div>
                    <div class="card-body">
                        <form method="post" action="{{route('categories.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="type_id">* Type</label>
                                <select class="form-control" id="type_id" name="type_id" required>
                                    @foreach($types as $type)
                                        <option value="{{$type->id}}">{{$type->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title_ar">* Title Ar</label>
                                <input type="text" class="form-control" id="title_ar" name="title_ar" required
                                       value="{{old('title_ar')}}">
                            </div>
                            <div class="form-group">
                                <label for="title_en">* Title En</label>
                                <input type="text" class="form-control" id="title_en" name="title_en" required
                                       value="{{old('title_en')}}">
                            </div>
                            <div class="form-group">
                                <label for="icon">* Icon</label>
                                <input type="file" class="form-control" id="icon" name="icon"
                                       accept="image/bmp,image/gif,image/jpeg,image/png," required>
                            </div>
                            <div class="form-group">
                                <label for="icon_filled">* Icon Filled</label>
                                <input type="file" class="form-control" id="icon_filled" name="icon_filled"
                                       accept="image/bmp,image/gif,image/jpeg,image/png," required>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" id="image" name="image"
                                       accept="image/bmp,image/gif,image/jpeg,image/png,">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
