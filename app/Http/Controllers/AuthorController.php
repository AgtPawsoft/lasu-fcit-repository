<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;

class AuthorController extends Controller
{
    public function show(User $user)
    {
        $documents = Document::approved()
            ->where('user_id', $user->id)
            ->with(['department', 'category'])
            ->latest()
            ->paginate(10);
        $totalDocs = Document::approved()->where('user_id', $user->id)->count();
        $departments = Document::approved()
            ->where('user_id', $user->id)
            ->with('department')
            ->get()
            ->pluck('department.name')
            ->unique();
        return view('authors.show', compact('user', 'documents', 'totalDocs', 'departments'));
    }
}