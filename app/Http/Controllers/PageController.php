<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\News;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
//        $course = News::all();
//        $user = Employee::all();
////        dd($course);
//        return view('index', compact('course', 'user'));
        return view('drivin.index');

    }
    public function about()
    {
//        $user = Employee::all();
////        dd($course);
        return view('drivin.about');
    }
    public function course()
    {
        return view('drivin.course');
    }
    public function contact()
    {
        return view('drivin.contact');
    }
}

