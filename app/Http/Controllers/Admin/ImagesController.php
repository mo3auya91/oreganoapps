<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\UploadController;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Category $category
     * @return View
     */
    public function index(Category $category): View
    {
        $images = Image::query()->where('category_id', $category->id)->paginate(10);
        return view('admin.images.index', ['category' => $category, 'images' => $images]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Category $category
     * @return View
     */
    public function create(Category $category): View
    {
        return view('admin.images._create', ['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request, Category $category)//: RedirectResponse
    {
        try {
            error_reporting(E_ALL | E_STRICT);
            new UploadController($category->id);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('errors', [$e->getMessage()]);
        }
//        $this->validate($request, [
//            'files' => ['required', 'array'],
//            'files.*' => ['required', 'file', 'mimes:jpeg,jpg,png', 'max:' . max_upload_size()],
//        ]);
//        $now = now();
//        $items = [];
//        foreach ($request->file('files') as $image) {
//            array_push($items, [
//                'category_id' => $category->id,
//                'image' => str_replace('public/', 'storage/', $image->store('public/categories/' . $category->id . '/images')),
//                'created_at' => $now,
//                'updated_at' => $now,
//            ]);
//        }
//        $category->images()->insert($items);
//        return api_response([], 'Created successfully', null);
        //return back()->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @param Image $image
     * @return Image
     */
    public function show(Category $category, Image $image)
    {
        return $image;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @param Image $image
     * @return View
     */
    public function edit(Category $category, Image $image): View
    {
        return view('admin.images.edit', ['image' => $image]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @param Image $image
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Category $category, Image $image)
    {
        $this->validate($request, [
            'title' => ['required', 'string'],
            'slug' => ['required', 'string'],
        ]);
        $image->update([
            'title' => $request->get('title'),
            'slug' => $request->get('slug'),
        ]);
        return back()->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @param Image $image
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Category $category, Image $image): JsonResponse
    {
        $image->delete();
        return api_response([], 'Deleted successfully', null);
    }
}
