<?php

namespace App\Http\Controllers;

use App\Models\ClassVideo;
use App\Models\CategoryClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Requests\StoreClassVideoRequest;
use App\Http\Requests\UpdateClassVideoRequest;

class ClassVideoController extends Controller
{
    public function index()
    {
        $query = ClassVideo::with('categoryClass')->orderByDesc('id');
        $classVideo = $query->paginate(10);

        return view('pages.course_video.index', compact('classVideo'));
    }

    public function create()
    {
        $categoryClass = CategoryClass::all();
        return view('pages.course_video.create', ['categoryClass' => $categoryClass]);
    }

    public function store(StoreClassVideoRequest $request)
    {
        DB::transaction(function () use ($request) {

            $validated = $request->validated();

            if ($request->hasFile('thumbnail_video')) {
                $thumbnailPath = $request->file('thumbnail_video')->store('thumbnails_video', 'public');
                $validated['thumbnail_video'] = $thumbnailPath;
            } else {
                $thumbnailPath = 'images/icon-default.png';
            }

            $classVideo = ClassVideo::create($validated);
        });

        return redirect()->route('course_video.index');
    }

    public function show(ClassVideo $classVideo)
    {
        return view('pages.course_video.edit', compact('classVideo'));
    }

    public function edit(ClassVideo $classVideo)
    {
        return view('pages.course_video.edit', compact('classVideo'));
    }

    public function update(UpdateClassVideoRequest $request, ClassVideo $classVideo)
    {
        DB::transaction(function () use ($request) {

            $validated = $request->validated();
            dd($validated);

            if ($request->hasFile('thumbnail_video')) {
                $thumbnailPath = $request->file('thumbnail_video')->store('thumbnails_video', 'public');
                $validated['thumbnail_video'] = $thumbnailPath;
            } else {
                $thumbnailPath = 'images/icon-default.png';
            }

            $classVideo->update($validated);
        });

        return redirect()->route('course_video.index', $classVideo->category_classes_id);
    }

    public function destroy(ClassVideo $classVideo)
    {
        DB::beginTransaction();

        try {
            $classVideo->delete();
            DB::commit();

            return redirect()->route('course_video.index', $classVideo->category_classes_id);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('course_video.index', $classVideo->category_classes_id)->with('error', 'Terjadi Sebuah Error');
        }
    }
}
