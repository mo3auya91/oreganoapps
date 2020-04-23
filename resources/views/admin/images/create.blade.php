@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Add New Images to {{$category->title}}</div>
                    <div class="card-body">
                        <form method="post" action="{{route('categories.images.store',['category'=>$category->id])}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="images">* Images</label>
                                <input type="file" name="images[]" multiple id="images" required
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
