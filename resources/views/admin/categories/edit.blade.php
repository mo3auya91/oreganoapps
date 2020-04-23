@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Update {{$category->title_en . ' - ' . $category->title_ar}}</div>
                    <div class="card-body">
                        <form method="post" action="{{route('categories.update',['category'=>$category->id])}}"
                              enctype="multipart/form-data">
                            @method('patch')
                            @csrf
                            <div class="form-group">
                                <label for="type_id">* Type</label>
                                <select class="form-control" id="type_id" name="type_id" required>
                                    @foreach($types as $type)
                                        @php
                                            $selected = '';
                                            /**
                                             * @var \App\Models\Type $type
                                             * @var \App\Models\Category $category
                                             */
                                            if ($type->id == $category->type_id) {
                                                $selected = 'selected';
                                            }
                                        @endphp
                                        <option value="{{$type->id}}" {{$selected}}>{{$type->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title_ar">* Title Ar</label>
                                <input type="text" class="form-control" id="title_ar" name="title_ar" required
                                       value="{{old('title_ar',$category->title_ar)}}">
                            </div>
                            <div class="form-group">
                                <label for="title_en">* Title En</label>
                                <input type="text" class="form-control" id="title_en" name="title_en" required
                                       value="{{old('title_en',$category->title_en)}}">
                            </div>
                            <div class="form-group">
                                <label for="icon">* Icon</label>
                                <div class="">
                                    <div class="thumbnail"
                                         onclick="document.getElementById('_icon').click()" style="cursor:pointer;">
                                        <img src="{{asset($category->icon)}}" style="height: 200px;" alt="">
                                    </div>
                                    <input type="file" class="form-control edit_image d-none" id="_icon" name="icon"
                                           accept="image/bmp,image/gif,image/jpeg,image/png,">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="icon_filled">* Icon Filled</label>
                                <div class="">
                                    <div class="thumbnail"
                                         onclick="document.getElementById('_icon_filled').click()"
                                         style="cursor:pointer;">
                                        <img src="{{asset($category->icon_filled)}}" style="height: 200px;" alt="">
                                    </div>
                                    <input type="file" class="form-control edit_image d-none" id="_icon_filled"
                                           name="icon_filled"
                                           accept="image/bmp,image/gif,image/jpeg,image/png,">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <div class="">
                                    <div class="thumbnail"
                                         onclick="document.getElementById('_image').click()" style="cursor:pointer;">
                                        <img src="{{asset($category->image)}}" style="height: 200px;" alt="">
                                    </div>
                                    <input type="file" class="form-control edit_image d-none" id="_image" name="image"
                                           accept="image/bmp,image/gif,image/jpeg,image/png,">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
