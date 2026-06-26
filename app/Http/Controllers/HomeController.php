<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Department;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $recentDocs = Document::approved()->with(['user', 'department', 'category'])
            ->latest()->take(6)->get();
        $departments = Department::withCount('documents')->get();
        $totalDocs = Document::approved()->count();
        $totalUsers = \App\Models\User::count();
        return view('home', compact('recentDocs', 'departments', 'totalDocs', 'totalUsers'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        $myDocs = Document::where('user_id', $user->id)->latest()->get();
        return view('dashboard', compact('myDocs'));
    }
}