<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return view('admin_panel.course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // So'rovni tekshirish...
        $request->validate([
            'title' => 'required|max:255',
            'shortContent' => 'required',
            'contents' => 'required',
//            'user_id' => 'nullable',
            'price' => 'required|numeric',
            'duration' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user_id = $request->user() ? $request->user()->id : null;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            // Faylni istalgan katalogga ko'chirish
            $path = $file->move(public_path('courses'), $filename);

            // Fayl yo'lining bazada saqlanishi
            // Bu erda $path o'zgaruvchisi bazaga saqlash uchun faylning yo'lini ifodalaydi
        }

//dd($request->contents);
        $course = Course::create([
            'title' => $request->title,
            'shortContent' => $request->shortContent,
            'content' => $request->contents,
            'user_id' => $user_id,
            'price' => $request->price,
            'duration' => $request->duration,
            'photo' => $filename // Fayl nomini bazada saqlash
        ]);
//        dd($request);

        return redirect()->route('admin_course')->with('success', 'Muvaffaqiyatli yaratildi');

    }


    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
