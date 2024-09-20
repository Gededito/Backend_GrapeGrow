<?php

namespace App\Http\Controllers;

use App\Models\CategoryClass;
use App\Http\Requests\StoreCategoryClassRequest;
use App\Http\Requests\UpdateCategoryClassRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryClassController extends Controller
{
    public function index(Request $request)
    {
        $categoryClass = CategoryClass::orderByDesc('id')->get();
        return view('pages.category_class.index', compact('categoryClass'));
    }

    public function create()
    {
        return view('pages.category_class.create');
    }

    public function store(StoreCategoryClassRequest $request)
    {
        DB::transaction(function () use ($request) {

            $validated = $request->validated();

            if ($request->hasFile('thumbnail_category')) {
                $thumbnailPath = $request->file('thumbnail_category')->store('thumbnails_category', 'public');
                $validated['thumbnail_category'] = $thumbnailPath;
            } else {
                $thumbnailPath = 'images/icon-default.png';
            }

            $categoryClass = CategoryClass::create($validated);
        });

        return redirect()->route('category_class.index');
    }

    public function show(CategoryClass $categoryClass)
    {
        return view('pages.category_class.edit', compact('categoryClass'));
    }

    public function edit(CategoryClass $categoryClass)
    {
        return view('pages.category_class.edit', compact('categoryClass'));
    }

    public function update(UpdateCategoryClassRequest $request, CategoryClass $categoryClass)
    {
        DB::transaction(function () use ($request, $categoryClass) {

            $validated = $request->validated();

            if ($request->hasFile('thumbnail_category')) {
                $thumbnailPath = $request->file('thumbnail_category')->store('thumbnails_category', 'public');
                $validated['thumbnail_category'] = $thumbnailPath;
            }

            $categoryClass->update($validated);
        });

        return redirect()->route('category_class.index', $categoryClass);
    }

    public function destroy(CategoryClass $categoryClass)
    {
        DB::beginTransaction();

        try {
            $categoryClass->delete();
            DB::commit();

            return redirect()->route('pages.category_class.index');
        } catch(\Exception $e) {
            DB::rollBack();

            return redirect()->route('category_class.index')
            ->with('error', 'Terjadi Error');
        }
    }
}
