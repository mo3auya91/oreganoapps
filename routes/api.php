<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::domain('{type}.' . env('APP_URL'))->group(function () {
    Route::get('/', function ($type) {
        $type = \App\Models\Type::query()->where('slug', $type)->firstOrFail();
        $images = \App\Models\Image::with('category')->whereHas('category', function ($query) use ($type) {
            $query->where('type_id', $type->id);
        })->orderByDesc('id')->paginate(10);
        return api_response($images, 'تمت العملية بنجاح', null);
    });

    Route::get('/categories', function ($type) {
        $type = \App\Models\Type::query()->where('slug', $type)->firstOrFail();
        $categories = \App\Models\Category::query()->where('type_id', $type->id)->get();
        return api_response($categories, 'تمت العملية بنجاح', null);
    });

    Route::get('/categories/{category_id}/images', function ($type, $category_id) {
        $type = \App\Models\Type::query()->where('slug', $type)->firstOrFail();
        $category = $type->categories()->findOrFail($category_id);
        $images = $category->images()->paginate(10);
        return api_response($images, 'تمت العملية بنجاح', null);
    });
});
