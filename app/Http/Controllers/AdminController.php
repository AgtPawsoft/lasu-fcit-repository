<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalDocs = Document::count();
        $pendingDocs = Document::where('status', 'pending')->count();
        $approvedDocs = Document::where('status', 'approved')->count();
        $totalUsers = User::count();
        $recentDocs = Document::with(['user', 'department', 'category'])->latest()->take(5)->get();
        return view('admin.index', compact('totalDocs', 'pendingDocs', 'approvedDocs', 'totalUsers', 'recentDocs'));
    }

    public function documents()
    {
        $documents = Document::with(['user', 'department', 'category'])->latest()->paginate(15);
        return view('admin.documents', compact('documents'));
    }

    public function approve(Document $document)
    {
        $document->update(['status' => 'approved']);
        return back()->with('success', 'Document approved successfully!');
    }

    public function reject(Document $document)
    {
        $document->update(['status' => 'rejected']);
        return back()->with('success', 'Document rejected!');
    }

    public function users()
    {
        $users = User::with('department')->latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $req, User $user)
    {
        $req->validate(['role' => 'required|in:admin,faculty,student']);
        $user->update(['role' => $req->role]);
        return back()->with('success', 'User role updated!');
    }

    public function departments()
    {
        $departments = Department::withCount('documents', 'users')->get();
        return view('admin.departments', compact('departments'));
    }

    public function storeDepartment(Request $req)
    {
        $req->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:departments,code',
            'description' => 'nullable|string',
        ]);
        Department::create($req->only(['name', 'code', 'description']));
        return back()->with('success', 'Department created successfully!');
    }
}