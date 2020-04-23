<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class TypesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $types = Type::all();
        return view('admin.types.index', ['types' => $types]);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return view('admin.types.create');
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
            'title' => ['required', 'string'],
            'slug' => ['required', 'string'],
        ]);
        Type::query()->create([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('slug')),
        ]);
        return back()->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     * @param Type $type
     * @return Type
     */
    public function show(Type $type)
    {
        return $type;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Type $type
     * @return View
     */
    public function edit(Type $type): View
    {
        return view('admin.types.edit', ['type' => $type]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Type $type
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Type $type)
    {
        $this->validate($request, [
            'title' => ['required', 'string'],
            'slug' => ['required', 'string'],
        ]);
        $type->update([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('slug')),
        ]);
        return back()->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param Type $type
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Type $type): JsonResponse
    {
        $type->delete();
        return api_response([], 'Deleted successfully', null);
    }
}
