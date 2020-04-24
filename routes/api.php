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

Route::prefix('v1/')->group(function () {
    $type_slug = request()->header('type');
    $type = \App\Models\Type::query()->where('slug', $type_slug)->first();
    if (!$type_slug) {
        $type = \App\Models\Type::query()->firstOrFail();
    }
    abort_if(!$type, 404);
    Route::get('/', function () use ($type) {
        $images = \App\Models\Image::with('category')->whereHas('category', function ($query) use ($type) {
            $query->where('status', 1);
            $query->where('type_id', $type->id);
        })->orderByDesc('id')->paginate(10);
        return api_response($images, 'تمت العملية بنجاح', null);
    });

    Route::get('/categories', function () use ($type) {
        $categories = \App\Models\Category::query()->where([
            'status' => 1,
            'type_id' => $type->id,
        ])->orderBy('order_number', 'asc')->get();
        return api_response($categories, 'تمت العملية بنجاح', null);
    });

    Route::get('/categories/{category_id}/images', function ($category_id) use ($type) {
        $category = $type->categories()->where('status', 1)->findOrFail($category_id);
        $images = $category->images()->orderByDesc('images.id')->paginate(10);
        return api_response($images, 'تمت العملية بنجاح', null);
    });
});
