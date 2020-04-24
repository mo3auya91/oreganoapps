<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $categories = Category::query()->withCount('images')->get();
        return view('admin.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        $types = Type::all(['id', 'title']);
        return view('admin.categories.create', ['types' => $types]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'type_id' => ['required', 'exists:types,id'],
            'title_ar' => ['required', 'string'],
            'title_en' => ['required', 'string'],
            'order_number' => ['required', 'integer','min:1'],
            'icon' => ['required', 'file', 'mimes:jpeg,jpg,png', 'max:' . max_upload_size()],
            'icon_filled' => ['required', 'file', 'mimes:jpeg,jpg,png', 'max:' . max_upload_size()],
            'image' => ['nullable', 'file', 'mimes:jpeg,jpg,png', 'max:' . max_upload_size()],
        ]);
        $data = [
            'type_id' => $request->get('type_id'),
            'order_number' => $request->get('order_number'),
            'title_ar' => $request->get('title_ar'),
            'title_en' => $request->get('title_en'),
            'icon' => str_replace('public/', 'storage/', $request->file('icon')->store('public/categories')),
            'icon_filled' => str_replace('public/', 'storage/', $request->file('icon_filled')->store('public/categories')),
        ];
        if ($request->hasFile('image')) {
            $data['image'] = str_replace('public/', 'storage/', $request->file('image')->store('public/categories'));
        }
        Category::query()->create($data);
        return back()->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     * @param Category $category
     * @return Category
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        $types = Type::all(['id', 'title']);
        return view('admin.categories.edit', ['types' => $types, 'category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'type_id' => ['required', 'exists:types,id'],
            'title_ar' => ['required', 'string'],
            'title_en' => ['required', 'string'],
            'order_number' => ['required', 'integer','min:1'],
            'icon' => ['nullable', 'file', 'mimes:jpeg,jpg,png', 'max:' . max_upload_size()],
            'icon_filled' => ['nullable', 'file', 'mimes:jpeg,jpg,png', 'max:' . max_upload_size()],
            'image' => ['nullable', 'file', 'mimes:jpeg,jpg,png', 'max:' . max_upload_size()],
        ]);
        $data = [
            'order_number' => $request->get('order_number'),
            'title_ar' => $request->get('title_ar'),
            'title_en' => $request->get('title_en'),
        ];
        if ($request->hasFile('icon')) {
            $data['icon'] = str_replace('public/', 'storage/', $request->file('icon')->store('public/categories'));
        }

        if ($request->hasFile('icon_filled')) {
            $data['icon_filled'] = str_replace('public/', 'storage/', $request->file('icon_filled')->store('public/categories'));
        }

        if ($request->hasFile('image')) {
            $data['image'] = str_replace('public/', 'storage/', $request->file('image')->store('public/categories'));
        }

        $category->update($data);
        return back()->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param Category $category
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return api_response([], 'Deleted successfully', null);
    }

    /**
     * Update Category status (enable/disable)
     *
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updateStatus(Request $request, Category $category)
    {
        $this->validate($request, ['status' => ['required', 'in:0,1']]);
        $category->update(['status' => $request->get('status')]);
        return back()->with('success', 'Updated successfully');
    }
}
